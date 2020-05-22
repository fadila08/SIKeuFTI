<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Trial_balance;
use App\Ledger;
use App\General_ledger;
use App\Coa;
use App\Http\Library\myLog;
use Auth;

class trialBalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Trial_balance $data)
    {
        $data = Trial_balance::orderBy('id_coa', 'ASC')->get();

        $myLog = new myLog;
        $myLog->go('show','','','ledgers');

        return view('trialBalances.index', ['trialBalances' => $data]);
    }
}
