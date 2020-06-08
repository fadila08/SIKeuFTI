<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AccReceivableRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Str;
use App\General_ledger;
use App\Acc_receivable;
use App\Http\Library\myLog;
use Auth;
use DB;

class AccReceivableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Acc_receivable $accReceivable)
    {
        //cari group idcustomer
        $data = DB::table('acc_receivable')
        ->join('general_ledgers', 'general_ledgers.id', '=', 'acc_receivable.id_transaction')
        ->join('projects', 'projects.id', '=', 'general_ledgers.id_project')
        ->join('customers', 'customers.id', '=', 'projects.id_cust')
        ->groupBy('projects.id_cust')
        ->get();

        //ambil data accreceivable
        $data2 = Acc_receivable::with('transaction.project.customer')->get();

        //seleksi data accreceivable ke group idcustomer
        $accReceivable = array();
        foreach ($data as $key => $value) {
            foreach ($data2 as $key2 => $item) {
                if ($value->id_cust == $item->transaction->project->id_cust) {
                    $accReceivable[$value->id_cust][] = $item;
                }
            }
        }

        $myLog = new myLog;
        $myLog->go('show','','','acc_receivable');

        return view('accReceivables.index', ['accReceivables' => $accReceivable]);
    }

    public function edit($id='')
    {
        $accReceivable = Acc_receivable::findOrFail($id);
        $transaction = General_ledger::where('id','=',$accReceivable->id_transaction)->get();

        return view('accReceivables.edit', compact('accReceivable','transaction'));
    }

    public function update(AccReceivableRequest $request, $id='')
    {
        $accReceivable = Acc_receivable::findOrFail($id);

        $before_value = \json_encode($accReceivable);

        $accReceivable->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'acc_receivable');

        return redirect()->route('accReceivable.index')->withStatus(__('Due Date successfully updated.'));
    }
}
