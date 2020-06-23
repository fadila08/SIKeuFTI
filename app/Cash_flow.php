<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Balance_sheet;
use App\Change_equity;
use App\Profit_loss;

class Cash_flow extends Model
{
    protected $table = 'cash_flows';
    protected $guarded = array('id');

    public function revenue_and_charge()
    {
        return $this->belongsTo(\App\Profit_loss::class, 'total_revenue_and_charge');
    }
    public function fixed_asset()
    {
        return $this->belongsTo(\App\Balance_sheet::class, 'book_value_fixed_asset');
    }
    public function equity_and_prive()
    {
        return $this->belongsTo(\App\Change_equity::class, 'equity_balance_and_prive');
    }

}
