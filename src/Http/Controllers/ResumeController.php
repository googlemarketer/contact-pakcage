<?php

namespace Googlemarketer\Contact\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Googlemarketer\Contact\Models\Admin\Job;
use Googlemarketer\Contact\Models\Member\JobResume;

class ResumeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumes = JobResume::orderBy('created_at','desc')->paginate(6);
        return view('app.resumes.index', compact('resumes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Job $job)
    {
        $resume = new JobResume;
        return view('app.resumes.create',compact('resume','job'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $this->requestValidate();
        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->position_applied_for));

        try {
            $resume = JobResume::create($input + ['user_id' => auth()->user()->id, 'job_id' => $request->job_id]);
            $this->storeImage($resume);

                return redirect()->route('web.home')->with([
                    'status' => 'success',
                    'flash_message' => 'Your Resume was submitted  successfully, Team would get to you on this',
                ]);

             } catch (Exception $e) {
                 return redirect()->back()->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
                ]);
            }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(JobResume $resume)
    {
        return view('app.resumes.show', compact('resumes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(JobResume $resume)
    {
        return view('app.resumes.edit', compact(['resume']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobResume $resume)
    {
        $input = $this->requestValidate();
        //$input = $request->all();
        $input['slug'] = strtolower(preg_replace('/\s+/', '-', $request->position_applied_for));
        //  $resume->update($input);

         try {
            $resume->update($input);
            $this->storeImage($resume);

             } catch (Exception $e) {
                 return redirect("resumes")->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
            ]);
        }

         return redirect('resumes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        File::delete((public_path('storage/'. $resume->cover_image)));
        if($resume->cover_image != 'noimage.jpg'){
            // Delete Image
        File::delete((public_path('storage/'. $resume->cover_image)));
        }

         $article->delete();
         return redirect('/resume')->with('success', 'Resume Removed');
    }


    /**
     * Validatating the form data.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    private function requestValidate(){
        return request()->validate([
            'first_name' => ['required','min:5','max:50'],
            'last_name' => ['required','min:5','max:50'],
            'email_address' => ['required','min:5','max:50'],
            'position_applied_for' => ['required','min:5','max:50'],
            'last_salary_drawn' => ['required','min:4','max:10'],
            'expected_salary' => ['required','min:4','max:10'],
            'start_date' => ['required'],
            'relocate' => ['required'],
            'last_organization' => ['required','min:5','max:50'],
            'reference' => ['required','min:5','max:50'],
            'job_id'    => ['required'],
            'cover_image' => 'sometimes | file | image| max:1999'
        ]);
    }

    private function storeImage($resume) {

        if (request()->has('cover_image')) {

        $resume->update(['cover_image' => request()->cover_image->store('jobs', 'public')]);

        //resizing $service_cover_image with composer package
        $cover_image = Image::make(public_path('storage/'. $resume->cover_image))->fit(300,300);
        $cover_image->save();
    }

    }
}
