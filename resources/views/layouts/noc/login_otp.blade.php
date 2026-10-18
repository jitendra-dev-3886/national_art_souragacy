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
            .bc-color-csp-noc-sixty{
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
                            <div class="shadow rounded py-5 bc-color-csp-noc-sixty">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">Login OTP Verify</h3>
                                            <!-- Display success message -->
                                            @if (session('success'))
                                            <div class="alert alert-success">
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
                                            
                                            <form action="{{ route('noc.verifyNocOtpLogin') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="email">Login OTP</label>
                                                    <input type="text" name="login_otp" id="login_otp" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-4">
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








                                                <button type="submit" class="btn btn-primary mt-3">submit </button>
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