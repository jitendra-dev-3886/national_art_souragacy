<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>National ART & Surrogacy Portal</title> 
    </head>
    <body class="antialiased">
        @extends('layouts.main')
        @section('content')
        <style nonce="{{ $cspNonce }}">
            .bg-color-csp-noc-one{
                background-color:#F0F8FF;
            }
        </style>
        <section class="login-section py-5">
            <div class="login-page bg-white py-5">
                <div class="container">
                    <div class="row">
                        {{-- @if(Sssion::get('error')) --}}
                        @if (session('error'))
                        @endif
                        <div class="col-lg-6 offset-lg-3">
                            <div class="shadow rounded py-5 bg-color-csp-noc-one">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">Forget password</h3>
                                            
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('password.update') }}" method="POST">
                                                @csrf
                                                {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
                                                <div class="form-group">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" name="email" value="{{ !empty($get_user->email) ? $get_user->email : '' }}" id="email" class="form-control" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">New Password</label>
                                                    <input type="password" name="password" id="password" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Reset Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endsection
    </body>
</html>