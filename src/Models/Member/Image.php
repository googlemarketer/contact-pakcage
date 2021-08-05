<?php

namespace Googlemarketer\Contact\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['images'];

    protected $casts = [
        'images' => 'array'
    ];
}
