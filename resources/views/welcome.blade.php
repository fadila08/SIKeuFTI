@extends('layouts.app', ['class' => 'bg-default-fti'])

@section('content')
    <div class="header bg-gradient-primary-fti py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <h1 class="text-white-right">
                            <img src="{{ asset('argon') }}/img/brand/logo-circl.png" style="width:200px;height:200px;"/>
                        </h1>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-base-left">{{ __('Welcome to') }}</h1>
                        <h1 class="text-base-left"><b>{{ __('FIT TECH INOVA GLOBAL') }}</b></h1>
                        <h1 class="text-base-left">{{ __('Financial Information System.') }}</h1>
                        <div class="text-left">
                            <a href="{{ route('login') }}">
                                <button class="btn btn-primary my-2">{{ __('LOGIN') }}</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default-fti" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
