<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\GeneralLedgerRequest;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\General_ledger;
use App\Ledger;
use App\Trial_balance;
use App\Coa;
use App\Creditor;
use App\Project;
use App\Account_group;
use App\Acc_payable;
use App\Http\Library\myLog;
use Auth;
use DB;
use Carbon\Carbon;

class otherTransactionController extends Controller
{
    private $id_creditor = "";

    public function create()
    {
        $coa = Coa::get();
        $creditor = Creditor::get();

        return view('otherTransactions.create', compact('coa','creditor'));
    }

    public function store(GeneralLedgerRequest $request, General_ledger $model)
    {
        $myLog = new myLog;

        //insert to jurnal umum
        $proof = $request->file('upload_proof')->store('proof_transactions'); 

        //di exclude dulu upload proofnya
        $data = $request->merge(['nominal' => Crypt::encryptString($request->get('nominal'))])->except('upload_proof');
        //ditambah secara manual
        $data['upload_proof'] = $proof;

        $model->create($data); 

        //log jurnal umum
        //sekali input, ke insert semuanya jadi 1 entri
        $myLog->go('store','',\json_encode($data),'general_ledgers');

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
            
            $ledgers_data_1 = array('id_coa' => $acc1,
                                    'id_desc' => $desc,
                                    'debet_saldo' => Crypt::encryptString($n_deb_saldo1),
                                    'cred_saldo' => Crypt::encryptString($n_cred_saldo1),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('ledgers')->insert($ledgers_data_1);

            //log buku besar (deb acc)
            $myLog->go('store','',\json_encode($ledgers_data_1),'ledgers');

        } else {
            $n_deb_saldo1 = (string)$nominal;
            $n_cred_saldo1 = "0";

            $ledgers_data_1 = array('id_coa' => $acc1,
                                    'id_desc' => $desc,
                                    'debet_saldo' => Crypt::encryptString($n_deb_saldo1),
                                    'cred_saldo' => Crypt::encryptString($n_cred_saldo1),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('ledgers')->insert($ledgers_data_1);

            //log buku besar (deb acc)
             $myLog->go('store','',\json_encode($ledgers_data_1),'ledgers');
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

            $ledgers_data_2 = array('id_coa' => $acc2,
                                    'id_desc' => $desc,
                                    'debet_saldo' => Crypt::encryptString($n_deb_saldo2),
                                    'cred_saldo' => Crypt::encryptString($n_cred_saldo2),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('ledgers')->insert($ledgers_data_2);

            //log buku besar (cred acc)
            $myLog->go('store','',\json_encode($ledgers_data_2),'ledgers');

        } else {
            $n_deb_saldo2 = "0";
            $n_cred_saldo2 = (string)$nominal;

            $ledgers_data_2 = array('id_coa' => $acc2,
                                    'id_desc' => $desc,
                                    'debet_saldo' => Crypt::encryptString($n_deb_saldo2),
                                    'cred_saldo' => Crypt::encryptString($n_cred_saldo2),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('ledgers')->insert($ledgers_data_2);

            //log buku besar (cred acc)
            $myLog->go('store','',\json_encode($ledgers_data_2),'ledgers');
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

            //data before value log activity
            $tb_before_value1 = Trial_balance::where('id_coa',$cek_gledger->id_debet_acc)->first();
            $before_value1 = \json_encode($tb_before_value1);

            $tbalance_data1 = array('period' => $thn,
                                    'id_coa' => $get_ledger_d->id_coa,
                                    'id_ledger' => $get_ledger_d->id,
                                    'created_at' => $cek_akun_d->created_at,
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('trial_balances')->where('id_coa',$cek_gledger->id_debet_acc)->update($tbalance_data1);
       
            $myLog->go('update',$before_value1,\json_encode($tbalance_data1),'trial_balances');    

        } else {

            $tbalance_data1 = array('period' => $thn,
                                    'id_coa' => $get_ledger_d->id_coa,
                                    'id_ledger' => $get_ledger_d->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('trial_balances')->insert($tbalance_data1);

            $myLog->go('store','',\json_encode($tbalance_data1),'trial_balances');
        }

        //inputan kedua
        if ($cek_akun_k != null) {  

            //data before value log activity
            $tb_before_value2 = Trial_balance::where('id_coa',$cek_gledger->id_cred_acc)->first();
            $before_value2 = \json_encode($tb_before_value2);

            $tbalance_data2 = array('period' => $thn,
                                    'id_coa' => $get_ledger_k->id_coa,
                                    'id_ledger' => $get_ledger_k->id,
                                    'created_at' => $cek_akun_k->created_at,
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('trial_balances')->where('id_coa',$cek_gledger->id_cred_acc)->update($tbalance_data2);
        
            $myLog->go('update',$before_value2,\json_encode($tbalance_data2),'trial_balances');    

        } else {

            $tbalance_data2 = array('period' => $thn,
                                    'id_coa' => $get_ledger_k->id_coa,
                                    'id_ledger' => $get_ledger_k->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );

            DB::table('trial_balances')->insert($tbalance_data2);

            $myLog->go('store','',\json_encode($tbalance_data2),'trial_balances');
        }

        //insert to acc payable (utang)
        $transaction = General_ledger::latest()->first();

        if ($transaction->id_creditor != NULL) {
            //get semua coa yang termasuk akun akun kewajiban/hutang
            $acc_group = Account_group::where('group_name','Kewajiban')->first();

            $cred_coa = Coa::where('id_account_group',$acc_group->id)->get(); 

            //get data acc payable terakhir yang id creditornya sama dgn id creditor inputan
            $this->id_creditor = $transaction->id_creditor;

            //variabel $this->id_creditor harus diinisialisasi di variabel global, kalau tidak dia tidak terdeteksi di fungsi builder dibawah ini
            $last_acc_payable = Acc_payable::with('transaction')->whereHas('transaction', function (Builder $query) {
                $query->where('id_creditor','=',$this->id_creditor);
            })->latest()->first();
            
            // jika $transaction->credit_acc = akun akun utang
            foreach ($cred_coa as $value) {           
                if ($transaction->id_cred_acc == $value->id) {
                    $paydate = NULL;
                    $debet = $transaction->nominal;
                    $debet = Crypt::decryptString($debet);
                    $credit = "0";

                    if ($last_acc_payable != NULL) {
                        $last_debt = $last_acc_payable->remaining_debt;
                        $last_debt = Crypt::decryptString($last_debt);
                        $rem_debt = $last_debt+$debet;
                    } else {
                        $rem_debt = $debet;
                    }
                break;

                } else {
                    $paydate = $transaction->date;
                    $debet = "0";
                    $credit = $transaction->nominal;
                    $credit = Crypt::decryptString($credit);

                    if ($last_acc_payable != NULL) {
                        $last_debt = $last_acc_payable->remaining_debt;
                        $last_debt = Crypt::decryptString($last_debt);
                        $rem_debt = $last_debt-$credit;
                    } else {
                        $rem_debt =-($credit);
                    }

                }
            }

            $accPayable_data = array('id_transaction' => $transaction->id,
                                    'pay_date' => $paydate,
                                    'due_date' => NULL,
                                    'debet' => Crypt::encryptString($debet),
                                    'credit' => Crypt::encryptString($credit),
                                    'remaining_debt' => Crypt::encryptString($rem_debt)
                                    );

            // dd($accPayable_data);
            DB::table('acc_payable')->insert($accPayable_data);

            //log acc payable
            $myLog->go('store','',\json_encode($accPayable_data),'acc_payable');

        } 

        return redirect()->route('otherTransaction.create')->withStatus(__('Transaction successfully added.'));
    }
}
