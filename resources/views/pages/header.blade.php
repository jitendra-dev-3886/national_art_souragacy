<!--nav class="navbar navbar-expand-lg" style="background-color:#337AB7;">
        <div class="container-fluid">
            <a class="navbar-brand link-dark text-white" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link link-dark text-white" href="https://artsurrogacy.gov.in/">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav mb-lg-0 float-right">
                    <li class="nav-item d-flex">
                        <a href="#" class="nav-link link-dark text-white">Login</a>
                        <a href="#" class="nav-link link-dark text-white">Admin-Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav-->
	 <style nonce="{{ $cspNonce }}">
/* Navbar background color */
.csp-navbar-bg {
    background-color: #337AB7;
}

/* Banner heading font size */
.csp-banner-heading {
    font-size: 45px;
}

/* Image sizing for additional logos */
.csp-header-logo {
    width: 150px;
    height: 85px;
}
</style>

<nav class="navbar navbar-expand-lg csp-navbar-bg">
    <div class="container-fluid">
        <a class="navbar-brand link-dark text-white" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex">
                <li class="nav-item">
                    <a class="nav-link link-dark text-white" href="https://artsurrogacy.gov.in/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-dark text-white" href="{{ route('clinic.dashboardsgs') }}">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle link-dark text-white" href="#" id="signupDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Signup
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="signupDropdown">
                        <li><a class="dropdown-item" href="{{ route('clinic.request_clinic_signup') }}">Signup for Clinics/Banks</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('noc.request_noc_signup') }}">Signup for NOC Applicant</a></li> --}}
                    </ul>                        
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle link-dark text-white" href="#" id="signupDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Login
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="signupDropdown">
                        <li><a class="dropdown-item" href="{{ route('clinic.loginclinicform') }}">Login as a Clinics/Banks</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('noc.loginnocform') }}">Login as a NOC Applicants</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('admin.loginssaform') }}">Login as a State Appropriate Authority</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.login') }}">Login as a Officials</a></li>
                    </ul>
                </li>
            </ul>               
        </div>
    </div>
</nav>

<!-- Banner Section -->
<div class="row py-2 shadow rounded mb-1">
    <!-- Logo -->
    <div class="col-md-2">
        <a target="_self" class="com-display-in" title="National ART &amp; Surrogacy Portal">
            <img src="{{ url('public/header_images/ART-surrogacy-logo.png') }}" width="150px" alt="National ART &amp; Surrogacy Portal">
        </a>
    </div>
    <!-- Title -->
    <div class="col-md-8">
        <h2 class="text-center text-dark csp-banner-heading">
            <strong>National ART & Surrogacy Registry</strong>
        </h2>
    </div>
    <!-- Additional Logos -->
    <div class="col-md-2 d-flex">
        <img src="{{ url('public/header_images/azadiKaAmritMahotsavLogo.png') }}" class="csp-header-logo"
            alt="Azadi Ka Amrit Mahotsav" title="Azadi Ka Amrit Mahotsav">
        <img src="{{ url('public/header_images/g20.png') }}" class="csp-header-logo"
            alt="G20" title="G20">
    </div>
</div>
