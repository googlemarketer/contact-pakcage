<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;
use Googlemarketer\Contact\Models\Member\Property;
use App\User;

class PropertyComment extends Model
{
    protected $fillable = ['comment','interest','user_id','property_id'];

     public function user(){
        return $this->belongsTo(User::class);
    }

    public function property(){
        return $this->belongsTo(Property::class);
    }

    public function commentowner($id){
            return User::find($id)->name;
    }

     public function replies()
    {
        return $this->hasMany(PropertyComment::class, 'parent_id');
    }

    public function propertycomment(){
        return $this->belongsTo(User::class,'user_id');
    }
}
