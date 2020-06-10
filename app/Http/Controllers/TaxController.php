<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaxRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Str;
use App\General_ledger;
use App\Tax;
use App\Http\Library\myLog;
use Auth;
use DB;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Tax $tax)
    { 
        $myLog = new myLog;
        $myLog->go('show','','','taxes');

        $tax = Tax::orderBy('id', 'ASC')->paginate(15);

        return view('taxes.index', ['taxes' => $tax]);
    }

    public function edit($id='')
    {
        $tax = Tax::findOrFail($id);
        $transaction = General_ledger::where('id','=',$tax->id_transaction)->get();

        return view('taxes.edit', compact('tax','transaction'));
    }

    public function update(TaxRequest $request, $id='')
    {
        $tax = Tax::findOrFail($id);

        $before_value = \json_encode($tax);

        $tax->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'taxes');

        return redirect()->route('tax.index')->withStatus(__('Due Date successfully updated.'));
    }
}
