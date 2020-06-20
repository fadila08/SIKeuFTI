<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Carbon\Carbon;
use DB;
use App\Trial_balance;
use App\Coas;
use App\Profit_loss;
use App\Change_equity;
use App\Balance_sheet;
use App\Cash_flow;

class FinancialStatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cYear = Carbon::now()->format('Y');             
        return view('financialStatements.index', ['data' => $cYear]);
    }

    public function create()
    {
        //insert to laba rugi
        //select neraca saldo where id_coa == akun pendapatan usaha [array]
        $acc_pendapatan = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                                                    $query->where('acc_name', 'like', 'pendapatan usaha%');
                                                                    $query->where('period', '=', Carbon::now()->format('Y'));
                                                                })->orderBy('id', 'ASC')->get();
    
        $total_pendapatan = 0;

        if ($acc_pendapatan->first() != NULL) {
            foreach ($acc_pendapatan as $value) {
                //insert data id acc pendapatan ke dalam array
                $id_acc_pendapatan = $value->id;
                $array_id[] = $id_acc_pendapatan;
    
                //get nilai saldo
                $saldo_debet = $value->ledger->debet_saldo;
                $saldo_debet = Crypt::decryptString($saldo_debet);
                $saldo_kredit = $value->ledger->cred_saldo;
                $saldo_kredit = Crypt::decryptString($saldo_kredit);
    
                if ($saldo_debet != "0") {
                    $saldo = -($saldo_debet);
                } elseif ($saldo_kredit != "0") {
                    $saldo = $saldo_kredit;
                }
    
                $total_pendapatan = $total_pendapatan+$saldo; //isi
            }
            $id_tb_pendapatan = implode(',',array_values($array_id)); //isi
        } else {
            $id_tb_pendapatan = NULL;
        }
        
        //select neraca saldo where id_coa == akun beban [array]
        $acc_beban = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                                                    $query->where('acc_name', 'like', 'beban%');
                                                                    $query->where('period', '=', Carbon::now()->format('Y'));
                                                                })->orderBy('id', 'ASC')->get();
        
        $total_beban = 0;
                                                            
        if ($acc_beban->first() != NULL) {
            foreach ($acc_beban as $value) {
                //insert data id acc beban ke dalam array
                $id_acc_beban = $value->id;
                $array_id_beban[] = $id_acc_beban;
    
                //get nilai saldo
                $saldo_debet_beban = $value->ledger->debet_saldo;
                $saldo_debet_beban = Crypt::decryptString($saldo_debet_beban);
                $saldo_kredit_beban = $value->ledger->cred_saldo;
                $saldo_kredit_beban = Crypt::decryptString($saldo_kredit_beban);
    
                if ($saldo_debet_beban != "0") {
                    $saldo_beban = $saldo_debet_beban;
                } elseif ($saldo_kredit_beban != "0") {
                    $saldo_beban = -($saldo_kredit_beban);
                }
    
                $total_beban = $total_beban+$saldo_beban; //isi            
            }
            $id_tb_beban = implode(',',array_values($array_id_beban)); //isi
        } else {
            $id_tb_beban = NULL;
        }
        
        $labarugi_bersih = $total_pendapatan-$total_beban; //isi

        $data_profitloss = array('period' => Carbon::now()->format('Y'),
                                    'acc_revenue' => $id_tb_pendapatan,
                                    'total_revenue' => Crypt::encryptString($total_pendapatan),
                                    'acc_charge' => $id_tb_beban,
                                    'total_charge' => Crypt::encryptString($total_beban),
                                    'net_income' => Crypt::encryptString($labarugi_bersih),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                );
        
        DB::table('profit_loss')->insert($data_profitloss);                
        
        //insert to perubahan ekuitas
        //select neraca saldo where id_coa == akun modal && where period == current year
        $acc_modal = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                                                $query->where('acc_name', 'like', 'modal%');
                                                                $query->where('period', '=', Carbon::now()->format('Y'));
                                                            })->orderBy('id', 'ASC')->get();

        //sum saldo dari neraca saldo, jadi saldo awal
        $total_modal = 0;

        foreach ($acc_modal as $value) {
            //get nilai saldo
            $saldo_debet_modal = $value->ledger->debet_saldo;
            $saldo_debet_modal = Crypt::decryptString($saldo_debet_modal);
            $saldo_kredit_modal = $value->ledger->cred_saldo;
            $saldo_kredit_modal = Crypt::decryptString($saldo_kredit_modal);

            if ($saldo_debet_modal != "0") {
                $saldo_modal = -($saldo_debet_modal);
            } elseif ($saldo_kredit_modal != "0") {
                $saldo_modal = $saldo_kredit_modal;
            }

            $total_modal = $total_modal+$saldo_modal; //isi            
        }

        //get nilai laba bersih && where period == current year
        $profitloss = Profit_loss::where('period','=',Carbon::now()->format('Y'))->first(); //ini

        $laba_bersih = $profitloss->net_income;
        $laba_bersih = Crypt::decryptString($laba_bersih);

        //prive
        $acc_prive = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                            $query->where('acc_name', 'like', 'prive%');
                                            $query->where('period', '=', Carbon::now()->format('Y'));
                                        })->orderBy('id', 'ASC')->get();

        //sum saldo akun prive
        $total_prive = 0;

        foreach ($acc_prive as $value) {
            //get nilai saldo
            $saldo_debet_prive = $value->ledger->debet_saldo;
            $saldo_debet_prive = Crypt::decryptString($saldo_debet_prive);
            $saldo_kredit_prive = $value->ledger->cred_saldo;
            $saldo_kredit_prive = Crypt::decryptString($saldo_kredit_prive);

            if ($saldo_debet_prive != "0") {
                $saldo_prive = $saldo_debet_prive;
            } elseif ($saldo_kredit_prive != "0") {
                $saldo_prive = -($saldo_kredit_prive);
            }

            $total_prive = $total_prive+$saldo_prive; //isi            
        }

        //sum saldo akhir
        $modal_akhir = $total_modal+$laba_bersih-$total_prive;

        $data_change_equity = array('period' => Carbon::now()->format('Y'),
                                    'initial_balance' => Crypt::encryptString($total_modal),
                                    'id_net_income' => $profitloss->id,
                                    'prive' => Crypt::encryptString($total_prive),
                                    'ending_balance' => Crypt::encryptString($modal_akhir),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                    );
        
        DB::table('change_equity')->insert($data_change_equity);                

        //insert to neraca
        //select neraca saldo where id coa == akun aset lancar (AL) && current year
        $acc_aset_lancar = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                                                $query->where('acc_code', 'like', 'AL%');
                                                                $query->where('period', '=', Carbon::now()->format('Y'));
                                                            })->orderBy('id', 'ASC')->get();

        $total_aset_lancar = 0;

        if ($acc_aset_lancar->first() != NULL) {
            foreach ($acc_aset_lancar as $value) {
                $id_acc_aset_lancar = $value->id;
                $array_id_aset_lancar[] = $id_acc_aset_lancar;
    
                //sum aset lancar
                $saldo_debet_al = $value->ledger->debet_saldo;
                $saldo_debet_al = Crypt::decryptString($saldo_debet_al);
                $saldo_kredit_al = $value->ledger->cred_saldo;
                $saldo_kredit_al = Crypt::decryptString($saldo_kredit_al);
    
                if ($saldo_debet_al != "0") {
                    $saldo_al = $saldo_debet_al;
                } elseif ($saldo_kredit_al != "0") {
                    $saldo_al = -($saldo_kredit_al);
                }
    
                $total_aset_lancar = $total_aset_lancar+$saldo_al; //isi            
            }
            $id_tb_aset_lancar = implode(',',array_values($array_id_aset_lancar)); //isi
        } else {
            $id_tb_aset_lancar = NULL;
        }

        //select neraca saldo where id coa == akun aset tetap (AT) && bukan akun akum depresiasi && current year
        $acc_aset_tetap = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                                                    $query->where('acc_code', 'like', 'AT%');
                                                                    $query->where('acc_name', 'not like', 'akumulasi depresiasi%');
                                                                    $query->where('period', '=', Carbon::now()->format('Y'));
                                                                })->orderBy('id', 'ASC')->get();

        $total_aset_tetap = 0;

        if ($acc_aset_tetap->first() != NULL) {
            foreach ($acc_aset_tetap as $value) {
                $id_acc_aset_tetap = $value->id;
                $array_id_aset_tetap[] = $id_acc_aset_tetap;
    
                //sum aset tetap
                $saldo_debet_at = $value->ledger->debet_saldo;
                $saldo_debet_at = Crypt::decryptString($saldo_debet_at);
                $saldo_kredit_at = $value->ledger->cred_saldo;
                $saldo_kredit_at = Crypt::decryptString($saldo_kredit_at);
    
                if ($saldo_debet_at != "0") {
                    $saldo_at = $saldo_debet_at;
                } elseif ($saldo_kredit_at != "0") {
                    $saldo_at = -($saldo_kredit_at);
                }
    
                $total_aset_tetap = $total_aset_tetap+$saldo_at; //isi            
            }
            $id_tb_aset_tetap = implode(',',array_values($array_id_aset_tetap)); //isi
        } else {
            $id_tb_aset_tetap = NULL;
        }

        //select neraca saldo where id coa == akun akum depresiasi && current year
        $acc_akum_depresiasi = Trial_balance::with(['coa'])->whereHas('coa', function (Builder $query) {
                                                                    $query->where('acc_name', 'like', 'akumulasi depresiasi%');
                                                                    $query->where('period', '=', Carbon::now()->format('Y'));
                                                                })->orderBy('id', 'ASC')->get();

        $total_akum_depresiasi = 0;

        if ($acc_akum_depresiasi->first() != NULL) {
            foreach ($acc_akum_depresiasi as $value) {
                $id_acc_akum_depresiasi = $value->id;
                $array_id_akum_depresiasi[] = $id_acc_akum_depresiasi;

                //sum akum depresiasi
                $saldo_debet_akum_depresiasi = $value->ledger->debet_saldo;
                $saldo_debet_akum_depresiasi = Crypt::decryptString($saldo_debet_akum_depresiasi);
                $saldo_kredit_akum_depresiasi = $value->ledger->cred_saldo;
                $saldo_kredit_akum_depresiasi = Crypt::decryptString($saldo_kredit_akum_depresiasi);
    
                if ($saldo_debet_akum_depresiasi != "0") {
                    $saldo_akum_depresiasi = -($saldo_debet_akum_depresiasi);
                } elseif ($saldo_kredit_akum_depresiasi != "0") {
                    $saldo_akum_depresiasi = $saldo_kredit_akum_depresiasi;
                }
    
                $total_akum_depresiasi = $total_akum_depresiasi+$saldo_akum_depresiasi; //isi            
            }
            $id_tb_akum_depresiasi = implode(',',array_values($array_id_akum_depresiasi)); //isi
        } else {
            $id_tb_akum_depresiasi = NULL;
        }

        //sum nilai buku aset tetap
        $nilai_buku_aset_tetap = $total_aset_tetap-$total_akum_depresiasi; //isi

        //total aset
        $total_aset = $total_aset_lancar+$nilai_buku_aset_tetap; //isi

        //select neraca saldo where coa == akun kewajiban && current year
        $acc_kewajiban = Trial_balance::with(['coa.accGroup'])->whereHas('coa.accGroup', function (Builder $query) {
                                                                            $query->where('group_name', 'Kewajiban');
                                                                            $query->where('period', '=', Carbon::now()->format('Y'));
                                                                        })->orderBy('id', 'ASC')->get();

        $total_kewajiban = 0;

        if ($acc_kewajiban->first() != NULL) {
            foreach ($acc_kewajiban as $value) {
                $id_acc_kewajiban = $value->id;
                $array_id_kewajiban[] = $id_acc_kewajiban;

                //sum akum kewajiban
                $saldo_debet_kewajiban = $value->ledger->debet_saldo;
                $saldo_debet_kewajiban = Crypt::decryptString($saldo_debet_kewajiban);
                $saldo_kredit_kewajiban = $value->ledger->cred_saldo;
                $saldo_kredit_kewajiban = Crypt::decryptString($saldo_kredit_kewajiban);
    
                if ($saldo_debet_kewajiban != "0") {
                    $saldo_kewajiban = -($saldo_debet_kewajiban);
                } elseif ($saldo_kredit_kewajiban != "0") {
                    $saldo_kewajiban = $saldo_kredit_kewajiban;
                }
                $total_kewajiban = $total_kewajiban+$saldo_kewajiban; //isi            
            }
            $id_tb_kewajiban = implode(',',array_values($array_id_kewajiban)); //isi
        }else {
            $id_tb_kewajiban = NULL;
        }

        //get modal dari perubahan ekuitas
        $id_modal = Change_equity::where('period','=',Carbon::now()->format('Y'))->first(); //ini

        $modal = $id_modal->ending_balance;
        $modal = Crypt::decryptString($modal);

        //sum kewajiban & ekuitas
        $total_kewajiban_ekuitas = $total_kewajiban+$modal;

        $data_balance_sheet = array('period' => Carbon::now()->format('Y'),
                                    'acc_current_asset' => $id_tb_aset_lancar,
                                    'total_current_asset' => Crypt::encryptString($total_aset_tetap),
                                    'acc_fixed_asset' => $id_tb_aset_tetap,
                                    'total_fixed_asset' => Crypt::encryptString($total_aset_tetap),
                                    'acc_acum_depreciation' => $id_tb_akum_depresiasi,
                                    'total_acum_depreciation' => Crypt::encryptString($total_akum_depresiasi),
                                    'book_value_fixed_asset' => Crypt::encryptString($nilai_buku_aset_tetap),
                                    'total_asset' => Crypt::encryptString($total_aset),
                                    'acc_liability' => $id_tb_kewajiban,
                                    'total_liability' => Crypt::encryptString($total_kewajiban),
                                    'id_equity_balance' => $id_modal->id,
                                    'total_liability_equity' => Crypt::encryptString($total_kewajiban_ekuitas),
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()                         
                                    );

        DB::table('balance_sheets')->insert($data_balance_sheet);                

        //insert to arus kas
        //get kas pada tabel arus kas tahun sebelumnya
        $latest_cashflow = Cash_flow::latest()->first(); //ini

        if ($latest_cashflow != NULL) {
            $kas_periode_sebelumnya = $latest_cashflow->net_cash_flow;
            $kas_periode_sebelumnya = Crypt::decryptString($kas_periode_sebelumnya);
        } else {
            $kas_periode_sebelumnya = 0;
        }
        
        //get laba rugi tahun ini (untuk ambil total pendapatan & total beban)
        $laba_rugi = Profit_loss::where('period','=',Carbon::now()->format('Y'))->first(); //ini

        $pendapatan = $laba_rugi->total_revenue;
        $pendapatan = Crypt::decryptString($pendapatan);

        $beban = $laba_rugi->total_charge;
        $beban = Crypt::decryptString($beban);

        //sum arus kas aktivitas operasi
        $sum_ak_operasi = $pendapatan-$beban;

        //get neraca tahun ini (untuk ambil nilai buku aset tetap)
        $neraca = Balance_sheet::where('period','=',Carbon::now()->format('Y'))->first(); //ini

        $aset_tetap = $neraca->total_fixed_asset;
        $aset_tetap = Crypt::decryptString($aset_tetap);

        $akum_depresiasi = $neraca->total_acum_depreciation;
        $akum_depresiasi = Crypt::decryptString($akum_depresiasi);

        //sum arus kas aktivitas investasi
        $sum_ak_invest = $aset_tetap-$akum_depresiasi;

        //get perubahan ekuitas tahun ini (untuk ambil nilai modal dan prive)
        $perubahan_ekuitas = Change_equity::where('period','=',Carbon::now()->format('Y'))->first(); //ini

        $ekuitas = $perubahan_ekuitas->initial_balance;
        $ekuitas = Crypt::decryptString($ekuitas);

        $prive = $perubahan_ekuitas->prive;
        $prive = Crypt::decryptString($prive);

        //sum arus kas aktivitas pendanaan
        $sum_ak_pendanaan = $ekuitas-$prive;

        //sum arus kas
        $sum_arus_kas = $sum_ak_operasi-$sum_ak_invest+$sum_ak_pendanaan;

        $data_cash_flow = array('period' => Carbon::now()->format('Y'),
                                'cash_previous_period' => Crypt::encryptString($kas_periode_sebelumnya),
                                'total_revenue_and_charge' => $laba_rugi->id,
                                'netto_op_activity' => Crypt::encryptString($sum_ak_operasi),
                                'book_value_fixed_asset' => $neraca->id,
                                'netto_invest_activity' => Crypt::encryptString($sum_ak_invest),
                                'equity_balance_and_prive' => $perubahan_ekuitas->id,
                                'netto_fund_activity' => Crypt::encryptString($sum_ak_pendanaan),
                                'net_cash_flow' => Crypt::encryptString($sum_arus_kas),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                                );

        DB::table('cash_flows')->insert($data_cash_flow);                

        // dd($data_cash_flow);
        
        return redirect()->route('financialStatement')->withStatus(__('Financial Statement has sucesfully created !'));
    }

}
