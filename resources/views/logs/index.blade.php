@extends('layouts.app', ['title' => __('Log Activity')])

@section('content')
    @include('layouts.headers.cardsClear')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Log Activity') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>                               
                                    <th scope="col">{{ __('Waktu Akses') }}</th>
                                    <th scope="col">{{ __('User Pengakses') }}</th>
                                    <th scope="col">{{ __('Role User Pengakses') }}</th>
                                    <th scope="col">{{ __('Menu yang Diakses') }}</th>
                                    <th scope="col">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->created_at }}</td>
                                        <td>{{ $log->user->role->role_name }}</td>
                                        <td>{{ $log->user->name }}</td>                                        
                                        <td>{{ $log->from_table }}</td>
                                        <td>{{ $log->type }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $logs->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection