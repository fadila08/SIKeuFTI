@extends('layouts.app', ['title' => __('Profit and Loss')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Profit and Loss')])   

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
                    
                    @foreach ($profitLos as $key => $value)
                        <div class="col-12 text-right">
                            <input type="button" value="Print" class="btn btn-primary my-2 btn-sm" onclick="window.print()" /> 
                        </div>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center" >{{ __('LAPORAN LABA RUGI') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('CV. FIT TECH INOVA GLOBAL') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('Periode : ') }} {{ $value[0]->period }}</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                @foreach ($value as $item)
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('Pendapatan') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    @foreach (explode(',',$item->acc_revenue) as $row)
                                        @foreach ($trialBalance as $cek)
                                            @if ($cek->id == $row)
                                                <tr>
                                                   <td>
                                                        {{ $cek->coa->acc_name }}
                                                    </td>
                                                    <td>
                                                        {{ Crypt::decryptString($cek->ledger->cred_saldo) }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Total Pendapatan') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_revenue) }}</td>                                    
                                    </tr>

                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('Beban') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    @foreach (explode(',',$item->acc_charge) as $row)
                                        @foreach ($trialBalance as $cek)
                                            @if ($cek->id == $row)
                                                <tr>
                                                    <td>
                                                        {{ $cek->coa->acc_name }}
                                                    </td>
                                                    <td>
                                                        {{ Crypt::decryptString($cek->ledger->debet_saldo) }}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Total Beban') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_charge) }}</td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Laba Bersih') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->net_income) }}</td>                                    
                                    </tr>

                                @endforeach
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