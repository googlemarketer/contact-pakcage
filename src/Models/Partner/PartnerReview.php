<?php

namespace Googlemarketer\Contact\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Googlemarketer\Contact\Models\Partner\Partner;

class PartnerReview extends Model
{
    protected $fillable = ['review','user_id','partner_id'];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
