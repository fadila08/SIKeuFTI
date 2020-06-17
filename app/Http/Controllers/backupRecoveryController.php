<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Maintenance;


class backupRecoveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Maintenance $data)
    {        
        $data = Maintenance::get();
     
        return view('backupRecoveries.index', ['db' => $data]);
    }

    public function recover()
    {
        return redirect()->route('indexBackupRecovery')->withStatus(__('Recovery Database.'));
    }

    public function download()
    {
        return response()->download('public/myphp-backup.sql');
    }
}
