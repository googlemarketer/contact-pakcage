<?php

namespace App\Models\Associate;

use Illuminate\Database\Eloquent\Model;
use App\Models\Associate\Associate;

class AssociateService extends Model
{
    protected $fillable = ['service_id','subservice_id','price','priority','partner_id'];

    public function associate(){
        return $this->belongsTo(Associate::class);
    }
}
