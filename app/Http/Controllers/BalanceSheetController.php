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
use PDF;

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

    public function print(Balance_sheet $data)
    {
        $data['balanceSheet'] = Balance_sheet::get()->groupBy('period'); 
        $data['trialBalance'] = Trial_balance::get(); 

        // $myLog = new myLog;
        // $myLog->go('show','','','general_ledgers');

        set_time_limit(2020);
        $pdf = PDF::loadView('balanceSheets.print', $data);
        return $pdf->download('balanceSheets_.'.date('Y-m-d_H:i:s').'.pdf');

        // return view('profitLoss.index', $data);
    }
}
