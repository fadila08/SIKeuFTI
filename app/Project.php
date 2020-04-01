<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $guarded = array('id');

    public function customer()
    {
        return $this->belongsTo(\App\Customer::class, 'id_cust');
    }

    public function service()
    {
        return $this->belongsTo(\App\Service::class, 'id_service');
    }

    public function projectStatus()
    {
        return $this->belongsTo(\App\Project_status::class, 'project_status');
    }
}
