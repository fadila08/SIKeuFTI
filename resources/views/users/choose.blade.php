@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('layouts.headers.cardsClear')

    <div class="container-fluid mt--7">
        <div class="col">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <br>
                                <br>
                                <br>
                                <div class="row">            
                                    <img src="{{ asset('argon') }}/img/theme/admin_acc.svg" style="width:80%;height:80%;display:block;margin-left:auto;margin-right:auto;"/>
                                </div>
                                <div class="text-center">
                                    <br>
                                    <br>
                                    <br>
                                    <a href="{{ route('user.index') }}">
                                        <button class="btn btn-primary my-2">{{ __('Akun Admin') }}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <br>
                                <div class="row">          
                                    <img src="{{ asset('argon') }}/img/theme/dir_acc.svg" style="width:60%;height:60%;display:block;margin-left:auto;margin-right:auto;"/>
                                </div>
                                <div class="text-center">
                                    <br>
                                    <a href="#">
                                        <button class="btn btn-primary my-2">{{ __('Akun Direksi') }}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footers.auth')
        </div>
    </div>
@endsection