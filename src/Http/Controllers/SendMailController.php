<?php

namespace Googlemarketer\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmails;
use App\Mail\Contactme;
use App\Mail\Propertylist;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentReceived;
use Illuminate\Notifications\Notifiable;


use Illuminate\Http\Request;

class SendMailController extends Controller
{

    use Notifiable;


    public function index(){
        return view('emails.mailform');
    }

    public function store(){

        // Mail::to(request('email'))
        // ->send(new Propertylist('Properties'));

        //request()->user()->notify(New PaymentReceived(2000)); //best for collection of users
         //$user->notify(New PaymentReceived(2000)); //best for single user
          //request()->user()->notifyNow([channels:array|null = null]):void;
         //Notification::send(request()->user(), New PaymentReceived(1000));

        return redirect()->back()->with('message','Email sent successfully');
    }
}
