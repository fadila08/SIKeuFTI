<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Maintenance;
use App\Http\Library\MyBackup\Restore_Database;

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
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $charset = 'utf8';
        $BACKUP_DIR = '';
        $BACKUP_FILE = 'myphp-backup.sql';
      
        // Report all errors
            /**
         * Instantiate Restore_Database and perform backup
         */
        // Report all errors
        error_reporting(E_ALL);
        // Set script max execution time
        set_time_limit(900); // 15 minutes

        if (php_sapi_name() != "cli") {
            echo '<div style="font-family: monospace;">';
        }

        $restoreDatabase = new Restore_Database($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName , $charset);
        $result = $restoreDatabase->restoreDb($BACKUP_DIR, $BACKUP_FILE) ? 'OK' : 'KO';
        $restoreDatabase->obfPrint("Restoration result: ".$result, 1);

        if (php_sapi_name() != "cli") {
            echo '</div>';
        }

        return redirect()->route('indexBackupRecovery')->withStatus(__('Recovery Database.'));
    }

    public function download()
    {
        $file = public_path()."/myphp-backup.sql";
        return response()->download($file);
    }
}
