<?php

namespace Googlemarketer\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageUpload;

use App\Models\Member\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;


class PostController extends Controller
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
    public function index()
        {
            $posts = Post::orderBy('created_at','desc')->where('published', 1)->paginate(9);
            return view('app.posts.index')->with('posts', $posts);

            // $posts = Post::take(5)->get();


            //$posts = Post::all();
            //$posts = Post::orderBy('title','asc')->get();
            //$posts = Post::where('title','Post Two')->get();
            //Post::where('slug',$slug)->get();
            //$posts = Post::orderBy('title','desc')->take(1)->get();
            //$posts = DB::select('SELECT * FROM posts');
            //DB::table('posts')->where('slug',$slug)->first();
            //.\DB::table('posts')->where('slug',$slug)->first();
            //return response()->json($post->paginate(20)->toArray());

            /*  public function blog(){
                $posts = Post::all();

                $posts = $posts->map(function ($post) {
                    return $post->where('user_id',1);
                });
                $user =Post::first()->user->name;
                dd($user);
                $posts = Post::orderBy('created_at','desc')->map(function ($user) {
                    return $user->name;
                });
                dd($posts);
                $posts = Post::latest()->where('published',1)->paginate(9);
                return view('members.post.index', compact('posts'));
                return redirect('posts');
            } */

            /**
             *  //composer require fruitcake/laravel-cors
            *   protected $middlewareGroups = [
            * [...]
            *     'api' => [
            *        \Fruitcake\Cors\HandleCors::class
            *         // [...]
            *     ],
            * ];
            */


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $post = new Post;
       $tags = Tag::pluck('post','id');
    //    if($_SERVER['REQUEST_URI'] == '/createpost'){
    //         return view('members.dashboard.posts.create', compact('post','tags'));
    //     }

        return view('app.posts.create', compact('post','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  request()
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //dd(request());
        // dd(request()->get('tag_list'));
        //   $this->validate(request(), [
        //         'title' => ['required','min:5','max:255'],
        //        'body' => ['required','min:10','max:255'],
        //        'cover_image' => 'image|nullable|max:1999'
        //      ]);
        //dd($user->id);
        //request()->validate([
        //  'title' => 'required | min:3,
        //  'body' => 'required'|'min:10'|'max:255',
        //]);

         // Handle File Upload
        if(request()->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = request()->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = request()->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = request()->file('cover_image')->storeAs('/public/post', $fileNameToStore);
        } else {
            $fileNameToStore = 'post/defaultpost.png';
        }
//dd(request());
        //  $post = new Post;
        //  $post->title = request()->input('title');
        //  $post->body = request()->input('body');
        //  $post->user_id = request()->input('user_id');  //auth()->user()->id; //or  Auth::id();
        //  $post->slug = strtolower(preg_replace('/\s+/', '-', $post->title));
        //  $post->cover_image = $fileNameToStore;
        //  $post->save();
        try {
            $post = auth()->user()->posts()->create($this->requestValidate() + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title)),'cover_image' => $fileNameToStore]);
            $this->storeImage($post,'post');
            $post->tags()->sync(request()->get('tag_list'));

            //return $post->load(auth()->user());
            return view('app.posts.show', compact('post'))->with('success','Post Created Successfully');
        }
        catch (Exception $e) {
            return redirect()->route('posts.index')->with([
                'status' => 'danger',
                'flash_message' => $e->getMessage()
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('app.posts.show',compact('post'));

        //dd($post);
       // $post = Post::findOrFail($id);
       //abort_unless((auth()->user()->owns($post)),403);
       //abort_if($post->user_id !== auth()->id(),403);
        // if ($post->user_id !== auth()->id()){
        //     abort(403);
        // }
       //if(\Gate::allows('update',$post){abort(403)};
        //if(\Gate::denies('update',$post){abort(403)};
        //abort_if(\Gate::denies('update',$post),403)};
         //abort_unelss(\Gate::allows('update',$post),403)};
         //auth()->user()->can('update',$post);
         //auth()->user()->cannot('update',$post);
         // Route::get('/blog', 'PagesController@blog')->name('blog')->middleware(can:update,post);

        //return response()->json($post->toArray());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::pluck('post','id');
        return view('app.posts.edit', compact('post','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  request()
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
      //dd(request());

        // Handle File Upload
        if(request()->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = request()->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = request()->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = request()->file('cover_image')->storeAs('public/post', $fileNameToStore);
        } else {
            $fileNameToStore = 'post/defaultpost.png';
        }

        // $post = Post::findOrFail($post);
        // $post->title = request()->input('title');
        // $post->body = request()->input('body');
        // $post->slug = strtolower(preg_replace('/\s+/', '-', $post->title));
        // $post->published = request()->input('published');
        // if(request()->hasFile('cover_image')){
        //     $post->cover_image = $fileNameToStore;
        // }
        // $post->save();

        try {
            $post->update($this->requestValidate() + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title)),'cover_image' => $fileNameToStore]);
            $post->update(['published' => request()->has('published')]);
            $this->updateImage($post,'post');
            $post->tags()->sync(request()->get('tag_list'));
            return redirect('posts')->with([
                'status' => 'success',
                'flash_message' => $post->title.' was published successfully',
            ]);
        }
        catch( Exception $e){
            return redirect()->route('posts.index')->with([
                'status' => 'danger',
                'flash_message' => $e->getMessage(),
        ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Post $post)
    {

      if($post->user_id == Auth::user()->id){
        if($post->cover_image !== 'post/defaultpost.png'){
            Storage::delete('/public/'.$property->cover_image);
         }
         $post->delete();
         return redirect('/posts')->with('success', $post->title.' Post Removed');
         }
         else {
        return redirect()->back();
        }
    }

    public function syncTags($post, $tags){
        $post->tags()->sync($tags);
    }

    protected function requestValidate(){
        return $this->validate(request(), [
                    'title' => ['required','min:5','max:255'],
                    'body' => ['required','min:10','max:255'],
                    'tag_list' => ['exists:tags,id'],
                    'cover_image' => 'sometimes | file | image| max:1999',
                 ]);
    }


}
