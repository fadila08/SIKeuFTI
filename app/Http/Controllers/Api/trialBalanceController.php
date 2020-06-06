<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
use DB;
use Carbon\Carbon;
use App\Http\Library\graph;

class trialBalanceController extends Controller
{
    public function getTotalRevenue(){
        $graph = new graph;
        return response()->json($graph->showTotalRevenue());
    }
}
