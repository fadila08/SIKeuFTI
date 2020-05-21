@extends('layouts.app', ['title' => __('General Ledger')])

@section('content')
    @include('generalLedgers.partials.header', ['title' => __('General Ledger')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <!-- <h3 class="mb-0">{{ __('Customer') }}</h3> -->
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="{{ route('cust.create') }}" class="btn btn-sm btn-primary">{{ __('Add Customer') }}</a> -->
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
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Ref') }}</th>
                                    <th scope="col">{{ __('Debet') }}</th>
                                    <th scope="col">{{ __('Credit')}}</th>
                                    <th scope="col">{{ __('Transaction Proof') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($generalLedgers as $data)
                                    <tr>
                                        <td>{{ $data->date }}</td>
                                        <td>
                                            {{ $data->debetAcc->acc_name }}
                                            <br>
                                            {{ $data->credAcc->acc_name }}
                                            <br>
                                            {{ '( ' . $data->description . ' )' }}
                                        </td>
                                        <td>
                                            {{ $data->debetAcc->acc_code }}
                                            <br>
                                            {{ $data->credAcc->acc_code }}
                                            <br>
                                            {{ __('.')}}
                                        </td>
                                        <td>
                                            {{ \Crypt::decryptString($data->nominal) }}
                                            <br>
                                            {{ __(' - ')}}
                                            <br>
                                            {{ __('.')}}
                                        </td>
                                        <td>
                                            {{ __(' - ')}}
                                            <br>
                                            {{ \Crypt::decryptString($data->nominal) }}
                                            <br>
                                            {{ __('.')}}
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">{{ $data->proof_num }}</a>

                                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <img src="{{ asset('images') }}/{{ ($data->upload_proof) }}" alt="" max-width="100%" height="auto">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <form action="{{ route('projectTransaction.destroy', $data) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <a class="dropdown-item" href="{{ route('projectTransaction.edit', $data->id) }}">{{ __('Edit') }}</a>
                                                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this data ?") }}') ? this.parentElement.submit() : ''">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>    
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
                            {{ $generalLedgers->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection