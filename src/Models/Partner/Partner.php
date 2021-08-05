<?php

namespace Googlemarketer\Contact\Models\Partner;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;  default extends this class

use Googlemarketer\Contact\Models\Partner\Partnerprofile;
use Googlemarketer\Contact\Models\Partner\Partnerservice;
use Googlemarketer\Contact\Models\Partner\Partnercustomer;
use App\Models\Partner\Partnerreview;

class Partner extends Authenticatable
{
    use Notifiable;

    protected $guard = 'partner';

    protected $fillable = [
        'name', 'email', 'mobile','subcategory_id', 'active', 'slug','password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function partnerprofile(){
        return $this->hasOne(Partnerprofile::class);
    }

    public function partnerservice(){
        return $this->hasOne(Partnerservice::class);
    }

    public function partnercustomers(){
        return $this->hasMany(Partnercustomer::class);
    }

    public function partnerreviews(){
        return $this->hasMany(Partnerservice::class);
    }
}
