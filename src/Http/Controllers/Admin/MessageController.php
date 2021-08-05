<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Googlemarketer\Contact\Models\Admin\AdminMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.messages.index',compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.messages.create', compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $data = $this->validateRequest();
       $data['admin_id'] = auth()->guard('admin')->user()->id;
        AdminMessage::create( $data );
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(AdminMessage $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminMessage $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminMessage $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminMessage $message)
    {
        //
    }

      public function validateRequest(){
        return request()->validate([
                'name' => ['required', 'min:3', 'max:100'],
                'email' => ['required', 'email'],
                'mobile' => ['required','min:10','max:13'],
                'subject' => ['required', 'min:5', 'max:25'],
                'message' => ['required','string', 'max:255']
        ]);
    }
}
