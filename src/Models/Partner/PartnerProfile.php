<?php

namespace Googlemarketer\Contact\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Googlemarketer\Contact\Models\Partner\Partner;

class PartnerProfile extends Model
{
    protected $fillable = ['title','body','address','area','city','phone','ccnumber','ccemail','web','logo','slug','partner_id'];

    public function partner(){
        return $this->belongsTo(Partner::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
