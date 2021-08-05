<?php

namespace Googlemarketer\Contact\Http\Controllers\Associate;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Googlemarketer\Contact\Models\Associate\Associate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Googlemarketer\Contact\Models\Associate\AssociateProfile;


class AssociateProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('Create or show profile here');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Associate $associate)
    {
        dd('reached create asso');
      return view('associate.profile.create', compact('associate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request()->validate([
        //     'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     ]);
        $imageName = time().'.'.request()->logo->getClientOriginalExtension();
        request()->logo->move(public_path('images'), $imageName);
        // $validatedData = $request->validate([
        //     'compName' => 'required|unique:posts|max:255',
        //     'compCity' => 'required',
        // ]);
         $input = $request->all();
         $input['logo'] =  $imageName;
         $input['associate_id'] = Auth::guard('associate')->user()->id;
         $input['slug'] = Str::slug($request->title);
               //dd($input);
        $associateprofile = AssociateProfile::create($input);

        return redirect()->route('associate.index', ['associate' => null]);

        // return redirect()->route('profile.show' )->with('success', 'Welcome to the family of PanckulaCommunity Club');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssociateProfile  $associateProfile
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $associate = Auth::guard('associate')->user();
        return view('associate.profile.show', compact('associate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssociateProfile  $associateProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(AssociateProfile $associateProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssociateProfile  $associateProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssociateProfile $associateProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssociateProfile  $associateProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssociateProfile $associateProfile)
    {
        //
    }
}
