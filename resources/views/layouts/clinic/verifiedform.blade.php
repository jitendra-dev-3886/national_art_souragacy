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
                                        @if(session('success'))
                                        <div id="success-message" class="alert me-4 alert-success"
                                            style="margin-top: 10px;">
                                            {{ session('success') }}

        <title>National ART & Surrogacy Portal</title>       
    </head>
    <body class="antialiased"> --}}
        @extends('layouts.main')
        {{-- @section('title','ART & Surrogacy Registry') @endsection --}}
        @section('content')

<style nonce="{{$cspNonce}}" nonce="{{$cspNonce}}">

    .csp-clinic-bg {
        background-color: #F0F8FF;
    }

    .csp-clinic-margin-top {
        margin-top: 10px;
    }

    .csp-clinic-btn-cancel {
        width: 93px;
    }

    .csp-clinic-bottom-line {
        border-top: 1px solid #888;
        padding-top: 15px;
        font-size: 85%;
    }
    .csp-password-policy {   
        color: #0d1b2a;                   
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        padding: 10px 15px;
        
        border-radius: 6px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); 
    }
    .csp-password-policy strong {
        color: #4273b3;                   
    }
</style>


        <section class="login-section py-2">
            <div class="login-page bg-white py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="shadow rounded py-2 csp-clinic-bg">
                           

                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h4 class="card-title text-center" >Generate your Password</h4>
                                            {{-- <span class="text-center">(Details to be filled by applicant)</span> --}}
                                            @if(session('success'))
                                           
                                            <div id="success-message" class="alert me-4 alert-success csp-clinic-margin-top">
                                                {{ session('success') }}
                                            
                                        </div>@endif    
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('clinic.verified_clinic_signup_data') }}" id="loginform" class="well form-horizontal" method="POST">
                                                @csrf
                                               
                                               
                                                {{-- <form  class="well form-horizontal" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> --}}
                                                    <!-- <form class="form-valide-with-icon needs-validation" novalidate> -->
                                                        <input type="hidden" name='encryptedEmail' value={{ $encryptedEmail }}>
                                                        <input type="hidden" name='encryptedtoken' value={{ $encryptedtoken }}>
                                                        <div class="mt-5 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Name of Health Facility (ART Clinic/ ART Bank/ Surrogacy Clinic)</strong></label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                                <input type="text" class="form-control border-left-end txtOnly"  name="clinicname" value="{{ !empty($get_user->clinicname) ? $get_user->clinicname : '' }}"id="validationCustomUsername" autocomplete="off" placeholder="Enter a username.." disabled>
                                                                <span class="text-danger"><?php //echo $user_name_err;?></span>
                                                                {{-- <div class="invalid-feedback">
                                                                    Please Enter a username.
                                                                  </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!-- Email Section -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="email"><strong>Email ID</strong></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                                    <input type="email" class="form-control border-left-end" name="email" id="email" value="{{ !empty($get_user->email) ? $get_user->email : '' }}" placeholder="Enter an email.." readonly>
                                                                    @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_email"><strong>Mobile Number</strong></label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text"><i class="fa fa-mobile-phone"></i></span>
                                                                    <input type="text" class="form-control border-left-end" name="mobile" id="mobile" value="{{ !empty($get_user->mobile) ? $get_user->mobile : '' }}" placeholder="Enter a mobile number.." disabled>
                                                                    @error('mobile')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>                                                       
                                                        
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="dlab-password"><strong>Password *</strong></label>
                                                                <div class="input-group transparent-append input-container">
                                                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                                    <input type="password" class="form-control" name="password" id="password" autocomplete="off" placeholder="Choose a safe one.." minlength="8"
    maxlength="50"
    pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$"
    title="Password must be at least 8 characters long and include at least one uppercase, one lowercase, one digit, and one special character."
    required>
                                                                    <span id="strength-icon" class="strength-icon"></span>
                                                                </div>
                                                                @error('password')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="dlab-cpassword"><strong>Confirm Password *</strong></label>
                                                                <div class="input-group transparent-append">
                                                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                                    <input type="password" class="form-control" name="password_confirmation" id="cpassword" autocomplete="off" placeholder="Repeat your password..">
                                                                </div>
                                                                @error('password_confirmation')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="csp-password-policy">
                                                                Password should be <strong>minimum 8 characters</strong> long and must include at least 
                                                                <strong>one uppercase letter</strong>, <strong>one lowercase letter</strong>, 
                                                                <strong>one digit</strong>, and <strong>one special character</strong>.
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
                                                                                       
                                                                                        <button type="submit" class="btn btn-danger light csp-clinic-btn-cancel">Cancel</button>
                                                                                        
                                                                                      
                                                                                        <div class="gap-2 mt-2 csp-clinic-bottom-line">


                                                                Already have an account! 
                                                                {{-- <a href="{{ route('clinic.loginclinicform') }}" class="text-dark text-decoration-none"
                                                                    onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                                                    Login Here
                                                                </a> --}}
                                                                
                                                                <a href="{{ route('clinic.loginclinicform') }}" class="text-dark text-decoration-none" id="showSignupLink">
    Login Here
</a>
                                                                
                                                                
                                                                
                                                                </div>
                                                                                    </form>
        
                                         
                                        </div>
                                        
                                        {{-- @endif
                                        @if ($errors->any())
                                        <div class="alert alert-danger col-sm-12">
                                            @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                        @endif --}}

                                        {{-- <form action="{{ route('noc.verified_noc_signup_data') }}" id="loginform"
                                            class="well form-horizontal" method="POST">
                                            @csrf
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-user"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-left-end txtOnly"
                                                            name="user_name"
                                                            value="{{ !empty($get_user->user_name) ? $get_user->user_name : '' }}"
                                                            id="validationCustomUsername" autocomplete="off"
                                                            placeholder="Enter a username.." disabled>
                                                        <span class="text-danger">
                                                           
                                                        </span>
                                                        <div class="invalid-feedback">
                                                            Please Enter a username.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- Email Section -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="text-label form-label" for="email">Email
                                                            ID</label>
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
                                                        <label class="text-label form-label"
                                                            for="dlab-password">Password *</label>
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
                                                        <label class="text-label form-label"
                                                            for="dlab-cpassword">Confirm Password *</label>
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
                                                        @if($errors->has('captcha'))
                                                        <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <input type="submit" class="btn btn-primary light" id="submitBtn"
                                                    value="Submit">
                                                <button type="submit" style="width: 93px;"
                                                    class="btn btn-danger light">Cancel</button>
                                                <div class="gap-2 mt-2"
                                                    style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
                                                    Already have an account! |
                                                    <a href="{{ route('clinic.loginclinicform') }}"
                                                        class="text-dark text-decoration-none"
                                                        onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                                        Login Here
                                                    </a>
                                                </div>
                                            </form> --}}


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>  
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js')}}"></script>
       
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


<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    const link = document.getElementById('showSignupLink');
    if (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            document.getElementById('loginbox')?.style.display = 'none';
            document.getElementById('signupbox')?.style.display = 'block';
        });
    }
});
</script>
            <script nonce="{{ $cspNonce }}">
                document.addEventListener("DOMContentLoaded", function () {
                    const password = document.getElementById("password");
                    const cpassword = document.getElementById("cpassword");
                    const strengthIcon = document.getElementById("strength-icon");
                    const captchaReload = document.getElementById("reload");
            
                    // Password Strength Check
                    password.addEventListener("input", function () {
                        const strength = checkPasswordStrength(password.value);
                        updateStrengthIndicator(strength);
                    });
            
                    function checkPasswordStrength(password) {
                        let strength = 0;
                        if (password.length >= 8) strength++;
                        if (/[A-Z]/.test(password)) strength++;
                        if (/[a-z]/.test(password)) strength++;
                        if (/[0-9]/.test(password)) strength++;
                        if (/[\W]/.test(password)) strength++;
                        return strength;
                    }
            
                    // function updateStrengthIndicator(strength) {
                    //     const strengthLevels = ["Weak", "Fair", "Good", "Strong", "Very Strong"];
                    //     const colors = ["red", "orange", "yellow", "blue", "green"];
                    //     strengthIcon.innerText = strengthLevels[strength - 1] || "";
                    //     strengthIcon.style.color = colors[strength - 1] || "black";
                    // }
            
                    // Confirm Password Match
                    cpassword.addEventListener("input", function () {
                        if (cpassword.value !== password.value) {
                            cpassword.setCustomValidity("Passwords do not match!");
                        } else {
                            cpassword.setCustomValidity("");
                        }
                    });
            
                    // Captcha Reload
                    captchaReload.addEventListener("click", function () {
                        fetch("/reload-captcha")
                            .then(response => response.json())
                            .then(data => {
                                document.querySelector(".captcha span").innerHTML = data.captcha;
                            });
                    });
                });
            </script>
            
    
@endsection