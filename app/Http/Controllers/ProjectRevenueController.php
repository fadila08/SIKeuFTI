<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Ledger;
use App\General_ledger;
use App\Coa;
use App\Http\Library\myLog;
use Auth;
use DB;

class ProjectRevenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Ledger $data)
    {  
        $data = Ledger::with(['coa'])->whereHas('coa', function (Builder $query) {
            $query->where('acc_name', 'like', 'pendapatan usaha%');
            })->get()->groupBy('id_coa'); 

        $myLog = new myLog;
        $myLog->go('show','','','ledgers');

        return view('projectRevenues.index', ['projectRevenues' => $data]);
    }
}
