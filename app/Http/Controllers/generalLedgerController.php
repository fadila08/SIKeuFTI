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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(General_ledger $data)
    {
        $lastData = General_ledger::orderBy('id', 'DESC')->first();
        $data['lastId'] = $lastData->id;

        $data['generalLedgers'] = $data->paginate(15);

        $myLog = new myLog;
        $myLog->go('show','','','general_ledgers');

        return view('generalLedgers.index', $data);
    }

}
