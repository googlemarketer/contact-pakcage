<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use Exception;
use Googlemarketer\Contact\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{

    public function __construct(){
        $this->middleware('auth.admin', ['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('created_at','ASC')->paginate(18);
        return view('admin.tag.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tag = new Tag;
        return view('admin.tag.create',compact('tag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = $this->requestValidate();
        try {
            $tag = auth()->guard('admin')->user->tags()->create($data);
            return redirect("tag")->with([
                //'status' => 'success',
                'message' => 'Tag was created successfully',
            ]);
         } catch (Exception $e) {
             return redirect("tag")->with([
                //'status' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {

        return view('admin.tag.show','tag');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {

        try {
            if($tag->admin_id == 1 || $tag->admin_id == auth()->guard('admin')->id()) {

                if( $data = $this->requestValidate()){
                    $tag->update($data);
                    return redirect("tag")->with([
                        //'status' => 'success',
                        'message' => 'Tag was update successfully',
                    ]);
                }
           }
        }
        catch (Exception $e) {
             return redirect('tag')->with([
                'status' => 'danger',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if(! $tag->admin_id == 1 ) {

                return redirect('tag')->with('message', 'Not Authorized to delete tags');
            }
        else {
            $tag->delete();
            return redirect('tag')->with('message', 'Tag was deleted successfully');
        }


    }

    private function requestValidate(){

    return request()->validate([
        'property' => ['min:5','max:100'],
        'community' =>  ['min:5','max:100'],
        'post' =>  ['min:5','max:100'],
        'article' =>  ['min:5','max:100'],
        'project' =>  ['min:5','max:100'],
        'job'  =>  ['min:5','max:100'],
        'priority' => 'required'
        ]);
}
}
