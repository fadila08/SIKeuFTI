<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AccPayableRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Str;
use App\General_ledger;
use App\Acc_payable;
use App\Http\Library\myLog;
use Auth;
use DB;

class AccPayableController extends Controller
{
    private $id_creditor = "";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Acc_payable $data)
    {
        // $transaction = General_ledger::get();

        // $this->id_creditor = $transaction->id_creditor;



        // $data = Acc_payable::with(['transaction' => function($query){
        //     $query->groupBy('id_creditor');
        // }])->get();

        //cari group idcreditor
        $data = DB::table('acc_payable')
        ->join('general_ledgers', 'general_ledgers.id', '=', 'acc_payable.id_transaction')
        ->groupBy('general_ledgers.id_creditor')
        ->get();

        //ambil data accpayable
        $data2 = Acc_payable::with('transaction.creditor')->get();

        //seleksi data accpayable ke group idcreditor
        $accPayable = array();
        foreach ($data as $key => $value) {
            foreach ($data2 as $key2 => $item) {
                if ($value->id_creditor == $item->transaction->id_creditor) {
                    $accPayable[$value->id_creditor][] = $item;
                }
            }
        }

        dd( $accPayable);

        
        // $data = Acc_payable::with('transaction')->get()->groupBy('transaction->id_creditor'); 
       
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
