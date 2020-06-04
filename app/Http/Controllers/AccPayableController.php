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
    private $id_creditor = "";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Acc_payable $data)
    {
        $transaction = General_ledger::get();

        // $this->id_creditor = $transaction->id_creditor;

        // $data = Acc_payable::with('transaction')->whereHas('transaction', function (Builder $query) {
        //                     $query->groupBy($this->id_creditor);
        //                     })->get();
        
        $data = Acc_payable::with('transaction')->get()->groupBy('transaction->id_creditor'); 
       
        $myLog = new myLog;
        $myLog->go('show','','','acc_payable');

        return view('accPayables.index', ['accPayables' => $data]);
    }

    public function edit($id='')
    {
        $accPayable = Acc_payable::findOrFail($id);
        $transaction = General_ledger::where('id','=',$accPayable->id_transaction)->get();

        return view('accPayables.edit', compact('accPayable','transaction'));
    }

    public function update(AccPayableRequest $request, $id='')
    {
        $accPayable = Acc_payable::findOrFail($id);

        $before_value = \json_encode($accPayable);

        $accPayable->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'acc_payable');

        return redirect()->route('accPayable.index')->withStatus(__('Due Date successfully updated.'));
    }


}
