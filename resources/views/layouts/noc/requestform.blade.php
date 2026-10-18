
        
@extends('layouts.main')
@section('content')
<style nonce="{{ $cspNonce }}">
    .bc-color-thirty-six{
     background-color:#F0F8FF;   
    }
    .with-csp-npoc-thirty-seven{
        width: 93px;
    }
    .border-padding-font-size-csp-noc-thirty-eight{
        border-top: 1px solid#888; padding-top:15px; font-size:85%
    }
    .margin-top-thirty-nine{
        margin-top: 10px;
    }
   
</style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- intl-tel-input CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"/>
        <section class="login-section py-2">
            <div class="login-page bg-white py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="shadow rounded py-2 bc-color-thirty-six">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h4 class="card-title text-center" >Registration Form For NOC</h4>
                                            <span class="text-center">(Details to be filled by applicant)</span>
                                            @if(session('success'))
                                            <div id="success-message" class="alert me-4 alert-success margin-top-thirty-nine">
                                                {{ session('success') }}
                                            
                                        </div>@endif   
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('noc.request_noc_signup_data') }}" id="loginform" class="well form-horizontal" method="POST">
                                                @csrf
                                               
                                                        <div class="mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                            <label class="text-label form-label" for="validationCustomUsername">Username</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                                <input type="text" class="form-control border-left-end txtOnly"  name="user_name" id="validationCustomUsername" autocomplete="off" placeholder="Enter a username.." required>
                                                                @error('user_name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!-- Email Section -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="email">Email ID</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                                    <input type="email" class="form-control border-left-end" name="email" id="email" value="{{ old('email') }}" placeholder="Enter an email.." required>
                                                                </div>
                                                                <div id="availability" class="mt-2"></div>                                                                  
                                                                   @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                            
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_email">Verify Email ID</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                                    <input type="email" class="form-control border-left-end" name="v_email" id="v_email" value="{{ old('v_email') }}" placeholder="Verify your email.." required>
                                                                    @error('v_email')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        
                                                            <!-- Mobile Number Section -->
                                                            
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="mobileno">Mobile Number</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="fa fa-mobile-phone"></i></span>
                                                                    <select name="countryCode" class="form-control">
                                                                          @if ($countries->count() > 0)
                                                                            @foreach ($countries as $country)
                                                                                <option value="{{ $country->country_code_no }}">
                                                                                    {{ $country->country_name .' '.$country->country_code_no }}
                                                                                </option>
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Countries Available</option>
                                                                        @endif
                                                                      </select>
                                                                    <input type="tel" class="form-control border-left-end" name="mobileno" id="mobileno" value="{{ old('mobileno') }}" placeholder="Enter a mobile number.." required>
                                                                    @error('mobileno')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_mobileno">Verify Mobile Number</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="fa fa-mobile-phone"></i></span>
                                                                    <select name="v_countryCode" class="form-control">
                                                                        @if ($countries->count() > 0)
                                                                            @foreach ($countries as $country)
                                                                                <option value="{{ $country->country_code_no }}">
                                                                                    {{ $country->country_name .' '.$country->country_code_no }}
                                                                                </option>
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Countries Available</option>
                                                                        @endif
                                                                  </select>
                                                                    <input type="text" class="form-control border-left-end" name="v_mobileno" id="v_mobileno" value="{{ old('v_mobileno') }}" placeholder="Verify your mobile number.." required>
                                                                    @error('v_mobileno')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <div class="captcha d-inline-flex d-flex">
                                                                    <span>{!! captcha_img() !!}</span>
                                                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                                        &#x21bb;
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                                                @if($errors->has('captcha'))
                                                                        <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                                                    @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="submit" class="btn btn-primary light" id="submitBtn" value="Submit">
                                                        <button type="submit"  class="btn btn-danger light with-csp-npoc-thirty-seven">Cancel</button>
                                <div class="gap-2 mt-2 border-padding-font-size-csp-noc-thirty-eight"> Already have an account! |
                                        <a href="{{route('noc.loginnocform')}}" class="text-dark text-decoration-none">Login Here</a>|
                                        <a href="{{url('/debug-back')}}" class="text-dark text-decoration-none">resend link</a></div></form>
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
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js')}}"></script>
       
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
        {{-- <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
        <script nonce="{{ $cspNonce }}">
            document.addEventListener('DOMContentLoaded', function () {
                const email = document.getElementById('email');
                const vEmail = document.getElementById('v_email');
                const mobileno = document.getElementById('mobileno');
                const vMobileno = document.getElementById('v_mobileno');
                
                const errorEmail = document.getElementById('error-v-email');
                const errorMobile = document.getElementById('error-v-mobile');
            
                // Email validation
                vEmail.addEventListener('input', function () {
                    if (email.value !== vEmail.value) {
                        errorEmail.style.display = 'block';
                    } else {
                        errorEmail.style.display = 'none';
                    }
                });
            
                // Mobile number validation
                vMobileno.addEventListener('input', function () {
                    if (mobileno.value !== vMobileno.value) {
                        errorMobile.style.display = 'block';
                    } else {
                        errorMobile.style.display = 'none';
                    }
                });
            });
            </script>
            
            <script nonce="{{ $cspNonce }}">
                document.addEventListener("DOMContentLoaded", function () {
                    const email = document.getElementById("email");
                    const vEmail = document.getElementById("v_email");
                    const mobileNo = document.getElementById("mobileno");
                    const vMobileNo = document.getElementById("v_mobileno");
                    const form = document.querySelector("form");
            
                    form.addEventListener("submit", function (event) {
                        let isValid = true;
            
                        // Validate Email
                        if (email.value !== vEmail.value) {
                            isValid = false;
                            vEmail.classList.add("is-invalid");
                            alert("Email and Verify Email must match.");
                        } else {
                            vEmail.classList.remove("is-invalid");
                        }
            
                        // Validate Mobile Number
                        if (mobileNo.value !== vMobileNo.value) {
                            isValid = false;
                            vMobileNo.classList.add("is-invalid");
                            alert("Mobile Number and Verify Mobile Number must match.");
                        } else {
                            vMobileNo.classList.remove("is-invalid");
                        }
            
                        if (!isValid) {
                            event.preventDefault();
                        }
                    });
                });
            </script>
            <script nonce="{{ $cspNonce }}">
                $(document).on('blur', '#email', function () {
           // $('#email').blur(function () {
                //alert('fgfd');
                //console.log('check 1');
                var email = $(this).val();
                //console.log(email);
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
                if (email == "") {
                    $('#availability').html('');
                } else {
                    $.ajax({
                        url: '{{ route('noc.checkEmail') }}', // Laravel route
                        method: "POST",
                        data: {
                            email: email,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            if (response.status === 'exists') {
                                $('#availability').html(
                                    '<span class="text-danger">Email ID already exists with NARTSR. Please use the forgot password option.</span>'
                                );
                                $('#submitBtn').attr("disabled", true);
                            } else if (!regex.test(email)) {
                                $('#availability').html(
                                    '<span class="text-danger">Please enter a valid email id</span>'
                                );
                            } else {
                                $('#availability').html(
                                    '<span class="text-success">Email available for submission of application form.</span>'
                                );
                                $('#submitBtn').attr("disabled", false);
                            }
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            
        </script>


<script nonce="{{ $cspNonce }}" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<!-- Optional: Utils script for formatting -->
<script nonce="{{ $cspNonce }}" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<script nonce="{{ $cspNonce }}">
  const input = document.querySelector("#phone");
  window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function (success, failure) {
      fetch("https://ipinfo.io/json?token=<YOUR_TOKEN>")
        .then(resp => resp.json())
        .then(resp => success(resp.country))
        .catch(() => success("us"));
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
  });
</script>
    {{-- </body>
</html> --}}
