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
        $myLog = new myLog;
        $myLog->go('show','','','logs');
        
        $data = Log::orderBy('created_at', 'DESC')->paginate(15);
     
        return view('logs.index', ['logs' => $data]);
    }
}
