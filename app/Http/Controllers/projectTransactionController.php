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
use App\Trial_balance;
use App\Coa;
use App\Tax;
use App\Project;
use App\Creditor;
use App\Acc_payable;
use App\Acc_receivable;
use App\Http\Library\myLog;
use Auth;
use DB;
use Carbon\Carbon;
use Storage;
use Illuminate\Database\Eloquent\Builder;

class projectTransactionController extends Controller
{
    private $id_debitor = "";
    private $id_project_tax = "";
    private $id_coa_tax = "";

    public function create()
    {
        $project = Project::get();
        $coa = Coa::get();

        return view('projectTransactions.create', compact('project','coa'));
    }

    public function store(GeneralLedgerRequest $request, General_ledger $model)
    {
        $myLog = new myLog;

        //insert to jurnal umum
        $proof = $request->file('upload_proof')->storeAs('proof_transactions',$request->proof_num.'.jpeg');

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

        //insert to acc receivable (piutang)
        $transaction = General_ledger::with('project')->latest()->first();
        $coa_AR = Coa::where('acc_name', 'like',   'piutang%')->get();
        
        foreach ($coa_AR as $value) {
            if ($transaction->id_debet_acc == $value->id || $transaction->id_cred_acc == $value->id) {
                
                $id_coa = $value->id;

                //get data acc receivable terakhir yang id customernya sama dgn id customer inputan
                $this->id_debitor = $transaction->project->id_cust;

                //variabel $this->id_debitor harus diinisialisasi di variabel global, kalau tidak dia tidak terdeteksi di fungsi builder dibawah ini
                $last_acc_receivable = Acc_receivable::with('transaction.project')->whereHas('transaction.project', function (Builder $query) {
                                                    $query->where('id_cust','=',$this->id_debitor);
                                                    })->latest()->first();

                if($transaction->id_debet_acc == $id_coa) {
                    $paydate = NULL;
                    $debet = $transaction->nominal;
                    $debet = Crypt::decryptString($debet);
                    $credit = "0";

                    if ($last_acc_receivable != NULL) {
                        $last_debt = $last_acc_receivable->remaining_debt;
                        $last_debt = Crypt::decryptString($last_debt);
                        $rem_debt = $last_debt+$debet;
                    } else {
                        $rem_debt = $debet;
                    }    

                } else {
                    $paydate = $transaction->date;
                    $debet = "0";
                    $credit = $transaction->nominal;
                    $credit = Crypt::decryptString($credit);

                    if ($last_acc_receivable != NULL) {
                        $last_debt = $last_acc_receivable->remaining_debt;
                        $last_debt = Crypt::decryptString($last_debt);
                        $rem_debt = $last_debt-$credit;
                    } else {
                        $rem_debt = -($credit);
                    }
                }

                $accReceivable_data = array('id_transaction' => $transaction->id,
                                            'pay_date' => $paydate,
                                            'due_date' => NULL,
                                            'debet' => Crypt::encryptString($debet),
                                            'credit' => Crypt::encryptString($credit),
                                            'remaining_debt' => Crypt::encryptString($rem_debt),
                                            'created_at' => Carbon::now(),
                                            'updated_at' => Carbon::now()
                                            );
                
                // dd($accReceivable_data);
                DB::table('acc_receivable')->insert($accReceivable_data);

                //log acc receivable
                $myLog->go('store','',\json_encode($accReceivable_data),'acc_receivable');

            break;
            }           
        }

        //insert into pajak
        $coa_tax = Coa::where('acc_name', 'like',   'PPh%')->get();

        foreach ($coa_tax as $value) {
            //insert
            if ($transaction->id_cred_acc == $value->id) {

                $tax_data = array('id_transaction' => $transaction->id,
                                    'due_date' => NULL,
                                    'pay_status' => "0"
                                );
                                
                // dd($tax_data);
                DB::table('taxes')->insert($tax_data);                

            break;
            } 
            //update
            elseif ($transaction->id_debet_acc == $value->id) {
                //get data tax terakhir yang id project & id coa sama dgn id customer inputan
                $this->id_project_tax = $transaction->id_project;
                $this->id_coa_tax = $transaction->id_debet_acc;

                //variabel $this->id_debitor harus diinisialisasi di variabel global, kalau tidak dia tidak terdeteksi di fungsi builder dibawah ini
                $last_tax = Tax::with('transaction')->whereHas('transaction', function (Builder $query) {
                                                        $query->where('id_project','=',$this->id_project_tax);
                                                        $query->where('id_cred_acc','=',$this->id_coa_tax);
                                                    })->latest()->first();
                
                $tax_data = array('id_transaction' => $transaction->id,
                                    'pay_status' => "1"
                                );

                // dd($tax_data);                
                $last_tax->update($tax_data);
                
            break;
            }
        }
        
        return redirect()->route('projectTransaction.create')->withStatus(__('Project Transaction successfully added.'));
    }

    public function edit($id='')
    {
        $generalLedger = General_ledger::findOrFail($id);
        $project = Project::where('id','=',$generalLedger->id_project)->get();
        $coa_deb = Coa::where('id','=',$generalLedger->id_debet_acc)->get();
        $coa_cred = Coa::where('id','=',$generalLedger->id_cred_acc)->get();
        $creditor = Creditor::where('id','=',$generalLedger->id_creditor)->get();

        return view('projectTransactions.edit', compact('generalLedger','project','coa_deb','coa_cred','creditor'));
    }

    public function update(GeneralLedgerRequest $request, $id='')
    {
        //update hanya berlaku untuk field yg terakhir di entri
        //update to jurnal umum
        $generalLedger = General_ledger::findOrFail($id);

        //get nominal old
        $nominal_old = Crypt::decryptString($generalLedger->nominal);
        $nominal_old = (int)$nominal_old;

        $nominal = (int)$request->get('nominal');

        Storage::delete($generalLedger->upload_proof);

        $proof = $request->file('upload_proof')->store('proof_transactions');

        //di exclude dulu upload proofnya
        $data = $request->merge(['nominal' => Crypt::encryptString($request->get('nominal'))])->except('upload_proof');
        //ditambah secara manual
        $data['upload_proof'] = $proof;
        
        $generalLedger->update($data);
        
        //update to buku besar
        //where ledger->id_desc == gledger->id && ledger->id_coa == gledger->id_debet_acc // id_cred_acc
        $ledger1 = Ledger::where(['id_coa' => $generalLedger->id_debet_acc , 'id_desc' => $generalLedger->id])->latest()->first();

        //ambil data credit saldo sebelum terakhir
        $ledger1_before = Ledger::where(['id_coa' => $generalLedger->id_debet_acc ])->get();
        $ledger1_before = $ledger1_before[count($ledger1_before)-2];      

        $ledger2 = Ledger::where(['id_coa' => $generalLedger->id_cred_acc , 'id_desc' => $generalLedger->id])->latest()->first();
        
        //ambil data debet saldo sebelum terakhir
        $ledger2_before = Ledger::where(['id_coa' => $generalLedger->id_cred_acc ])->get();
        $ledger2_before = $ledger2_before[count($ledger2_before)-2];                        
        
        //inputan pertama (deb acc)
        $deb_saldo1 = Crypt::decryptString($ledger1_before->debet_saldo);
        $deb_saldo1 = (int)$deb_saldo1;

        $cred_saldo1 = Crypt::decryptString($ledger1_before->cred_saldo);
        $cred_saldo1 = (int)$cred_saldo1;
                           
        //cek debet kredit
        if ($deb_saldo1 != 0) {
            $n_deb_saldo1 = ($deb_saldo1)+$nominal;
            $n_deb_saldo1 = (string)$n_deb_saldo1;    
        } else {
            $n_deb_saldo1 = "0";
        }
        if($cred_saldo1 != 0) {
            $n_cred_saldo1 = ($cred_saldo1)-$nominal;
            $n_cred_saldo1 = (string)$n_cred_saldo1;    
        }
        else {
            $n_cred_saldo1 = "0";
        }
                    
        $ledgers_data_1 = array('id_coa' => $ledger1->id_coa,
                                'id_desc' => $ledger1->id_desc,
                                'debet_saldo' => Crypt::encryptString($n_deb_saldo1),
                                'cred_saldo' => Crypt::encryptString($n_cred_saldo1),
                                'created_at' => $ledger1->created_at,
                                'updated_at' => Carbon::now()
                                );
        
        DB::table('ledgers')->where(['id_coa' => $generalLedger->id_debet_acc , 'id_desc' => $generalLedger->id])->update($ledgers_data_1);
        
        //log buku besar (deb acc)
        // $myLog->go('store','',\json_encode($ledgers_data_1),'ledgers');
        
        //inputan kedua (cred acc)
        $deb_saldo2 = Crypt::decryptString($ledger2_before->debet_saldo);
        $deb_saldo2 = (int)$deb_saldo2;
        $cred_saldo2 = Crypt::decryptString($ledger2_before->cred_saldo);
        $cred_saldo2 = (int)$cred_saldo2;
                
        if ($cred_saldo2 != 0) {
            $n_cred_saldo2 = ($cred_saldo2)+$nominal;
            $n_cred_saldo2 = (string)$n_cred_saldo2;    
        } else {
            $n_cred_saldo2 = "0";
        }
        
        if ($deb_saldo2 != 0) {
            $n_deb_saldo2 = ($deb_saldo2)-$nominal;
            $n_deb_saldo2 = (string)$n_deb_saldo2;    
        } else {
            $n_deb_saldo2 = "0";
        }
        
        $ledgers_data_2 = array('id_coa' => $ledger2->id_coa,
                                'id_desc' => $ledger2->id_desc,
                                'debet_saldo' => Crypt::encryptString($n_deb_saldo2),
                                'cred_saldo' => Crypt::encryptString($n_cred_saldo2),
                                'created_at' => $ledger2->created_at,
                                'updated_at' => Carbon::now()
                                );
        
        DB::table('ledgers')->where(['id_coa' => $generalLedger->id_cred_acc , 'id_desc' => $generalLedger->id])->update($ledgers_data_2);
        
        //log buku besar (cred acc)
        // $myLog->go('store','',\json_encode($ledgers_data_2),'ledgers');
        
        //update to neraca saldo
        $cek_akun_d = Trial_balance::where('id_ledger','=',$ledger1->id)->first();
        $cek_akun_k = Trial_balance::where('id_ledger','=',$ledger2->id)->first();
        
        $thn = Carbon::parse($request->get('date'))->format('Y');

        //inputan pertama
        //data before value log activity
        // $tb_before_value1 = Trial_balance::where('id_coa',$cek_gledger->id_debet_acc)->first();
        // $before_value1 = \json_encode($tb_before_value1);

        $tbalance_data1 = array('period' => $thn,
                                'id_coa' => $cek_akun_d->id_coa,
                                'id_ledger' => $cek_akun_d->id_ledger,
                                'created_at' => $cek_akun_d->created_at,
                                'updated_at' => Carbon::now()
                                );

        DB::table('trial_balances')->where('id_ledger','=',$ledger1->id)->update($tbalance_data1);
    
        // $myLog->go('update',$before_value1,\json_encode($tbalance_data1),'trial_balances');    

        //inputan kedua
        //data before value log activity
        // $tb_before_value2 = Trial_balance::where('id_coa',$cek_gledger->id_cred_acc)->first();
        // $before_value2 = \json_encode($tb_before_value2);
            
        $tbalance_data2 = array('period' => $thn,
                                'id_coa' => $cek_akun_k->id_coa,
                                'id_ledger' => $cek_akun_k->id_ledger,
                                'created_at' => $cek_akun_k->created_at,
                                'updated_at' => Carbon::now()
                                );

        DB::table('trial_balances')->where('id_ledger','=',$ledger2->id)->update($tbalance_data2);

        // $myLog->go('update',$before_value2,\json_encode($tbalance_data2),'trial_balances');    

        //update to acc payable

        return redirect()->route('generalLedger.index')->withStatus(__('Project Transaction successfully updated.'));
        // dd([$data], [$ledgers_data_1], [$ledgers_data_2], [$tbalance_data1], [$tbalance_data2]);
    }

}
