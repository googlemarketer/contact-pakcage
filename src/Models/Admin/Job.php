<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Googlemarketer\Contact\Models\Admin\Admin;
use Googlemarketer\Contact\Models\Member\JobResume;

class Job extends Model {

    use HasFactory, Notifiable;

    protected $fillable = ['title','published','body','vacancy','slug','priority','published','published_at','cover_image', 'admin_id'];

    protected $dates = [
        'published_at'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
       return 'slug';
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function getTagListAttribute(){
        return $this->tags->pluck('id');
    }

    public function jobresumes(){
        return $this->hasMany(JobResume::class);
    }
}
