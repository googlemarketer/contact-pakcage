<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\Models\Admin\Admin;
use Googlemarketer\Contact\Tag;

class Article extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['title', 'body', 'priority','published','published_at','cover_image','slug','admin_id',];

    protected $dates = [
        'published_at'
    ];

    //protected $dateFormat = 'U';

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
       return 'slug';
    }

    /**
	*An article is owned by an user.
	*
	*returns \Illuminate\Database\Eloquent\Relations\BelongsTo
    */

    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function getTagListAttribute(){
        return $this->tags->pluck('id');
    }

    public function path(){
        return route('admin.article.show', $this);
    }

    // public function getPublishedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->format('m/d/Y');
    // }
}
