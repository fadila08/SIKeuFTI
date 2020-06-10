@extends('layouts.app', ['title' => __('Contract Account Receivable')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Contract Account Receivable')])   

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
                    
                    @foreach ($contractAR as $key => $value)
                        <h5 class="card-title text-muted mb-0 ml-3">{{ __('No. Akun : ') }} {{ $value[0]->coa->acc_code }}</h5>
                        <h5 class="card-title text-muted mb-1 ml-3">{{ __('Nama Akun : ') }} {{ $value[0]->coa->acc_name }}</h5>
                       
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Date') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Debet') }}</th>
                                        <th scope="col">{{ __('Credit')}}</th>
                                        <th scope="col">{{ __('Debet Saldo') }}</th>
                                        <th scope="col">{{ __('Credit Saldo')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($value as $item)
                                        <tr>
                                            <td>{{ $item->desc->date }}</td>
                                            <td>{{ $item->desc->description }}</td>
                                            <td>
                                                @if ($item->id_coa != $item->desc->id_debet_acc)
                                                    {{ ('0') }}
                                                @else
                                                    {{ Crypt::decryptString($item->desc->nominal) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->id_coa != $item->desc->id_cred_acc)
                                                    {{ ('0') }}
                                                @else
                                                    {{ Crypt::decryptString($item->desc->nominal) }}
                                                @endif
                                            </td>
                                            <td>{{ Crypt::decryptString($item->debet_saldo) }}</td>
                                            <td>{{ Crypt::decryptString($item->cred_saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>
                    @endforeach

                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection