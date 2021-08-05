<?php

namespace Googlemarketer\Contact\Models\Member;

use App\Models\Member\Post;
use App\User;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['comment','post_id','user_id'];

    /**
     * each Comment belongs to User
     */
     public function user(){
         return $this->belongsTo(User::class,'user_id');
     }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    /**
     * each postcomment can have many replies
    */

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    public function postcomment(){
        return $this->belongsTo(User::class,'user_id');
    }


}
