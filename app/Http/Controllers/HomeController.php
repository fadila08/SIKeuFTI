<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use Auth;

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
        // return view('dashboard');

        //Super Admin
        if(Auth::user()->id_roles == 1){
            // $data['user'] = User::with('account')->get();
            return view('dashboard');
        }

        //Admin
        if(Auth::user()->id_roles == 2){
            // $data['user'] = User::with('account')->where('role','distributor')->get();
            return view('dashboard');
        }

        //direksi
        if(Auth::user()->id_roles == 3){
            Auth::logout();
            return redirect('login');
        }
    }
}
