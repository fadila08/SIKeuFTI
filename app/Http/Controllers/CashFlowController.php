<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Profit_loss;
use App\Change_equity;
use App\Balance_sheet;
use App\Cash_flow;
use App\Http\Library\myLog;
use Auth;
use PDF;

class CashFlowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Cash_flow $data)
    {
        $data['cashFlow'] = Cash_flow::get()->groupBy('period'); 

        // $myLog = new myLog;
        // $myLog->go('show','','','general_ledgers');

        return view('cashFlows.index', $data);
    }

    public function print(Cash_flow $data)
    {
        $data['cashFlow'] = Cash_flow::get()->groupBy('period'); 

        // $myLog = new myLog;
        // $myLog->go('show','','','general_ledgers');

        set_time_limit(2020);
        $pdf = PDF::loadView('cashFlows.print', $data);
        return $pdf->download('cashFlows_.'.date('Y-m-d_H:i:s').'.pdf');

        // return view('profitLoss.index', $data);
    }

}
