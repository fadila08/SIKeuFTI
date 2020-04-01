<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CoaRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Coa;
use App\Account_group;
use App\Normal_balance;
use Auth;

class CoaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Coa $data)
    {
        $data = Coa::orderBy('acc_code', 'ASC')->paginate(15);
     
        return view('coas.index', ['coas' => $data]);
    }

    public function create()
    {
        $normalBalance = Normal_balance::get();
        $accountGroup = Account_group::get();

        return view('coas.create', compact('normalBalance','accountGroup'));
    }

    public function store(CoaRequest $request, Coa $model)
    {
        $model->create($request->all());

        return redirect()->route('coa.index')->withStatus(__('Code of Account successfully added.'));
    }

    public function edit($id='')
    {
        $coa = Coa::findOrFail($id);
        $normalBalance = Normal_balance::get();
        $accountGroup = Account_group::get();

        return view('coas.edit', compact('coa','normalBalance','accountGroup'));
    }

    public function update(CoaRequest $request, $id='')
    {
        $coa = Coa::findOrFail($id);
        $coa->update($request->all());

        return redirect()->route('coa.index')->withStatus(__('Code of Account successfully updated.'));
    }

    public function destroy($id='')
    {
        $coa = Coa::findOrFail($id);
        $coa->delete();

        return redirect()->route('coa.index')->withStatus(__('Code of Account successfully deleted.'));
    }
}
