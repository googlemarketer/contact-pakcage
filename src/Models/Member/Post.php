<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\User;
use App\Models\Member\PostComment;
use App\Models\Tag;
//use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

     //Change tableName, primaryKey  or timestamps here is required
     protected $table = 'posts';
     public $primaryKey = 'id';
     public $timestamps = true;

     protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

     protected $fillable = ['title', 'body', 'cover_image','published_at','published','slug','user_id'];

     public function getRouteKeyName(){
         return 'slug';
     }

     /**
     *A post is owned by an user.
     *
     *returns \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function user(){
         return $this->belongsTo(User::class);
     }

    //  public function postcomments(){
    //      return $this->hasMany(Postcomment::class);
    //  }

     public function postcomments()  {
        return $this->morphMany(PostComment::class, 'commentable')->whereNull('parent_id');
        }

     public function tags(){
         return $this->belongsToMany(Tag::class)->withTimestamps();
     }

     public function getTagListAttribute(){
        return $this->tags->pluck('id');
    }

    public function unpublish(){
        $this->published= false;
    }

    public function publish(){
        $this->published= true;
    }



}
