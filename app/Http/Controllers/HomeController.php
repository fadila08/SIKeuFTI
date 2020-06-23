<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Cash_flow;
use App\Profit_loss;
use App\Acc_payable;
use App\Acc_receivable;
use App\Tax;
use Carbon\Carbon;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //Super Admin
        if(Auth::user()->id_roles == 1){
            $cYear = Carbon::now()->format('Y');             
            $data['cashFlow'] = Cash_flow::where('period',$cYear)->first();
            $data['profitLoss'] = Profit_loss::where('period',$cYear)->first();
            $data['accReceivable'] = Acc_receivable::get();
            $data['accPayable'] = Acc_payable::get();
            $data['tax'] = Tax::where('pay_status',0)->get();

            return view('dashboard', $data);
        }

        //Admin
        if(Auth::user()->id_roles == 2){
            $cYear = Carbon::now()->format('Y');             
            $data['cashFlow'] = Cash_flow::where('period',$cYear)->first();
            $data['profitLoss'] = Profit_loss::where('period',$cYear)->first();
            $data['accReceivable'] = Acc_receivable::get();
            $data['accPayable'] = Acc_payable::get();
            $data['tax'] = Tax::where('pay_status',0)->get();

            return view('dashboard', $data);
        }

        //direksi
        if(Auth::user()->id_roles == 3){
            Auth::logout();
            return redirect('login');
        }
    }
}
