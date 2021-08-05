<?php

namespace Googlemarketer\Contact\Models;

use App\User;

use Googlemarketer\Contact\Models\Member\job;
use Googlemarketer\Contact\Models\Member\Post;
use Googlemarketer\Contact\Models\Admin\Article;
use Googlemarketer\Contact\Models\Member\Property;
use Googlemarketer\Contact\Models\Member\Community;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = ['property','community','post','article','project','job','priority'];

    public function properties(){
        return $this->belongsToMany(Property::class)->withTimestamps();
    }

    public function communities(){
        return $this->belongsToMany(Community::class)->withTimestamps();
    }

    public function posts(){
        return $this->belongsToMany(Post::class)->withTimestamps();
    }

    public function articles(){
        return $this->belongsToMany('App\Models\Admin\Article')->withTimestamps();
    }

    public function jobs(){
        return $this->belongsToMany('App\Models\Admin\Job')->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
