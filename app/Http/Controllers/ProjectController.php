<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Project;
use App\Project_status;
use App\Service;
use App\Customer;
use Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $data)
    {
        return view('projects.index', ['projects' => $data->paginate(15)]);
    }

    public function create()
    {
        $service = Service::get();
        $customer = Customer::get();
        $projectStatus = Project_status::get();

        return view('projects.create', compact('service','customer','projectStatus'));
    }

    public function store(ProjectRequest $request, Project $model)
    {
        $model->create($request->all());

        return redirect()->route('project.index')->withStatus(__('Project successfully added.'));
    }

    public function edit($id='')
    {
        $project = Project::findOrFail($id);
        $service = Service::get();
        $customer = Customer::get();
        $projectStatus = Project_status::get();

        return view('projects.edit', compact('project','service','customer','projectStatus'));
    }

    public function update(ProjectRequest $request, $id='')
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return redirect()->route('project.index')->withStatus(__('Project successfully updated.'));
    }

    public function destroy($id='')
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('project.index')->withStatus(__('Project successfully deleted.'));
    }
}
