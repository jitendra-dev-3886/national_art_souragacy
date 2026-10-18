@extends('layouts.main')
@section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-bg-lightblue {
        background-color: #F0F8FF;
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

                                    <form action="{{ route('password.update_signup_ssa') }}" method="POST" id="passwordForm">
                                        @csrf

                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" value="{{ !empty($get_user->email) ? $get_user->email : '' }}" id="email" class="form-control" readonly>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" name="password" id="password" class="form-control" required>
                                        <div class="mt-2">
                                            <small><strong>Password must contain:</strong></small>
                                            <ul id="passwordRules" class="mb-0" style="font-size: 13px;">
                                                <li id="length" class="text-danger">❌ At least 8 characters</li>
                                                <li id="uppercase" class="text-danger">❌ One uppercase letter (A-Z)</li>
                                                <li id="lowercase" class="text-danger">❌ One lowercase letter (a-z)</li>
                                                <li id="number" class="text-danger">❌ One number (0-9)</li>
                                                <li id="special" class="text-danger">❌ One special character (@, #, $, etc.)</li>
                                            </ul>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Reset Password</button>
                                        <!-- Password Policy Note -->
                                        {{-- <div class="mt-3 p-2 rounded bg-light border">
                                            <small class="text-muted">
                                                <strong>Password must:</strong>
                                                <ul class="mb-0">
                                                    <li>Be at least 8 characters long</li>
                                                    <li>Include at least one uppercase letter (A-Z)</li>
                                                    <li>Include at least one lowercase letter (a-z)</li>
                                                    <li>Include at least one number (0-9)</li>
                                                    <li>Include at least one special character (e.g., @, #, $, %)</li>
                                                </ul>
                                            </small>
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
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const form = document.getElementById('passwordForm');

    const rules = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };

    function validatePassword() {
        const value = passwordInput.value;

        const checks = {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            lowercase: /[a-z]/.test(value),
            number: /\d/.test(value),
            special: /[^a-zA-Z0-9]/.test(value)
        };

        Object.keys(checks).forEach(key => {
            if (checks[key]) {
                rules[key].classList.remove('text-danger');
                rules[key].classList.add('text-success');
                rules[key].innerHTML = '✅ ' + rules[key].innerText.replace('❌ ', '').replace('✅ ', '');
            } else {
                rules[key].classList.remove('text-success');
                rules[key].classList.add('text-danger');
                rules[key].innerHTML = '❌ ' + rules[key].innerText.replace('❌ ', '').replace('✅ ', '');
            }
        });

        return Object.values(checks).every(Boolean);
    }

    passwordInput.addEventListener('input', validatePassword);

    form.addEventListener('submit', function (e) {
        const isValid = validatePassword();

        if (!isValid) {
            e.preventDefault();
            alert('Please follow password policy.');
            return;
        }

        if (passwordInput.value !== confirmInput.value) {
            e.preventDefault();
            alert('Passwords do not match.');
        }
    });

});
</script>
        <script nonce="{{ $cspNonce }}">
    //         document.addEventListener('DOMContentLoaded', function () {
    //             const form = document.getElementById('passwordForm');
    //             const messageDiv = document.createElement('div');
    //             messageDiv.style.color = 'red';
    //             messageDiv.style.marginTop = '10px';
    //             form.appendChild(messageDiv); // Append message container to the form

    //     form.addEventListener('submit', function (e) {
    //         const newPassword = document.getElementById('password').value.trim();
    //         const confirmPassword = document.getElementById('password_confirmation').value.trim();

    //         messageDiv.textContent = '';
    //         messageDiv.style.color = 'red';

    //         if (newPassword !== confirmPassword) {
    //             e.preventDefault();
    //             messageDiv.textContent = 'New password and confirm password do not match.';
    //             return;
    //         }

    //         messageDiv.style.color = 'green';
    //         messageDiv.textContent = 'Validation passed. Submitting...';
    //     });
    // });
</script>

@endsection
