@extends('layouts.app', ['title' => __('Cash Flow')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Cash Flow')])   

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
                    
                    @foreach ($cashFlow as $key => $value)
                        <div class="col-12 text-right">
                            <input type="button" value="Print" class="btn btn-primary my-2 btn-sm" onclick="window.print()" /> 
                        </div>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center" >{{ __('ARUS KAS') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('CV. FIT TECH INOVA GLOBAL') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('Untuk Tahun Yang Berakhir : ') }} {{ $value[0]->period }}</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                @foreach ($value as $item)
                                    <tr>
                                        <td style="font-weight:bold">{{ __('Kas Periode Sebelumnya') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->cash_previous_period) }}</td>                                    
                                    </tr>

                                    <tbody class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('Arus Kas dari Aktivitas Operasi :') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </tbody>

                                    <tr>
                                        <td>{{ __('Kas diterima dari pelanggan') }}</td>
                                        <td>{{ Crypt::decryptString($item->revenue_and_charge->total_revenue) }}</td>                                    
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Dikurangi pembayaran kas untuk beban') }}</td>
                                        <td>{{ Crypt::decryptString($item->revenue_and_charge->total_charge) }}</td>                                    
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Arus Kas Netto dari Aktivitas Operasi') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->netto_op_activity) }}</td>                                    
                                        <td></td>
                                    </tr>

                                    <tbody class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('Arus Kas dari Aktivitas Investasi :') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </tbody>

                                    <tr>
                                        <td>{{ __('Pembayaran kas untuk pemelian aset tetap') }}</td>
                                        <td>{{ Crypt::decryptString($item->fixed_asset->total_fixed_asset) }}</td>                                    
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Dikurangi akumulasi depresiasi') }}</td>
                                        <td>{{ Crypt::decryptString($item->fixed_asset->total_acum_depreciation) }}</td>                                    
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Arus Kas Netto dari Aktivitas Operasi') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ __('-( ')}} {{ Crypt::decryptString($item->netto_invest_activity) }} {{ __(' )')}}</td>                                    
                                        <td></td>
                                    </tr>

                                    <tbody class="thead-light">
                                        <tr>
                                            <th scope="col" style="font-weight:bold">{{ __('Arus Kas dari Aktivitas Pendanaan :') }}</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </tbody>

                                    <tr>
                                        <td>{{ __('Kas diterima sebagai investasi oleh pemilik') }}</td>
                                        <td>{{ Crypt::decryptString($item->equity_and_prive->initial_balance) }}</td>                                    
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Dikurangi penarikan kas oleh pemilik') }}</td>
                                        <td>{{ Crypt::decryptString($item->equity_and_prive->prive) }}</td>                                    
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Arus Kas Netto dari Aktivitas Pendanaan') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->netto_fund_activity) }}</td>                                    
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Kenaikan Netto di Kas Selama Tahun Berjalan') }}</td>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->net_cash_flow) }}</td>                                    
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Kas Periode ') }} {{ $item->period }}</td>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->net_cash_flow) }}</td>                                    
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