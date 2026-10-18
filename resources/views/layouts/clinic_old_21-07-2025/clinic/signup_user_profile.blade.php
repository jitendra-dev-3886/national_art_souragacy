
@extends('layouts.clinic.clinic_master')
@section('content')		
<style nonce="{{$cspNonce}}">
	.alert-success {
		width: 50%;
		position: absolute;
		z-index: 11;
		
		height: auto;
		box-shadow: 2px 3px 10px 0px rgba(0, 0, 0, 0.353);
	}


.csp-clinic-update-alert {
    background-color: #1460c4;
   
}
</style>


<div class="container-fluid">
	@if(session()->has('update_message')) <div class="alert alert-success alert-dismissible text-white border-0 fade show csp-clinic-update-alert" role="alert">>
		<button type="button" class="btn-close btn-close-red" data-bs-dismiss="alert" aria-label="Close"></button>
		<p class="font-30 py-2" ><strong>{{ session('update_message') }}</strong> </p>
	</div>@endif




	
	<div class="d-flex align-items-center mb-4">
		<h3 class="me-auto">User Profile</h3>
		{{-- <div>
			<a href="javascript:void(0);" class="btn btn-secondary btn-sm me-3"> <i class="fas fa-envelope"></i></a>
			<a href="javascript:void(0);" class="btn btn-secondary btn-sm me-3"><i class="fas fa-phone-alt"></i></a>
			<a href="javascript:void(0);" class="btn btn-primary btn-sm"><i class="fas fa-info"></i></a>
		
		</div> --}}
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header border-0 flex-wrap align-items-start">
					<div class="col-md-8">
						<div class="user d-sm-flex d-block pe-md-5 pe-0">
							<img src="{{url('public/images/profile/profile_image.png')}}" alt="">
							<div class="ms-sm-3 ms-0 me-md-5 md-0">
								<h5 class="mb-1 font-w600 "><a href="javascript:void(0);" class="text-black">{{ $user->clinicname }}</a></h5>
								<div class="listline-wrapper mb-2">
									<span class="item"><i class="text-primary far fa-envelope"></i>{{ $user->email }}</span>
									<span class="item"><i class="text-primary far fa-mobile-alt"></i>{{ $user->mobile }}</span>
									{{-- <span class="item"><i class="text-primary fas fa-map-marker-alt"></i>Indonesia</span> --}}
								</div>
								{{-- <p>A data analyst collects, interprets and visualizes data to uncover insights. A data analyst assigns a numerical value to business functions so performance.</p> --}}
							</div>
						</div>
					</div>
					{{-- <div class="col-md-4 col-12 text-end">	
						<a href="javascript:void(0);" class="btn btn-sm btn-primary me-2">Ask</a>
						<a href="javascript:void(0);" class="btn btn-sm btn-info">Hire</a>
						<div class="mt-3">
							<h6 class="text-start">Progress
								<span class="float-end">85%</span>
							</h6>
							<div class="progress ">
								<div class="progress-bar bg-danger progress-animated" style="width: 85%; height:6px;" role="progressbar">
									<span class="sr-only">60% Complete</span>
								</div>
							</div>
						</div>
					</div> --}}
				</div>
				<div class="card-body pt-0">
					{{-- <h4 class="fs-20">Description</h4> --}}
					<div class="row">
						<div class="col-xl-6 col-md-6">
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Clinic Name : </span><span class="font-w400"> {{ $user->clinicname ? $user->clinicname : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Address : </span><span class="font-w400">{{ $user->address ? $user->address : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">State : </span><span class="font-w400">{{ $user->state ? $user->state : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">District : </span><span class="font-w400">{{ $user->district ? $user->district : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Pincode : </span><span class="font-w400">{{ $user->pincode ? $user->pincode : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Mobile Number : </span><span class="font-w400">{{ $user->mobile ? $user->mobile : 'N/A' }}</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Name of the Contact Person : </span><span class="font-w400">{{ $user->personname ? $user->personname : 'N/A' }}</span></p>
							
							{{-- <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Pincode : </span><span class="font-w400">{{ $user->pincode ? $user->pincode : 'N/A' }}</span></p> --}}
							{{-- <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Experience : </span><span class="font-w400">3 Yrs</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Location :</span> <span class="font-w400">USA</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Preferred Location : </span><span class="font-w400">USA</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Qualification: </span><span class="font-w400">B.Tech(CSE)</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Key Skills: </span><span class="font-w400">Good Communication, Planning and research skills</span></p>
						 --}}</div>
						{{-- <div class="col-xl-6 col-md-6">
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Launguages :</span> <span class="font-w400">English, German, Spanish</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Email :</span> <span class="font-w400">andrew@gmail.com</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Phone : </span><span class="font-w400">1234598765</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Industry :</span> <span class="font-w400">it Software/ Developer</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Date Of Birth : </span><span class="font-w400">13 June 1996</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Gender : </span><span class="font-w400">Female</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Marital Status : </span><span class="font-w400">Unmarried</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Permanent Address :</span> <span class="font-w400">USA</span></p>
							<p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Zip code: </span><span class="font-w400">12345</span></p>
						</div> --}}
					</div>
				</div>
				<div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
					<div class="mb-md-2 mb-3 exp-del">
						{{-- <span class="d-block mb-1"><i class="fas fa-circle me-2"></i>Currently Working at  <strong>Abcd Pvt Ltd</strong></span>
						<span><i class="fas fa-circle me-2"></i>3 Yrs Of Working Experience in   <strong>Abcd Pvt Ltd</strong></span> --}}
					</div>
					<div>
						{{-- <a href="{{ route('noc.profile.update') }}" class="btn btn-primary btn-sm me-2" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;"><i class="fas fa-edit me-2"></i>Update Profile</a> --}}
						{{-- <a href="javascript:void(0);" class="btn btn-warning btn-sm me-2"><i class="fas fa-share-alt me-2"></i>Share Profile</a>
						<a href="javascript:void(0);" class="btn btn-info btn-sm me-2"><i class="fas fa-phone-alt me-2"></i>Contact</a> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection();