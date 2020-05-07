<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coa;
use App\General_ledger;

class Ledger extends Model
{
    protected $table = 'ledgers';
    protected $guarded = array('id');

    public function coa()
    {
        return $this->belongsTo(\App\Coa::class, 'id_coa');
    }

    public function desc()
    {
        return $this->belongsTo(\App\General_ledger::class, 'id_desc');
    }
}
