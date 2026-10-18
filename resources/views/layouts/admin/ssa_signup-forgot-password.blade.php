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
        <style nonce="{{$cspNonce}}">
            .csp-clinic-shadow{
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
                            <div class="shadow rounded py-5 csp-clinic-shadow" >
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">Forget password</h3>
                                            <!-- Display success message -->
                                            @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                            @endif
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('password.ssa_email_signup') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" name="email" id="email" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <div class="captcha d-inline-flex d-flex">
                                                        <span>{!! captcha_img() !!}</span>
                                                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                            &#x21bb;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                                    @if($errors->has('captcha'))
                                                            <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                                        @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Send Reset Link</button>
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
                    url: '{{route('clinic.reloadCaptcha')}}',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            </script>
            
    </body>
</html>