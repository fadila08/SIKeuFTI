@extends('layouts.app', ['title' => __('Account Receivable')])

@section('content')
    @include('Ledgers.partials.header', ['title' => __('Account Receivable')])   

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
                    
                    @foreach ($accReceivables as $key => $value)
                        <h5 class="card-title text-muted mb-0 ml-3">{{ __('Nama Debitur : ') }} {{ $value[0]->transaction->project->customer->cust_name }}</h5>
                        
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Due Date') }}</th>
                                        <th scope="col">{{ __('Pay Date') }}</th>
                                        <th scope="col">{{ __('Proof Number') }}</th>
                                        <th scope="col">{{ __('Debet') }}</th>
                                        <th scope="col">{{ __('Credit')}}</th>
                                        <th scope="col">{{ __('Remaining Debt') }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($value as $item)
                                        <tr>
                                            <td>{{ $item->transaction->description }}</td>
                                            <td>{{ $item->due_date }}</td>
                                            <td>{{ $item->pay_date }}</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#exampleModal-{{ $item->transaction->id }}">{{ $item->transaction->proof_num }}</a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal-{{ $item->transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">{{ $item->transaction->proof_num }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" >
                                                                <img class="img-fluid" src="{{ asset('images') }}/{{ ($item->transaction->upload_proof) }}" alt="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ Crypt::decryptString($item->debet) }}</td>
                                            <td>{{ Crypt::decryptString($item->credit) }}</td>
                                            <td>{{ Crypt::decryptString($item->remaining_debt) }}</td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item" href="{{ route('accReceivable.edit', $item->id) }}">{{ __('Edit') }}</a>
                                                    </div>
                                                </div>
                                            </td>
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