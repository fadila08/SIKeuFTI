<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Balance_sheet;
use App\Trial_balance;
use App\Http\Library\myLog;
use Auth;

class BalanceSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Balance_sheet $data)
    {
        $data['balanceSheet'] = Balance_sheet::get()->groupBy('period'); 
        $data['trialBalance'] = Trial_balance::get(); 

        // $myLog = new myLog;
        // $myLog->go('show','','','general_ledgers');

        return view('balanceSheets.index', $data);
    }
}
