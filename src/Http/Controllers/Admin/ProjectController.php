<?php

namespace Googlemarketer\Contact\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Googlemarketer\Contact\Models\Admin\Project;
use Googlemarketer\Contact\Models\Admin\Task;

class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin', ['except' => ['index','show']]);
    }

    public function index()

    {
    $projects = Project::orderBy('created_at','desc')->paginate(9);
    $tasks = Task::all();
    return view('admin.project.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.project.create');
    }

    public function store()
    {
        Project::create(request()->validate([
            'title' => ['required', 'min: 3'],
            'description' => ['required', 'min: 10']
        ]));

        return redirect('/projects')->with('message', 'Project was created successfully');
    }

    public function edit(Project $project)
    {
        return view('admin.project.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $project->update(request(['title', 'description']));

        $project->save();

        return redirect('/projects');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect('/projects');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);

        return view ('admin.project.show', compact('project'));
    }
}
