<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Admin\Subservice;


class Order extends Model
{
    protected $fillable = ['user_id','subservice_id','price','gst','quantity','amount','discount','payable_amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subservice(){
        return $this->belongsTo(Subservice::class);
    }

}
