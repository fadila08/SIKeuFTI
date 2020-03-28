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
        return view('customers.index', ['customers' => $data->paginate(15)]);
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

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
        // dd("tes");
    }

    public function update(CustomerRequest $request, Customer  $customer)
    {
        $customer->update($request->all());

        return redirect()->route('cust.index')->withStatus(__('Customer successfully updated.'));
    }

    public function destroy(Customer  $customer)
    {
        $customer->delete();

        return redirect()->route('cust.index')->withStatus(__('Customer successfully deleted.'));
        // return redirect()->route('cust.index')->withStatus(__($customer->cust_name));

    }
}
