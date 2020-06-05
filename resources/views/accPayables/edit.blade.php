@extends('layouts.app', ['title' => __('Account Payable')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Edit Account Payable')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="{{ route('coa.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('accPayable.update', $accPayable->id) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Account Payable Data') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('id_transaction') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-transaction">{{ __('Description') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_transaction') ? ' is-invalid' : '' }}" name="id_transaction" value="{{ old('id_transaction', $accPayable->id_transaction) }}" disabled="disabled">
                                        @foreach ($transaction as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['description']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('pay_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-pay-date">{{ __('Pay Date') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="{{ old('pay_date', $accPayable->pay_date) }}" name="pay_date" id="input-pay-date" disabled="disabled">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-due-date">{{ __('Due Date') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="{{ old('due_date', $accPayable->due_date) }}" name="due_date" id="input-due-date">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('debet') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-debet">{{ __('Debet') }}</label>
                                    <input type="text" name="debet" id="input-debet" class="form-control form-control-alternative{{ $errors->has('debet') ? ' is-invalid' : '' }}" placeholder="{{ __('Debet') }}" value="{{ old('debet', \Crypt::decryptString($accPayable->debet)) }}" required autofocus disabled="disabled">

                                    @if ($errors->has('debet'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('debet') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('credit') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-credit">{{ __('Credit') }}</label>
                                    <input type="text" name="credit" id="input-credit" class="form-control form-control-alternative{{ $errors->has('credit') ? ' is-invalid' : '' }}" placeholder="{{ __('Credit') }}" value="{{ old('credit', \Crypt::decryptString($accPayable->credit)) }}" required autofocus disabled="disabled">

                                    @if ($errors->has('credit'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('credit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('remaining_debt') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-remaining-debt">{{ __('Remaining Debt') }}</label>
                                    <input type="text" name="remaining_debt" id="input-remaining-debt" class="form-control form-control-alternative{{ $errors->has('remaining_debt') ? ' is-invalid' : '' }}" placeholder="{{ __('Remaining Debt') }}" value="{{ old('remaining_debt', \Crypt::decryptString($accPayable->remaining_debt)) }}" required autofocus disabled="disabled">

                                    @if ($errors->has('remaining_debt'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('remaining_debt') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection