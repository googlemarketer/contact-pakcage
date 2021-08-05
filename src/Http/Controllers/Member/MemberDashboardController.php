<?php

namespace Googlemarketer\Contact\Http\Controllers\Member;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Userprofile;
use App\Models\Location;

use App\Models\Member\Property;
use App\Models\Member\Post;


class MemberDashboardController extends Controller
{
   /**
     * The user repository instance.
     */

    public function __construct(){
      $this->middleware('auth', ['except' => ['index']]);

    }

      public function index() {
        //dd('reached dashbarod index()');
          $user = Auth::user();
          $profile = $user->profile;

          if(! $profile) {
            //  dd($profile);
           $profile = new Userprofile;
           $profile->user_id = $user->id;
           $profile->address ="";
           $profile->cover_image="usersprofile/defaultuser.png";
           $profile->location_id= "3";
           $profile->save();
           return view('app.dashboard.show', compact('user', 'profile'));
          } else {
            //dd($profile);
             return view('app.dashboard.show', compact('user', 'profile'));
          }
    }

    public function listedproperty(User $user){
        $user = Auth::user();
        dd($user->propertycomment);
        //dd(Property::find($user->propertyComment->first()->property_id));
       dd($user->propertyComment->first()->property_id);
        //dd($user->propertyPropertycomment);

        $user = Auth::user();
        $properties = $user->properties()->orderBy('priority','asc')->paginate(9);
        return view('app.dashboard.properties.listedproperty',compact('user','properties'));
    }

    public function favproperty(User $user){
        $user = Auth::user();
        $user->properties;
        $properties = $user->properties()->orderBy('created_at','desc')->orderBy('priority','asc')->paginate(9);
        return view('app.dashboard.properties.favproperty',compact('user','properties'));
    }

    public function listedposts(User $user){
        //dd($user->properties());
        $user = Auth::user();
        $posts = $user->posts()->orderBy('priority','asc')->paginate(9);
        return view('app.dashboard.posts.index',compact('user', 'posts'));

    }

     public function listorders(User $user){
        //dd($user->properties());
        $user = Auth::user();
        $orders = $user->orders()->paginate(18);
        return view('app.dashboard.orders.index',compact('user','orders'));
        }

}
