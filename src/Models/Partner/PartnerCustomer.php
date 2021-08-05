<?php

namespace Googlemarketer\Contact\Models\Partner;

use Illuminate\Database\Eloquent\Model;

use Googlemarketer\Contact\Models\Partner\Partner;

class PartnerCustomer extends Model
{
    protected $fillable = ['title','email','mobile','active','partner_id'];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }
}
