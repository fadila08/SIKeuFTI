<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Log;
use App\User;
use App\Http\Library\myLog;
use Auth;

class logActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Log $data)
    {
        // tambahkan pengecekan role
        if(Auth::user()->id_roles == 1){
            $header = 'layouts.app';
        }
        if(Auth::user()->id_roles == 2){
            $header = 'layouts.appadmin';
        }
        
        $myLog = new myLog;
        $myLog->go('show','','','logs');
        
        $data = Log::orderBy('created_at', 'DESC')->paginate(15);
     
        return view('logs.index', ['logs' => $data]);
    }
}
