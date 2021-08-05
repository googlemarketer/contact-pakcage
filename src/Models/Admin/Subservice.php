<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\Models\Admin\Service;
use Googlemarketer\Contact\Models\Member\Order;

class Subservice extends Model {

    use HasFactory, Notifiable;

    protected $fillable = ['title','body','cover_image','price','gst','slug','priority','published','published_at','admin_id','service_id'];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getTitleAttribute($value){
        return ucfirst($value);
    }
}
