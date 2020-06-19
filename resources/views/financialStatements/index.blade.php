@extends('layouts.app', ['title' => __('Financial Statements')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Financal Statements')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        
                    </div>
                    
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

                    <h4 class="mb-0 ml-3">{{ __('This menu is used for generate Financial Statements in the current year') }}</h4>
                    <br>
                    <h4 class="mb-0 ml-3 mr-3">{{ __('Financial Statement consist of :') }}</h4>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead>
                                <tr>
                                    <td>{{ __('- Profit Loss Statement') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Change in Equity Statement') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Balance Sheet') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Cash Flow') }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                    <h4 class="mb-0 ml-3">{{ __('Generate Financal Statement for ') }}{{$data}}</h4>
                    <div class="col-xl-6 col-lg-6">
                        <a href="{{ route('generateStatement') }}" class="btn btn-primary my-2 btn-sm">{{ __('GENERATE') }}</a>
                    </div>
                    
                    <div class="card-footer py-4">
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection