<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Library\MyBackup\Backup_Database;
use GuzzleHttp\Client;

class DatabaseController extends Controller
{
    public function export(){
        //ENTER THE RELEVANT INFO BELOW
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');
        $charset = 'utf8';
        $BACKUP_DIR = '.';
        $TABLES = '*';
      
// Report all errors
        error_reporting(E_ALL);
        // Set script max execution time
        set_time_limit(900); // 15 minutes

        if (php_sapi_name() != "cli") {
            echo '<div style="font-family: monospace;">';
        }

        $backupDatabase = new Backup_Database($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName , $charset);
        $result = $backupDatabase->backupTables($TABLES, $BACKUP_DIR) ? 'OK' : 'KO';
        $backupDatabase->obfPrint('Backup result: ' . $result, 1);

        // Use $output variable for further processing, for example to send it by email
        $output = $backupDatabase->getOutput();

        if (php_sapi_name() != "cli") {
            echo '</div>';
        }
     

        if ($result == "OK") {
            $backupDatabase->obfPrint('Proses kirim data, mohon ditunggu..',1);

            //ganti url dengan web kedua
            $client = new Client();

            $result = $client->request('POST', 'http://keuangan.fittechinova.com/api/data/import', [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen('myphp-backup.sql', 'r'),
                    ],
                ],
            ]);

            echo $result->getBody();
        }
    }
}
