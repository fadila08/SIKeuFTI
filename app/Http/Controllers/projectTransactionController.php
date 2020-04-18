<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\ProjectTrcRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Transaction;
use App\Coa;
use App\Project;
use App\Http\Library\myLog;
use Auth;

class projectTransactionController extends Controller
{
    public function create()
    {
        $project = Project::get();
        $coa = Coa::get();

        return view('projectTransactions.create', compact('project','coa'));
    }

    public function store(ProjectTrcRequest $request, Transaction $model)
    {
        $model->create($request->merge(['nominal' => Crypt::encryptString($request->get('nominal'))])->all());

        $myLog = new myLog;
        $myLog->go('store','',\json_encode($request->all()),'transactions');

        return redirect()->route('projectTransaction.create')->withStatus(__('Project Transaction successfully added.'));
    }
}
