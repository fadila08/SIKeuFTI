@extends('layouts.app', ['title' => __('Projects')])

@section('content')
    @include('projects.partials.header', ['title' => __('Add Projects')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0" style="color:#028090">{{ __('Projects') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('project.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('project.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Project information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('project_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-project-name">{{ __('Project Name') }}</label>
                                    <input type="text" name="project_name" id="input-project-name" class="form-control form-control-alternative{{ $errors->has('project_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Project Name') }}" value="{{ old('project_name') }}" required autofocus>

                                    @if ($errors->has('project_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('project_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('id_cust') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-cust">{{ __('Customer') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_cust') ? ' is-invalid' : '' }}" name="id_cust">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($customer as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['cust_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group{{ $errors->has('id_service') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-service">{{ __('Service') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_service') ? ' is-invalid' : '' }}" name="id_service">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($service as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['service_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                                
                                <div class="form-group{{ $errors->has('project_started') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-project-started">{{ __('Project Started') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="" name="project_started" id="input-project-started">
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('project_ended') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-project-ended">{{ __('Project Ended') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker " placeholder="Select date" type="text" value="" name="project_ended" id="input-project-ended">
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('project_cost') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-project-cost">{{ __('Project Cost') }}</label>
                                    <input type="text" name="project_cost" id="input-project-cost" class="form-control form-control-alternative{{ $errors->has('project_cost') ? ' is-invalid' : '' }}" placeholder="{{ __('Project Cost') }}" value="{{ old('project_cost') }}" required autofocus>

                                    @if ($errors->has('project_cost'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('project_cost') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('project_status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-project-status">{{ __('Project Status') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('project_status') ? ' is-invalid' : '' }}" name="project_status">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($projectStatus as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['status_project']}}
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
