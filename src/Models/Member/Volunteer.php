<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;

use Googlemarketer\Contact\Models\Member\Community;

class Volunteer extends Model
{
    protected $fillable = ['community_id','user_id'];

    public function communities(){
        return $this->belongsToMany(Community::class);
    }
}
