<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use App\Http\Requests\ArticlesRequest;
use Illuminate\Support\Facades\Storage;
use App\Traits\ImageUpload;
use Googlemarketer\Contact\Models\Admin\Article;
use Googlemarketer\Contact\Models\Admin\Prioritylist;
use Googlemarketer\Contact\Models\Tag;

class ArticleController extends Controller
{
    use ImageUpload;
    private $lists;

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
        if (request('tag')){
            //tag instance fetching its won articles.
            $article = Tag::where('article',request('tag'))->firstOrFail()->articles;
            return $article;
        } else {


        $lists = $this->lists;
        //$articles = Article::latest('published_at')->where('published_at','<=', Carbon::now())->get();
        //$article = Article::latest('published_at')->get();  //default field used is 'created_at'
        //$articles = Article::orderBy('created_at','desc')->get();

        $articles = Article::orderBy('created_at','desc')->paginate(18);
        }
        return view('admin.article.index',compact('articles','lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new Article;
        $tags = Tag::pluck('article','id')->filter()->all();
        $lists = $this->lists;
        return view('admin.article.create',compact('article','tags','lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Article $article)
    {
        $data = $this->requestValidate();

        if(! request()->has('cover_image')){
            $data['cover_image'] = 'article\defaultarticle.png' ;
        }
        //dd($data);
        try {
            $article = auth()->guard('admin')->user()->articles()->create($data + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title))]);

            if($article->cover_image !== 'article\defaultarticle.png'){
                $this->storeImage($article,'article');
            }
            if (request()->has('tag_list')){
            $article->tags()->attach(request()->input('tag_list'));
            }

            return redirect("article")->with([
                'status' => 'success',
                'message' => $article->title.' Article was published successfully',
            ]);
            }
        catch (Exception $e) {
                 return redirect("article")->with([
                'status' => 'danger',
                'message' => $e->getMessage(),
                ]);
            }
            //$article = Auth::user()->articles()->save(new Article($request->all()));
            //or
            //$article = new Article($request->all());
            //Auth::user()->articles()->save($article);
            //$tagsId = $request->input('tags);
            //$article->tags()->attach('tagsId)


        	// $article = new Article::create($request->all());
            // Auth::user()->articles()->save($article);
            //$tagsId = $request->input('tags');
           // $tagsId = $tagsId->pluck($tagsId,$tagsId.id);

         //$tagIds = $request->input('tags');
         // $input['tags'] = $tagIds;
        //dd($tagsIds);

        //  $str = strtolower($request->title);
        //  $input['slug'] = preg_replace('/\s+/', '-', $str);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //return $article;
        //$articles = Article::where('id','=', $article)->get();
        //return redirect()->route('article.index',$article)
        //return redirect()->route($article->path())
        return view('admin.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $tags = array_filter(Tag::pluck('article','id')->toArray());
        $lists = $this->lists;
        return view('admin.article.edit', compact(['article','tags','lists']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * public function update(Request $request, $id) was earliest by default
     * fetching request from form and $id was passed automaticlly by laravel
     **/
    public function update(Article $article)
    {
        if(request()->priority !== $article->priority) {
            $article->update(request(['priority']));
        }
        $article->update(['published' => request()->has('published')]);

        $data = $this->requestValidate();
         try {
            $article->update($data + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title))]);
            $this->updateImage($article,'article');
            $article->tags()->sync(request()->input('tag_list'));

                return redirect("article")->with([
                    'status' => 'success',
                    'flash_message' => $article->title.' was updated successfully',
                ]);
             } catch (Exception $e) {
                 return redirect("article")->with([
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
    public function destroy(Article $article)
    {
       if($article->cover_image !== 'article\defaultarticle.png'){
            Storage::delete('/public/'.$article->cover_image);
         }

         $article->delete();
         return redirect('/article')->with('success', 'Article Removed');
    }

    public function syncTags(Article $article, $tags){
        $article->tags()->sync($tags);
    }

    /**
     * Validatating the form data.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    private function requestValidate(){

            return request()->validate([
                'title' => ['bail','required','min:5','max:255'],
                'body' => ['required','min:10','max:255'],
                'published' => ['sometimes'],
                'priority' => ['required'],
                'published_at' => ['required'],
                'tag_list'  => ['exists:tags,id'], //tag_list keys exits in tags table of database
                'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);
    }

//     private function storeImage($article) {

//         if (request()->has('cover_image')) {

//         $article ->update(['cover_image' => request()->cover_image->store('article', 'public')]);

//            //resizing $service_cover_image with composer package
//            $cover_image = Image::make(public_path('storage/'. $article->cover_image))->fit(300,300);
//            $cover_image->save();
//        }
// }

}
