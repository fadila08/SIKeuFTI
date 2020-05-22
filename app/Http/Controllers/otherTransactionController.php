<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\GeneralLedgerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\General_ledger;
use App\Ledger;
use App\Trial_balance;
use App\Coa;
use App\Project;
use App\Http\Library\myLog;
use Auth;
use DB;
use Carbon\Carbon;

class otherTransactionController extends Controller
{
    public function create()
    {
        $coa = Coa::get();

        return view('otherTransactions.create', compact('coa'));
    }

    public function store(GeneralLedgerRequest $request, General_ledger $model)
    {
        //insert to jurnal umum
        $proof = $request->file('upload_proof')->store('proof_transactions');

        //di exclude dulu upload proofnya
        $data = $request->merge(['nominal' => Crypt::encryptString($request->get('nominal'))])->except('upload_proof');
        //ditambah secara manual
        $data['upload_proof'] = $proof;

        $model->create($data);

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
        $cek_gledger = General_ledger::latest()->first();
        $cek_akun_d = Trial_balance::where('id_coa','=',$cek_gledger->id_debet_acc)->first();
        $cek_akun_k = Trial_balance::where('id_coa','=',$cek_gledger->id_cred_acc)->first();
        $get_ledger_d = Ledger::where('id_coa','=',$cek_gledger->id_debet_acc)->latest()->first();
        $get_ledger_k = Ledger::where('id_coa','=',$cek_gledger->id_cred_acc)->latest()->first();
        
        $thn = Carbon::parse($cek_gledger->date)->format('Y');

        //inputan pertama
        if ($cek_akun_d != null) { 
            DB::table('trial_balances')->where('id_coa',$cek_gledger->id_debet_acc)->update([
                'period' => $thn,
                'id_coa' => $get_ledger_d->id_coa,
                'id_ledger' => $get_ledger_d->id,
                'created_at' => $cek_akun_d->created_at,
                'updated_at' => Carbon::now()
            ]);
        } else {
            DB::table('trial_balances')->insert(['period' => $thn,
                                        'id_coa' => $get_ledger_d->id_coa,
                                        'id_ledger' => $get_ledger_d->id,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                        ]);
        }

        //inputan kedua
        if ($cek_akun_k != null) {  
            DB::table('trial_balances')->where('id_coa',$cek_gledger->id_cred_acc)->update([
                'period' => $thn,
                'id_coa' => $get_ledger_k->id_coa,
                'id_ledger' => $get_ledger_k->id,
                'created_at' => $cek_akun_k->created_at,
                'updated_at' => Carbon::now()
            ]);
        } else {
            DB::table('trial_balances')->insert(['period' => $thn,
                                        'id_coa' => $get_ledger_k->id_coa,
                                        'id_ledger' => $get_ledger_k->id,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                        ]);
        }

        // $myLog = new myLog;
        // $myLog->go('store','',\json_encode($request->all()),'general_ledgers');
        // $myLog->go('store','',\json_encode($request->all()),'ledgers');
        // $myLog->go('store','',\json_encode($request->all()),'trial_balances');

        return redirect()->route('projectTransaction.create')->withStatus(__('Project Transaction successfully added.'));
    }
}
