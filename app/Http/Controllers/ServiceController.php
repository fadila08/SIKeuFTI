<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Service;
use Auth;

//tambahkan library ini
use App\Http\Library\myLog;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Service $data)
    {
        // insert perubahan ke db
        // parameter nya
        // {
        // 1. type = nama fungsinya
        // 2. before value = sebelum data dirubah (gunakan json_encode)
        // 3. after value = sesudah data dirubah (gunakan json_decode)
        // 4. tabel = ini dari tabel mana
        // }

        // berhubung ini show maka before dan after valuenya kosong
        $myLog = new myLog;
        $myLog->go('show','','','Service');

        return view('services.index', ['services' => $data->paginate(15)]);
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request, Service $model)
    {
        $model->create($request->all());

        // insert perubahan ke db
        // parameter nya
        // {
        // 1. type = nama fungsinya
        // 2. before value = sebelum data dirubah (gunakan json_encode)
        // 3. after value = sesudah data dirubah (gunakan json_decode)
        // 4. tabel = ini dari tabel mana
        // }

        // berhubung ini insert maka before valuenya kosong
        $myLog = new myLog;
        $myLog->go('store','',\json_encode($request->all()),'Service');

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

        //tambahkan variabel penampung value awal, letakkan variabel ini setelah find atau where
        $before_value = \json_encode($service);

        $service->update($request->all());

        // insert perubahan ke db
        // parameter nya
        // {
        // 1. type = nama fungsinya
        // 2. before value = sebelum data dirubah (gunakan json_encode)
        // 3. after value = sesudah data dirubah (gunakan json_decode)
        // 4. tabel = ini dari tabel mana
        // }

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'Service');

        return redirect()->route('services.index')->withStatus(__('Service successfully updated.'));
    }

    public function destroy($id='')
    {
        $service = Service::findOrFail($id);

         //tambahkan variabel penampung value awal, letakkan variabel ini setelah find atau where
         $before_value = \json_encode($service);

        $service->delete();

        // insert perubahan ke db
        // parameter nya
        // {
        // 1. type = nama fungsinya
        // 2. before value = sebelum data dirubah (gunakan json_encode)
        // 3. after value = sesudah data dirubah (gunakan json_decode)
        // 4. tabel = ini dari tabel mana
        // }

        //khusus destroy after value dikosong kan

        $myLog = new myLog;
        $myLog->go('destroy',$before_value,'','Service');

        return redirect()->route('services.index')->withStatus(__('Service successfully deleted.'));
    }
}
