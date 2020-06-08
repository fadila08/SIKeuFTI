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
      $group = DB::table('general_ledgers')
      ->join('coas','coas.id','=','general_ledgers.id_cred_acc')
      ->where('coas.acc_name', 'like',   'pendapatan%')
      ->orderBy('date', 'ASC')
      ->get()
      ->groupBy(function($d) {
          return Carbon::parse($d->date)->format('Y-m');
      })
      ;


      $data = General_ledger::with(['credAcc'])->whereHas('credAcc', function (Builder $query) {
        $query->where('acc_name', 'like',   'pendapatan%');
        })->orderBy('id', 'ASC')->get();
      
      $month = array();
      $month['labels'] = array();
      $month['data'] = array();
      foreach ($group as $key => $value) {
          $total = 0;
          array_push($month['labels'],date("M", strtotime($key)));
          foreach ($data as $key2 => $item) {
              if ($key == date("Y-m", strtotime($item->date))) {
                  $total += \Crypt::decryptString($item->nominal);
              }
          }
          array_push($month['data'],$total);
      }

      /* year */

      $group =  DB::table('general_ledgers')
      ->join('coas','coas.id','=','general_ledgers.id_cred_acc')
      ->where('coas.acc_name', 'like',   'pendapatan%')
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
            if ($key == date("Y-m", strtotime($item->date))) {
                $total += \Crypt::decryptString($item->nominal);
            }
        }
          array_push($month['data_year'],$total);
      }

      // return \json_encode($month);
      return $month;
    }

    public function showTotalProject(){
        /* month */
        $group = DB::table('projects')
                ->whereMonth('project_started',date('m'))
                ->select('id_service', DB::raw('count(*) as total'))
                 ->groupBy('id_service')
                 ->get();
  
        $data = DB::table('services')
                 ->get();
        

        $month = array();
        $month['labels'] = array();
        $month['data'] = array();
        foreach ($data as $key => $value) {
            $flag = true;
            array_push($month['labels'],$value->service_name);
            foreach ($group as $key2 => $item) {
                if ($value->id == $item->id_service) {
                    array_push($month['data'],$item->total);
                    $flag = true;
                break;
                }else{
                    $flag = false;
                }
            }
            if (!$flag) {
                array_push($month['data'],0);
            }
        }
  
        /* year */
  
        $group = DB::table('projects')
                ->whereYear('project_started',date('Y'))
                ->select('id_service', DB::raw('count(*) as total'))
                 ->groupBy('id_service')
                 ->get();
  
        $month['labels_year'] = array();
        $month['data_year'] = array();
        foreach ($data as $key => $value) {
            $flag = true;
            array_push($month['labels_year'],$value->service_name);
            foreach ($group as $key2 => $item) {
                if ($value->id == $item->id_service) {
                    array_push($month['data_year'],$item->total);
                    $flag = true;
                break;
                }else{
                    $flag = false;
                }
                
            }
            if (!$flag) {
                array_push($month['data_year'],0);
            }
        }

        $month['time'] = array(date('F'),date('Y'));
  
        // return \json_encode($month);
        return $month;
      }
}
