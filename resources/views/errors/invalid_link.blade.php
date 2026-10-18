<!DOCTYPE html>
<html>
<head>
    <title>Clinic Email/Access Change Request</title>

    <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" nonce="{{ $cspNonce }}">

    <style nonce="{{ $cspNonce }}">
        body{
            background:#e9eef5;
            font-family: "Segoe UI",sans-serif;
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }
        .top-header{
            background:#84b9b9;
            padding:25px;
            color:#000000;
            text-align:center;
            font-size:26px;
            font-weight:600;
            letter-spacing:.5px;
            box-shadow:0 2px 10px rgba(0,0,0,.2);
        }
        .csp-clinic-header-content {
        background-color: #d3e5e1;
        }
        .footer{
            background:white;
            text-align:center;
            padding:15px;
            margin-top:auto;
            box-shadow:0 -2px 8px rgba(0,0,0,.08);
            font-size:14px;
        }
        /* Responsive behaviour stays the same */
        button{padding:10px 45px;font-size:16px;border-radius:6px;}
    </style>
</head>

<body>

<div class="top-header csp-clinic-header-content">
    National ART & Surrogacy Portal
</div>
<div class="container mt-5">
    <div class="alert alert-danger text-center p-4">

        <h2 class="mb-3">Invalid or Expired Link</h2>

        @if(session('error'))
            <p class="lead">{{ session('error') }}</p>
        @else
            <p class="lead">This verification link is invalid, expired, or has been tampered with.</p>
        @endif

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go to Home Page</a>
    </div>
</div>


<style nonce="{{$cspNonce}}">
		.footer .copyright a {
			color: #0b5ed7;
			
		}
		</style>
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://registry.artsurrogacy.gov.in/" target="_blank">ART & Surrogacy Registry</a> 2024</p>
            </div>
        </div>



</body>
</html>
