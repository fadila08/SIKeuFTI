<?php

namespace App\Http\Library;
use App\Log;
use Auth;

//made by Aditya Nanda Keren :D

class myLog{
    public function __construct(){
      $this->id = Auth::user()->id;
    }

    public function go($type='',$before_value='',$after_value='',$from_table=''){
      $log = new Log;
      $log->id_user       = $this->id;
      $log->type          = $type;
      $log->before_value  = $before_value;
      $log->after_value   = $after_value;
      $log->from_table    = $from_table;

      return $log->save();
    }
}
