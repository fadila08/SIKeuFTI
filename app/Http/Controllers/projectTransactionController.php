<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\GeneralLedgerRequest;
use App\Http\Requests\LedgerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\General_ledger;
use App\Ledger;
use App\Coa;
use App\Project;
use App\Http\Library\myLog;
use Auth;
use DB;
use Carbon\Carbon;

class projectTransactionController extends Controller
{
    public function create()
    {
        $project = Project::get();
        $coa = Coa::get();

        return view('projectTransactions.create', compact('project','coa'));
    }

    public function store(GeneralLedgerRequest $request, General_ledger $model)
    {
        //insert to jurnal umum
        $proof = $request->file('upload_proof')->store('proof_transactions');
        $model->create($request->merge(['nominal' => Crypt::encryptString($request->get('nominal'))],['upload_proof' => $proof])->all());

        //insert to buku besar
        $gledger = General_ledger::latest()->first();
        $ledger1 = Ledger::where('id_coa','=',$gledger->id_debet_acc)->latest()->first();
        $ledger2 = Ledger::where('id_coa','=',$gledger->id_cred_acc)->latest()->first();
        
        $acc1 = $gledger->id_debet_acc;
        $acc2 = $gledger->id_cred_acc;
        $desc = $gledger->id;
        $nominal = (int)Crypt::decryptString($gledger->nominal);

        //inputan pertama (deb acc)
        if ($ledger1 != null) {
            $deb_saldo1 = Crypt::decryptString($ledger1->debet_saldo);
            $deb_saldo1 = (int)$deb_saldo1;
            $cred_saldo1 = Crypt::decryptString($ledger1->cred_saldo);
            $cred_saldo1 = (int)$cred_saldo1;
            
            if ($deb_saldo1 != 0) {
                $n_deb_saldo1 = $deb_saldo1+$nominal;
                $n_deb_saldo1 = (string)$n_deb_saldo1;    
            } else {
                $n_deb_saldo1 = "0";
            }
            if($cred_saldo1 != 0) {
                $n_cred_saldo1 = $cred_saldo1-$nominal;
                $n_cred_saldo1 = (string)$n_cred_saldo1;    
            }
            else {
                $n_cred_saldo1 = "0";
            }
            
            DB::table('ledgers')->insert(['id_coa' => $acc1,
                                        'id_desc' => $desc,
                                        'debet_saldo' => Crypt::encryptString($n_deb_saldo1),
                                        'cred_saldo' => Crypt::encryptString($n_cred_saldo1),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                        ]);

        } else {
            $n_deb_saldo1 = (string)$nominal;
            $n_cred_saldo1 = "0";

            DB::table('ledgers')->insert(['id_coa' => $acc1,
                                        'id_desc' => $desc,
                                        'debet_saldo' => Crypt::encryptString($n_deb_saldo1),
                                        'cred_saldo' => Crypt::encryptString($n_cred_saldo1),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                        ]);

        }
        
        //inputan kedua (cred acc)
        if ($ledger2 != null) {
            $deb_saldo2 = Crypt::decryptString($ledger2->debet_saldo);
            $deb_saldo2 = (int)$deb_saldo2;
            $cred_saldo2 = Crypt::decryptString($ledger2->cred_saldo);
            $cred_saldo2 = (int)$cred_saldo2;
        
            if ($cred_saldo2 != 0) {
                $n_cred_saldo2 = $cred_saldo2+$nominal;
                $n_cred_saldo2 = (string)$n_cred_saldo2;    
            } else {
                $n_cred_saldo2 = "0";
            }
            if ($deb_saldo2 != 0) {
                $n_deb_saldo2 = $deb_saldo2-$nominal;
                $n_deb_saldo2 = (string)$n_deb_saldo2;    
            } else {
                $n_deb_saldo2 = "0";
            }

            DB::table('ledgers')->insert(['id_coa' => $acc2,
                                        'id_desc' => $desc,
                                        'debet_saldo' => Crypt::encryptString($n_deb_saldo2),
                                        'cred_saldo' => Crypt::encryptString($n_cred_saldo2),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                        ]);

        } else {
            $n_deb_saldo2 = "0";
            $n_cred_saldo2 = (string)$nominal;

            DB::table('ledgers')->insert(['id_coa' => $acc2,
                                        'id_desc' => $desc,
                                        'debet_saldo' => Crypt::encryptString($n_deb_saldo2),
                                        'cred_saldo' => Crypt::encryptString($n_cred_saldo2),
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                        ]);

        }
        
        //insert to neraca saldo

        // $myLog = new myLog;
        // $myLog->go('store','',\json_encode($request->all()),'transactions');

        return redirect()->route('projectTransaction.create')->withStatus(__('Project Transaction successfully added.'));
    }
}
