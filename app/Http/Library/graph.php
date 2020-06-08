<?php

namespace App\Http\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Str;
use App\Trial_balance;
use App\Ledger;
use App\General_ledger;
use App\Coa;
use Auth;
use DB;
use Carbon\Carbon;

//made by Aditya Nanda Keren :D

class graph{

    public function showTotalRevenue(){
      /* month */
      $group = DB::table('trial_balances')
      ->join('coas','coas.id','=','trial_balances.id_coa')
      ->where('coas.acc_name', 'like',   'pendapatan%')
      ->join('ledgers','ledgers.id','=','trial_balances.id_ledger')
      ->join('general_ledgers','general_ledgers.id','=','ledgers.id_desc')
      ->orderBy('date', 'ASC')
      ->get()
      ->groupBy(function($d) {
          return Carbon::parse($d->date)->format('Y-m');
      })
      ;

      $data = Trial_balance::with(['ledger.desc','coa'])->whereHas('coa', function (Builder $query) {
        $query->where('acc_name', 'like',   'pendapatan%');
        })->orderBy('id_coa', 'ASC')->get();
      
      $month = array();
      $month['labels'] = array();
      $month['data'] = array();
      foreach ($group as $key => $value) {
          $total = 0;
          array_push($month['labels'],date("M", strtotime($key)));
          foreach ($data as $key2 => $item) {
              if ($key == date("Y-m", strtotime($item->ledger->desc->date))) {
                  $total += \Crypt::decryptString($item->ledger->cred_saldo);
              }
          }
          array_push($month['data'],$total);
      }

      /* year */

      $group = DB::table('trial_balances')
      ->join('coas','coas.id','=','trial_balances.id_coa')
      ->where('coas.acc_name', 'like',   'pendapatan%')
      ->join('ledgers','ledgers.id','=','trial_balances.id_ledger')
      ->join('general_ledgers','general_ledgers.id','=','ledgers.id_desc')
      ->orderBy('date', 'ASC')
      ->get()
      ->groupBy(function($d) {
          return Carbon::parse($d->date)->format('Y');
      })
      ;

      $month['labels_year'] = array();
      $month['data_year'] = array();
      foreach ($group as $key => $value) {
          $total = 0;
          array_push($month['labels_year'],date("Y", strtotime($key)));
          foreach ($data as $key2 => $item) {
              if ($key == date("Y", strtotime($item->ledger->desc->date))) {
                  $total += \Crypt::decryptString($item->ledger->cred_saldo);
              }
          }
          array_push($month['data_year'],$total);
      }

      // return \json_encode($month);
      return $month;
    }
}
