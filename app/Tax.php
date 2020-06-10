<?php

namespace App;
use App\General_ledger;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxes';
    protected $guarded = array('id');

    public function transaction()
    {
        // return $this->belongsTo(\App\General_ledger::class, 'id_transaction');
        return $this->hasOne('App\General_ledger','id','id_transaction');
    }
}
