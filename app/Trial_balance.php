<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ledger;
use App\Coa;

class Trial_balance extends Model
{
    protected $table = 'trial_balances';
    protected $guarded = array('id');

    public function ledger()
    {
        return $this->belongsTo(\App\Ledger::class, 'id_ledger');
    }

    public function coa()
    {
        return $this->belongsTo(\App\Coa::class, 'id_coa');
    }

}
