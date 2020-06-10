<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Library\myLog;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Library\graph;

class GraphController extends Controller
{
    public function getTotalRevenue(){
        $graph = new graph;
        return response()->json($graph->showTotalRevenue());
    }

    public function getTotalProject(){
        $graph = new graph;
        return response()->json($graph->showTotalProject());
    }

    public function getTotalProjectRevenue(){
        $graph = new graph;
        return response()->json($graph->showTotalProjectRevenue());
    }
}
