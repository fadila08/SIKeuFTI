@extends('layouts.app', ['title' => __('Balance Sheet')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Balance Sheet')])   

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
                    
                    @foreach ($balanceSheet as $key => $value)
                        <div class="col-12 text-right">
                            <input type="button" value="Print" class="btn btn-primary my-2 btn-sm" onclick="window.print()" /> 
                        </div>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center" >{{ __('NERACA') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('CV. FIT TECH INOVA GLOBAL') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('Periode : ') }} {{ $value[0]->period }}</h4>
                        <br>
                        <div class="table-responsive">
                            @foreach ($value as $item)
                                <table class="table align-items-center table-flush float-left" style="width:50%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('ASET') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('ASET LANCAR') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach (explode(',',$item->acc_current_asset) as $row)
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
                                        <td style="font-weight:bold">{{ __('Jumlah Aset Lancar') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_current_asset) }}</td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('ASET TETAP') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach (explode(',',$item->acc_fixed_asset) as $row)
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
                                        <td style="font-weight:bold">{{ __('Jumlah Aset Tetap') }}</td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_fixed_asset) }}</td>
                                        <td></td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('AKUMULASI DEPRESIASI') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach (explode(',',$item->acc_acum_depreciation) as $row)
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
                                        <td style="font-weight:bold">{{ __('Jumlah Akumulasi Depresasi') }}</td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_acum_depreciation) }}</td>
                                        <td></td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Nilai Buku Aset Tetap') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->book_value_fixed_asset) }}</td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('TOTAL ASET') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_asset) }}</td>                                    
                                    </tr>
                                </table>

                                <table class="table align-items-center table-flush" style="width:50%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('KEWAJIBAN DAN EKUITAS') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('KEWAJIBAN') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach (explode(',',$item->acc_liability) as $row)
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
                                        <td style="font-weight:bold">{{ __('Jumlah Kewajiban') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_liability) }}</td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('EKUITAS') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Modal') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->equity_balance->ending_balance) }}</td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('TOTAL KEWAJIBAN DAN EKUITAS') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->total_liability_equity) }}</td>                                    
                                    </tr>
                                </table>
                            @endforeach
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