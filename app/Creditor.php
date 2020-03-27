<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    protected $table = 'creditors';
    protected $guarded = array('id');
}
