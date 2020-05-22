@extends('layouts.app', ['title' => __('Trial Balance')])

@section('content')
    @include('trialBalances.partials.header', ['title' => __('Trial Balance')])   

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

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Account Code') }}</th>
                                    <th scope="col">{{ __('Account Name') }}</th>
                                    <th scope="col">{{ __('Debet') }}</th>
                                    <th scope="col">{{ __('Credit')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sumDebet = 0;
                                    $sumCred = 0;
                                ?>
                                @foreach ($trialBalances as $tb)
                                    <tr>
                                        <td>{{ $tb->coa->acc_code }}</td>
                                        <td>{{ $tb->coa->acc_name }}</td>
                                        <td>
                                            {{ \Crypt::decryptString($tb->ledger->debet_saldo) }}
                                            <?php
                                                $sumDebet = $sumDebet + \Crypt::decryptString($tb->ledger->debet_saldo);
                                            ?>
                                        </td>
                                        <td>
                                            {{ \Crypt::decryptString($tb->ledger->cred_saldo) }}
                                            <?php
                                                $sumCred = $sumCred + \Crypt::decryptString($tb->ledger->cred_saldo);
                                            ?>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td class="font-weight-bold">{{ ('TOTAL') }}</td>
                                    <td class="font-weight-bold">{{ $sumDebet }}</td>
                                    <td class="font-weight-bold">{{ $sumCred }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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