<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Change_equity;

class Balance_sheet extends Model
{
    protected $table = 'balance_sheets';
    protected $guarded = array('id');

    public function equity_balance()
    {
        return $this->belongsTo(\App\Change_equity::class, 'id_equity_balance');
    }
}
