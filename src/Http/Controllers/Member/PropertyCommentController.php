<?php

namespace Googlemarketer\Contact\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member\PropertyComment;
use App\Models\Member\Property;
use Illuminate\Http\Request;
use Auth;

class PropertyCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Property $property)
    {
        //dd(request()->input('comment'));
        //dd([request()->body, 'property_id' => $property->id]);
        $property->propertycomments()->create(['user_id' => Auth::id(),'property_id' => $property->id ,'comment' => request()->input('comment'),$request->all()]);
        return redirect()->back();
    }

     public function addcomment(Request $request){
        //dd($request);
        $comment = new PropertyComment;
        $comment->comment = $request->get('comment');
        $comment->user()->associate($request->user());
        $comment->property_id = $request->get('property_id');
        //dd($comment);
        $property = Property::find($request->get('property_id'));
        $property->propertycomments()->save($comment);
        return back();
    }


     /**
     * storing comment replies
     */
    public function replyStore(Request $request) {
        $reply = new PropertyComment();
        $reply->comment = $request->get('comment');
        $reply->user()->associate($request->user());
        $reply->property_id = $request->get('property_id');
        $reply->parent_id = $request->get('comment_id');
        $property = Property::find($request->get('property_id'));
        $property->propertycomments()->save($reply);

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Propertycomments  $propertycomments
     * @return \Illuminate\Http\Response
     */
    public function show(Propertycomments $propertycomments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Propertycomments  $propertycomments
     * @return \Illuminate\Http\Response
     */
    public function edit(Propertycomments $propertycomments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Propertycomments  $propertycomments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Propertycomments $propertycomments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Propertycomments  $propertycomments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Propertycomments $propertycomments)
    {
        //
    }
}
