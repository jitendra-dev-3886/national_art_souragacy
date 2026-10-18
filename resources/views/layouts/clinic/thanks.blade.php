<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(session('success'))
    <title>Thank You</title>
    @endif
    <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" nonce="{{ $cspNonce }}">
    <style nonce="{{ $cspNonce }}">
        body {
            background: #e9eef5;
            font-family: "Segoe UI", sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

      
        header {
            background: #84b9b9;
            padding: 25px;
            color: #000;
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

      
        .thank-card {
            background: #fff;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }

        .success-icon {
            font-size: 70px;
            color: #28a745;
        }

        .btn-home {
            background: #0d6efd;
            color: #fff;
            border-radius: 50px;
            padding: 10px 40px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: #0b5ed7;
            color: #fff;
        }

        /* Footer */
        .footer {
            background: #fff;
            text-align: center;
            padding: 15px;
            margin-top: auto;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.08);
            font-size: 14px;
        }

        .footer a {
            color: #0b5ed7;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

       
        @media(max-width:576px) {
            .thank-card {
                padding: 30px 20px;
            }
            header {
                font-size: 22px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
 
    <header>
        National ART & Surrogacy Portal
    </header>

  
    <div class="d-flex justify-content-center align-items-center flex-grow-1" style="padding: 40px 20px;">
        <div class="thank-card text-center">
            <div class="mb-4">
                <span class="success-icon">&#10004;</span>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('success'))
                <h1 class="mb-3">Thank You!</h1>
            @else
                <h1 class="mb-3">Thank You!</h1>
            @endif
            
            <p class="mb-4 text-muted">We will process it shortly.</p>
            <a href="{{ url('/') }}" class="btn-home">Go to Homepage</a>
        </div>
    </div>

   
    <div class="footer">
        <p>Copyright © Designed &amp; Developed by 
            <a href="https://registry.artsurrogacy.gov.in/" target="_blank">ART & Surrogacy Registry</a> 2024
        </p>
    </div>
</body>
</html>
