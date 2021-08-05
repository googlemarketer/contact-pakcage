<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\Models\Admin\Admin;
use Googlemarketer\Contact\Models\Admin\Subcategory;
use Googlemarketer\Contact\Models\Admin\Subservice;

class Service extends Model {
    use HasFactory, Notifiable;

    protected $fillable = ['title','body','cover_image','slug','priority','published','published_at','admin_id','subcategory_id'];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function subservices(){
        return $this->hasMany(Subservice::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function getTitleAttribute($value){
        return ucfirst($value);
    }
}
