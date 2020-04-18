<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Customer;
use App\Http\Library\myLog;
use Auth;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Customer $data)
    {
        $myLog = new myLog;
        $myLog->go('show','','','customers');

        return view('customers.index', ['customers' => $data->paginate(15)]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(CustomerRequest $request, Customer $model)
    {
        $model->create($request->all());

        $myLog = new myLog;
        $myLog->go('store','',\json_encode($request->all()),'customers');

        return redirect()->route('cust.index')->withStatus(__('Customer successfully added.'));
    }

    public function edit($id='')
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, $id='')
    {
        $customer = Customer::findOrFail($id);

        $before_value = \json_encode($customer);

        $customer->update($request->all());

        $myLog = new myLog;
        $myLog->go('update',$before_value,\json_encode($request->all()),'customers');

        return redirect()->route('cust.index')->withStatus(__('Customer successfully updated.'));
    }

    public function destroy($id='')
    {
        $customer = Customer::findOrFail($id);

        $before_value = \json_encode($customer);

        $customer->delete();

        $myLog = new myLog;
        $myLog->go('destroy',$before_value,'','customers');

        return redirect()->route('cust.index')->withStatus(__('Customer successfully deleted.'));
    }
}
