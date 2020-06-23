<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Profit_loss;
use App\Trial_balance;
use App\Http\Library\myLog;
use Auth;

class ProfitLossController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Profit_loss $data)
    {
        $data['profitLos'] = Profit_loss::get()->groupBy('period'); 
        $data['trialBalance'] = Trial_balance::get(); 

        // $myLog = new myLog;
        // $myLog->go('show','','','general_ledgers');

        return view('profitLoss.index', $data);
    }
}
