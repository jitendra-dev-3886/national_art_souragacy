	@extends('layouts.noc.noc_master')
@section('content')		
<style nonce="{{ $cspNonce }}">
	.alert-success {
		width: 50%;
		position: absolute;
		z-index: 11;
		height: auto;
		box-shadow: 2px 3px 10px 0px rgba(0, 0, 0, 0.353);
	}

	.background-border-color-cspnoc-one{
		background-color: #0b5ed7; border-color: #0b5ed7; color: white;
	}
	
	.bc-color-csp-noc-one{
		background-color:#1460c4;
	}

</style>
<div class="container-fluid">
	@if(session()->has('update_message'))<div class="alert alert-success alert-dismissible text-white border-0 fade show bc-color-csp-noc-one" role="alert">
		<button type="button" class="btn-close btn-close-red" data-bs-dismiss="alert" aria-label="Close"></button>
		<p class="font-30 py-2" ><strong>{{ session('update_message') }}</strong> </p>
	</div>@endif
	<div class="d-flex align-items-center mb-4">
		<h3 class="me-auto">User Profile</h3>
		
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header border-0 flex-wrap align-items-start">
					<div class="col-md-8">
						<div class="user d-sm-flex d-block pe-md-5 pe-0">
							<img src="{{url('public/images/profile/profile_image.png')}}" alt="">
							<div class="ms-sm-3 ms-0 me-md-5 md-0">
								<h5 class="mb-1 font-w600 "><a href="javascript:void(0);" class="text-black">{{ $user->user_name }}</a></h5>
								<div class="listline-wrapper mb-2">
									<span class="item"><i class="text-primary far fa-envelope"></i>{{ $user->email }}</span>
									
								</div>
								
							</div>
						</div>
					</div>
					
				</div>
				<div class="card-body pt-0">
					
					<div class="row">
						<div class="col-xl-6 col-md-6">
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Applicant Name : </span><span class="font-w400"> {{ $profile && $profile->name_applicant ? $profile->name_applicant : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Gender : </span><span class="font-w400"> {{ $profile && $profile->gender ? $profile->gender : 'N/A' }}</span></p>

							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Nationality : </span><span class="font-w400"> {{ $profile && $profile->nationality_type ? $profile->nationality_type : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Address : </span><span class="font-w400">{{ $profile && $profile->address ? $profile->address : 'N/A' }}</span></p>

							@if($profile->nationality_type == 'Indian')
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">State : </span><span class="font-w400">{{ $profile && $profile->state ? $profile->state : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">District : </span><span class="font-w400">{{ $profile && $profile->district ? $profile->district : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Pincode : </span><span class="font-w400">{{ $profile && $profile->pincode ? $profile->pincode : 'N/A' }}</span></p>

							@else 
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Country : </span><span class="font-w400">{{ $profile && $profile->country ? $profile->country : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">zipcode : </span><span class="font-w400">{{ $profile && $profile->zipcode ? $profile->zipcode : 'N/A' }}</span></p>
	                        @endif
							</div>
						
					</div>
				</div>
				<div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
					<div class="mb-md-2 mb-3 exp-del">
					</div>
					<div>
						<a href="{{ route('noc.profile.update') }}" class="btn btn-primary btn-sm me-2" class="background-border-color-cspnoc-one"><i class="fas fa-edit me-2"></i>Update Profile</a>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection();