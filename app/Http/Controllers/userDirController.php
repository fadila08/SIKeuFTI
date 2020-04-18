<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Library\myLog;

class userDirController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $myLog = new myLog;
        $myLog->go('show','','','users');

        return view('usersDir.index', ['users' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('usersDir.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());

        $myLog = new myLog;
        $myLog->go('store','',\json_encode($request->merge(['password' => Hash::make($request->get('password'))])->all()),'users');

        return redirect()->route('userDir.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $userDir)
    {
        return view('usersDir.edit', compact('userDir'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $userDir)
    {
        // $usr = User::findOrFail($user);

        $before_value = \json_encode($userDir);

        $userDir->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->merge(['password' => Hash::make($request->get('password'))])
                                                            ->except([$request->get('password') ? '' : 'password']
                                                            )),'users');

        return redirect()->route('userDir.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $userDir)
    {
        $before_value = \json_encode($userDir);

        $userDir->delete();

        $myLog = new myLog;
        $myLog->go('destroy',$before_value,'','users');

        return redirect()->route('userDir.index')->withStatus(__('User successfully deleted.'));
    }
}
