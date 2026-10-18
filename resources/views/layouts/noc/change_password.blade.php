@extends('layouts.noc.noc_master')
@section('content')	
<style nonce="{{ $cspNonce }}">
	.bcbr-color-fiftyfive{
		background-color: #0b5ed7; border-color: #0b5ed7; color: white;	
	}

</style>	
			
			<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Change Password</h4>
				</div>
				@if(session('status'))
					<div class="alert alert-success">{{ session('status') }}</div>
                @endif                                          
				@if ($errors->any())
				<div class="alert alert-danger col-sm-12">
					@foreach ($errors->all() as $error)
					<div>{{ $error }}</div>
					@endforeach
				</div>
				@endif
				<div class="card-body">
					<div class="basic-form">
						<form class="form-valide-with-icon needs-validation" id="passwordForm" novalidate="" action="{{ route('noc.password.change.post') }}" method="POST">
							@csrf
							<div class="mb-3">
								<label class="text-label form-label" for="current_password">Current Password *</label>
								<div class="input-group transparent-append">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Choose a safe one.." required="">
									<input type="hidden" id="encrypted_current_password" name="_current_password">
									<span class="input-group-text show-pass border-left-end "> 
										<i class="fa fa-eye-slash"></i>
										<i class="fa fa-eye"></i>
									</span>
									<div class="invalid-feedback">
										Please Enter a Current password.
									</div>
								</div>
							</div>
							<div class="mb-3">
								<label class="text-label form-label" for="new_password">Password *</label>
								<div class="input-group transparent-append">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Choose a safe one.." required="">
									<input type="hidden" id="encrypted_new_password" name="_new_password">
									<span class="input-group-text show-pass border-left-end "> 
										<i class="fa fa-eye-slash"></i>
										<i class="fa fa-eye"></i>
									</span>
									<div class="invalid-feedback">
										Please Enter a username.
									</div>
								</div>
							</div>
							<div class="mb-3">
								<label class="text-label form-label" for="new_password_confirmation">Confirm Password *</label>
								<div class="input-group transparent-append">
									<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
									<input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Choose a safe one.." required="">
									<input type="hidden" id="encrypted_new_password_confirmation" name="_new_password_confirmation">
									<span class="input-group-text show-pass border-left-end "> 
										<i class="fa fa-eye-slash"></i>
										<i class="fa fa-eye"></i>
									</span>
									<div class="invalid-feedback">
										Please Enter a username.
									</div>
								</div>
							</div>
							
							<button type="submit" class="btn me-2 btn-primary bcbr-color-fiftyfive">Submit</button>
							<button type="submit" class="btn btn-danger light bcbr-color-fiftyfive">Cancel</button>
						</form>
					</div>	
				</div>
			</div>
		</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jsencrypt.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    let PUBLIC_KEY = '';
    const form = document.getElementById('passwordForm');
    const currentPasswordInput = document.getElementById('current_password');
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');

    const encryptedCurrentInput = document.getElementById('encrypted_current_password');
    const encryptedNewInput = document.getElementById('encrypted_new_password');
    const encryptedConfirmInput = document.getElementById('encrypted_new_password_confirmation');

    const messageDiv = document.createElement('div');
    messageDiv.style.marginTop = '10px';
    form.appendChild(messageDiv);

    // Disable form submit until public key is loaded
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;

    fetch('{{ url('publickey') }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch public key');
            return response.text();
        })
        .then(key => {
            PUBLIC_KEY = key.trim();
            if (!PUBLIC_KEY.startsWith('-----BEGIN PUBLIC KEY-----')) throw new Error('Invalid public key format');
            submitBtn.disabled = false;
        })
        .catch(err => {
            console.error('Error loading public key:', err);
            alert('Encryption setup failed. Please reload the page.');
        });

    form.addEventListener('submit', function (e) {
        messageDiv.textContent = '';
        messageDiv.style.color = 'red';

        const currentPassword = currentPasswordInput.value.trim();
        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();
		// Empty field checks
        if (!currentPassword || !newPassword || !confirmPassword) {
            e.preventDefault();
            messageDiv.textContent = 'All password fields are required.';
            return;
        }
        // Validation 1: New password != current password
        if (currentPassword === newPassword) {
            e.preventDefault();
            messageDiv.textContent = 'New password cannot be the same as current password.';
            return;
        }

        // Validation 2: New password === Confirm password
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            messageDiv.textContent = 'New password and confirm password do not match.';
            return;
        }

        // Validation passed — Encrypt passwords
        try {
            if (!PUBLIC_KEY) {
                e.preventDefault();
                alert('Encryption key not loaded yet. Please wait.');
                return;
            }

            const encrypt = new JSEncrypt();
            encrypt.setPublicKey(PUBLIC_KEY);

            const encryptedCurrent = encrypt.encrypt(currentPassword);
            const encryptedNew = encrypt.encrypt(newPassword);
            const encryptedConfirm = encrypt.encrypt(confirmPassword);

            if (!encryptedCurrent || !encryptedNew || !encryptedConfirm) {
                e.preventDefault();
                alert('Encryption failed.');
                return;
            }

            // Set encrypted values & disable plaintext inputs
            encryptedCurrentInput.value = encryptedCurrent;
            encryptedNewInput.value = encryptedNew;
            encryptedConfirmInput.value = encryptedConfirm;

            currentPasswordInput.disabled = true;
            newPasswordInput.disabled = true;
            confirmPasswordInput.disabled = true;

            messageDiv.style.color = 'green';
            messageDiv.textContent = 'Validation passed. Submitting...';

        } catch (err) {
            console.error('Encryption error:', err);
            e.preventDefault();
            alert('An error occurred while encrypting the passwords.');
        }
    });
});
</script>		
<!-- <script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('passwordForm');
    const messageDiv = document.createElement('div');
    messageDiv.style.color = 'red';
    messageDiv.style.marginTop = '10px';
    form.appendChild(messageDiv); // Append message container to the form

    form.addEventListener('submit', function (e) {
        const currentPassword = document.getElementById('current_password').value.trim();
        const newPassword = document.getElementById('new_password').value.trim();
        const confirmPassword = document.getElementById('new_password_confirmation').value.trim();

        messageDiv.textContent = ''; // Clear previous messages
        messageDiv.style.color = 'red';

        // Validation 1: New password should not be same as current
        if (currentPassword === newPassword) {
            e.preventDefault();
            messageDiv.textContent = 'New password cannot be the same as current password.';
            return;
        }

        // Validation 2: Confirm password must match new password
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            messageDiv.textContent = 'New password and confirm password do not match.';
            return;
        }

        // All validations passed — allow form to submit
        // Optionally show a green message
        messageDiv.style.color = 'green';
        messageDiv.textContent = 'Validation passed. Submitting...';
        // No e.preventDefault(), so the form will submit normally
    });
});
</script> -->
@endsection();
