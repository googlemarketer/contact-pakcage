<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Googlemarketer\Contact\Models\Location;
use Googlemarketer\Contact\Models\Tag;


class Community extends Model
{
    protected $fillable = ['name','body', 'cover_image','slug', 'location_id','user_id'];


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
       return 'slug';
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function communitycomments(){
        return $this->hasMany(Communitycommnet::class);
    }

    public function getTagListAttribute(){
        return $this->tags->pluck('id');
    }
}
