<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignLab">
	<meta name="robots" content="" >
	<meta name="keywords" content="admin dashboard, admin template, analytics, bootstrap, bootstrap 5, bootstrap 5 admin template, job board admin, job portal admin, modern, responsive admin dashboard, sales dashboard, sass, ui kit, web app, frontend">
	<meta name="description" content="We proudly present Jobick, a Job Admin dashboard HTML Template, If you are hiring a job expert you would like to build a superb website for your Jobick, it's a best choice.">
	<meta property="og:title" content="Jobick : Job Admin Dashboard Bootstrap 5 Template + FrontEnd">
	<meta property="og:description" content="We proudly present Jobick, a Job Admin dashboard HTML Template, If you are hiring a job expert you would like to build a superb website for your Jobick, it's a best choice." >
	<meta property="og:image" content="https://jobick.dexignlab.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	
	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Page Title -->
	<title>National ART & Surrogacy Registry</title>
	
	<!-- Favicon icon -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">
	
	<!-- All StyleSheet -->
	<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jquery-3.6.0.min.js')); ?>"></script>
	<link href="<?php echo e(url('public/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(url('public/vendor/owl-carousel/owl.carousel.css')); ?>" rel="stylesheet">
	
	<link href="<?php echo e(url('public/vendor/datatables/css/jquery.dataTables.min.css')); ?>" rel="stylesheet">
    

<link rel="stylesheet" href="<?php echo e(url('public/vendor/datatables/css/buttons.dataTables.min.css')); ?>">

	
	<!-- Globle CSS -->
    <link href="<?php echo e(url('public/css/style.css')); ?>" rel="stylesheet">

	<!-- Select CSS -->
    <link href="<?php echo e(url('public/css/select2.min.css')); ?>" rel="stylesheet">
	
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
				<svg class="logo-abbr" xmlns="http://www.w3.org/2000/svg" width="62.074" height="65.771" viewBox="0 0 62.074 65.771">
				  <g id="search_11_" data-name="search (11)" transform="translate(12.731 12.199)">
					<rect class="rect-primary-rect" id="Rectangle_1" data-name="Rectangle 1" width="60" height="60" rx="30" transform="translate(-10.657 -12.199)" fill="#f73a0b"/>
					<path id="Path_2001" data-name="Path 2001" d="M32.7,5.18a17.687,17.687,0,0,0-25.8,24.176l-19.8,21.76a1.145,1.145,0,0,0,0,1.62,1.142,1.142,0,0,0,.81.336,1.142,1.142,0,0,0,.81-.336l19.8-21.76a17.687,17.687,0,0,0,29.357-13.29A17.57,17.57,0,0,0,32.7,5.18Zm-1.62,23.392A15.395,15.395,0,0,1,9.312,6.8,15.395,15.395,0,1,1,31.083,28.572Zm0,0" transform="translate(1 0)" fill="#fff" stroke="#fff" stroke-width="1"/>
					<path id="Path_2002" data-name="Path 2002" d="M192.859,115.547a4.523,4.523,0,0,0,.7-2.415v-2.284a4.55,4.55,0,0,0-9.1,0v2.284a4.523,4.523,0,0,0,.7,2.415,4.954,4.954,0,0,0-3.708,4.788v1.623a2.4,2.4,0,0,0,2.4,2.4h10.323a2.4,2.4,0,0,0,2.4-2.4v-1.623a4.954,4.954,0,0,0-3.708-4.788Zm-6.114-4.7a2.259,2.259,0,0,1,4.518,0v2.284a2.259,2.259,0,1,1-4.518,0Zm7.53,11.111a.11.11,0,0,1-.11.11H183.843a.11.11,0,0,1-.11-.11v-1.623a2.656,2.656,0,0,1,2.653-2.653h5.237a2.656,2.656,0,0,1,2.653,2.653Zm0,0" transform="translate(-168.591 -98.178)" fill="#fff" stroke="#fff" stroke-width="1"/>
				  </g>
				</svg>



				<svg class="brand-title" xmlns="http://www.w3.org/2000/svg" width="134.01" height="48.365" viewBox="0 0 134.01 48.365">
				  <g id="Group_38" data-name="Group 38" transform="translate(-133.99 -40.635)">
					<text id="Job_Admin_Dashboard" data-name="Job Admin Dashboard" transform="translate(134 85)" fill="#787878" font-size="12" font-family="Poppins-Light, Poppins" font-weight="300"><tspan x="0" y="0">Job Admin Dashboard</tspan></text>
					<path id="Path_1948" data-name="Path 1948" d="M.36,6.616a1.661,1.661,0,0,0,1.094-.422,1.287,1.287,0,0,0,.5-1.016V-11.738H7.52L7.551,5.271A8.16,8.16,0,0,1,6.91,8.789a4.074,4.074,0,0,1-2.2,1.985,11.542,11.542,0,0,1-4.346.657ZM17.651,9.68A7.316,7.316,0,0,1,13.7,8.617a7.008,7.008,0,0,1-2.626-2.97,9.786,9.786,0,0,1-.922-4.315,9.276,9.276,0,0,1,.907-4.174,6.935,6.935,0,0,1,2.6-2.877,7.438,7.438,0,0,1,4-1.047,7.607,7.607,0,0,1,4.018,1.032,6.8,6.8,0,0,1,2.611,2.861,9.349,9.349,0,0,1,.907,4.205,9.759,9.759,0,0,1-.922,4.33,6.993,6.993,0,0,1-2.642,2.955A7.4,7.4,0,0,1,17.651,9.68Zm0-4.565a1.753,1.753,0,0,0,1.438-.954,5.2,5.2,0,0,0,.625-2.83,4.8,4.8,0,0,0-.594-2.626,1.73,1.73,0,0,0-1.47-.907,1.694,1.694,0,0,0-1.454.907,4.908,4.908,0,0,0-.578,2.626,5.309,5.309,0,0,0,.61,2.83A1.718,1.718,0,0,0,17.651,5.115Zm17.478,4.6q-2.345,0-5.972-.375L27.75,9.18V-12.238h5.44V-6.11q.25-.094.844-.3a6.64,6.64,0,0,1,1.079-.281,6.807,6.807,0,0,1,1.079-.078,5.75,5.75,0,0,1,4.737,1.939q1.579,1.939,1.579,6.285,0,4.377-1.767,6.316T35.129,9.711Zm-.594-4.878a2.3,2.3,0,0,0,1.876-.719A4.131,4.131,0,0,0,37,1.551Q37-1.92,34.754-1.92q-.719,0-1.563.063v6.6A10.43,10.43,0,0,0,34.535,4.834ZM45.134-6.36h5.44V9.274h-5.44Zm.031-6.222h5.44V-7.36h-5.44ZM59.611,9.68a5.9,5.9,0,0,1-4.909-2q-1.595-2-1.595-6.222a12.451,12.451,0,0,1,.844-5.143A4.635,4.635,0,0,1,56.3-6.125a9.87,9.87,0,0,1,3.846-.641,13.2,13.2,0,0,1,2.095.188q1.157.188,3.033.625L65.145-1.7q-2.908-.219-3.627-.219a4.459,4.459,0,0,0-1.845.3,1.565,1.565,0,0,0-.844.985,6.976,6.976,0,0,0-.219,2A7.45,7.45,0,0,0,58.845,3.5a1.625,1.625,0,0,0,.86,1.032,4.362,4.362,0,0,0,1.813.3l3.6-.219L65.27,8.9A27.641,27.641,0,0,1,59.611,9.68Zm8.473-21.918h5.44V-.325l1.032-.406L76.714-6.36H82.78L79.4,1.207,83,9.274H76.9L74.744,3.958l-1.219.406V9.274h-5.44Z" transform="translate(133.63 53.217)" fill="#464646"/>
				  </g>
				</svg>

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
		
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
        
		<?php echo $__env->make('layouts.admin.ssa_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
        <?php echo $__env->make('layouts.admin.ssa_siderbar_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<!-- <div class="container-fluid">
				<div class="row">
					<div class="col-xl-6">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="row separate-row">
											<div class="col-sm-6">
												<div class="job-icon pb-4 d-flex justify-content-between">
													<div>
														<div class="d-flex align-items-center mb-1">
															<h2 class="mb-0 lh-1">342</h2>
															<span class="text-success ms-3">+0.5 %</span>
														</div>	
														<span class="fs-14 d-block mb-2">Interview Schedules</span>
													</div>	
													<div id="NewCustomers"></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="job-icon pb-4 pt-4 pt-sm-0 d-flex justify-content-between">
													<div>
														<div class="d-flex align-items-center mb-1">
															<h2 class="mb-0 lh-1">984</h2>
														</div>	
														<span class="fs-14 d-block mb-2">Application Sent</span>
													</div>	
													<div id="NewCustomers1"></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="job-icon pt-4 pb-sm-0 pb-4 pe-3 d-flex justify-content-between">
													<div>
														<div class="d-flex align-items-center mb-1">
															<h2 class="mb-0 lh-1">1,567k</h2>
															<span class="text-danger ms-3">-2 % </span>
														</div>	
														<span class="fs-14 d-block mb-2">Profile Viewed</span>
													</div>	
													<div id="NewCustomers2"></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="job-icon pt-4  d-flex justify-content-between">
													<div>
														<div class="d-flex align-items-center mb-1">
															<h2 class="mb-0 lh-1">437</h2>
														</div>	
														<span class="fs-14 d-block mb-2">Unread Messages</span>
													</div>	
													<div id="NewCustomers3"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card "  id="user-activity">
									<div class="card-header border-0 pb-0 flex-wrap">
										<h4 class="fs-20 mb-0">Vacany Start</h4>
										<div class="card-action coin-tabs mt-3 mt-sm-0">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link " data-bs-toggle="tab" href="#Daily" role="tab">Daily</a>
												</li>
												<li class="nav-item">
													<a class="nav-link " data-bs-toggle="tab" href="#Daily" role="tab" >Weekly</a>
												</li>
												<li class="nav-item">
													<a class="nav-link active" data-bs-toggle="tab" href="#Daily" role="tab" >Monthly</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="card-body">
										<div class="pb-4 d-flex flex-wrap">
											<span class="d-flex align-items-center">
												<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
												  <rect  width="13" height="13" rx="6.5" fill="#35c556"/>
												</svg>
												Application Sent	
											</span>
											<span class="application d-flex align-items-center">
												<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
												  <rect  width="13" height="13" rx="6.5" fill="#3f4cfe"/>
												</svg>

												Interviews	
											</span>
											<span class="application d-flex align-items-center">
												<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
												  <rect  width="13" height="13" rx="6.5" fill="#f34040"/>
												</svg>

												Rejected
											</span>
										</div>
										<div class="tab-content">
											<div class="tab-pane fade show active" id="Daily">
												<canvas id="activity" height="115"></canvas>
											</div>	
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card" id="user-activity1">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-20 mb-0">Chart</h4>
										<div class="card-action coin-tabs  mt-0">
											<ul class="nav nav-tabs" role="tablist">
												<li class="nav-item">
													<a class="nav-link " data-bs-toggle="tab" href="#Daily1" role="tab">Daily</a>
												</li>
												<li class="nav-item">
													<a class="nav-link " data-bs-toggle="tab" href="#Daily1" role="tab" >Weekly</a>
												</li>
												<li class="nav-item">
													<a class="nav-link active" data-bs-toggle="tab" href="#Daily1" role="tab" >Monthly</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="card-body">
										<span class="me-sm-5 me-3 font-w500">
											<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
											  <rect  width="13" height="13" fill="#f73a0b"/>
											</svg>
											Delivered
										</span>
										<span class="fs-16 font-w600 me-5">239 <small class="text-success fs-12 font-w400">+0.4%</small></span>
										<span class="ms-sm-5 ms-3 font-w500">
											<svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13">
											  <rect  width="13" height="13" fill="#6e6e6e"/>
											</svg>
											Expense
										</span>
										<span class="fs-16 font-w600">239</span>
										<div class="tab-content mt-5" id="myTabContent">
											<div class="tab-pane fade show active" id="monthly1">
												<canvas id="activity1" class="chartjs"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-20 mb-1">Featured Companies</h4>
										<div class="dropdown">
											<a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown" aria-expanded="false">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#575757" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
											</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="javascript:void(0);">Delete</a>
												<a class="dropdown-item" href="javascript:void(0);">Edit</a>
											</div>
										</div>
									</div>
									<div class="card-body pt-3 loadmore-content dlab-scroll height370 " id="scroll-y">
										<div class="row " id="FeaturedCompaniesContent">
											<div class="col-xl-6 col-sm-6 mt-4 ">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#2769ee"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Kleon Team</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 mt-4 col-sm-6">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#7630d2"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Ziro Studios Inc.</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6  col-sm-6 mt-4">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#b848ef"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Qerza</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6 mt-4">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#7e1d74"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Kripton Studios</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6 mt-4">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#0411c2"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Omah Ku Inc.</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6 mt-4">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#378a82"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="fs-20 mb-1">Ventic</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6 mt-4">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#175baa"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Sakola</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6 mt-4">
												<div class="d-flex align-items-center">
													<span>
														<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
														  <g  transform="translate(-457 -443)">
															<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
															<g  transform="translate(457 443)">
															  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#eeb927"/>
															  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
															  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
															</g>
														  </g>
														</svg>
													</span>
													<div class="ms-3 featured">
														<h4 class="mb-1">Uena Foods</h4>
														<span>Desgin Team Agency</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer border-0 m-auto">
										<a href="javascript:void(0);" class="btn btn-outline-primary m-auto dlab-load-more" id="FeaturedCompanies" rel="ajax/featuredcompanies.html">View more</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="row ">
											<div class="col-xl-8 col-xxl-7 col-sm-7">
												<div class="update-profile d-flex">
													<img src="images/profile/pic1.jpg" alt="">
													<div class="ms-4">
														<h3 class="fs-24 font-w600 mb-0">Franklin Jr</h3>
														<span class="text-primary d-block mb-4">UI / UX Designer</span>
														<span><i class="fas fa-map-marker-alt me-1"></i>Medan, Sumatera Utara - ID</span>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-xxl-5 col-sm-5 sm-mt-auto mt-3 text-sm-end">
												<a href="javascript:void(0);" class="btn btn-primary">Update Profile</a>
											</div>
										</div>
										<div class="row mt-4 align-items-center">
											<h4 class="fs-20 mb-3">Skills</h4>
											<div class="col-xl-6 col-sm-6">
												<div class="progress default-progress">
													<div class="progress-bar bg-green progress-animated" style="width: 90%; height:13px;" role="progressbar">
														<span class="sr-only">90% Complete</span>
													</div>
												</div>
												<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
													<span class="fs-14 font-w500">Figma</span>
													<span class="fs-16"><span class="text-black pe-2"></span>90%</span>
												</div>
												<div class="progress default-progress">
													<div class="progress-bar bg-info progress-animated" style="width: 68%; height:13px;" role="progressbar">
														<span class="sr-only">45% Complete</span>
													</div>
												</div>
												<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
													<span class="fs-14 font-w500">Adobe XD</span>
													<span class="fs-16"><span class="text-black pe-2"></span>68%</span>
												</div>
												<div class="progress default-progress">
													<div class="progress-bar bg-blue progress-animated" style="width: 85%; height:13px;" role="progressbar">
														<span class="sr-only">85% Complete</span>
													</div>
												</div>
												<div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
													<span class="fs-14 font-w500">Photoshop</span>
													<span class="fs-16"><span class="text-black pe-2"></span>85%</span>
												</div>
											</div>
											<div class="col-xl-6 col-sm-6">
												<div id="pieChart1"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header border-0 pb-0">
										<h4 class="fs-20 mb-0">Recent Activity</h4>
										<div>	
											<select class="default-select dashboard-select">
											  <option data-display="Newest">Newest</option>
												  <option value="1">latest</option>
											  
											  <option value="2">oldest</option>
											</select>
											<div class="dropdown custom-dropdown mb-0">
												<div class="btn sharp tp-btn dark-btn" data-bs-toggle="dropdown">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#342E59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#342E59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#342E59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
												</div>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="javascript:void(0);">Details</a>
													<a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
												</div>
											</div>
										</div>	
									</div>
									<div class="card-body loadmore-content dlab-scroll height370 recent-activity-wrapper" id="RecentActivityContent">
										<div class="d-flex recent-activity">
											<span class="me-3 activity">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
												  <circle  cx="8.5" cy="8.5" r="8.5" fill="#f93a0b"/>
												</svg>
											</span>
											<div class="d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
												  <g  transform="translate(-457 -443)">
													<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
													<g  transform="translate(457 443)">
													  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#2769ee"/>
													  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
													  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
													</g>
												  </g>
												</svg>
												<div class="ms-3">
													<h5 class="mb-1">Bubles Studios have 5 available positions for you</h5>
													<span>8min ago</span>
												</div>
											</div>
										</div>
										<div class="d-flex recent-activity">
											<span class="me-3 activity">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
												  <circle  cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9"/>
												</svg>
											</span>
											<div class="d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
													  <g  transform="translate(-457 -443)">
														<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
														<g  transform="translate(457 443)">
														  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#eeac27"/>
														  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
														  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
														</g>
													  </g>
												</svg>
												<div class="ms-3">
													<h5 class="mb-1">Elextra Studios has invited you to interview meeting tomorrow</h5>
													<span>8min ago</span>
												</div>
											</div>
										</div>
										<div class="d-flex recent-activity">
											<span class="me-3 activity">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
												  <circle  cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9"/>
												</svg>
											</span>
											<div class="d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
													  <g  transform="translate(-457 -443)">
														<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
														<g  transform="translate(457 443)">
														  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#22bc32"/>
														  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
														  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
														</g>
													  </g>
												</svg>
												<div class="ms-3">
													<h5 class="mb-1">Highspeed Design Team have 2 available positions for you</h5>
													<span>8min ago</span>
												</div>
											</div>
										</div>
										<div class="d-flex recent-activity">
											<span class="me-3">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
												  <circle  cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9"/>
												</svg>
											</span>
											<div class="d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
													  <g  transform="translate(-457 -443)">
														<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
														<g  transform="translate(457 443)">
														  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#9933cb"/>
														  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
														  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
														</g>
													  </g>
												</svg>
											<div class="ms-3">
												<h5 class="mb-1">Kleon Studios have 5 available positions for you</h5>
												<span>8min ago</span>
											</div>
											</div>
										</div>
										<div class="d-flex recent-activity">
											<span class="me-3 activity">
												<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
												  <circle  cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9"/>
												</svg>
											</span>
											<div class="d-flex align-items-center">
												<svg xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
													  <g  transform="translate(-457 -443)">
														<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
														<g  transform="translate(457 443)">
														  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#eeac27"/>
														  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
														  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
														</g>
													  </g>
												</svg>
												<div class="ms-3">
													<h5 class="mb-1">Elextra Studios has invited you to interview meeting tomorrow</h5>
													<span>8min ago</span>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer border-0 text-center">
										<a href="javascript:void(0);" class="btn btn-outline-primary m-auto dlab-load-more" id="RecentActivity" rel="ajax/recentactivity.html">View more</a>
									</div>
								</div>
							</div>
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header pb-0 border-0 flex-wrap">
										<h4 class="fs-20 mb-0 ">Available Jobs For You</h4>
										<div>	
											<select class="default-select dashboard-select">
											  <option data-display="Newest">Newest</option>
											  
											  <option value="2">oldest</option>
											</select>
											<div class="dropdown custom-dropdown mb-0">
												<div class="btn sharp tp-btn dark-btn" data-bs-toggle="dropdown">
													<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
														<path d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z" stroke="#342E59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z" stroke="#342E59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
														<path d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z" stroke="#342E59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
													</svg>
												</div>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="javascript:void(0);">Details</a>
													<a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
												</div>
											</div>
										</div>	
									</div>
									<div class="card-body">
										<div class="owl-carousel owl-carousel owl-loaded front-view-slider ">
											<div class="items">
												<div class="jobs">
													<div class="text-center">
														<span>
															<svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#2769ee"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
															</svg>
														</span>
														<h4 class="mb-0">UI Designer</h4>
														<span class="text-primary mb-3 d-block">Bubbles Studios</span>
													</div>
													<div class="text-center">
													<span class="d-block mb-1"><i class="fas fa-map-marker-alt me-2"></i>Manchester, England</span>
														<span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $ 2,500</span>
													</div>
												</div>	
											</div>
											<div class="items">
												<div class="jobs">
													<div class="text-center">
														<span>
															<svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#ee27c0"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
															</svg>
														</span>
														<h4 class="mb-0">Researcher</h4>
														<span class="text-primary mb-3 d-block">Kleon Studios</span>
													</div>
													<div class="text-center">
													<span class="d-block mb-1"><i class="fas fa-map-marker-alt me-2"></i>Manchester, England</span>
														<span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $ 2,500</span>
													</div>
												</div>	
											</div>
											<div class="items">
												<div class="jobs">
													<div class="text-center">
														<span>
															<svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#2db532"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
															</svg>
														</span>
														<h4 class="mb-0">Frontend</h4>
														<span class="text-primary mb-3 d-block">Green Comp.</span>
													</div>
													<div class="text-center">
													<span class="d-block mb-1"><i class="fas fa-map-marker-alt me-2"></i>Manchester, England</span>
														<span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $ 2,500</span>
													</div>
												</div>	
											</div>
											<div class="items">
												<div class="jobs">
													<div class="text-center">
														<span>
															<svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#2769ee"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
															</svg>
														</span>
														<h4 class="mb-0">UI Designer</h4>
														<span class="text-primary mb-3 d-block">Bubbles Studios</span>
													</div>
													<div class="text-center">
													<span class="d-block mb-1"><i class="fas fa-map-marker-alt me-2"></i>Manchester, England</span>
														<span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $ 2,500</span>
													</div>
												</div>	
											</div>
											<div class="items">
												<div class="jobs">
													<div class="text-center">
														<span>
															<svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#ee27c0"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
															</svg>
														</span>
														<h4 class="mb-0">Researcher</h4>
														<span class="text-primary mb-3 d-block">Kleon Studios</span>
													</div>
													<div class="text-center">
													<span class="d-block mb-1"><i class="fas fa-map-marker-alt me-2"></i>Manchester, England</span>
														<span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $ 2,500</span>
													</div>
												</div>	
											</div>
											<div class="items">
												<div class="jobs">
													<div class="text-center">
														<span>
															<svg class="mb-2" xmlns="http://www.w3.org/2000/svg" width="71" height="71" viewBox="0 0 71 71">
															  <g  transform="translate(-457 -443)">
																<rect  width="71" height="71" rx="12" transform="translate(457 443)" fill="#c5c5c5"/>
																<g  transform="translate(457 443)">
																  <rect  data-name="placeholder" width="71" height="71" rx="12" fill="#2db532"/>
																  <circle  data-name="Ellipse 12" cx="18" cy="18" r="18" transform="translate(15 20)" fill="#fff"/>
																  <circle  data-name="Ellipse 11" cx="11" cy="11" r="11" transform="translate(36 15)" fill="#ffe70c" style="mix-blend-mode: multiply;isolation: isolate"/>
																</g>
															  </g>
															</svg>
														</span>
														<h4 class="mb-0">Frontend</h4>
														<span class="text-primary mb-3 d-block">Green Comp.</span>
													</div>
													<div class="text-center">
													<span class="d-block mb-1"><i class="fas fa-map-marker-alt me-2"></i>Manchester, England</span>
														<span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $ 2,500</span>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
				</div>	
            </div> -->
			<?php echo $__env->yieldContent('content'); ?>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
		
		
		
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://registry.artsurrogacy.gov.in/" target="_blank">ART & Surrogacy Registry</a> 2024</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->
		
        <!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
   
	

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/global/global.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')); ?>"></script>

<!-- Apex Chart -->
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/apexchart/apexchart.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(asset('js/apexcharts.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/chartjs/chart.bundle.min.js')); ?>"></script>

<!-- Chart piety plugin files -->
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/peity/jquery.peity.min.js')); ?>"></script>

<!-- Select2 -->
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/select2.min.js')); ?>"></script>

<!-- Dashboard 1 -->
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/dashboard/dashboard-1.js')); ?>"></script>

<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/owl-carousel/owl.carousel.js')); ?>"></script>

<!-- DataTables + Buttons JS -->
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/jquery.dataTables.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/dataTables.buttons.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/buttons.html5.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/buttons.print.min.js')); ?>"></script>

<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/jszip.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/pdfmake.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/vfs_fonts.js')); ?>"></script>

<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/custom.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/dlabnav-init.js')); ?>"></script>
  <!-- Datatable -->
  <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/plugins-init/datatables.init.js')); ?>"></script>

  



<script nonce="<?php echo e($cspNonce); ?>">
function JobickCarousel()
	{

		/*  testimonial one function by = owl.carousel.js */
		jQuery('.front-view-slider').owlCarousel({
			loop:false,
			margin:30,
			nav:true,
			autoplaySpeed: 3000,
			navSpeed: 3000,
			autoWidth:true,
			paginationSpeed: 3000,
			slideSpeed: 3000,
			smartSpeed: 3000,
			autoplay: false,
			animateOut: 'fadeOut',
			dots:true,
			navText: ['', ''],
			responsive:{
				0:{
					items:1,
					
					margin:10
				},
				
				480:{
					items:1
				},			
				
				767:{
					items:3
				},
				1750:{
					items:3
				}
			}
		})
	}

	jQuery(window).on('load',function(){
		setTimeout(function(){
			JobickCarousel();
		}, 1000); 
	});
	
		$(document).ready(function () {

    // Disable browser back button
    history.pushState(null, null, location.href);

    window.onpopstate = function () {

        history.go(1);

    };

});
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/admin/ssa_master.blade.php ENDPATH**/ ?>