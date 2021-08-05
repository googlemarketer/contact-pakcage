<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends Model {

   use HasFactory, Notifiable;

   protected $fillable = ['role_id','object','operation'];
}
