<?php

namespace App;
use App\General_ledger;

use Illuminate\Database\Eloquent\Model;

class Acc_receivable extends Model
{
    protected $table = 'acc_receivable';
    protected $guarded = array('id');

    public function transaction()
    {
        // return $this->belongsTo(\App\General_ledger::class, 'id_transaction');
        return $this->hasOne('App\General_ledger','id','id_transaction');
    }
}
