@extends('layouts.app', ['title' => __('Service')])

@section('content')
    @include('services.partials.header', ['title' => __('Edit Service')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Service Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('services.update', $service->id) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Service information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('service_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-service-name">{{ __('Name') }}</label>
                                    <input type="text" name="service_name" id="input-service-name" class="form-control form-control-alternative{{ $errors->has('service_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Service Name') }}" value="{{ old('service_name', $service->service_name) }}" required autofocus>

                                    @if ($errors->has('service_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('service_name') }}</strong>
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