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
            .csp-admin-shadow{
                background-color:#F0F8FF;
            }
            .csp-admin-margin-div{
                margin-top: 10px;
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
                            <div class="shadow rounded py-5 csp-admin-shadow">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">State Authority Sign In</h3>
                                            @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                            @elseif(session('message'))
                                        <div id="warning-message" class="alert me-4 alert-warning csp-admin-margin-div">
                                            {{ session('message') }}

                                        </div>
                                            @endif
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('admin.loginssaformdata') }}" id="loginform" class="row g-4" method="POST" autocomplete="off">
                                                @csrf
                                                <div class="col-12">
                                                    <label>Username<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                                        <input id="login-username" type="email" class="form-control"
                                                            name="email" placeholder="Enter email" value="{{ old('email') }}">
                                                    </div>
                                                </div>
        
                                                <div class="col-12">
                                                    <label>Password<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                                        <input type="password" id="login-password" class="form-control"
                                                            name="password" placeholder="Enter Password" autocomplete="new-password">
                                                        <input type="hidden" name="_password" id="encrypted_password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="captcha d-inline-flex d-flex">
                                                        <span>{!! captcha_img() !!}</span>
                                                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                            &#x21bb;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                                    @if($errors->has('captcha'))
                                                            <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                                        @endif
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary px-4 mt-4">Login</button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end mt-2">
                                                    {{-- <a href="{{ route('noc.request_noc_signup') }}" class="text-decoration-none">Signup</a> --}}
                                                    {{-- <span class="mx-2">|</span> --}}
                                                    {{-- <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password</a> --}}
                                                </div>
                                                {{-- <div class="col-12 text-end mt-2">
                                                    <a href="{{ route('noc.request_noc_signup') }}" class="text-decoration-none">Signup?</a>
                                                </div>
                                                <div class="col-12 text-end mt-2">
                                                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                                                </div> --}}
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
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jsencrypt.min.js') }}"></script>
        <script nonce="{{ $cspNonce }}">
        document.addEventListener('DOMContentLoaded', function () {
            let PUBLIC_KEY = '';
            const form = document.getElementById('loginform');
            const passwordInput = document.getElementById('login-password');
            const encryptedInput = document.getElementById('encrypted_password');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Disable submit button until public key is loaded
            submitBtn.disabled = true;
            //url = '{{ url('publickey') }}';
            //alert(url);

            // Load public key from Laravel
            fetch('{{ url('publickey') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch public key');
                    }
                    return response.text();
                })
                .then(key => {
                    PUBLIC_KEY = key.trim(); // remove extra whitespace/newlines
                    if (!PUBLIC_KEY.startsWith('-----BEGIN PUBLIC KEY-----')) {
                        throw new Error('Invalid public key format');
                    }
                    submitBtn.disabled = false;
                })
                .catch(err => {
                    console.error('Error loading public key:', err);
                    alert('Encryption setup failed. Please reload the page.');
                });

            // On form submit: encrypt password and disable plain input
            form.addEventListener('submit', function (e) {
                try {
                    if (!PUBLIC_KEY) {
                        alert('Encryption key not loaded yet. Please wait.');
                        e.preventDefault();
                        return;
                    }

                    const password = passwordInput.value;
                    if (!password) {
                        alert('Please enter your password.');
                        e.preventDefault();
                        return;
                    }

                    const encrypt = new JSEncrypt();
                    encrypt.setPublicKey(PUBLIC_KEY);

                    const encrypted = encrypt.encrypt(password);
                    if (!encrypted) {
                        alert('Password encryption failed.');
                        e.preventDefault();
                        return;
                    }

                    encryptedInput.value = encrypted;
                    passwordInput.disabled = true; // block plain-text from being submitted
                    //alert(encryptedInput.value);
                } catch (err) {
                    console.error('Encryption error:', err);
                    alert('An error occurred while encrypting the password.');
                    e.preventDefault();
                }
            });
        });
        </script>
        @endsection
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
        <script nonce="{{ $cspNonce }}" type="text/javascript">
            $(document).ready(function(){
                $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '{{route('noc.reloadCaptcha')}}',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            </script>

            
        
    </body>
</html>