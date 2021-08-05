<?php

namespace Googlemarketer\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\Subcategory;
use App\Models\Admin\Service;
use App\Models\Admin\Subservice;
use App\Models\Admin\Article;
use App\Models\Admin\Job;
use App\Models\Member\Post;
use App\Models\Member\Property;
use App\Models\Tag;
use App\Models\Location;
use App\User;
use App\UserProfile;
use Auth;

class PagesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    //    $this->middleware('auth')->only('postproperty','blog','jobs','contact');

    }

   public function about(){
        return view('app.pages.about');
    }

    public function plan(){
        return view('app.pages.plans');
    }

    public function volunteer(){
        return view('app.pages.volunteers');
    }

    public function single(){
        return view('app.pages.single');
    }

    public function privacy(){
        return view('app.pages.privacy');
    }

    public function terms(){
        return view('app.pages.terms');
    }

    public function status(){
        return view('app.pages.status');
    }

    public function news(){
        $articles = Article::latest()->paginate(9);
        return view('app.pages.news', compact('articles'));
    }

   public function careers(){
        $jobs = Job::where('published',1)->orderBy('created_at', 'desc')->paginate(6);
        return view('app.pages.jobs', compact('jobs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}


