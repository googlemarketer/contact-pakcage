<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Googlemarketer\Contact\Models\Admin\Task;
use Googlemarketer\Contact\Models\Admin\Project;

class ProjectTaskController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin', ['except' => ['index','show']]);
    }

    public function store(Project $project)
    {
        $attributes = request()->validate(['title' => 'required', 'description' => 'required']);

        $project->addTask($attributes);

        return back();
    }

    public function update(Project $project, Task $task)
    {
        request()->has('completed') ? $task->complete() : $task->incomplete();

        return back();
    }
}
