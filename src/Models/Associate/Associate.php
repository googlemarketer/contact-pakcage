<?php

namespace App\Models\Associate;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;  default extends this class
use App\Models\Associate\AssociateProfile;
use App\Models\Associate\AssociateService;
use App\Models\Associate\AssociateCustomer;
use App\Models\Associate\AssociateReview;
use App\Models\Associate\AssociateMessage;

class Associate extends Authenticatable
{
    use Notifiable;

    protected $guard = 'associate';

    protected $fillable = [
        'name', 'email', 'mobile','subcategory_id', 'active', 'password', 'slug'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function getRouteKeyName(){
        return 'slug';
    }

    public function associateprofile(){
        return $this->hasOne(AssociateProfile::class);
    }

    public function associateservices(){
        return $this->hasOne(AssociateService::class);
    }

    public function associatecustomers(){
        return $this->hasMany(AssociateCustomer::class);
    }

    public function associatereviews(){
        return $this->hasMany(AssociateService::class);
    }

      public function associatemessages(){
        return $this->hasMany(AssociateMessage::class);
    }
}
