<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Library\MyBackup\Backup_Database;
use GuzzleHttp\Client;
use App\Maintenance;

class DBreplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replicate:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will replicate db from primary db to secondary db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = Maintenance::first();
        $data->status = "1";
        $data->save();

        $start = microtime(true);

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

            $result = $client->request('POST', 'https://keuangan.fittechinova.com/api/data/import', [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen('myphp-backup.sql', 'r'),
                    ],
                ],
            ]);

            echo $result->getBody();

            $time_elapsed_secs = microtime(true) - $start;
            $backupDatabase->obfPrint('Lama waktu eksekusi.. '.$time_elapsed_secs.' detik',1);
        }
        $data = Maintenance::first();
        $data->status = "0";
        $data->save();
    }
}
