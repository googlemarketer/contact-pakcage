<?php

namespace Googlemarketer\Contact\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageUpload;

use App\Models\Member\Property;
use App\Models\Tag;
use App\Models\Location;
use App\User;

//use Intervention\Image\Facades\Image;
//use Illuminate\Support\Facades\File;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;

use App\Events\PropertyAdded;
use App\Mail\Propertylist;
use App\Notifications\PaymentReceived;

class PropertyController extends Controller
{
    use ImageUpload;

     /**
     * Check Autorization of a resource via controller method
     *
     * to check weather use is authorized to access that resource
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       $this->middleware('auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  {
        $properties = Property::orderBy('created_at','desc')->orderBy('priority','asc')->where('published', 0)->paginate(9);
        return view('app.properties.index',compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()  {

        $property = new Property;
        $locs = Location::pluck('area','id');
        $tags = Tag::pluck('property','id');

        if($_SERVER['REQUEST_URI'] == '/createproperty'){
             return view('members.dashboard.property.create', compact('property','tags','locs'));
        }

        return view('app.properties.create', compact('property','tags','locs'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        //$data = $request->all();
        // dd($data);
        //$data = $this->requestValidate();
        //dd($data);
        //$data['user_id'] = auth()->user()->id;
       // $data['slug'] = strtolower(preg_replace('/\s+/', '-', $request->title));
         // $property = Property::create($data);
        //dd($data);

       if(! request()->cover_image){
        request()->cover_image = 'property/defaultproperty.png';
       }

        try {
            $property = auth()->user()->properties()->create($this->requestValidate() + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title)),'cover_image' => request()->cover_image]);
            $this->storeImage($property,'property');
            $property->tags()->sync(request()->get('tag_list'));

            //Mail::to(request()->user()->email)
             //   ->send(new Propertylist($property));

            //request()->user()->notify(new PaymentReceived($property));

            event(new PropertyAdded($property)); //broadcast a new property created event

            return redirect("property")->with([
                'status' => 'success',
                'flash_message' => $property->title.' listing was published successfully',
            ]);

             } catch (Exception $e) {
                 return redirect()->route('property.index')->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
            ]);
             }
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        return view('app.properties.show',compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $locs = Location::pluck('area','id');
        $tags = Tag::pluck('property','id');
        return view('app.properties.edit',compact('property','locs', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Property $property)
    {
        //$this->authorize('update-property', $property);
        if(Gate::denies('update-property',$property)) {
            return redirect("property")->with([
                'status' => 'success',
                'flash_message' => 'You are not authorized to update this property',
            ]);
        }
       // dd($request);
        //$input = $this->requestValidate();
        //dd($input);
         //$input['user_id'] = auth()->user()->id;
         //$input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->title));
          //$property = auth()->user()->create($input);
             //$property->tags()->attach($request->input('tag_list'));
            //  //$property->location()->attach($request->input('plocation'));
            //  if(! request()->cover_image){
            //     request()->cover_image = 'property/defaultproperty.png';
            //    }
         try {
           $property->update($this->requestValidate() + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title)),'cover_image' => request()->cover_image]);
            $this->updateImage($property,'property');
            $property->tags()->sync(request()->get('tag_list'));

                return redirect("property")->with([
                    'status' => 'success',
                    'flash_message' => $property->title.' was published successfully',
                ]);
             } catch (Exception $e) {
                 return redirect()->route('property.index')->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //dd($property->cover_image);
        if(Gate::allows('delete-property', $property)){
            if($property->cover_image !== 'property/defaultproperty.png'){
                Storage::delete('/public/'.$property->cover_image);
             }
             $property->delete();
             return redirect('/property')->with('success', $property->title.' Property Removed');
        }

    }

    public function syncTags($property, $tags){
        $property->tags()->sync($tags);
    }

    // public function syncLocation(Property $property, $location){
    //     $property->location()->sync($location);
    // }

    private function requestValidate(){

        return request()->validate([
            'service' => ['required'],
            'custtype' => ['required'],
            'property' => ['required'],
            'title' => ['required','min:5','max:255'],
            'body' => ['sometimes','min:10','max:255'],
            'price' => ['sometimes'],
            'pricemultiple' => ['sometimes'],
            'address' => ['sometimes'],
            'location_id' => ['required'],
            'tag_list' => ['exists:tags,id'],
            'available' => ['required'],
            'cover_image' => 'sometimes | file | image| max:1999',
            //'cover_image' => 'sometimes | file | image| max:1999',
            //'user_id' => ['required']
        ]);
}

// private function storeImage($property) {

//     if (request()->has('cover_image')) {

//     $property ->update(['cover_image' => request()->cover_image->store('property', 'public')]);

//        //resizing $service_cover_image with composer package
//        $cover_image = Image::make(public_path('storage/'. $property->cover_image))->fit(300,300);
//        $cover_image->save();
//    }
// }



}
