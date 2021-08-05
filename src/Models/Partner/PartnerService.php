<?php

namespace Googlemarketer\Contact\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Googlemarketer\Contact\Models\Partner\Partner;

class PartnerService extends Model
{
    protected $fillable = ['service_id','subservice_id','price','priority','partner_id'];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
