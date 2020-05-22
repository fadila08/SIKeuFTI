<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Ledger;
use App\General_ledger;
use App\Coa;
use App\Http\Library\myLog;
use Auth;

class LedgerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Ledger $data)
    {
        $data = Ledger::get()->groupBy('id_coa'); 

        //view dummy
        // return view('coba.coba', ['coba' => $data]);
        
        // $myLog = new myLog;
        // $myLog->go('show','','','projects');

        return view('ledgers.index', ['ledgers' => $data]);
    }
}
