<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;

use App\Http\Library\myLog;

use Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {

        // // tambahkan pengecekan role
        // if(Auth::user()->id_roles == 1){
        //     $header = 'layouts.app';

        // }
        // if(Auth::user()->id_roles == 2){
        //     $header = 'layouts.appadmin';
        // }
        
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        $userBefore = auth()->user();
        $before_value = \json_encode($userBefore);

        auth()->user()->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'users');

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        $userPassBefore = auth()->user()->password;
        $before_value = \json_encode($userPassBefore);

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode(['password' => Hash::make($request->get('password'))]),'users');

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
