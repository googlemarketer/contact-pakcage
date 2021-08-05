<?php

namespace App\Models\Associate;

use Illuminate\Database\Eloquent\Model;

class AssociateProfile extends Model
{
    protected $fillable = ['title','body','address','area','city','phone','ccnumber','ccemail','web','logo','slug','associate_id'];

   public function getRouteKeyName(){
        return 'slug';
    }

    public function associate() {
        return $this->belongsTo(Associate::class);
    }
}
