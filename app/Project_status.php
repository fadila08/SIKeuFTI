<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_status extends Model
{
    protected $table = 'project_status';
    protected $fillable = [
	  'status_project'
    ];
}
