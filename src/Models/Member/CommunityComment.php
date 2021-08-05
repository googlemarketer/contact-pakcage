<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;
use Googlemarketer\Contact\Model\Member\Community;

class CommunityComment extends Model
{
    protected $fillable = ['body','user_id','community_id'];

    public function community(){
        return $this->belongsTo(Community::class);
    }
}
