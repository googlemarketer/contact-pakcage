<?php

namespace App\Models\Associate;

use Illuminate\Database\Eloquent\Model;
use App\Models\Associate\AssociateReview;

class AssociateReview extends Model
{
    protected $fillable = ['review','user_id','partner_id'];

    public function associate(){
        return $this->belongsTo(Associate::class);
    }
}
