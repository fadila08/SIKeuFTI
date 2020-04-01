<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Service;
use Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Service $data)
    {
        return view('services.index', ['services' => $data->paginate(15)]);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request, Service $model)
    {
        $model->create($request->all());

        return redirect()->route('services.index')->withStatus(__('Service successfully added.'));
    }

    public function edit($id='')
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, $id='')
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('services.index')->withStatus(__('Service successfully updated.'));
    }

    public function destroy($id='')
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->withStatus(__('Service successfully deleted.'));
    }
}
