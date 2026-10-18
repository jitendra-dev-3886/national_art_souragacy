@extends('layouts.main')
@section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-bg-lightblue {
        background-color: #F0F8FF;
    }
    .csp-clinic-error-color-red {
        background-color: #f02323ce;
    }

    .csp-clinic-login-shadow {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        border-radius: 0.25rem;
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

</style>

<section class="login-section py-5">
    <div class="login-page bg-white py-5">
        <div class="container">
            <div class="row">
                @if (session('error'))
                    {{-- Handle error message here if needed --}}
                @endif

                <div class="col-lg-6 offset-lg-3">
                    <div class="shadow rounded csp-clinic-bg-lightblue csp-clinic-login-shadow">
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

                                    <form action="{{ route('admin_password.update') }}" method="POST" id="passwordForm">
                                        @csrf
                                        <input type="hidden" name="secure_email" value="{{ request('email') }}" class="form-control">
                                        <input type="hidden" name="secure_token" value="{{ request('token') }}" class="form-control">

                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" value="{{ !empty($userRequest->email) ? $userRequest->email : '' }}" id="email" class="form-control" required>
                                            
                                            <small id="emailError" class="csp-clinic-error-color-red"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Username</label>
                                            <input type="text" name="username" value="{{ !empty($userRequest->username) ? $userRequest->username : '' }}" id="username" class="form-control" required>
                                            <small id="usernameError" class="csp-clinic-error-color-red"></small>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                            <small id="passworderror" class="csp-clinic-error-color-red"></small>
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                            <small id="confirmPasswordError" class="csp-clinic-error-color-red"></small>
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

        <script nonce="{{ $cspNonce }}">
        document.getElementById("passwordForm").addEventListener("submit", function(e) {
            let isValid = true;
            // Get values
            const email = document.getElementById("email").value.trim();
            const username = document.getElementById("username").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmPassword = document.getElementById("password_confirmation").value.trim();
            const passwordError = document.getElementById("passworderror");
            const confirmPasswordError = document.getElementById("confirmPasswordError");

            // Error elements
            const emailError = document.getElementById("emailError");
            const usernameError = document.getElementById("usernameError");

            // Clear previous errors
            emailError.textContent = "";
            usernameError.textContent = "";

            // Email Validation
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (email === "") {
                emailError.textContent = "Email is required.";
                isValid = false;
            } else if (!email.match(emailPattern)) {
                emailError.textContent = "Enter a valid email address.";
                isValid = false;
            }

            // Username Validation
            if (username === "") {
                usernameError.textContent = "Username is required.";
                isValid = false;
            } else if (username.length < 4) {
                usernameError.textContent = "Username must be at least 4 characters.";
                isValid = false;
            }

            passwordError.textContent = "";
            confirmPasswordError.textContent = "";

            if (password === "") {
                passwordError.textContent = "Password is required.";
                isValid = false;
            } else if (password.length < 8) {
                passwordError.textContent = "Password must be at least 8 characters.";
                isValid = false;
            } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#^()_\-+=])/ .test(password)) {
                passwordError.textContent = "Password must contain uppercase, lowercase, number, and special character.";
                isValid = false;
            }

            if (confirmPassword === "") {
                confirmPasswordError.textContent = "Please confirm your password.";
                isValid = false;
            } else if (password !== confirmPassword) {
                confirmPasswordError.textContent = "Passwords do not match.";
                isValid = false;
            }

            // Prevent submission if invalid
            if (!isValid) {
                e.preventDefault();
            }
        });
        </script>

@endsection
