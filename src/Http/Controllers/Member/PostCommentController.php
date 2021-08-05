<?php

namespace Googlemarketer\Contact\Http\Controllers\Member;

use App\Models\Member\Post;
use Illuminate\Http\Request;
use App\Models\Member\PostComment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class PostCommentController extends Controller
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
    public function create(Post $post)  {

        return view('app.posts.postcomment', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post, Request $request)
    {
        //dd(Auth::id(),request()->input('body'),$request->all(),$post->id);
        //dd([request()->body, 'post_id' => $post->id]);
         $post->postcomments()->create(['user_id' => Auth::id(),'post_id' => $post->id ,'comment' => request()->input('body'), $request->all()]);
        return redirect()->back();
        // $post->postcomments()->create($request->all());
        // return redirect()->back();

    }

    public function addcomment(Request $request){

        //dd($request);
        $comment = new PostComment;
        $comment->comment = $request->get('comment');
        $comment->user()->associate($request->user());
        $comment->post_id = $request->get('post_id');
        //dd($comment);
        $post = Post::find($request->get('post_id'));
        $post->postcomments()->save($comment);
        return back();
    }


     /**
     * storing comment replies
     */
    public function replyStore(Request $request) {
        $reply = new PostComment();
        $reply->comment = $request->get('comment');
        $reply->user()->associate($request->user());
        $reply->post_id = $request->get('post_id');
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));

        $post->postcomments()->save($reply);

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function show(PostComment $postComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function edit(PostComment $postComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostComment $postComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostComment  $postComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostComment $postComment)
    {
        //
    }
}
