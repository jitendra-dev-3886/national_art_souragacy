@extends('layouts.noc.noc_master')
@section('content')		
<style nonce="{{$cspNonce}}">
	.alert-success {
		width: 50%;
		position: absolute;
		z-index: 11;
		
		height: auto;
		box-shadow: 2px 3px 10px 0px rgba(0, 0, 0, 0.353);
	}


    .csp-clinic-alert {
        background-color: #1460c4;
    }

    .csp-clinic-btn-submit {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }
</style>



			<div class="container">
				@if (session()->has('success'))
					
						<div class="alert alert-success alert-dismissible text-white border-0 fade show csp-clinic-alert" role="alert">
						<button type="button" class="btn-close btn-close-red" data-bs-dismiss="alert" aria-label="Close"></button>
						<p class="font-30 py-2" ><strong>{{ session('success') }}</strong> </p>
					</div>
					@endif
				<div class="card">
					
				<div class="card-header">
					<h3>Update Your Profile</h3>
				</div>				
				<div class="card-body">
					<div class="basic-form">
						<form class="form-valide-with-icon needs-validation" novalidate="" action="{{ route('noc.profile.update.submit') }}" method="POST">
							@csrf
						
							<div class="mb-3">
								<label class="text-label form-label" for="validationCustomUsername"><strong>Name of the Applicant</strong></label>
								<div class="input-group">
									<span class="input-group-text"> <i class="fa fa-user"></i> </span>
									<input type="text" name="name_applicant" value="{{ old('name_applicant', $applicantProfile->name_applicant ?? '') }}" class="form-control" required>
								</div>
								@error('name_applicant') <!-- Display error for name_applicant -->
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						
							<div class="mb-3">
								<label class="text-label form-label" for="validationCustomUsername"><strong>Address</strong></label>
								<div class="input-group">
									<span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
									<input type="text" name="address" id="address" class="form-control" value="{{ old('address', $applicantProfile->address ?? '') }}">
								</div>
								@error('address') <!-- Display error for address -->
								<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						
							<div class="row">
								<div class="col-md-4">
									<div class="mb-3">
										<label class="text-label form-label" for="validationCustomUsername"><strong>Pincode</strong></label>
										<div class="input-group">
											<span class="input-group-text"> <i class="fa fa-marker"></i> </span>
											<input type="text" pattern="^[0-9]{6}$" name="pincode" value="{{ old('pincode', $applicantProfile->pincode ?? '') }}" placeholder="Pincode should be six numbers" maxlength="6" id="pincode" class="form-control">
											<span id="pincodeavailability"></span>
										</div>
										@error('pincode') <!-- Display error for pincode -->
										<div class="text-danger">{{ $message }}</div>
										@enderror
									</div>
								</div>
						
								<div class="col-md-4">
									<div class="mb-3">
										<label class="text-label form-label" for="validationCustomUsername"><strong>State</strong></label>
										<div class="input-group">
											<span class="input-group-text"> <i class="fa fa-map"></i> </span>
											<input type="text" name="state" id="state" placeholder="State" value="{{ old('state', $applicantProfile->state ?? '') }}" class="form-control">

										</div>
										@error('state') <!-- Display error for state -->
										<div class="text-danger">{{ $message }}</div>
										@enderror
									</div>
								</div>
						
								<div class="col-md-4">
									<div class="mb-3">
										<label class="text-label form-label" for="validationCustomUsername"><strong>District</strong></label>
										<div class="input-group">
											<span class="input-group-text"> <i class="fa fa-map"></i> </span>
											<input type="text" name="district" id="district" value="{{ old('district', $applicantProfile->district ?? '') }}" placeholder="District" class="form-control" >
										</div>
										@error('district') <!-- Display error for district -->
										<div class="text-danger">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>						
							<button type="submit" class="btn me-2 csp-clinic-btn-submit">Submit</button>
														
						</form>
						
					</div>	
				</div>
			</div>
		</div>
		<script nonce="{{ $cspNonce }}">
			$('#pincode').blur(function() {
				var pincode = $(this).val();
				if (pincode === "") {
					$('#state').val('');
					$('#district').val('');
					$('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
				} else {
					$.ajax({
						url: "{{ route('pincode.check') }}", // Laravel route
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
						}
					});
				}
			});
		</script>
@endsection();