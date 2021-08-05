<?php

namespace App\Models\Associate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Associate\Associate;

class AssociateMessage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function associate(){
        return $this->belongsTo(Associate::class,'associate_id');
    }
}
