@extends('layouts.app', ['title' => __('Taxes')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Taxes')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('List of Taxes') }}</h3>
                            </div>
                            <div class="col-4 text-right">
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
                                    <th scope="col">{{ __('Account Name') }}</th>
                                    <th scope="col">{{ __('Ref') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Due Date') }}</th>
                                    <th scope="col">{{ __('Nominal') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($taxes as $value)
                                     @if (strpos($value->transaction->debetAcc->acc_name, "PPh") !== false ||  strpos($value->transaction->credAcc->acc_name, "PPh") !== false)
                                    <tr>
                                        <td>{{ $value->transaction->date }}</td>
                                        <td>
                                            {{-- {{dd($value->transaction->debetAcc->acc_name)}} --}}
                                            @if (strpos($value->transaction->debetAcc->acc_name, "PPh") !== false)
                                                {{ $value->transaction->debetAcc->acc_name }}
                                            @elseif (strpos($value->transaction->credAcc->acc_name, "PPh") !== false)
                                                {{ $value->transaction->credAcc->acc_name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (strpos($value->transaction->debetAcc->acc_name, "PPh") !== false)
                                                {{ $value->transaction->debetAcc->acc_code }}
                                            @elseif (strpos($value->transaction->credAcc->acc_name, "PPh") !== false)
                                                {{ $value->transaction->credAcc->acc_code }}
                                            @endif
                                        </td>
                                        <td>{{ $value->transaction->description }}</td>
                                        <td>{{ $value->due_date }}</td>
                                        <td>{{ Crypt::decryptString($value->transaction->nominal) }}</td>
                                        <td>
                                            @if ($value->pay_status == "0")
                                                {{ "Belum Terbayar" }}
                                            @else
                                                {{ "Sudah Terbayar" }}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item" href="{{ route('tax.edit', $value->id) }}">{{ __('Edit') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $taxes->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection