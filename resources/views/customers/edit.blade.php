@extends('layouts.app', ['title' => __('Customer')])

@section('content')
    @include('customers.partials.header', ['title' => __('Edit Customer')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Customer Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('cust.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('cust.update', $customer->id) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Customer information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('cust_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cust-name">{{ __('Name') }}</label>
                                    <input type="text" name="cust_name" id="input-cust-name" class="form-control form-control-alternative{{ $errors->has('cust_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Customer Name') }}" value="{{ old('cust_name', $customer->cust_name) }}" required autofocus>

                                    @if ($errors->has('cust_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cust_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('cust_address') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cust-address">{{ __('Address') }}</label>
                                    <input type="text" name="cust_address" id="input-cust-address" class="form-control form-control-alternative{{ $errors->has('cust_address') ? ' is-invalid' : '' }}" placeholder="{{ __('Customer Address') }}" value="{{ old('cust_address', $customer->cust_address) }}" required autofocus>

                                    @if ($errors->has('cust_address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cust_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('cust_email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cust-email">{{ __('Email Address') }}</label>
                                    <input type="email" name="cust_email" id="input-cust-email" class="form-control form-control-alternative{{ $errors->has('cust_email') ? ' is-invalid' : '' }}" placeholder="{{ __('Customer Email') }}" value="{{ old('cust_email', $customer->cust_email) }}" required>

                                    @if ($errors->has('cust_email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cust_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('cust_phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-cust-phone">{{ __('Phone Number') }}</label>
                                    <input type="text" name="cust_phone" id="input-cust-phone" class="form-control form-control-alternative{{ $errors->has('cust_phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Customer Phone') }}" value="{{ old('cust_phone', $customer->cust_phone) }}" required>

                                    @if ($errors->has('cust_phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cust_phone') }}</strong>
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