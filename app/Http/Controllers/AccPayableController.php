<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AccPayableRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\General_ledger;
use App\Acc_payable;
use App\Http\Library\myLog;
use Auth;

class AccPayableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Acc_payable $data)
    {
        $data = Acc_payable::with('transaction')->get()->groupBy('transaction->id_creditor'); 
       
        // $myLog = new myLog;
        // $myLog->go('show','','','ledgers');

        return view('accPayable.index', ['accPayables' => $data]);
    }

    public function edit($id='')
    {
        $accPayable = Acc_payable::findOrFail($id);
        $transaction = General_ledger::where('id','=',$accPayable->id_transaction)->get();

        return view('accPayable.edit', compact('accPayable','transaction'));
    }

    public function update(AccPayableRequest $request, $id='')
    {
        $accPayable = Acc_payable::findOrFail($id);

        // $before_value = \json_encode($project);

        $accPayable->update($request->all());

        // $myLog = new myLog;
        // $myLog->go('update',$before_value,\json_encode($request->all()),'projects');

        return redirect()->route('accPayable.index')->withStatus(__('Due Date successfully updated.'));
    }


}
