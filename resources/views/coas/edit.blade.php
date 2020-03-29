@extends('layouts.app', ['title' => __('Code of Account')])

@section('content')
    @include('coas.partials.header', ['title' => __('Edit Code of Account')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Code of Account Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('coa.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('coa.update', $coa->id) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Code of Account information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('acc_code') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-acc-code">{{ __('Account Code') }}</label>
                                    <input type="text" name="acc_code" id="input-acc-code" class="form-control form-control-alternative{{ $errors->has('acc_code') ? ' is-invalid' : '' }}" placeholder="{{ __('Account Code') }}" value="{{ old('acc_code', $coa->acc_code) }}" required autofocus>

                                    @if ($errors->has('acc_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('acc_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('acc_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-acc-name">{{ __('Account Name') }}</label>
                                    <input type="text" name="acc_name" id="input-acc-name" class="form-control form-control-alternative{{ $errors->has('acc_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Account Name') }}" value="{{ old('acc_name', $coa->acc_name) }}" required autofocus>

                                    @if ($errors->has('acc_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('acc_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('id_account_group') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-account-group">{{ __('Account Group') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_account_group') ? ' is-invalid' : '' }}" name="id_account_group" value="{{ old('id_account_group', $coa->id_account_group) }}">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($accountGroup as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['group_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('id_normal_balance') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-normal-balance">{{ __('Normal Balance') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_normal_balance') ? ' is-invalid' : '' }}" name="id_normal_balance" value="{{ old('id_normal_balance', $coa->id_normal_balance) }}">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($normalBalance as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['normal_balance']}}
                                            </option>
                                        @endforeach
                                    </select>
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