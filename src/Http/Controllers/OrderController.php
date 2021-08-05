<?php

namespace Googlemarketer\Contact\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Member\Order;
use App\Models\Admin\Subservice;
use App\User;

class OrderController extends Controller
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
        dd('reached order controller');
        $orders = Order::all();
        return view('app.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Order $order, User $user, Request $request)
    {
       //dd($request,$user,$order);
        // if (Auth::check()){
        //     $user = Auth::user()->id;
        // } else {
        //     $user = 1;
        // }

        $input = $request->all();
        $discount = 10;
        if(Auth::check()) {
            for($i=0; $i<= count($input['quantity']); $i++) {
                if(empty($input['quantity'][$i]) || !is_numeric($input['quantity'][$i])) continue;
                $data = [
                    'user_id' =>  Auth::user()->id,
                    'subservice_id' => $request['subservice_id'][$i],
                    'quantity' => $request['quantity'][$i],
                    'price' => $request['price'][$i],
                    'amount' =>  $request['quantity'][$i] * $request['price'][$i],
                    'discount' => 10,
                    'gst' => 5,
                    'payable_amount' => ($request['quantity'][$i] * $request['price'][$i])- (($discount)/100)* ($request['quantity'][$i] * $request['price'][$i])
                 ];
                 $orders[$i] = Order::create($data);
            }
        } else {
            return 'Login to create Order';
        }

        if ( !empty($orders)) {
            //send email to user, admin
            //Mail::to('trustrajeshg@gmail.com')->send(new ContactFormMail($data));
            //send sms to user, associate
            return view('app.orders.show',compact('orders'));
          } else {
              echo 'Please select your order Quantity';
              return back();
          }

           // $orderdis = 100;
        // $amount = $request['quantity'] * $request['price'];
        // $order = new Order([
        //     'user_id' => $user,
        //     'subservice_id' => $request['subservice_id'],
        //     'quantity' => $request['quantity'],
        //     'price' => $request['price'],
        //     'amount' =>  $amount,
        //     'payable_amount' => $amount
        //  ]);
        // $order->save();
      // dd($order);

        // $order->create([
        //     'user_id' => $user->id,
        //     'service_id' => $request['service_id'],
        //     'orderqty' => $request['orderqty'],
        //     'price' => $request['price'],
        //     'orderval' => $orderval,
        //     'orderdis' => $orderdis,
        //     'ordernet' => $ordernet
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('app.orders.show', compact('order'));
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
