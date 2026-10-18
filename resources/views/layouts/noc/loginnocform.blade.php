<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>National ART & Surrogacy Portal</title> 
    </head>
    <body class="antialiased">
        @extends('layouts.main')
        @section('content')
        <style nonce="{{ $cspNonce }}">
            .bc-thrirfive{
                background-color:#F0F8FF;
             }
             .margin-top-fiftysix{
                margin-top: 10px;
             }
        </style>
        <section class="login-section py-5">
            <div class="login-page bg-white py-5">
                <div class="container">
                    <div class="row">
                        {{-- @if(Sssion::get('error')) --}}
                        @if (session('error'))
                        @endif
                        <div class="col-lg-6 offset-lg-3">
                            <div class="shadow rounded py-5 bc-thrirfive">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">NOC Login</h3>
                                            @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                            @elseif(session('message'))
                                        <div id="warning-message" class="alert me-4 alert-warning margin-top-fiftysix">
                                            {{ session('message') }}

                                        </div>
                                            @endif
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('noc.loginnocformdata') }}" id="loginform" class="row g-4" method="POST" autocomplete="off">
                                                @csrf
                                                <div class="col-12">
                                                    <label>Username<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                                        <input id="login-username" type="email" class="form-control"
                                                            name="email" placeholder="Enter email" value="{{ old('email') }}">
                                                    </div>
                                                </div>
        
                                                <div class="col-12">
                                                    <label>Password<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                                        <input type="password" id="login-password" class="form-control"
                                                            name="password" placeholder="Enter Password" autocomplete="new-password">
                                                        <input type="hidden" name="_password" id="encrypted_password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="captcha d-inline-flex d-flex">
                                                        <span>{!! captcha_img() !!}</span>
                                                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                            &#x21bb;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                                    @if($errors->has('captcha'))
                                                            <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                                        @endif
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary px-4 mt-4">Login</button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end mt-2">
                                                    <a href="{{ route('noc.request_noc_signup') }}" class="text-decoration-none">Signup</a>
                                                    <span class="mx-2">|</span>
                                                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password</a>
                                                </div>
                                               
                                            </form>
        
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jsencrypt.min.js') }}"></script>
        <script nonce="{{ $cspNonce }}">
        document.addEventListener('DOMContentLoaded', function () {
            let PUBLIC_KEY = '';
            const form = document.getElementById('loginform');
            const passwordInput = document.getElementById('login-password');
            const encryptedInput = document.getElementById('encrypted_password');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Disable submit button until public key is loaded
            submitBtn.disabled = true;
            //url = '{{ url('publickey') }}';
            //alert(url);

            // Load public key from Laravel
            fetch('{{ url('publickey')}}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch public key');
                    }
                    return response.text();
                })
                .then(key => {
                    PUBLIC_KEY = key.trim(); // remove extra whitespace/newlines
                    if (!PUBLIC_KEY.startsWith('-----BEGIN PUBLIC KEY-----')) {
                        throw new Error('Invalid public key format');
                    }
                    submitBtn.disabled = false;
                })
                .catch(err => {
                    console.error('Error loading public key:', err);
                    alert('Encryption setup failed. Please reload the page.');
                });

            // On form submit: encrypt password and disable plain input
            form.addEventListener('submit', function (e) {
                try {
                    if (!PUBLIC_KEY) {
                        alert('Encryption key not loaded yet. Please wait.');
                        e.preventDefault();
                        return;
                    }

                    const password = passwordInput.value;
                    if (!password) {
                        alert('Please enter your password.');
                        e.preventDefault();
                        return;
                    }

                    const encrypt = new JSEncrypt();
                    encrypt.setPublicKey(PUBLIC_KEY);

                    const encrypted = encrypt.encrypt(password);
                    if (!encrypted) {
                        alert('Password encryption failed.');
                        e.preventDefault();
                        return;
                    }

                    encryptedInput.value = encrypted;
                    passwordInput.disabled = true; // block plain-text from being submitted
                    //alert(encryptedInput.value);
                } catch (err) {
                    console.error('Encryption error:', err);
                    alert('An error occurred while encrypting the password.');
                    e.preventDefault();
                }
            });
        });
        </script>
        @endsection
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
        <script nonce="{{ $cspNonce }}" type="text/javascript">
            $(document).ready(function(){
                $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '{{route('noc.reloadCaptcha')}}',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            });
            </script>

            <script nonce="{{ $cspNonce }}">

                function saltedSHA256() {
                    var pass = document.getElementById('login-password').value;
                    var autonum = document.getElementById('autonum').value;
                    var ret = SHA256(pass);
                    var newval = ret + autonum;
                    var againSHA256 = SHA256(newval);

                     var storeShaPassUrl = "{{ route('admin.storeShaPass') }}"

                    // AJAX request to set value in session
                    $.ajax({
                        url: storeShaPassUrl,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            sha_password: pass
                        },
                        success: function(response) {
                            // Optional callback
                            console.log("SHA password stored in session");
                        }
                    });

                    // remove value from field or reset field
                    document.getElementById('login-password').value = againSHA256;
                }


            function SHA256(s){

 


    var chrsz   = 8;


    var hexcase = 0;

 


    function safe_add (x, y) {


        var lsw = (x & 0xFFFF) + (y & 0xFFFF);


        var msw = (x >> 16) + (y >> 16) + (lsw >> 16);


        return (msw << 16) | (lsw & 0xFFFF);


    }

 


    function S (X, n) { return ( X >>> n ) | (X << (32 - n)); }


    function R (X, n) { return ( X >>> n ); }


    function Ch(x, y, z) { return ((x & y) ^ ((~x) & z)); }


    function Maj(x, y, z) { return ((x & y) ^ (x & z) ^ (y & z)); }


    function Sigma0256(x) { return (S(x, 2) ^ S(x, 13) ^ S(x, 22)); }


    function Sigma1256(x) { return (S(x, 6) ^ S(x, 11) ^ S(x, 25)); }


    function Gamma0256(x) { return (S(x, 7) ^ S(x, 18) ^ R(x, 3)); }


    function Gamma1256(x) { return (S(x, 17) ^ S(x, 19) ^ R(x, 10)); }

 


    function core_sha256 (m, l) {


        var K = new Array(0x428A2F98, 0x71374491, 0xB5C0FBCF, 0xE9B5DBA5, 0x3956C25B, 0x59F111F1, 0x923F82A4, 0xAB1C5ED5, 0xD807AA98, 0x12835B01, 0x243185BE, 0x550C7DC3, 0x72BE5D74, 0x80DEB1FE, 0x9BDC06A7, 0xC19BF174, 0xE49B69C1, 0xEFBE4786, 0xFC19DC6, 0x240CA1CC, 0x2DE92C6F, 0x4A7484AA, 0x5CB0A9DC, 0x76F988DA, 0x983E5152, 0xA831C66D, 0xB00327C8, 0xBF597FC7, 0xC6E00BF3, 0xD5A79147, 0x6CA6351, 0x14292967, 0x27B70A85, 0x2E1B2138, 0x4D2C6DFC, 0x53380D13, 0x650A7354, 0x766A0ABB, 0x81C2C92E, 0x92722C85, 0xA2BFE8A1, 0xA81A664B, 0xC24B8B70, 0xC76C51A3, 0xD192E819, 0xD6990624, 0xF40E3585, 0x106AA070, 0x19A4C116, 0x1E376C08, 0x2748774C, 0x34B0BCB5, 0x391C0CB3, 0x4ED8AA4A, 0x5B9CCA4F, 0x682E6FF3, 0x748F82EE, 0x78A5636F, 0x84C87814, 0x8CC70208, 0x90BEFFFA, 0xA4506CEB, 0xBEF9A3F7, 0xC67178F2);


        var HASH = new Array(0x6A09E667, 0xBB67AE85, 0x3C6EF372, 0xA54FF53A, 0x510E527F, 0x9B05688C, 0x1F83D9AB, 0x5BE0CD19);


        var W = new Array(64);


        var a, b, c, d, e, f, g, h, i, j;


        var T1, T2;

 


        m[l >> 5] |= 0x80 << (24 - l % 32);


        m[((l + 64 >> 9) << 4) + 15] = l;

 


        for ( var i = 0; i<m.length; i+=16 ) {


            a = HASH[0];


            b = HASH[1];


            c = HASH[2];


            d = HASH[3];


            e = HASH[4];


            f = HASH[5];


            g = HASH[6];


            h = HASH[7];

 


            for ( var j = 0; j<64; j++) {


                if (j < 16) W[j] = m[j + i];


                else W[j] = safe_add(safe_add(safe_add(Gamma1256(W[j - 2]), W[j - 7]), Gamma0256(W[j - 15])), W[j - 16]);

 


                T1 = safe_add(safe_add(safe_add(safe_add(h, Sigma1256(e)), Ch(e, f, g)), K[j]), W[j]);


                T2 = safe_add(Sigma0256(a), Maj(a, b, c));

 


                h = g;


                g = f;


                f = e;


                e = safe_add(d, T1);


                d = c;


                c = b;


                b = a;


                a = safe_add(T1, T2);


            }

 


            HASH[0] = safe_add(a, HASH[0]);


            HASH[1] = safe_add(b, HASH[1]);


            HASH[2] = safe_add(c, HASH[2]);


            HASH[3] = safe_add(d, HASH[3]);


            HASH[4] = safe_add(e, HASH[4]);


            HASH[5] = safe_add(f, HASH[5]);


            HASH[6] = safe_add(g, HASH[6]);


            HASH[7] = safe_add(h, HASH[7]);


        }


        return HASH;


    }

 


    function str2binb (str) {


        var bin = Array();


        var mask = (1 << chrsz) - 1;


        for(var i = 0; i < str.length * chrsz; i += chrsz) {


            bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (24 - i%32);


        }


        return bin;


    }

 


    function Utf8Encode(string) {


        string = string.replace(/\r\n/g,"\n");


        var utftext = "";

 


        for (var n = 0; n < string.length; n++) {

 


            var c = string.charCodeAt(n);

 


            if (c < 128) {


                utftext += String.fromCharCode(c);


            }


            else if((c > 127) && (c < 2048)) {


                utftext += String.fromCharCode((c >> 6) | 192);


                utftext += String.fromCharCode((c & 63) | 128);


            }


            else {


                utftext += String.fromCharCode((c >> 12) | 224);


                utftext += String.fromCharCode(((c >> 6) & 63) | 128);


                utftext += String.fromCharCode((c & 63) | 128);


            }

 


        }

 


        return utftext;


    }

 


    function binb2hex (binarray) {


        var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";


        var str = "";


        for(var i = 0; i < binarray.length * 4; i++) {


            str += hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8+4)) & 0xF) +


            hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8  )) & 0xF);


        }


        return str;


    }

 


    s = Utf8Encode(s);


    return binb2hex(core_sha256(str2binb(s), s.length * chrsz));

 

}
 


            </script>
    </body>
</html>