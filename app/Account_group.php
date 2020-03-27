<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_group extends Model
{
    protected $table = 'account_groups';
    protected $fillable = [
	  'group_name'
    ];
}
