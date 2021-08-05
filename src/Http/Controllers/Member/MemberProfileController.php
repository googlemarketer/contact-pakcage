<?php

namespace Googlemarketer\Contact\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\User;
use App\UserProfile;
use App\Models\Location;
use Illuminate\Support\Str;

class MemberProfileController extends Controller
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
       // dd('reached index');
        $user = Auth::user();
        $areas = Location::pluck('area','id');
        if( $user->profile !== null ) {
             $profile = $user->profile;
             return view('app.dashboard.profile.show', compact('user','profile','areas'));
        } else {
            $profile = new UserProfile;
            return view('app.dashboard.profile.create', compact('user','profile','areas') );
        }
    }


    public function show(){
        $user = Auth::user();
        $profile = $user->profile;
        $areas = Location::pluck('area','id');
         return view('app.dashboard.profile.show', compact('user','profile','areas'));
    }


     public function create(){
        $user = Auth::user();
        $profile = new Userprofile;
        $areas = Location::pluck('area','id');
            return view('app.dashboard.profile.create', compact('user','profile','areas') );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Userprofile $profile)
    {

        dd($request->all());
        $user = Auth::user();
        $input = $this->requestValidate();

        //$input['location_id'] = $input['area'];
        //dd($input);
       if(! request()->cover_image){
        $input['cover_image'] = 'usersprofile/defaultuser.png';
       }
        try {
            $profile = $profile->create( $input + ['user_id' => auth()->user()->id]);
            $this->storeImage($profile,'usersprofile');
            return redirect()->route('profile.show',[$user->slug])->with([
                    'status' => 'success',
                    'flash_message' =>  $profile->owner->name.' Profile created successfully',
                ]);
             } catch (Exception $e) {
                 return redirect()->route('profile.create')->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
            ]);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Userprofile $profile)
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $profile = $user->profile;
            $areas = Location::pluck('area','id');
            return view('app.dashboard.profile.edit',compact('user', 'profile','areas'));
         }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Userprofile $profile)
    {
        // dd($profile);
        $input = $this->requestValidate();
        //dd($input);

        try {
           $profile->update($input);
           $this->storeImage($profile,'usersprofile');
            return redirect()->route('profile.show',[$user->slug, $user->profile])->with([
                    'status' => 'success',
                    'flash_message' => $profile->owner->name.' Profile updated successfully',
                ]);
             } catch (Exception $e) {
                 return redirect()->route('profile.create')->with([
                    'status' => 'danger',
                    'flash_message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $profile)  {
        if($profile->cover_image !== 'usersprofile\defaultuser.png'){
            Storage::delete('/public/'.$profile->cover_image);
         }
         $profile->delete();
         return redirect('/profile')->with('success', $profile->user->title.' Profile Removed');
    }

    private function requestValidate(){

        return request()->validate([
            'address' => ['sometimes'],
            'location_id' => ['required'],
            'wallet_amount' => ['sometimes'],
            'slug' => 'sometimes',
            'cover_image' => 'sometimes | file | image| max:1999',
            //'user_id' => ['required'],

        ]);
}

        private function storeImage($profile, $folder) {

        if (request()->has('cover_image')) {

        $profile->update(['cover_image' => request()->cover_image->storeAs($folder, Str::random(25).'.png','public')]);

        //resizing $service_cover_image with composer package
        $cover_image = Image::make(public_path('storage/'. $profile->cover_image))->fit(300,300);
        $cover_image->save();

        // $file = Input::file('url_Avatar');
        // $filename = '...';
        // Image::make($file->getRealPath())->resize('200','200')->save($filename);
            }
    }

}
