@extends('layouts.app', ['title' => __('Backup and Recovery')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Backup and Recovery')])

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

                    <h4 class="mb-0 ml-3">{{ __('This menu is used for Backup and Recovery Database') }}</h4>
                    <br>
                    <h4 class="mb-0 ml-3 mr-3">{{ __('List Backup & Recovery Table :') }}</h4>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead>
                                <tr>
                                    <td>{{ __('- Account Group Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Account Payable Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Account Receivable Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Code of Account Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Creditor Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Customer Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- General Ledger Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Ledger Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Log Activity Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Normal Balance Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Log Activity Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Project Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Service Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Taxes Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- Trial Balance Table') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('- User Table') }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                    <h4 class="mb-0 ml-3">{{ __('Latest Backup : ') }}</h4>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead>
                                @foreach ($db as $item)
                                    <tr>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('recoverBackupRecovery') }}" class="btn btn-sm btn-primary">{{ __('Recover') }}</a>
                                            <a href="{{ route('downloadBackupRecovery') }}" class="btn btn-sm btn-primary">{{ __('Download') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection