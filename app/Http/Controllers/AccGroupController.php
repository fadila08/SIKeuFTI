<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AccGroupRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Account_group;
use App\Http\Library\myLog;
use Auth;

class AccGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Account_group $data)
    {
        $myLog = new myLog;
        $myLog->go('show','','','account_groups');

        return view('accGroups.index', ['accGroups' => $data->paginate(15)]);
    }

    public function create()
    {
        return view('accGroups.create');
    }

    public function store(AccGroupRequest $request, Account_group $model)
    {
        $model->create($request->all());

        $myLog = new myLog;
        $myLog->go('store','',\json_encode($request->all()),'account_groups');

        return redirect()->route('accGroup.index')->withStatus(__('Account Group successfully added.'));
    }

    public function edit($id='')
    {
        $accGroup = Account_group::findOrFail($id);

        return view('accGroups.edit', compact('accGroup'));
    }

    public function update(AccGroupRequest $request, $id='')
    {
        $accGroup = Account_group::findOrFail($id);

        $before_value = \json_encode($accGroup);

        $accGroup->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'account_groups');

        return redirect()->route('accGroup.index')->withStatus(__('Account Group successfully updated.'));
    }

    public function destroy($id='')
    {
        $accGroup = Account_group::findOrFail($id);

        $before_value = \json_encode($accGroup);

        $accGroup->delete();

        $myLog = new myLog;
        $myLog->go('destroy',$before_value,'','account_groups');

        return redirect()->route('accGroup.index')->withStatus(__('Account Group successfully deleted.'));
    }
}
