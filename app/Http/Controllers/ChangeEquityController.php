<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Profit_loss;
use App\Change_equity;
use App\Http\Library\myLog;
use Auth;

class ChangeEquityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Change_equity $data)
    {
        $data['changeEquity'] = Change_equity::get()->groupBy('period'); 

        // $myLog = new myLog;
        // $myLog->go('show','','','general_ledgers');

        return view('changeEquities.index', $data);
    }
}
