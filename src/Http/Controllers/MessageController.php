<?php

namespace Googlemarketer\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Models\Member\Message;

class MessageController extends Controller
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
        $messages = Message::all();

        return view('app.messages.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //return view('app.pages.contact');
       return view('app.messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $data = $this->validateRequest();
        if (Auth::check()){
            $user = Auth::user()->id;
        } else {
            $user = 1;
        }
        $data['user_id'] = $user;

        Message::create( $data);
         //Mail::to('trustrajeshg@gmail.com')->send(new ContactFormMail($data));
       return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
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
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
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
