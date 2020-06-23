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
}
