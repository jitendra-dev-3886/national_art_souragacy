@extends('layouts.admin.ssa_master')
@section('content')
	<style nonce="{{ $cspNonce }}">
        .csp-admin-hr-border{
            min-width: 845px;
        }
    </style>
<div class="container-fluid">
	@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

	<div class="row">		
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-danger">
				<div class="card-body  p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							{{-- <h5 class="text-white text-left" >ART Clinic</h5><br> --}}
							<h3 class="text-white">{{ $totalartSubmittedData }}</h3><br>
							<p class="mb-1">ART Clinic</p>
							  <p id="countdown"></p>
							<p class="mb-1">Total Application RECEIVED</p>
							{{-- <span>Renewal Application Due: {{ $totalrenewaldueclinicData }}</span> --}}
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="{{ route('admin.ssaForm_list') }}" class="small-box-footer text-decoration-none text-white">More info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-success">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white">{{ $totalbankSubmittedData }}</h3><br>
							<p class="mb-1">ART Bank</p>
							<p class="mb-1">Total Application RECEIVED</p>
							{{-- <span>Renewal Application Due: {{ $totalrenewalduebankData }}</span> --}}
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="{{ route('admin.bank_ssaForm_list') }}" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-info">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white">{{ $totalsurrogacySubmittedData }}</h3><br>
							<p class="mb-1">Surrogacy Clinic</p>
							<p class="mb-1">Total Application RECEIVED</p>
							{{-- <span>Renewal Application Due: {{ $totalrenewalduesurrogacyData }}</span> --}}
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="{{ route('admin.surrogacy_ssaForm_list') }}" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div>



		

		{{-- renewal section --}}
		
		 <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-light">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
						<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
						<h3 class="text-white">{{ $totalrenewalclinicData->total_submitted }}</h3>
						<br>
						<p class="mb-1">Total Application RECEIVED</p>
						<p class="mb-1">ART Clinic Renewal</p>
						<p class="mb-0 fw-bold">
							<span class="text-danger">Pending: {{ $totalrenewalclinicData->total_pending }}</span> |
							<span class="text-info">Received: {{ $totalrenewalclinicData->total_received }}</span> |
							<span class="text-primary">Approved: {{ $totalrenewalclinicData->total_approved }}</span> |
							<span class="text-danger">Rejected: {{ $totalrenewalclinicData->total_rejected }}</span>
						</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="{{ route('renewal.clinic_ssarenewal_list', ['clinicType' => 'artclinic']) }}" 
						class="small-box-footer text-decoration-none text-white">
						More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-warning">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
						<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
						<h3 class="text-white">{{ $totalrenewalbankData->total_submitted }}</h3>
						<br>
						<p class="mb-1">Total Application RECEIVED</p>
						<p class="mb-1">ART Bank Renewal</p>
						<p class="mb-0 fw-bold">
							<span class="text-danger">Pending: {{ $totalrenewalbankData->total_pending }}</span> |
							<span class="text-info">Received: {{ $totalrenewalbankData->total_received }}</span> |
							<span class="text-primary">Approved: {{ $totalrenewalbankData->total_approved }}</span> |
							<span class="text-danger">Rejected: {{ $totalrenewalbankData->total_rejected }}</span>
						</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="{{ route('renewal.clinic_ssarenewal_list', ['clinicType' => 'artbank']) }}" 
						class="small-box-footer text-decoration-none text-white">
						More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</p>
				</div>
			</div>
		</div>

		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-dark">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
						<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
						<h3 class="text-white">{{ $totalrenewalsurrogacyData->total_submitted }}</h3>
						<br>
						<p class="mb-1">Total Application RECEIVED</p>
						<p class="mb-1">Surrogacy Renewal</p>
						<p class="mb-0 fw-bold">
							<span class="text-danger">Pending: {{ $totalrenewalsurrogacyData->total_pending }}</span> |
							<span class="text-info">Received: {{ $totalrenewalsurrogacyData->total_received }}</span> |
							<span class="text-primary">Approved: {{ $totalrenewalsurrogacyData->total_approved }}</span> |
							<span class="text-danger">Rejected: {{ $totalrenewalsurrogacyData->total_rejected }}</span>
						</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="{{ route('renewal.clinic_ssarenewal_list', ['clinicType' => 'artsurrogacy']) }}" 
						class="small-box-footer text-decoration-none text-white">
						More info <i class="fa fa-arrow-circle-right"></i>
						</a>
					</p>
				</div>
			</div>
		</div>


		<!-- Changes Addrees -->
		@php
			$cards = [
			    'ARTCLINIC' => [
			        'title' => 'ART Clinic Change Address',
			        'color' => 'bg-light',
			        'route' => 'artclinic'
			    ],
			    'ARTBANK' => [
			        'title' => 'ART Bank Change Address',
			        'color' => 'bg-warning',
			        'route' => 'artbank'
			    ],
			    'ARTSURROGACY' => [
			        'title' => 'Surrogacy Change Address',
			        'color' => 'bg-dark',
			        'route' => 'artsurrogacy'
			    ],
			];
			@endphp

			@foreach($cards as $type => $item)
			@php
			$data = $changeAddressData[$type] ?? (object)[
			    'total_submitted' => 0,
			    'total_received' => 0,
			    'total_approved' => 0,
			    'total_rejected' => 0,
			    'total_pending' => 0,
			];
		@endphp
		<div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
		    <div class="widget-stat card {{ $item['color'] }}">
		        <div class="card-body p-4">
		            <div class="media">
		                <span class="me-3">
		                    <i class="flaticon-381-calendar-1"></i>
		                </span>
		                <div class="media-body text-white text-end">
		                    <h3 class="text-white">{{ $data->total_submitted }}</h3>
		                    <br>
		                    <p class="mb-1">Total Applications Submitted</p>
		                    <p class="mb-1">{{ $item['title'] }}</p>
		                    <p class="mb-0 fw-bold">
		                        <span class="text-danger">Pending: {{ $data->total_pending }}</span> |
		                        <span class="text-info">Received: {{ $data->total_received }}</span> |
		                        <span class="text-primary">Approved: {{ $data->total_approved }}</span> |
		                        <span class="text-danger">Rejected: {{ $data->total_rejected }}</span>
		                    </p>
		                </div>
		            </div>
		        </div>

		        <hr class="csp-admin-hr-border">

		        <div>
		            <p class="text-dark text-center py-1">
		                <a href="{{ route('change_address.clinic_list', ['clinicType' => $item['route']]) }}" 
		                   class="small-box-footer text-decoration-none text-white">
		                   More info <i class="fa fa-arrow-circle-right"></i>
		                </a>
		            </p>
		        </div>
		    </div>
		</div>
		@endforeach
		<!-- Changes Addrees @end(06-05-2026)-->

		<!-- <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-warning">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white">10</h3><br>
							<p class="mb-1">In Process</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="#" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div> -->
		{{-- <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
			<div class="widget-stat card bg-secondary">
				<div class="card-body p-4">
					<div class="media">
						<span class="me-3">
							<i class="flaticon-381-calendar-1"></i>
						
						</span>
						<div class="media-body text-white text-end">
							<h3 class="text-white">10</h3><br>
							<p class="mb-1">NOC Issued</p>
						</div>
					</div>
				</div>
				<hr class="csp-admin-hr-border">
				<div>
					<p class="text-dark text-center py-1">
						<a href="#" class="small-box-footer text-decoration-none text-white">More
							info <i class="fa fa-arrow-circle-right"></i></a>
					</p>
				</div>
			</div>
		</div> --}}
		
		
		
	</div>

</div>

<script nonce="{{ $cspNonce }}">
    let timeout;
		const inactivityLimit = 1 * 3000 * 1000; 
		function resetTimer() {
			clearTimeout(timeout);
			timeout = setTimeout(() => {
				alert("You have been inactive for 2 minutes. You will be logged out.");
				if({{session('user_type')}}==5){
						document.getElementById('logout-form').submit();
				}
				
			}, inactivityLimit);
		}
		
		window.onload = resetTimer;
		document.onmousemove = resetTimer;
		document.onkeypress = resetTimer;
		document.onscroll = resetTimer;
		
</script>

@endsection();