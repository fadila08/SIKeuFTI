@extends('layouts.app', ['title' => __('Creditor')])

@section('content')
    @include('creditors.partials.header', ['title' => __('Add Creditor')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0" style="color:#028090">{{ __('Creditor') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('cred.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('cred.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Creditor information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('cred_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cred-name">{{ __('Name') }}</label>
                                    <input type="text" name="cred_name" id="input-cred-name" class="form-control form-control-alternative{{ $errors->has('cred_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Creditor Name') }}" value="{{ old('cred_name') }}" required autofocus>

                                    @if ($errors->has('cred_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cred_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('cred_address') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cred-address">{{ __('Address') }}</label>
                                    <input type="text" name="cred_address" id="input-cred-address" class="form-control form-control-alternative{{ $errors->has('cred_address') ? ' is-invalid' : '' }}" placeholder="{{ __('Creditor Address') }}" value="{{ old('cred_address') }}" required autofocus>

                                    @if ($errors->has('cred_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cred_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('cred_email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cred-email">{{ __('Email') }}</label>
                                    <input type="email" name="cred_email" id="input-cred-email" class="form-control form-control-alternative{{ $errors->has('cred_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Creditor Email Address') }}" value="{{ old('cred_email') }}" required>

                                    @if ($errors->has('cred_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cred_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('cred_phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cred-phone">{{ __('Phone Number') }}</label>
                                    <input type="phone" name="cred_phone" id="input-cred-phone" class="form-control form-control-alternative{{ $errors->has('cred_phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Creditor Phone Number') }}" value="{{ old('cred_phone') }}" required>

                                    @if ($errors->has('cred_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cred_phone') }}</strong>
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