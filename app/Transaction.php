<?php

namespace App;

use App\Coa;
use App\Project;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $guarded = array('id');

    public function project()
    {
        return $this->belongsTo(\App\Project::class, 'id_project');
    }

    public function debetAcc()
    {
        return $this->belongsTo(\App\Coa::class, 'id_debet_acc');
    }

    public function credAcc()
    {
        return $this->belongsTo(\App\Coa::class, 'id_cred_acc');
    }

}
