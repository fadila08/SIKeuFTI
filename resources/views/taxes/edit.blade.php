@extends('layouts.app', ['title' => __('Taxes')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Edit Taxes')])   

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
                        <form method="post" action="{{ route('tax.update', $tax->id) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Tax Data') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('id_transaction') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-id-transaction">{{ __('Description') }}</label>
                                    <select class="form-control form-control-alternative{{ $errors->has('id_transaction') ? ' is-invalid' : '' }}" name="id_transaction" value="{{ old('id_transaction', $tax->id_transaction) }}" disabled="disabled">
                                        @foreach ($transaction as $row)
                                            <option value="{{$row['id']}}">
                                                {{$row['description']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('due_date') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-due-date">{{ __('Due Date') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="{{ old('due_date', $tax->due_date) }}" name="due_date" id="input-due-date">
                                    </div>
                                </div>

                                @if ($tax->pay_status == "0")
                                    <div class="form-group{{ $errors->has('pay_status') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-pay-status">{{ __('Pay Status') }}</label>
                                        <input type="text" name="pay_status" id="input-pay-status" class="form-control form-control-alternative{{ $errors->has('pay_status') ? ' is-invalid' : '' }}" placeholder="{{ __('Pay Status') }}" value="{{ old('pay_status', $tax->pay_status) }}" required autofocus hidden="hidden">
                                        <input type="text" class="form-control" placeholder="{{ __('Pay Status') }}" value="{{ __('Belum Terbayarkan')  }}" required autofocus disabled="disabled">

                                        @if ($errors->has('pay_status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pay_status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="form-group{{ $errors->has('pay_status') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-pay-status">{{ __('Pay Status') }}</label>
                                        <input type="text" name="pay_status" id="input-pay-status" class="form-control form-control-alternative{{ $errors->has('pay_status') ? ' is-invalid' : '' }}" placeholder="{{ __('Pay Status') }}" value="{{ old('pay_status', $tax->pay_status) }}" required autofocus hidden="hidden">
                                        <input type="text" class="form-control" placeholder="{{ __('Pay Status') }}" value="{{ __('Sudah Terbayarkan')  }}" required autofocus disabled="disabled">

                                        @if ($errors->has('pay_status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pay_status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif

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