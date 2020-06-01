@extends('layouts.app', ['title' => __('Project Transaction')])

@section('content')
    @include('projectTransactions.partials.header', ['title' => __('Add Project Transaction')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <div class="col-12">
                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('status') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="{{ route('coa.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('projectTransaction.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Project Transaction') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('id_project') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-project">{{ __('Project') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_project') ? ' is-invalid' : '' }}" name="id_project" id="id_project">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($project as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['project_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-date">{{ __('Date') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="" name="date" id="input-date">
                                    </div>
                                </div>
                                
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                                    <input type="text" name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" value="{{ old('description') }}" required autofocus>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('proof_num') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-proof-num">{{ __('Proof Number') }}</label>
                                    <input type="text" name="proof_num" id="input-proof-num" class="form-control form-control-alternative{{ $errors->has('proof_num') ? ' is-invalid' : '' }}" placeholder="{{ __('Proof Number') }}" value="{{ old('proof_num') }}" required autofocus>

                                    @if ($errors->has('proof_num'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('proof_num') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('upload_proof') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-upload-proof">{{ __('Upload Proof Transaction') }}</label>
                                    <input type="file" name="upload_proof" id="input-upload-proof" class="form-control form-control-alternative{{ $errors->has('upload_proof') ? ' is-invalid' : '' }}" placeholder="{{ __('Upload Proof Transaction') }}" value="{{ old('upload_proof') }}" required autofocus>

                                    @if ($errors->has('upload_proof'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('upload_proof') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('id_debet_acc') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-debet-acc">{{ __('Debet Account') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_debet_acc') ? ' is-invalid' : '' }}" name="id_debet_acc" id="id_debet_acc">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($coa as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['acc_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('id_cred_acc') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-cred-acc">{{ __('Credit Account') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_cred_acc') ? ' is-invalid' : '' }}" name="id_cred_acc" id="id_cred_acc">
                                        <option selected disabled>Choose one</option>
                                        @foreach ($coa as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['acc_name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('nominal') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-nominal">{{ __('Nominal') }}</label>
                                    <input type="text" name="nominal" id="input-nominal" class="form-control form-control-alternative{{ $errors->has('nominal') ? ' is-invalid' : '' }}" placeholder="{{ __('Nominal') }}" value="{{ old('nominal') }}" required autofocus>

                                    @if ($errors->has('nominal'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nominal') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#exampleModal" onclick="showProjectTransaction()">{{ __('Save') }}</button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">Pastikan data sudah benar sebelum disimpan !</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-left">
                                            <h5>Project name :</h5>
                                            <h5 class="text-muted" id="project_value"></h5>
                                            <br>
                                            <h5>Date :</h5>        
                                            <h5 class="text-muted" id="date_value"></h5>                                    
                                            <br>
                                            <h5>Description :</h5>                                            
                                            <h5 class="text-muted" id="desc_value"></h5>                                    
                                            <br>
                                            <h5>Proof Number :</h5>                                            
                                            <h5 class="text-muted" id="proof_num_value"></h5>                                    
                                            <br>
                                            <h5>Debet Account :</h5>                                            
                                            <h5 class="text-muted" id="debet_acc_value"></h5>                                    
                                            <br>
                                            <h5>Credit Account :</h5>                                            
                                            <h5 class="text-muted" id="cred_acc_value"></h5>                                    
                                            <br>
                                            <h5>Nominal :</h5>                                            
                                            <h5 class="text-muted" id="nominal_value"></h5>                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{asset('/js/custom.js')}}"></script>
        @include('layouts.footers.auth')
    </div>
@endsection