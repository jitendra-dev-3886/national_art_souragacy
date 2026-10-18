    {{-- @extends('layouts.main')
    @section('content')
    <section class="login-section py-2">
        <div class="login-page bg-white py-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="shadow rounded py-2" style="background-color:#F0F8FF;">
                            <div class="row">
                                <div class="col-md-12 pe-0">
                                    <div class="form-left h-100 py-3 px-5">
                                        <h4 class="card-title text-center">Generate your Password</h4>
                                        <span class="text-center">(Details to be filled by applicant)</span>
                                        @if (session('success'))
                                        <div id="success-message" class="alert me-4 alert-success"
                                            style="margin-top: 10px;">
                                            {{ session('success') }}

        <title>National ART & Surrogacy Portal</title>

       
    </head>
    <body class="antialiased"> --}}
    @extends('layouts.main')
    @section('content')
    <style nonce="{{ $cspNonce }}">
    .bc-color-csp-noc-one{
        background-color:#F0F8FF;
    }
    .width-csp-noc-one{
        width: 93px;
    }
    .brtop-padding-top-font-size-csp-one{
        border-top: 1px solid#888; padding-top:15px; font-size:85%
    }
    .margin-top-csp-noc-three{
        margin-top: 10px;
    }
        
    </style>
        <section class="login-section py-2">
            <div class="login-page bg-white py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="shadow rounded py-2 bc-color-csp-noc-one">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h4 class="card-title text-center">Generate your Password</h4>
                                            <span class="text-center">(Details to be filled by applicant)</span>
                                            @if (session('success'))
                                                <div id="success-message" class="alert me-4 alert-success margin-top-csp-noc-three">
                                                    {{ session('success') }}

                                                </div>
                                            @endif
                                            @if ($errors->any())
                                                <div class="alert alert-danger col-sm-12">
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <form action="{{ route('noc.verified_noc_signup_data') }}" id="loginform"
                                                class="well form-horizontal" method="POST">
                                                @csrf


                                                {{-- <form  class="well form-horizontal" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);
                                                ?>" method="POST"> --}}
                                                <!-- <form class="form-valide-with-icon needs-validation" novalidate> -->
                                                <div class="mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : '';
                                                ?>">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                        <input type="text" class="form-control border-left-end txtOnly"
                                                            name="user_name"
                                                            value="{{ !empty($get_user->user_name) ? $get_user->user_name : '' }}"id="validationCustomUsername"
                                                            autocomplete="off" placeholder="Enter a username.." disabled>
                                                        <span class="text-danger"><?php //echo $user_name_err;
                                                        ?></span>
                                                        <div class="invalid-feedback">
                                                            Please Enter a username.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Email Section -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-label form-label" for="email">Email ID</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="email" class="form-control border-left-end"
                                                                name="email" id="email"
                                                                value="{{ !empty($get_user->email) ? $get_user->email : '' }}"
                                                                placeholder="Enter an email.." readonly>
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-label form-label" for="v_email">Mobile
                                                            Number</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="fa fa-mobile-phone"></i></span>
                                                            <input type="text" class="form-control border-left-end"
                                                                name="mobileno" id="mobileno"
                                                                value="{{ !empty($get_user->mobileno) ? $get_user->mobileno : '' }}"
                                                                placeholder="Enter a mobile number.." disabled>
                                                            @error('mobileno')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-label form-label" for="dlab-password">Password
                                                            *</label>
                                                        <div class="input-group transparent-append input-container">
                                                            <span class="input-group-text"> <i class="fa fa-lock"></i>
                                                            </span>
                                                            <input type="password" class="form-control" name="password"
                                                                id="password" autocomplete="off"
                                                                placeholder="Choose a safe one..">
                                                            <span id="strength-icon" class="strength-icon"></span>
                                                        </div>
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-label form-label" for="dlab-cpassword">Confirm
                                                            Password *</label>
                                                        <div class="input-group transparent-append">
                                                            <span class="input-group-text"> <i class="fa fa-lock"></i>
                                                            </span>
                                                            <input type="password" class="form-control"
                                                                name="password_confirmation" id="cpassword"
                                                                autocomplete="off" placeholder="Repeat your password..">
                                                        </div>
                                                        @error('password_confirmation')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <div class="captcha d-inline-flex d-flex">
                                                            <span>{!! captcha_img() !!}</span>
                                                            <button type="button" class="btn btn-danger" class="reload"
                                                                id="reload">
                                                                &#x21bb;
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <input id="captcha" type="text"
                                                            class="form-control @error('captcha') is-invalid @enderror"
                                                            placeholder="Enter Captcha" name="captcha"
                                                            autocomplete="off">
                                                        @if ($errors->has('captcha'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('captcha') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <input type="submit" class="btn btn-primary light" id="submitBtn"
                                                    value="Submit">
                                                <button type="submit" class="btn btn-danger light width-csp-noc-one">Cancel</button>
                                                <div class="gap-2 mt-2 brtop-padding-top-font-size-csp-one">
                                                    Already have an account! |
                                                    <a href="{{ route('noc.loginnocform') }}"
                                                        class="text-dark text-decoration-none">
                                                        Login Here
                                                    </a>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- @endif --}}
                                        @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>

        <script nonce="{{ $cspNonce }}" type="text/javascript">
            $(document).ready(function() {
                $('#reload').click(function() {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('noc.reloadCaptcha') }}',
                        success: function(data) {
                            $(".captcha span").html(data.captcha);
                        }
                    });
                });
            })
        </script>
        <script nonce="{{ $cspNonce }}" type="text/javascript">
            $(document).ready(function() {
                $('#reload').click(function() {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('noc.reloadCaptcha') }}',
                        success: function(data) {
                            $(".captcha span").html(data.captcha);
                        }
                    });
                });
            })
        </script>

        <script nonce="{{ $cspNonce }}">
            document.addEventListener('DOMContentLoaded', function() {
                const email = document.getElementById('email');
                const vEmail = document.getElementById('v_email');
                const mobileno = document.getElementById('mobileno');
                const vMobileno = document.getElementById('v_mobileno');
                const errorEmail = document.getElementById('error-v-email');
                const errorMobile = document.getElementById('error-v-mobile');

                // Email validation
                vEmail.addEventListener('input', function() {
                    if (email.value !== vEmail.value) {
                        errorEmail.style.display = 'block';
                    } else {
                        errorEmail.style.display = 'none';
                    }
                });

                vMobileno.addEventListener('input', function() {
                    if (mobileno.value !== vMobileno.value) {
                        errorMobile.style.display = 'block';
                    } else {
                        errorMobile.style.display = 'none';
                    }
                });
            });
        </script>
    @endsection
