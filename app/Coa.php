<?php

namespace App;

use App\Account_group;
use App\Normal_balance;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    protected $table = 'coas';
    protected $guarded = array('id');

    public function accGroup()
    {
        return $this->belongsTo(\App\Account_group::class, 'id_account_group');
    }

    public function normalBalance()
    {
        return $this->belongsTo(\App\Normal_balance::class, 'id_normal_balance');
    }
}
