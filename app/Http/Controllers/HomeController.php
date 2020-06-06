<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use Auth;
use App\Http\Library\graph;


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
        $graph = new graph;
        $t_revenue = $graph->showTotalRevenue();

        $data['t_revenue_m'] = \json_encode($t_revenue['data']);
        $data['t_revenue_y'] = \json_encode($t_revenue['data_year']);
        //Super Admin
        if(Auth::user()->id_roles == 1){
            // $data['user'] = User::with('account')->get();
            return view('dashboard',$data);
        }

        //Admin
        if(Auth::user()->id_roles == 2){
            // $data['user'] = User::with('account')->where('role','distributor')->get();
            return view('dashboard',$data);
        }

        //direksi
        if(Auth::user()->id_roles == 3){
            Auth::logout();
            return redirect('login');
        }
    }
}
