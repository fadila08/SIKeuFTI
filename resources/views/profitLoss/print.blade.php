<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
                .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        }

        .table th,
        .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        }

        .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        }

        .table tbody + tbody {
        border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
        padding: 0.3rem;
        }

        .table-bordered {
        border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
        border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody + tbody {
        border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
        color: #212529;
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-primary,
        .table-primary > th,
        .table-primary > td {
        background-color: #c6e0f5;
        }

        .table-primary th,
        .table-primary td,
        .table-primary thead th,
        .table-primary tbody + tbody {
        border-color: #95c5ed;
        }

        .table-hover .table-primary:hover {
        background-color: #b0d4f1;
        }

        .table-hover .table-primary:hover > td,
        .table-hover .table-primary:hover > th {
        background-color: #b0d4f1;
        }

        .table-secondary,
        .table-secondary > th,
        .table-secondary > td {
        background-color: #d6d8db;
        }

        .table-secondary th,
        .table-secondary td,
        .table-secondary thead th,
        .table-secondary tbody + tbody {
        border-color: #b3b7bb;
        }

        .table-hover .table-secondary:hover {
        background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover > td,
        .table-hover .table-secondary:hover > th {
        background-color: #c8cbcf;
        }

        .table-success,
        .table-success > th,
        .table-success > td {
        background-color: #c7eed8;
        }

        .table-success th,
        .table-success td,
        .table-success thead th,
        .table-success tbody + tbody {
        border-color: #98dfb6;
        }

        .table-hover .table-success:hover {
        background-color: #b3e8ca;
        }

        .table-hover .table-success:hover > td,
        .table-hover .table-success:hover > th {
        background-color: #b3e8ca;
        }

        .table-info,
        .table-info > th,
        .table-info > td {
        background-color: #d6e9f9;
        }

        .table-info th,
        .table-info td,
        .table-info thead th,
        .table-info tbody + tbody {
        border-color: #b3d7f5;
        }

        .table-hover .table-info:hover {
        background-color: #c0ddf6;
        }

        .table-hover .table-info:hover > td,
        .table-hover .table-info:hover > th {
        background-color: #c0ddf6;
        }

        .table-warning,
        .table-warning > th,
        .table-warning > td {
        background-color: #fffacc;
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody + tbody {
        border-color: #fff6a1;
        }

        .table-hover .table-warning:hover {
        background-color: #fff8b3;
        }

        .table-hover .table-warning:hover > td,
        .table-hover .table-warning:hover > th {
        background-color: #fff8b3;
        }

        .table-danger,
        .table-danger > th,
        .table-danger > td {
        background-color: #f7c6c5;
        }

        .table-danger th,
        .table-danger td,
        .table-danger thead th,
        .table-danger tbody + tbody {
        border-color: #f09593;
        }

        .table-hover .table-danger:hover {
        background-color: #f4b0af;
        }

        .table-hover .table-danger:hover > td,
        .table-hover .table-danger:hover > th {
        background-color: #f4b0af;
        }

        .table-light,
        .table-light > th,
        .table-light > td {
        background-color: #fdfdfe;
        }

        .table-light th,
        .table-light td,
        .table-light thead th,
        .table-light tbody + tbody {
        border-color: #fbfcfc;
        }

        .table-hover .table-light:hover {
        background-color: #ececf6;
        }

        .table-hover .table-light:hover > td,
        .table-hover .table-light:hover > th {
        background-color: #ececf6;
        }

        .table-dark,
        .table-dark > th,
        .table-dark > td {
        background-color: #c6c8ca;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th,
        .table-dark tbody + tbody {
        border-color: #95999c;
        }

        .table-hover .table-dark:hover {
        background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover > td,
        .table-hover .table-dark:hover > th {
        background-color: #b9bbbe;
        }

        .table-active,
        .table-active > th,
        .table-active > td {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover > td,
        .table-hover .table-active:hover > th {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table .thead-dark th {
        color: #fff;
        background-color: #343a40;
        border-color: #454d55;
        }

        .table .thead-light th {
        color: #495057;
        background-color: #e9ecef;
        border-color: #dee2e6;
        }

        .table-dark {
        color: #fff;
        background-color: #343a40;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
        border-color: #454d55;
        }

        .table-dark.table-bordered {
        border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.075);
        }
    </style>
    <title>Profit Loss</title>
</head>
<body>
    

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
            

</body>
</html>