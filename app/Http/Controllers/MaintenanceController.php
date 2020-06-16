<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Maintenance;

class MaintenanceController extends Controller
{
    public function check(){
        $maintenance = Maintenance::first();
        return response()->json($maintenance->status);
    }
}