@extends('layouts.noc.noc_master')
@section('content')
{{--<div class="container-fluid">
				 <div class="row">
					<div class="col-xl-4 col-md-6">
						<div class="card-tiles rounded" style="background-color:#00c0ef !important">
							<div class="card-block p-2">
								<div class="row align-items-center py-2">
									<div class="col-8">
										<h3 class="text-white"><strong>{{ $totalSubmittedData }}</strong></h3>
										<h2 class="text-white">NOC Form</h2>
										<p class="text-white"><b>Status: Submitted Application</b></p>
									</div>
									<div class="col-md-2 text-right">
										<i class="fa fa-hospital-o opacity-25" style="font-size:100px; margin: -15px;"></i>
									</div>
								</div>
							</div>
							<div style="background-color:#00A3CB;">
								<p class="text-dark text-center py-1">
									<a href="{{ route('noc.nocForm_list') }}" class="small-box-footer text-decoration-none text-white">More
										info <i class="fa fa-arrow-circle-right"></i></a>
								</p>
							</div>
						</div>
					</div> 
					
					
				</div>	
				
            </div>--}}
			<div class="container-fluid">
				<div class="row">
										
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-danger">
							<div class="card-body  p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-calendar-1"></i>
									</span>
									<div class="media-body text-white text-end">
										
										<h3 class="text-white">{{ $totalSubmittedData }}</h3><br>
										<p class="mb-1">Submitted Application</p>
									</div>
								</div>
							</div>
							<hr style="border-top: 1px solid #ffffff; ">
							<div>
								<p class="text-dark text-center py-1">
									<a href="{{ route('noc.nocForm_list') }}" class="small-box-footer text-decoration-none text-white">More
										info <i class="fa fa-arrow-circle-right"></i></a>
								</p>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-success">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-calendar-1"></i>
									</span>
									<div class="media-body text-white text-end">
										<h3 class="text-white">{{ $totalSubmittedData }}</h3><br>
										<p class="mb-1">Query raised</p>
									</div>
								</div>
							</div>
							<hr style="border-top: 1px solid #ffffff; ">
							<div>
								<p class="text-dark text-center py-1">
									<a href="{{ route('noc.nocForm_list') }}" class="small-box-footer text-decoration-none text-white">More
										info <i class="fa fa-arrow-circle-right"></i></a>
								</p>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-info">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-calendar-1"></i>
									</span>
									<div class="media-body text-white text-end">
										<h3 class="text-white">{{ $totalSubmittedData }}</h3><br>
										<p class="mb-1">Query Responded</p>
									</div>
								</div>
							</div>
							<hr style="border-top: 1px solid #ffffff; ">
							<div>
								<p class="text-dark text-center py-1">
									<a href="{{ route('noc.nocForm_list') }}" class="small-box-footer text-decoration-none text-white">More
										info <i class="fa fa-arrow-circle-right"></i></a>
								</p>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-warning">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-calendar-1"></i>
									</span>
									<div class="media-body text-white text-end">
										<h3 class="text-white">{{ $totalSubmittedData }}</h3><br>
										<p class="mb-1">In Process</p>
									</div>
								</div>
							</div>
							<hr style="border-top: 1px solid #ffffff; ">
							<div>
								<p class="text-dark text-center py-1">
									<a href="{{ route('noc.nocForm_list') }}" class="small-box-footer text-decoration-none text-white">More
										info <i class="fa fa-arrow-circle-right"></i></a>
								</p>
							</div>
						</div>
                    </div>
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card bg-secondary">
							<div class="card-body p-4">
								<div class="media">
									<span class="me-3">
										<i class="flaticon-381-calendar-1"></i>
										{{-- <i class="flaticon-381-user-7"></i> --}}
									</span>
									<div class="media-body text-white text-end">
										<h3 class="text-white">{{ $totalSubmittedData }}</h3><br>
										<p class="mb-1">NOC Issued</p>
									</div>
								</div>
							</div>
							<hr style="border-top: 1px solid #ffffff; ">
							<div>
								<p class="text-dark text-center py-1">
									<a href="{{ route('noc.nocForm_list') }}" class="small-box-footer text-decoration-none text-white">More
										info <i class="fa fa-arrow-circle-right"></i></a>
								</p>
							</div>
						</div>
                    </div>
					
					
					
                </div>
			
            </div>
@endsection();