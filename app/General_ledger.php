<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coa;
use App\Project;

class General_ledger extends Model
{
    protected $table = 'general_ledgers';
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
