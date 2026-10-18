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

                                    <form action="{{ route('password.update_signup') }}" method="POST" id="passwordForm">
                                        @csrf

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

        <script nonce="{{ $cspNonce }}">
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('passwordForm');
                const messageDiv = document.createElement('div');
                messageDiv.style.color = 'red';
                messageDiv.style.marginTop = '10px';
                form.appendChild(messageDiv); // Append message container to the form

        form.addEventListener('submit', function (e) {
            const newPassword = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('password_confirmation').value.trim();

            messageDiv.textContent = '';
            messageDiv.style.color = 'red';

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                messageDiv.textContent = 'New password and confirm password do not match.';
                return;
            }

            messageDiv.style.color = 'green';
            messageDiv.textContent = 'Validation passed. Submitting...';
        });
    });
</script>

@endsection
