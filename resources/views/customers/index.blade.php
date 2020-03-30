@extends('layouts.app', ['title' => __('Customer')])

@section('content')
    @include('layouts.headers.cardsClear')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Customer') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('cust.create') }}" class="btn btn-sm btn-primary">{{ __('Add Customer') }}</a>
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
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Address') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->cust_name }}</td>
                                        <td>{{ $customer->cust_address }}</td>
                                        <td>
                                            <a href="mailto:{{ $customer->cust_email }}">{{ $customer->cust_email }}</a>
                                        </td>
                                        <td>{{ $customer->cust_phone }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <!-- <form action="{{ route('cust.destroy', $customer) }}" method="post">
                                                        @csrf
                                                        @method('delete') -->
                                                        <a class="dropdown-item" href="{{ route('cust.edit', $customer->id) }}">{{ __('Edit') }}</a>
                                                        <!-- <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this customer ?") }}') ? this.parentElement.submit() : ''">
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
                            {{ $customers->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection