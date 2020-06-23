<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Profit_loss;

class Change_equity extends Model
{
    protected $table = 'change_equity';
    protected $guarded = array('id');

    public function net_income()
    {
        return $this->belongsTo(\App\Profit_loss::class, 'id_net_income');
    }
}
