<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Admin\Subservice;
use App\Models\Admin\Service;
use App\Models\Admin\Prioritylist;
use App\Traits\ImageUpload;

class SubserviceController extends Controller
{
    use ImageUpload;
    private $lists ;

    public function __construct(){
        $this->middleware('auth.admin', ['except' => ['index','show']]);
        $this->lists =  Prioritylist::pluck('priority','id');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $lists = $this->lists;
        if(auth()->guard('admin')->id()==1){
            $subservices = Subservice::orderBy('title','ASC')->paginate(36);
        }else {
            $subservices = Subservice::where('admin_id',auth()->guard('admin')->id())->orderBy('priority','ASC')->paginate(36);
        }
       return view('admin.subservice.index', compact('subservices','lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subservice = new Subservice;
        $services = Service::pluck('title','id');
        $lists = $this->lists;
        return view('admin.subservice.create', compact('subservice','services','lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //$data['slug'] = strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', $request->title)));

        $data = $this->requestValidate();

        if(! request()->has('cover_image')){
            $data['cover_image'] = 'subservice\defaultsubservice.png' ;
        }
        $subservice = Subservice::create($data +[ 'slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title)))]);
        $this->storeImage($subservice, 'subservice');
        return redirect('subservice')->with('message', $subservice->title . ' subservice added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subservice  $subservice
     * @return \Illuminate\Http\Response
     */
    public function show(Subservice $subservice) {

        $lists = $this->lists;
       return view('admin.subservice.show', compact('subservice','lists'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subservice  $subservice
     * @return \Illuminate\Http\Response
     */
    public function edit(Subservice $subservice)
    {
        $lists = $this->lists;
        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $subservice->admin->id){

        $services = Service::pluck('title','id');
        return view('admin.subservice.edit', compact('subservice','services','lists'));
    }
    else {
        return back()->with('message','Not Authorized to edit'.$subservice->title);
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subservice  $subservice
     * @return \Illuminate\Http\Response
     */
    public function update(Subservice $subservice)
    {
        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $subservice->admin->id){

        if(request()->priority !== $subservice->priority) {
            $subservice->update(request(['priority']));
        }
        $subservice->update(['published' => request()->has('published')]);

            $data = $this->requestValidate();

             if(($subservice->image == 'subservice\defaultsubservice.png') && request()->has('cover_image')){
                Storage::delete('/public/'.$subservice->cover_image);
               }
         try {
            $subservice->update($data + ['slug' => strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', request()->title)))]);
            $this->updateImage($subservice, 'subservice');

            return redirect('subservice')->with('message', $subservice->title . 'updated Successfully');

        }

        catch (Exception $e) {
            return redirect("subservice")->with([
                'status' => 'danger',
                    'message' => $e->getMessage()]);
            }
        }
        else {
            return redirect('subservice')->with('message', 'Not Authorized to  update'. $subservice->title);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subservice  $subservice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subservice $subservice)
    {
        if(auth()->guard('admin')->id()==1 || auth()->guard('admin')->id() == $subservice->admin->id){

        $subservice->delete();
        Storage::delete('/public/'.$subservice->cover_image);

        return redirect('subservice')->with('message', $subservice->title .' removed successfully');
    }
    else{
        return redirect('subservice')->with('message', 'Not Authorised to remove'.$subservice->title);
    }
    }

      /**
     * Validatating the form data.     *
     * @param  \App\Subservice  $subservice
     * @return \Illuminate\Http\Response
     */

    private function requestValidate(){        {
            return request()->validate([
                'title' => ['required','min:3','max:255'],
                'body' => ['required','min:5','max:255'],
                'price' => 'required',
                'gst'   => 'sometimes',
                'priority' =>['sometimes'],
                'published' =>['sometimes'],
                'published_at' =>['sometimes'],
                'cover_image' => 'sometimes | file | image| max:1999',
                'service_id' => 'required'
            ]);
        }
    }

}
