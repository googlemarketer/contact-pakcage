<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\Models\Admin\Admin;
use Googlemarketer\Contact\Models\Admin\Category;
use Googlemarketer\Contact\Models\Admin\Service;

class Subcategory extends Model {

    use HasFactory, Notifiable;

    protected $fillable = ['title','body','cover_image','slug','priority','published','published_at','admin_id','category_id'];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }

    public function getTitleAttribute($value){
        return ucfirst($value);
    }
}
