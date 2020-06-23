@extends('layouts.app', ['title' => __('Change Equity')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Change Equity')])   

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
                    
                    @foreach ($changeEquity as $key => $value)
                        <div class="col-12 text-right">
                            <input type="button" value="Print" class="btn btn-primary my-2 btn-sm" onclick="window.print()" /> 
                            <a href="{{url('changeEquity/print')}}" class="btn btn-primary my-2 btn-sm">Unduh PDF</a>
                        </div>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center" >{{ __('LAPORAN PERUBAHAN EKUITAS') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('CV. FIT TECH INOVA GLOBAL') }}</h4>
                        <h4 class="mb-0 ml-3" style="font-weight:bold ;text-align: center">{{ __('Untuk Periode Yang Berakhir : ') }} {{ $value[0]->period }}</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                @foreach ($value as $item)
                                    <tr>
                                        <td style="font-weight:bold">{{ __('Saldo Awal Modal') }}</td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->initial_balance) }}</td>                                    
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Laba Bersih') }}</td>
                                        <td>{{ Crypt::decryptString($item->net_income->net_income) }}</td>                                    
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td>{{ __('Prive') }}</td>
                                        <td>{{ Crypt::decryptString($item->prive) }}</td>                                    
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight:bold">{{ __('Saldo Akhir Modal') }}</td>
                                        <td></td>
                                        <td style="font-weight:bold">{{ Crypt::decryptString($item->ending_balance) }}</td>                                    
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