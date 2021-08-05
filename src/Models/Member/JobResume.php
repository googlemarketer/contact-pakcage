<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Googlemarketer\Contact\Models\Admin\Job;

class JobResume extends Model
{

    protected $fillable = ['first_name', 'last_name', 'email_address','position_applied_for','last_salary_drawn','expected_salary','joining_date','relocate','last_organization','reference','cover_image', 'slug','user_id','job_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
       return 'slug';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

     public function resumes(){
        return $this->belongsTo(Job::class,'job_id');
    }

}
