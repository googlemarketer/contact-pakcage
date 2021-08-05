<?php

namespace Googlemarketer\Contact\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\ContactServiceProvider\Models\Member\PropertyComment;
use App\User;
use Googlemarketer\Contact\Models\Location;
use Googlemarketer\Contact\Models\Tag;

use Carbon\Carbon;
use Collective\Html\Eloquent\FormAccessible;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['service','custtype','property','title', 'body', 'price', 'pricemultiple', 'address', 'location_id', 'available', 'cover_image', 'slug','priority', 'published', 'published_at',  'user_id' ];
   // protected $guarded = [];
    protected $dates = [
        'available'
    ];
    // protected $attributes = [
    //     'cover_image' => 'defaultproperty.png',
    // ] ;

     /**
     * Get the route key for the model.
     *
     * @return string
     */

     public function getRouteKeyName(){

        return 'slug';
     }

    /**
	*An property is owned by an user.
	*
	*returns \Illuminate\Database\Eloquent\Relations\BelongsTo
    */

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function location(){
       return $this->belongsTo(Location::class);
    }

   // public function comments(){
    //     return $this->morphMany(PrpopertyComment::class, 'commentable')->whereNull('parent_id');
    // }

     /**
     * Property has many comments with morphMany
     */
    public function propertycomments(){
        return $this->morphMany(PropertyComment::class, 'commentable')->whereNull('parent_id');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function getTagListAttribute($value){

        return $this->tags->pluck('id');
    }

    // public function getPlocationAttribute($value){

    //     return $this->location->pluck('id');
    //     //  foreach($this->location->pluck('area') as $loc) {
    //     //     return $loc;
    //     //  }
    // }

    // public function getAvailableAttribute($value)    {
    //     return Carbon::parse($value)->format('d/m/Y');
    // }

    // public function formAvailableAttribute($value)    {
    //     return Carbon::parse($value)->format('d/m/Y');
    // }

        //return $this->attributes[$value] = Location::find($value)->area;
        //dd($value);
         //dd($this->attributes['location'] = $property->area($value));



}
