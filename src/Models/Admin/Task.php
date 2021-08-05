<?php

namespace Googlemarketer\Contact\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model {

    use HasFactory, Notifiable;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function complete($completed = true)
    {
        $this->update(compact('completed'));
    }

    public function incomplete()
    {
        $this->complete(false);
    }
}
