<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Creditor;
use App\Http\Library\myLog;
use Auth;


class CreditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Creditor $data)
    {
        $myLog = new myLog;
        $myLog->go('show','','','creditors');

        return view('creditors.index', ['creditors' => $data->paginate(15)]);
    }

    public function create()
    {
        return view('creditors.create');
    }

    public function store(CreditorRequest $request, Creditor $model)
    {
        $model->create($request->all());

        $myLog = new myLog;
        $myLog->go('store','',\json_encode($request->all()),'creditors');

        return redirect()->route('cred.index')->withStatus(__('Creditor successfully added.'));
    }

    public function edit($id='')
    {
        $creditor = Creditor::findOrFail($id);
        return view('creditors.edit', compact('creditor'));
    }

    public function update(CreditorRequest $request, $id='')
    {
        $creditor = Creditor::findOrFail($id);

        $before_value = \json_encode($creditor);

        $creditor->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'creditors');

        return redirect()->route('cred.index')->withStatus(__('Creditor successfully updated.'));
    }

    public function destroy($id='')
    {
        $creditor = Creditor::findOrFail($id);

        $before_value = \json_encode($creditor);

        $creditor->delete();

        $myLog = new myLog;
        $myLog->go('destroy',$before_value,'','creditors');

        return redirect()->route('cred.index')->withStatus(__('Creditor successfully deleted.'));
    }
}
