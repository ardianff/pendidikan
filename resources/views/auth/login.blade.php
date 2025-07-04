{{-- resources/views/auth/signin.blade.php --}}
@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="text-center mb-6">
                            <a class="logo" href="{{ url('/') }}">
                                <img class="img-fluid for-light" src="{{ url('assets/images/logo/logo.png') }}"
                                    alt="logo" />
                                <img class="img-fluid for-dark" src="{{ url('assets/images/logo/logo_dark.png') }}"
                                    alt="logo dark" />
                            </a>
                        </div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('login') }}" class="theme-form" id="sign_in_form">
                                @csrf

                                <h4 class="mb-2">Sign in to account</h4>
                                <p class="text-muted mb-4">Enter your email &amp; password to login</p>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email Address</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                        autofocus placeholder="test@gmail.com"
                                        class="form-control @error('email') is-invalid @enderror" />
                                    @error('email')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="form-group">
                                    <label for="password" class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input id="password" type="password" name="password" required
                                            class="form-control @error('password') is-invalid @enderror" />
                                        <div class="show-hide"><span class="show"> </span></div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Captcha --}}
                                <div class="form-group">
                                    <label for="captcha-input" class="col-form-label">Captcha</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <span id="captcha-img" class="p-2 bg-white rounded shadow-sm">
                                            {!! captcha_img('math') !!}
                                        </span>
                                        <button type="button" id="reload-captcha"
                                            class="btn btn-outline-secondary btn-sm ms-2" aria-label="Reload captcha">
                                            <i id="reload-icon"
                                                class="fa-solid fa-rotate-right fa-lg transition-transform"></i>
                                        </button>
                                    </div>
                                    <input id="captcha-input" type="text" name="captcha" required
                                        placeholder="Enter captcha code"
                                        class="form-control @error('captcha') is-invalid @enderror" />
                                    @error('captcha')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Remember + Forgot --}}
                                <div class="form-group mb-0">
                                    <div class="form-check"><input class="checkbox-primary form-check-input" id="checkbox1"
                                            type="checkbox" name="remember" /><label class="text-muted form-check-label"
                                            for="checkbox1">Remember password</label></div>
                                    <a href="{{ route('password.request') }}" class="link">Forgot password?</a>
                                    <div class="text-end"><button class="btn btn-primary btn-block w-100 mt-3"
                                            type="submit">Sign in</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $('#reload-captcha').on('click', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const $icon = $btn.find('#reload-icon');

                $btn.prop('disabled', true);
                $icon.addClass('fa-spin');

                $.ajax({
                    url: '{{ route('captcha.reload') }}',
                    method: 'POST',
                    success(response) {
                        $('#captcha-img').html(response.data);
                    },
                    error(xhr) {
                        let msg = 'Error reloading captcha.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg = xhr.responseJSON.errors.join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    },
                    complete() {
                        $btn.prop('disabled', false);
                        $icon.removeClass('fa-spin');
                    }
                });
            });
        });
    </script>
@endpush
