<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class FinancialStatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cYear = Carbon::now()->format('Y');             
        return view('financialStatements.index', ['data' => $cYear]);
    }

    public function create()
    {
        return redirect()->route('financialStatement')->withStatus(__('Financial Statement has sucesfully created !'));
    }

}
