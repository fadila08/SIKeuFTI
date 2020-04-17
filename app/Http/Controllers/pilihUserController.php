<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pilihUserController extends Controller
{
    public function index()
    {
        return view('users.choose');
    }
}
