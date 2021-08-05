<?php

namespace Googlemarketer\Contact\Http\Controllers\Associate;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Googlemarketer\Contact\Models\Associate\Associate;
use App\Models\Associate\AssociateProfile;
use Auth;

class AssociateController extends Controller
{

    public function __construct(){
        $this->middleware('auth.associate');
    }

    //   public function home()
    // {

    //     $associate = Auth::guard('associate')->user();
    //     $profile = $associate->associateprofile;
    //     //dd($profile);
    //     if($profile == null) {
    //         //dd('redirect to route profile.create');
    //        // dd($associate->associateprofile);
    //         return redirect()->route('profile.create',[$associate]);
    //     } else {
    //        return redirect()->route('profile.show',[$associate,$profile]);
    //     }
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('reaced associate.index');
        $associate = Auth::guard('associate')->user();
        $profile = $associate->associateprofile;
        //dd($profile);
        if($profile == null) {
            //dd('redirect to route profile.create');
           // dd($associate->associateprofile);
            return view('associate.profile.create',compact('associate','profile'));
            //return redirect()->route('associate.profile.create',[$associate]);
        } else {
            //dd('redirect to route profile.create');
            //return view('associate.show',compact('associate','profile'));
             return redirect()->route('associate.profile', $associate);
            //return view('associate.profile.show',compact('associate','profile'));
            // return redirect()->route('associate.profile.show',[$associate]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('associate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('reached');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Associate $associate)
    {
        return view('associate.show',compact('associate'));
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
