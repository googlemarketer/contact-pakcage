<?php

namespace Googlemarketer\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Auth;

use App\Models\Member\Community;
use App\Models\Tag;
use App\Models\Location;


class CommunityController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $communities = Community::paginate(9);
        return view('app.communities.index',compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Auth::check()){
            $user = Auth::user();
            $tags = Tag::pluck('community','id');
            $locations = Location::pluck('area','id');
            return view('app.communities.create', compact('user','tags','locations'));
        } else {
            abort('404');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);
        //$input = $request->all();
        $input = $this->requestValidate();
        $input['slug'] = strtolower(trim(preg_replace('/[\t\n\r\s]+/', '-', $request->name)));

         //$input['user_id'] = auth()->user()->id;
       // $input['tags'] = $tagIds;
       //Article::create($input);
   // dd($input);
            try {
           $community = Community::create($input);
           $this->storeImage($community);
           $community->tags()->sync($request->input('tag_list'));
          // $community->locations()->sync($request->input('location'));
               return redirect("community")->with([
                   'status' => 'success',
                   'flash_message' => 'Your Community was published successfully',
               ]);
            } catch (Exception $e) {
                return redirect("community")->with([
                   'status' => 'danger',
                   'flash_message' => $e->getMessage(),
           ]);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show(Community $community)
    {
        return view('app.communities.show',compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function edit(Community $community)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Community $community)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        //
    }

     /**
     * Validatating the form data.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    private function requestValidate(){

        return request()->validate([
            'user_id' => ['required'],
            'name' => ['required','min:5','max:255'],
            'body' => ['required','min:10','max:255'],
            'location_id' => ['required'],
            'tag_list' => ['required'],
            'cover_image' => 'sometimes | file | image| max:1999'
        ]);
}

    private function storeImage($community) {

        if (request()->has('cover_image')) {

        $community ->update(['cover_image' => request()->cover_image->store('community', 'public')]);

        //resizing $service_cover_image with composer package
        $cover_image = Image::make(public_path('storage/'. $community->cover_image))->fit(300,300);
        $cover_image->save();
        }
    }
}
