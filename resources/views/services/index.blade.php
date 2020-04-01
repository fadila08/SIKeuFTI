@extends('layouts.app', ['title' => __('Service')])

@section('content')
    @include('layouts.headers.cardsClear')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Services') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary">{{ __('Add Service') }}</a>
                            </div>
                        </div>
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

                    <div class="table-responsive">
                        <style type="text/css">
                            table {
                            /* width: 50%; */
                            counter-reset: row-num;
                            }
                            table tbody tr {
                            counter-increment: row-num;
                            }
                            table tbody tr td:first-child::before {
                                content: counter(row-num);
                            }
                        </style>
                        <table class="table align-items-center table-flush" >
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('No') }}</th>
                                    <th scope="col">{{ __('Service') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td></td>
                                        <td>{{ $service->service_name }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <!-- <form action="{{ route('services.destroy', $service) }}" method="post">
                                                        @csrf
                                                        @method('delete') -->
                                                        <a class="dropdown-item" href="{{ route('services.edit', $service->id) }}">{{ __('Edit') }}</a>
                                                        <!-- <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this service ?") }}') ? this.parentElement.submit() : ''">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>     -->
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $services->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection