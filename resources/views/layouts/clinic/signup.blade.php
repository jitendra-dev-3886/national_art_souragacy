{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>National ART & Surrogacy Portal</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}

        <!-- Styles -->
        {{-- <style nonce="{{$cspNonce}}">
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.mx-auto{margin-left:auto;margin-right:auto}.mx-6{margin-left:1.5rem;margin-right:1.5rem}.ml-4{margin-left:1rem}.mt-16{margin-top:4rem}.mt-6{margin-top:1.5rem}.mt-4{margin-top:1rem}.-mt-px{margin-top:-1px}.mr-1{margin-right:0.25rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.h-16{height:4rem}.h-7{height:1.75rem}.h-6{height:1.5rem}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-auto{width:auto}.w-16{width:4rem}.w-7{width:1.75rem}.w-6{width:1.5rem}.w-5{width:1.25rem}.max-w-7xl{max-width:80rem}.shrink-0{flex-shrink:0}.scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.items-center{align-items:center}.justify-center{justify-content:center}.gap-6{gap:1.5rem}.gap-4{gap:1rem}.self-center{align-self:center}.rounded-lg{border-radius:0.5rem}.rounded-full{border-radius:9999px}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-dots-darker{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")}.from-gray-700\/50{--tw-gradient-from:rgb(55 65 81 / 0.5);--tw-gradient-to:rgb(55 65 81 / 0);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0);--tw-gradient-stops:var(--tw-gradient-from), transparent, var(--tw-gradient-to)}.bg-center{background-position:center}.stroke-red-500{stroke:#ef4444}.stroke-gray-400{stroke:#9ca3af}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-gray-500\/20{--tw-shadow-color:rgb(107 114 128 / 0.2);--tw-shadow:var(--tw-shadow-colored)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.selection\:bg-red-500 *::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-red-500::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.hover\:text-gray-700:hover{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.focus\:rounded-sm:focus{border-radius:0.125rem}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}.group:hover .group-hover\:stroke-gray-600{stroke:#4b5563}@media (prefers-reduced-motion: no-preference){.motion-safe\:hover\:scale-\[1\.01\]:hover{--tw-scale-x:1.01;--tw-scale-y:1.01;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}@media (prefers-color-scheme: dark){.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:bg-gray-800\/50{background-color:rgb(31 41 55 / 0.5)}.dark\:bg-red-800\/20{background-color:rgb(153 27 27 / 0.2)}.dark\:bg-dots-lighter{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")}.dark\:bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.dark\:stroke-gray-600{stroke:#4b5563}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.dark\:ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.dark\:ring-inset{--tw-ring-inset:inset}.dark\:ring-white\/5{--tw-ring-color:rgb(255 255 255 / 0.05)}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.group:hover .dark\:group-hover\:stroke-gray-400{stroke:#9ca3af}}@media (min-width: 640px){.sm\:fixed{position:fixed}.sm\:top-0{top:0px}.sm\:right-0{right:0px}.sm\:ml-0{margin-left:0px}.sm\:flex{display:flex}.sm\:items-center{align-items:center}.sm\:justify-center{justify-content:center}.sm\:justify-between{justify-content:space-between}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}}@media (min-width: 1024px){.lg\:gap-8{gap:2rem}.lg\:p-8{padding:2rem}}
        </style>
    </head> --}}
    {{-- <body class="antialiased"> --}}
        


        @extends('layouts.main')
        @section('content')
<style nonce="{{$cspNonce}}">

.csp-clinic-shadow{
                background-color:#F0F8FF;
            }
          
.csp-clinic-button-danger {
    width: 93px;
}
.csp-clinic-gap{
border-top: 1px solid#888;
padding-top:15px;
font-size:85%
}

    </style>


        <section class="login-section py-2">
            <div class="login-page bg-white py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="shadow rounded py-2 csp-clinic-shadow">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h4 class="card-title text-center mb-4" >Sign-up Form</h4>
                                            {{-- <span class="text-center">(Details to be filled by Clinics/Banks)</span> --}}
                                            {{-- @if(session('success'))
                                            <div id="success-message" class="alert me-4 alert-success" style="margin-top: 10px;">
                                                {{ session('success') }}
                                            
                                        </div>
                                        @endif     --}}
                                            @if ($errors->any())
                                            <div class="alert alert-danger col-sm-12">
                                                @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            @endif
                                            
                                            <form action="{{ route('clinic.request_signup_data') }}" id="loginform" class="well form-horizontal" method="POST">
                                                @csrf
                                               
                                               
                                                {{-- <form  class="well form-horizontal" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> --}}
                                                    <!-- <form class="form-valide-with-icon needs-validation" novalidate> -->
                                                        <div class="mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Name of Health Facility (ART Clinic/ ART Bank/ Surrogacy Clinic)*</strong></label>
                                                            <div class="input-group">
                                                                <input id="clinicname" name="clinicname" pattern="[A-Za-z0-9 &()]*" placeholder="Name of Health Facility" class="form-control" type="text" autocomplete="off">
                                                                @error('clinicname')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="mb-3">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Address of the Organisation*</strong></label>
                                                            <div class="input-group">
                                                                <input name="address" id="address" placeholder="Address" class="form-control" type="text" autocomplete="off">
                                                                @error('address')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                    

                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="pincode"><strong>Pincode *</strong></label>
                                                                <div class="input-group" >
                                                                    <input type="text" pattern="^[0-9]{6}$" name="pincode" maxlength="6" id="pincode" class="form-control">
                                                                    <span id="pincodeavailability"></span>
                                                                </div>
                                                                {{-- <div id="availability" class="mt-2"></div>                                                                   --}}
                                                                   @error('pincode')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                            
                                                        
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="state"><strong>State</strong></label>
                                                                <div class="input-group">
                                                                    <input type="text" name="state" id="state" placeholder="State" class="form-control" readonly>
                                                                    @error('state')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>                                                           
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="district"><strong>District</strong></label>
                                                                <div class="input-group" id="district-container">
                                                                    <input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />
                                                                </div>                                                       
                                                                   @error('district')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                            <div class="col-md-6 mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                                <label class="text-label form-label" for="natures"><strong>Nature*</strong></label>
                                                                <div class="input-group">
                                                                    <select name="nature" id="nature" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option value="Government">Government</option>
                                                                        <option value="Private">Private</option>
                                                                    </select>
                                                                    @error('nature')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                                <label class="text-label form-label" for="contactno"><strong>Contact Number of the Organisation *</strong></label>
                                                                <div class="input-group">
                                                                    <input name="contactno" id="contactno" placeholder="contact number should be 11 numbers" class="form-control" pattern="^[0-9]{11}$" maxlength="11" type="text">
                                                                    @error('contactno')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="email"><strong>Email Address of the Organisation *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control border-left-end" name="email" id="email" value="{{ old('email') }}" placeholder="Enter an email.." >
                                                                </div>
                                                                <div id="availability" class="mt-2"></div>
                                                                   @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_email"><strong>Verify Email Address of the Organisation *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control border-left-end" name="v_email" id="v_email" value="{{ old('v_email') }}" placeholder="Verify your email.." >
                                                                  </div>  
                                                                    <div id="error_email_org" class="text-danger small"></div>
                                                                    @error('v_email')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        
                                                            <!-- Mobile Number Section -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="personname"><strong>Name of the Contact Person *</strong></label>
                                                                <div class="input-group">
                                                                    <input id="personname" name="personname" placeholder="Name of contact Person" class="form-control" type="text"
                                                                    pattern="[A-Za-z ]*" title="Only alphabetic characters are allowed">
                                                                    @error('personname')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="mobileno"><strong>Mobile Number *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control border-left-end" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="Enter a mobile number.." pattern="^[0-9]{10}$" maxlength="10" title="This is not a valid 10-digit mobile number">
                                                                    @error('mobileno')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="v_mobileno"><strong>Verify Mobile Number *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control border-left-end" name="v_mobile" id="v_mobile" value="{{ old('v_mobile') }}" placeholder="Verify your mobile number.." pattern="^[0-9]{10}$" maxlength="10" title="This is not a valid 10-digit mobile number">
                                                                    </div>
                                                                    <div id="error_v_mobile_contact_person" class="text-danger small"></div>
                                                                    @error('v_mobile')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                            <!-- email of contact person Section -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="email_contact_person"><strong>Email Address *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control @error('email_contact_person') is-invalid @enderror" name="email_contact_person" id="email_contact_person" value="{{ old('email_contact_person') }}" placeholder="Enter a email address..">
                                                                    @error('email_contact_person')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_email_contact_person"><strong>Verify Email Address *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control @error('error_v_email_contact_person') is-invalid @enderror" name="v_email_contact_person" id="v_email_contact_person" value="{{ old('v_email_contact_person') }}" placeholder="Verify your email address." >
                                                                    </div>  
                                                                    <div id="error_v_email_contact_person" class="text-danger small"></div>
                                                                    @error('v_email_contact_person')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                            </div>

                                                            <!-- end the email verify -->
                                                            <div class="form-group mb-2">
                                                                <div class="captcha d-inline-flex d-flex">
                                                                    <span>{!! captcha_img() !!}</span>
                                                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                                        &#x21bb;
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
                                                                <input id="captcha" type="text" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                                                @if($errors->has('captcha'))
                                                                        <span class="text-danger">{{ $errors->first('captcha') }}</span>
                                                                    @endif
                                                            </div>
                                                        </div>
                                                        
                                                                                        <input type="submit" class="btn btn-primary light" id="submitBtn" value="Submit">
                                                                                     
                                                                                        <button type="submit" class="btn btn-danger light csp-clinic-button-danger">Cancel</button>

                                                                                        <div class="gap-2 mt-2 csp-clinic-gap" >


                                                                                            
                                                                Already have an account! |
                                                                <a href="{{route('clinic.loginclinicform')}}" class="text-dark text-decoration-none"
                                                                  id="showSignupLink">
                                                                    Login Here
                                                                </a>
                                                                <a href="{{ route('clinic.resendLink') }}" class="text-dark text-decoration-none">| Resend Verification Link</a>
                                                                {{-- <a href="{{ route('clinic.loginclinicform') }}" 
   class="text-dark text-decoration-none" 
   id="showSignupLink">
   Login Here
</a> --}}
                                                                
                                                                
                                                                
             {{-- onClick="$('#loginbox').hide(); $('#signupbox').show()"  --}}
                                                                
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
        @endsection
        <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js')}}"></script>
       
        <script nonce="{{ $cspNonce }}" type="text/javascript">
            $(document).ready(function(){
                $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '{{route('clinic.reloadCaptcha')}}',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            </script>
{{-- added for login button show hide inline  --}}
 <script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    const link = document.getElementById('showSignupLink');

    if (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // prevent the link from navigating
            document.getElementById('loginbox')?.style.display = 'none';
            document.getElementById('signupbox')?.style.display = 'block';
        });
    }
});
</script>
{{-- added onkeyup realtime check show hide inline  --}}
           <script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    // Attach input event listeners
    document.getElementById("v_email").addEventListener("input", function() {
        checkRealtimeValue(this);
    });

    document.getElementById("v_email_contact_person").addEventListener("input", function() {
        checkRealtimeValue(this);
    });

    document.getElementById("v_mobile").addEventListener("input", function() {
        checkRealtimeValue(this);
    });
});

function checkRealtimeValue(input) {
    let first_value, second_value, value_err, msg;

    if (input.id === "v_email") {
        first_value = document.getElementById("email").value;
        second_value = input.value;
        value_err = document.getElementById("error_email_org");
        msg = "Organization Email does not match";
    } else if (input.id === "v_email_contact_person") {
        first_value = document.getElementById("email_contact_person").value;
        second_value = input.value;
        value_err = document.getElementById("error_v_email_contact_person");
        msg = "Contact person Email do not match";
    } else if (input.id === "v_mobile") {
        first_value = document.getElementById("mobile").value;
        second_value = input.value;
        value_err = document.getElementById("error_v_mobile_contact_person");
        msg = "Contact person Mobile no do not match";
    }

    if (first_value !== second_value) {
        value_err.innerHTML = msg;
        input.setCustomValidity(msg);
    } else {
        value_err.innerHTML = "";
        input.setCustomValidity("");
    }
}
</script>

            </script>
             <script nonce="{{ $cspNonce }}">
                $(document).ready(function () {
                    $('#pincode').blur(function () {
                        var pincode = $(this).val();
                        if (pincode === "") {
                            $('#state').val('');
                            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                        } else {
                            $.ajax({
                                url: "{{ route('pincode.signup') }}",
                                method: "POST",
                                data: {
                                    pincode: pincode,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function (data) {
                                    if (data.success) {
                                        $('#state').val(data.state);
                                        $('#pincodeavailability').html('');

                                        if (data.districts.length > 1) {
                                            
                                            // If multiple districts, show dropdown
                                            let districtDropdown = '<select name="district" id="district" class="form-control">';
                                            //    console.log(districtDropdown);
                                            districtDropdown += '<option value="">Select District</option>';
                                            data.districts.forEach(district => {
                                                districtDropdown += `<option value="${district}">${district}</option>`;
                                            });
                                            districtDropdown += '</select>';
                                            $('#district-container').html(districtDropdown);
                                        } else if (data.districts.length === 1) {
                                            // If only one district, show input field
                                            $('#district-container').html(`<input type="text" name="district" id="district" value="${data.districts[0]}" class="form-control" readonly />`);
                                        } else {
                                            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                                            $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                        }
                                    } else {
                                        $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                        $('#state').val('');
                                        $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error:', error);
                                    console.log('Response Text:', xhr.responseText);
                                }
                            });
                        }
                    });
                });
        </script>
            {{-- <script nonce="{{ $cspNonce }}">
                 $(document).ready(function(){
                $('#pincode').blur(function() {
                  
                    var pincode = $(this).val();
                    if (pincode === "") {
                        $('#state').val('');
                        $('#district').val('');
                        $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                    } else {                       
                        $.ajax({
                            url: "{{ route('pincode.signup') }}", // Laravel route
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
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                                console.log('Response Text:', xhr.responseText);
                            }
                        });
                    }
                });
            });
            </script> --}}
        
            <script nonce="{{ $cspNonce }}">
                document.addEventListener("DOMContentLoaded", function() {
                    let inputs = document.querySelectorAll("input");
            
                    inputs.forEach(input => {
                        input.addEventListener("keypress", function(event) {
                            let char = String.fromCharCode(event.which);
                            if (char === "<" || char === ">") {
                                alert("'<>' characters are not allowed!");
                                event.preventDefault();
                            }
                        });
                    });
                });
            
                function validateInput() {
                    let inputs = document.querySelectorAll("input");
            
                    for (let input of inputs) {
                        if (input.value.includes("<") || input.value.includes(">")) {
                            alert("'<>' characters are not allowed in input fields!");
                            input.focus();
                            return false;
                        }
                    }
            
                    return true;
                }
            </script>

            {{-- added for validation onsubmit  inline  --}}
          <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("loginform");

        form.addEventListener("submit", function (e) {
            if (!validation()) {
                e.preventDefault(); // Stop form from submitting
            }
        });

        function validation() {
            if (document.getElementById("clinicname").value == "") {
                alert("Name of Health Facility (ART Clinic/ ART Bank/ Surrogacy Clinic) cannot be blank");
                document.getElementById("clinicname").focus();
                return false;
            }
            if (document.getElementById("address").value == "") {
                alert("Address of the Organisation cannot be blank");
                document.getElementById("address").focus();
                return false;
            }
            if (document.getElementById("pincode").value == "") {
                alert("Pincode cannot be blank");
                document.getElementById("pincode").focus();
                return false;
            }
            if (document.getElementById("nature").value == "") {
                alert("Nature of the Organisation cannot be blank");
                document.getElementById("nature").focus();
                return false;
            }
            if (document.getElementById("contactno").value == "") {
                alert("Contact Number of the Organisation cannot be blank");
                document.getElementById("contactno").focus();
                return false;
            }
            if (document.getElementById("email").value == "") {
                alert("Email Address cannot be blank");
                document.getElementById("email").focus();
                return false;
            }
            if (document.getElementById("v_email").value == "") {
                alert("Verify Email Address cannot be blank");
                document.getElementById("v_email").focus();
                return false;
            }

            const email = document.getElementById("email");
            const vEmail = document.getElementById("v_email");

            if (email.value !== vEmail.value) {
                vEmail.classList.add("is-invalid");
                alert("Email and Verify Email must match.");
                vEmail.focus();
                return false;
            } else {
                vEmail.classList.remove("is-invalid");
            }

            if (document.getElementById("personname").value == "") {
                alert("Name of the Contact Person cannot be blank");
                document.getElementById("personname").focus();
                return false;
            }
            if (document.getElementById("mobile").value == "") {
                alert("Mobile Number cannot be blank");
                document.getElementById("mobile").focus();
                return false;
            }
            if (!/^[0-9]+$/.test(document.getElementById("mobile").value)) {
                alert("Mobile Number should be numeric");
                document.getElementById("mobile").focus();
                return false;
            }
            if (document.getElementById("v_mobile").value == "") {
                alert("Verify Mobile Number cannot be blank");
                document.getElementById("v_mobile").focus();
                return false;
            }
            if (!/^[0-9]+$/.test(document.getElementById("v_mobile").value)) {
                alert("Verify Mobile Number should be numeric");
                document.getElementById("v_mobile").focus();
                return false;
            }

            const mobileNo = document.getElementById("mobile");
            const vMobileNo = document.getElementById("v_mobile");

            if (mobileNo.value !== vMobileNo.value) {
                vMobileNo.classList.add("is-invalid");
                alert("Mobile Number and Verify Mobile Number must match.");
                vMobileNo.focus();
                return false;
            } else {
                vMobileNo.classList.remove("is-invalid");
            }

            const emailContact = document.getElementById("email_contact_person");
            const vEmailContact = document.getElementById("v_email_contact_person");

            if (emailContact.value == "") {
                alert("Email Address of the contact person cannot be blank");
                emailContact.focus();
                return false;
            }
            if (vEmailContact.value == "") {
                alert("Verify Email Address of the contact person cannot be blank");
                vEmailContact.focus();
                return false;
            }

            if (emailContact.value !== vEmailContact.value) {
                vEmailContact.classList.add("is-invalid");
                alert("Email of contact person and Verify email must match.");
                vEmailContact.focus();
                return false;
            } else {
                vEmailContact.classList.remove("is-invalid");
            }

            const captchaInput = document.getElementById("captcha").value;
            if (captchaInput.trim() === "") {
                alert("CAPTCHA cannot be blank");
                document.getElementById("captcha").focus();
                return false;
            }

            const agree = confirm("Kindly check and confirm all details before final submission.");
            return agree;
        }
    });
</script>

             <script nonce="{{ $cspNonce }}">
                $(document).on('blur', '#email', function () {
           // $('#email').blur(function () {
                //alert('fgfd');
                //console.log('check 1');
                var email = $(this).val();
                //console.log(email);
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
                if (email == "") {
                    $('#availability').html('');
                } else {
                    $.ajax({
                        url: '{{ route('clinic.checkEmail') }}', // Laravel route
                        method: "POST",
                        data: {
                            email: email,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            if (response.status === 'exists') {
                                $('#availability').html(
                                    '<span class="text-danger">Email ID already exists with NARTSR. Please use the another email ID.</span>'
                                );
                                $('#submitBtn').attr("disabled", true);
                            } else if (!regex.test(email)) {
                                $('#availability').html(
                                    '<span class="text-danger">Please enter a valid email id</span>'
                                );
                            } else {
                                $('#availability').html(
                                    '<span class="text-success">Email available for submission of application form.</span>'
                                );
                                $('#submitBtn').attr("disabled", false);
                            }
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            
        </script>


        
    {{-- </body>
</html> --}}
