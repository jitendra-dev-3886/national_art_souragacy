        @extends('layouts.main')
        @section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-bg-lightblue {
        background-color: #F0F8FF;
    }

    .csp-clinic-success-msg {
        margin-top: 10px;
    }
</style>


        <section class="login-section py-2">
            <div class="login-page bg-white py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="shadow rounded py-2 csp-clinic-bg-lightblue">
                                        <div class="form-left h-100 py-3 px-5">
                                            {{-- <h4 class="card-title text-center mb-4" >Sign-up Form</h4> --}}
                                            {{-- <span class="text-center">(Details to be filled by Clinics/Banks)</span> --}}
                                            @if(session('success'))
                                      
                                            <div id="success-message" class="alert me-4 alert-success csp-success-success-msg">
                                                {{ session('success') }}
                                        </div>@endif
                                       {{-- @if(session('link'))
                                                <script nonce="{{ $cspNonce }}">
                                                        console.log("Link for registration of clinic is: " + @json(session('link')));
                                                </script>
                                            @endif --}}
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
                    url: '{{route('clinic.reloadCaptcha')}}',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            </script>
            <script nonce="{{ $cspNonce }}">
                 $(document).ready(function(){
                $('#pincode').blur(function() {
                  
                    var pincode = $(this).val();
                    if (pincode === "") {
                        $('#state').val('');
                        $('#district').val('');
                        $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                    } else {                       
                        $.ajax({
                            url: "{{ route('pincode.signup') }}", // Laravel route
                            method: "POST",
                            data: {
                                pincode: pincode,
                                _token: "{{ csrf_token() }}" // CSRF token for security
                            },
                            success: function(data) {
                                if (data.success) {
                                    $('#state').val(data.state);
                                    $('#district').val(data.district);
                                    $('#pincodeavailability').html('');
                                } else {
                                    $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                    $('#state').val('');
                                    $('#district').val('');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                console.log('Response Text:', xhr.responseText);
                            }
                        });
                    }
                });
            });
            </script>
        {{-- <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
            <script nonce="{{ $cspNonce }}">
                document.addEventListener("DOMContentLoaded", function() {
                    let inputs = document.querySelectorAll("input");
            
                    inputs.forEach(input => {
                        input.addEventListener("keypress", function(event) {
                            let char = String.fromCharCode(event.which);
                            if (char === "<" || char === ">") {
                                alert("'<>' characters are not allowed!");
                                event.preventDefault();
                            }
                        });
                    });
                });
            
                function validateInput() {
                    let inputs = document.querySelectorAll("input");
            
                    for (let input of inputs) {
                        if (input.value.includes("<") || input.value.includes(">")) {
                            alert("'<>' characters are not allowed in input fields!");
                            input.focus();
                            return false;
                        }
                    }
            
                    return true;
                }
            </script>
            <script nonce="{{ $cspNonce }}">
                function validation() {
                    //alert("Call");
            
                    if (document.getElementById("clinicname").value == "") {
                        alert("Name of Health Facility (ART Clinic/ ART Bank/ Surrogacy Clinic) cannot be blank");
                        document.getElementById("clinicname").focus();
                        return false;
                    }
                    if (document.getElementById("address").value == "") {
                        alert("Address of the Organisation cannot be blank");
                        document.getElementById("address").focus();
                        return false;
                    }
                    if (document.getElementById("pincode").value == "") {
                        alert("Pincode cannot be blank");
                        document.getElementById("pincode").focus();
                        return false;
                    }
                    if (document.getElementById("nature").value == "") {
                        alert("Nature of the Organisation cannot be blank");
                        document.getElementById("nature").focus();
                        return false;
                    }
                    if (document.getElementById("contactno").value == "") {
                        alert("Contact Number of the Organisation cannot be blank");
                        document.getElementById("contactno").focus();
                        return false;
                    }
                    if (document.getElementById("email").value == "") {
                        alert("Email Address cannot be blank");
                        document.getElementById("email").focus();
                        return false;
                    }
                    if (document.getElementById("v_email").value == "") {
                        alert("Verify Email Address cannot be blank");
                        document.getElementById("v_email").focus();
                        return false;
                    }
                    const email = document.getElementById("email");
                    const vEmail = document.getElementById("v_email");
                    const mobileNo = document.getElementById("mobile");
                    const vMobileNo = document.getElementById("v_mobile");
                    const form = document.querySelector("form");
                    if (email.value !== vEmail.value) {
                            isValid = false;
                            vEmail.classList.add("is-invalid");
                            alert("Email and Verify Email must match.");
                            document.getElementById("v_email").focus();
                        return false;
                        } else {
                            vEmail.classList.remove("is-invalid");                           
                        }
                    
                    if (document.getElementById("personname").value == "") {
                        alert("Name of the Contact Person cannot be blank");
                        document.getElementById("personname").focus();
                        return false;
                    }
                    if (document.getElementById("mobile").value == "") {
                        alert("Mobile Number cannot be blank");
                        document.getElementById("mobile").focus();
                        return false;
                    }
                    if (document.getElementById("mobile").value.match(/^[0-9]+$/) == true) {
                        alert("Mobile Number should be numeric");
                        document.getElementById("mobile").focus();
                        return false;
                    }
                    if (document.getElementById("v_mobile").value == "") {
                        alert("Verify Mobile Number cannot be blank");
                        document.getElementById("v_mobile").focus();
                        return false;
                    }
                    if (document.getElementById("v_mobile").value.match(/^[0-9]+$/) == true) {
                        alert("Verify Mobile Number should be numeric");
                        document.getElementById("v_mobile").focus();
                        return false;
                    }
                    if (mobileNo.value !== vMobileNo.value) {
                            isValid = false;
                            vMobileNo.classList.add("is-invalid");
                            alert("Mobile Number and Verify Mobile Number must match.");
                            document.getElementById("v_mobile").focus();
                            return false;
                        } else {
                            vMobileNo.classList.remove("is-invalid");
                        }
                        let captchaInput = document.getElementById("captcha").value;

                    if (captchaInput.trim() === "") {
                        alert("CAPTCHA cannot be blank");
                        document.getElementById("captcha").focus();
                        return false;
                    }
                    var agree = confirm(
                        "Kindly check and confirm all details before final submission."
                    );
                    if (agree) {
                
                        return true;
                    } else {
                        return false;
                    }
                    // if (document.getElementById("password").value == "") {
                    //     alert("Password cannot be blank");
                    //     document.getElementById("password").focus();
                    //     return false;
                    // }
                    // let password = document.getElementById("password").value;
                    // let cpassword = document.getElementById("cpassword").value;
                    // let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/; // At least 8 characters, 1 letter, 1 number

                    // if (password.length < 8) {
                    //     alert("Password must be at least 8 characters long.");
                    //     document.getElementById("password").focus();
                    //     return false;
                    // }

                    // if (!passwordRegex.test(password)) {
                    //     alert("Password must contain at least one letter and one number.");
                    //     document.getElementById("password").focus();
                    //     return false;
                    // }

                    // if (cpassword === "") {
                    //     alert("Confirm Password cannot be blank.");
                    //     document.getElementById("cpassword").focus();
                    //     return false;
                    // }

                    // if (password !== cpassword) {
                    //     alert("Password and Confirm Password should match.");
                    //     document.getElementById("password").focus();
                    //     return false;
                    // }
                    // if (document.getElementById("password").value.length < 8) {
                    //     alert("Password Must Contain At Least 8 Characters!");
                    //     document.getElementById("password").focus();
                    //     return false;
                    // }
                    // if (document.getElementById("cpassword").value == "") {
                    //     alert("Confirm Password cannot be blank");
                    //     document.getElementById("cpassword").focus();
                    //     return false;
                    // }
                    // if ((document.getElementById("password").value) != (document.getElementById("cpassword").value)) {
                    //     alert("Password and Confirm Password should be same");
                    //     document.getElementById("password").focus();
                    //     return false;
                    // }
                    // if (!document.getElementById("declaration").checked) {
                    //     alert("Declaration cannot be blank");
                    //     document.getElementById("declaration").focus();
                    //     return false;
                    // }
                    return true;
                }
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
                        url: '{{ route('clinic.checkEmail') }}', // Laravel route
                        method: "POST",
                        data: {
                            email: email,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            if (response.status === 'exists') {
                                $('#availability').html(
                                    '<span class="text-danger">Email ID already exists with NARTSR. Please use the another email ID.</span>'
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


        
    {{-- </body>
</html> --}}
