@extends('layouts.app', ['title' => __('Account Group')])

@section('content')
    @include('accGroups.partials.header', ['title' => __('Edit Account Group')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Account Group Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('accGroup.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('accGroup.update', $accGroup->id) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Account Group information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('group_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-group-name">{{ __('Group Name') }}</label>
                                    <input type="text" name="group_name" id="input-group-name" class="form-control form-control-alternative{{ $errors->has('group_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Group Name') }}" value="{{ old('group_name', $accGroup->group_name) }}" required autofocus>

                                    @if ($errors->has('group_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('group_name') }}</strong>
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