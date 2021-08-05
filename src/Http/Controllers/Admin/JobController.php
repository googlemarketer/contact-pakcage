<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Googlemarketer\Contact\Traits\ImageUpload;
use Googlemarketer\Contact\Models\Admin\Job;
use Googlemarketer\Contact\Models\Admin\Prioritylist;
use Googlemarketer\Contact\Models\Tag;

class JobController extends Controller
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
        $lists = $this->lists;

        $jobs = Job::orderBy('priority','ASC')->paginate(18);
        return view('admin.job.index',compact('jobs','lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job = new Job;
        $tags = Tag::pluck('job','id')->filter()->all();
        $lists = $this->lists;
        return view('admin.job.create',compact('job','tags','lists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Job $job)
    {
        $data = $this->requestValidate();

        if(! request()->has('cover_image')){
            $data['cover_image'] = 'job\defaultjob.png' ;
        }

        try {

            $job = auth()->guard('admin')->user()->jobs()->create($data + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title))]);

            if($job->cover_image !== 'job\defaultjob.png'){
                $this->storeImage($job,'job');
            }
            $job->tags()->attach(request()->input('tag_list'));

            return redirect("job")->with([
                'status' => 'success',
                'message' => $job->title.' Job was published successfully',
            ]);
         } catch (Exception $e) {
             return redirect("job")->with([
                'status' => 'danger',
                'message' => $e->getMessage(),
        ]);

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


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return view('admin.job.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        $tags = array_filter(Tag::pluck('job','id')->toArray());
        $lists = $this->lists;
        return view('admin.job.edit', compact(['job','tags','lists']));
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
    public function update(Job $job)
    {
        if(request()->priority !== $job->priority) {
            $job->update(request(['priority']));
        }

        $job->update(['published' => request()->has('published')]);

        $data = $this->requestValidate();
        try {
            $job->update($data + ['slug' => strtolower(preg_replace('/\s+/', '-', request()->title))]);
            $this->storeImage($job,'job');
            $job->tags()->sync(request()->input('tag_list'));

                return redirect("job")->with([
                    'status' => 'success',
                    'flash_message' => $job->title.' was updated successfully',
                ]);
             } catch (Exception $e) {
                 return redirect("job")->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
            ]);
        }
       // $this->syncTags($article, $request->input('tag_list'));
       // return redirect(route('admin.article.show',$article));
       //return redirect($article->path());
         //return redirect('article');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {

        if($job->cover_image !== 'job\defaultjob.png'){
            Storage::delete('/public/'.$job->cover_image);
        }

         $job->delete();
         return redirect('/job')->with('success', 'Job Removed');
    }

    public function syncTags(Job $job, $tags){
        $job->tags()->sync($tags);
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
                'vacancy' => ['required'],
                'published' => ['sometimes'],
                'priority' => ['required'],
                'published_at' => ['required'],
                'tags'  => ['exists:tags,id'],
                'cover_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]);
    }
}
