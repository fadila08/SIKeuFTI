<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\GeneralLedgerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\General_ledger;
use App\Coa;
use App\Project;
use App\Http\Library\myLog;
use Auth;


class generalLedgerController extends Controller
{
    public function store(GeneralLedgerRequest $request, General_ledger $model)
    {

        // dd($request->file('upload_proof'));

        $proof = $request->file('upload_proof')->store('proof_transactions');

        $model->create($request->merge(['nominal' => Crypt::encryptString($request->get('nominal'))],['upload_proof' => $proof])->all());

        // $myLog = new myLog;
        // $myLog->go('store','',\json_encode($request->all()),'transactions');

        return redirect()->route('projectTransaction.create')->withStatus(__('Project Transaction successfully added.'));
    }
}
