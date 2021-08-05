<?php

namespace App\Models\Associate;

use Illuminate\Database\Eloquent\Model;

use App\Models\Associate\AssociateCustomer;

class AssociateCustomer extends Model
{
    protected $fillable = ['title','email','mobile','active','partner_id'];

    public function associate(){
        return $this->belongsTo(Associate::class);
    }
}
