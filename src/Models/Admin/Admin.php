<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;  default extends this class

use Googlemarketer\Contact\Models\Admin\Category;
use Googlemarketer\Contact\Models\Admin\Subcategory;
use Googlemarketer\Contact\Models\Admin\Service;
use Googlemarketer\Contact\Models\Admin\Subservice;
use Googlemarketer\Contact\Models\Admin\Role;
use Googlemarketer\Contact\Models\Admin\RolePermission;
use Googlemarketer\Contact\Models\Admin\Job;
use Googlemarketer\Contact\Models\Admin\Article;
use Googlemarketer\Contact\Models\Admin\Project;
use Googlemarketer\Contact\Models\Tag;
use Googlemarketer\Contact\Models\AdminMessage;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

        protected $fillable = [
            'name', 'email', 'mobile', 'password','role','active' ,'slug'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];

        public function getRouteKeyName(){
            return 'slug';
        }

        public function categories(){
            return $this->hasMany(Category::class);
        }

        public function subcategories(){
            return $this->hasMany(Subcategory::class);
        }

        public function services(){
            return $this->hasMany(Service::class);
        }

        public function subservices(){
            return $this->hasMany(Subservice::class);
        }

        public function jobs(){
            return $this->hasMany(Job::class);
        }

        public function articles(){
            return $this->hasMany(Article::class);
        }

        public function projects(){
            return $this->hasMany(Project::class);
        }

        public function tags(){
            return $this->hasMany(Tag::class);
        }

        public function adminmessages(){
            return $this->hasMany(AdminMessage::class);
        }

       public function roles(){
            return $this->belongsToMany(Role::class,'admin_roles');
        }

        public function isAuthorized($object, $operation)
         {
             return Db::table('role_permissions')
                 ->where('object', $object)
                 ->where('operation', $operation)
                 ->join('admin_roles', 'admin_roles.role_id', '=', 'role_permissions.role_id')
                 ->where('admin_roles.admin_id', $this->id)
                 ->exists();
         }
}
