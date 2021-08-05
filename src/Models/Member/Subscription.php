<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //  protected $fillable = ['first_name', 'last_name', 'email_address','position_applied_for','last_salary_drawn','expected_salary','joining_date','relocate','last_organization','reference','cover_image', 'slug','user_id'];
    protected $guarded = [];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
       return 'slug';
    }
}
