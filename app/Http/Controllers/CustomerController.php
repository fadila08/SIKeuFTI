<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Customer;
use Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Customer $data)
    {
        return view('customers.index', ['cust' => $data->paginate(15)]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request, Customer $model)
    {
        $model->create($request->all());

        return redirect()->route('cust.index')->withStatus(__('Customer successfully added.'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User  $user)
    {
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$request->get('password') ? '' : 'password']
        ));

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    public function destroy(Customer  $customer)
    {
        $customer->delete();

        return redirect()->route('cust.index')->withStatus(__('Customer successfully deleted.'));
    }
}
