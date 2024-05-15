@extends('layouts.login')

@section('content')
    <div class="content-body h-100">
        <div class="auth-inner row m-0 h-100">
            <div class="d-none d-lg-flex col-lg-8 align-items-center p-3"
                style="background-image: url('{{ asset('img/bg-login.jpg') }}'); background-size: cover;">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    <div class="container text-center">
                        <img class="img-fluid" style="height: 120px;" src="{{ asset('img/logo.png') }}" />
                        <h3 class="font-weight-bold text-center mt-4 text-primary text-uppercase">Aplikasi
                            {{ config('app.name') }} <br>
                            {{ config('app.client_name') }}
                        </h3>
                        <p class="d-inline m-0">
                            Aplikasi {{ config('app.name') }} berbasis web
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                    <h3 class="text-bold text-primary">Login</h3>
                    <p>Silahkan login untuk menggunakan aplikasi ini</p>
                    <br>
                    <form id="my-form" class="forms-sample" action="{{ route('login') }}" method="POST" novalidate>
                        @csrf

                        @inputText(['title' => 'Email', 'name' => 'username', 'class' => $errors->has('username') ? ' is-invalid' : '', 'validation' => 'required'])

                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('Password') }}</label>
                            <input type="password"
                                class="form-control form-control-sm {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                name="password" id="password" autocomplete="current-password" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="mt-4">
                            <button type="submit"
                                class="btn btn-sm btn-primary btn-block btn-icon-text mb-2 mb-md-0 login">
                                <i class="btn-icon-prepend fas fa-lock mr-2"></i>
                                Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script>
        $(function() {
            formValidation('form#my-form');
        });
    </script>
@endpush
