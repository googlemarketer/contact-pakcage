<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Googlemarketer\Contact\Models\Admin\Admin;

class AdminMessage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }

}
