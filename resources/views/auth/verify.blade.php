@extends('layouts.auth')

@section('content')
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div class="restricted-account">
                        <div class="text-center mb-6">
                            <a class="logo" href="{{ url('/') }}">
                                <img class="img-fluid for-light" src="{{ url('assets/images/logo/logo.png') }}"
                                    alt="logo" />
                                <img class="img-fluid for-dark" src="{{ url('assets/images/logo/logo_dark.png') }}"
                                    alt="logo dark" />
                            </a>
                        </div>
                        <div class="login-main text-center">
                            @if (session('resent'))
                                <div class="alert alert-success mb-4" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <h2 class="mb-3">{{ __('Verify Your Email Address') }}</h2>
                            <p class="mb-4">
                                {{ __('Before proceeding, please check your email for a verification link.') }}</p>
                            <p class="mb-4">
                                {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                    {{ __('click here to request another') }}
                                </button>.
                            </form>
                            </p>

                            <a class="btn btn-primary mb-5" href="{{ url('/') }}">{{ __('Home Page') }}</a>
                            {{-- <div>
                                <img class="img-fluid" src="{{ url('assets/images/login/4.png') }}"
                                    alt="restricted account" />
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
