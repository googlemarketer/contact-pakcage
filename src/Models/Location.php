<?php

namespace Googlemarketer\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member\Property;
use App\Models\Member\Community;
use App\Models\Member\UsersProfile;

class Location extends Model
{
    protected $fillable = ['area','city','pincode','state','country'];

    public function communities() {
        return $this->hasMany(Community::class)->withTimestamps();
     }

   public function properties(){
      return $this->hasMany(Property::class)->withTimestamps();
   }

   public function usersprofiles(){
      return $this->hasMany(UsersProfile::class);
  }
}
