<?php

namespace Googlemarketer\Contact\Http\Controllers\Associate;

use App\Http\Controllers\Controller;
use Googlemarketer\Contact\Models\Associate\AssociateMessage;
use Illuminate\Http\Request;
use Googlemarketer\Contact\Models\Associate\Associate;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $associate = auth()->guard('associate')->user();
        return view('associate.messages.index',compact('associate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $associate = auth()->guard('associate')->user();
        return view('associate.messages.create', compact('associate'));
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
       $data['associate_id'] = auth()->guard('associate')->user()->id;
        AssociateMessage::create( $data );
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Associate\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Associate\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Associate\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Associate\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
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
