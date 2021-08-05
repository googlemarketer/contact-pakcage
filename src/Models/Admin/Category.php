<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\Models\Admin\Admin;
use Googlemarketer\Contact\Models\Admin\Subcategory;

class Category extends Model {

     use HasFactory, Notifiable;

    protected $fillable= ['title','body','cover_image','slug','priority','published','published_at','admin_id'];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    /**
     * Categories has many subcategories
     * relationship between categories & subcategories
     */
    public function subcategories() {
        return $this->hasMany(Subcategory::class);
        }

    /**
     * functon returning slug name rather id
     * in accessing routes via web browser
     */
    public function getRouteKeyName(){
        return 'slug';
    }

   public function getTitleAttribute($value){
       return ucfirst($value);
   }


}
