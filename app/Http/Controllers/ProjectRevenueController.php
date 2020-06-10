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
        //ambil data ledger yang akun pendapatan proyek sajaaw
        $data = DB::table('ledgers')
        ->join('general_ledgers','general_ledgers.id','=','ledgers.id_desc')
        ->join('projects','projects.id','=','general_ledgers.id_project')
        ->join('customers','customers.id','=','projects.id_cust')
        ->join('coas','coas.id','=','ledgers.id_coa')
        ->where('coas.acc_name', 'like', 'pendapatan usaha%')
        ->groupBy('id_project')
        ->get();
         
        $myLog = new myLog;
        $myLog->go('show','','','ledgers');

        return view('projectRevenues.index', ['projectRevenues' => $data]);
    }
}
