
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Permission Letter</title> --}}
    <style nonce="{{$cspNonce}}">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
           
        }
        
        
        .header,
        .footer {
            text-align: center;
        }

        .content {
            margin: 20px;
        }

        .content p {
            text-align: justify;
        }
        .right-text  {
            padding-left: 18px;
            font-size:12px;
}
        .logo.text-center {
            padding-left: 146px;
}
.left-text.text-end {
            padding-left: ;
}
.pdf-container {
        width: 100%;         /* Makes the container full width */
        /* max-width: 1000px;    Limits the width of the PDF */
        margin: 0 auto;      /* Centers the container horizontally */
        height: 600px;       /* Set a fixed height for the container */
        overflow: hidden;    /* Prevents overflow */
    }

    .pdf-container {
        width: 100%;         /* Ensures the PDF takes up the full container width */
        height: 100%;        /* Ensures the PDF takes up the full container height */
    }
    .display-flex-eightwo{
        display:flex
    }
    .width-hight-eightree{
    width: 700px; height: auto;    
    }
    .padding-left-cspo-enight{
        padding-left:50px;
    }
    .widht-hight-eight-five{
        width: 400px; height: auto;
    }
    </style>
</head>

<body>
    <!-- Main Heading -->
    {{-- <div class="main-heading">Application form for transfer of Gametes (sperms Oocyte)/Embryos (Within
        and Outside India)</div> --}}
    {{-- <div class="application-number">
        Application No: {{ $application->application_no }}
    </div> --}}

    {{-- <div class="col-lg-12">
        <div class="card-header">


        </div>
        <div class="card-body">
            <div class="header ">
                <img src="{{ url('public/images/profile/goi_logo.png') }}" alt="Government of India Logo"
                    style="width: 100px; height: auto; margin-bottom: 10px;">
                <p>
                    भारत सरकार/Government of India<br>
                    स्वास्थ्य और परिवार कल्याण मंत्रालय/ Ministry of Health & Family Welfare<br>
                    (स्वास्थ्य अनुसंधान विभाग/Department of Health Research)<br>
                    2nd Floor, IRCS Building, New Delhi, the {{ $currentDate }}
                </p>
            </div>
            <div class="content">
                <p>To<br><strong> Name of Applicant:</strong> {{ $application['name_applicant'] }}<br><strong> Address
                        of Applicant:</strong> {{ $application['address'] }}<br> <strong>Email:</strong> {{
                    $application['email'] }}</p>
                <p><b><strong>Sub:</strong></b> Permission for transfer of {{ $application['transfer_of'] }} from ----
                    to ------ for the purpose of IVF/Surrogacy- reg.</p>
                <p><strong>Madam /Sir,</strong></p>
                <p>
                    This is with reference to your request on the above-mentioned subject. It is informed that the
                    National Assisted Reproductive Technology and Surrogacy Board has permitted the transfer of {{
                    $application['transfer_of'] }} for the purpose of IVF/Surrogacy from -------- to ------- in
                    accordance with section 29 of the Assisted Reproductive Technology (Regulation) Act, 2021 and
                    subject to the fulfillment of all provisions of the Assisted Reproductive Technology (Regulation)
                    Act, 2021 and Surrogacy (Regulation) Act, 2021 as per procedures involved / applicable in your case.
                </p>
                <p>It may be noted that exposure to X-ray may adversely influence the quality of embryos/ gametes.</p>
                <p><strong>Yours faithfully,</strong></p>
                <p><strong>(N. Sriramasubramanian)</strong><br><strong>Under Secretary to the Government of
                        India</strong></p>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <div class="pdf-container">
        <div class="row display-flex-eightwo">
            <div class="col-md-12 width-hight-eightree">
                <img src="{{ url('public/images/profile/combine_logo.png') }}" alt="Government of India Logo"
               >
            </div>
            <div class="logo text-center col-md-12 padding-left-cspo-enight">
                <div><span>  {{ $application['application_no'] }}<span></div>
                <img src="{{ url('public/images/profile/m_hindi_eng.png') }}" alt="Government of India Logo"
                class="widht-hight-eight-five">
            </div>
            <!-- Right Section -->
            {{-- <div class="col-md-4">
                <div class="right-text">
                    <p>
                        <img src="{{ url('public/images/profile/m_logo.png') }}" alt="Government of India Logo"
                        style="width: 200px; height: auto;">
                        {{-- <span style="padding-left:50px;">Government of India</span><br>
                        Ministry of Health & Family Welfare<br>
                        (Department of Health Research)<br>                         --}}
                    {{-- </p> --}}
                {{-- </div> --}}
            {{-- </div> --}} 
        
            <!-- Center Section (Logo) -->
            {{-- <div class="col-md-4">
               
                <div class="logo text-center">
                    <img src="{{ url('public/images/profile/goi_logo.png') }}" alt="Government of India Logo"
                        style="width: 100px; height: auto;"><br>
                
                    <img src="{{ url('public/images/profile/Azadi_Logo.png') }}" alt="Government of India Logo"
                        style="width: 100px; height: auto;"><br>
                   
                        <span style="padding-right: 200px;">  {{ $application['application_no'] }}<span><br>
                        <img src="{{ url('public/images/profile/m_hindi_eng.png') }}" alt="Government of India Logo"
                        style="width: 400px; height: auto;"><br>
                      
                    {{-- भारत सरकार/Government of India<br>
                    स्वास्थ्य और परिवार कल्याण मंत्रालय/Ministry of Health & Family Welfare<br>
                    (स्वास्थ्य अनुसंधान विभाग/Department of Health Research)<br> --}}
                   

                {{-- </div> --}}
            {{-- </div> --}} 
        
            <!-- Left Section -->
            {{-- <div class="col-md-4">
                <div class="left-text text-end">
                    <p>
                        <img src="{{ url('public/images/profile/m_hindi_logo.png') }}" alt="Government of India Logo"
                        style="width: 200px; height: auto;">
                    </p>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div class="" style="float:right; font-size:14px;">
                2nd Floor, IRCS Building, New Delhi<br>
                {{ $currentDate }}
            </div>
                
            </div>
            <div>
            <div class="row">
                <div class="content mt-4">

                    <p style="font-size:14px;">To<br><strong>Name of Applicant:</strong> {{ $application['name_applicant'] }}<br>
                        <strong>Address of Applicant:</strong>
                        {{ substr($application['address'], 0, 30) }}<br>  <!-- First part (first 30 characters) -->
                        {{ substr($application['address'], 30, 30) }}<br> <!-- Second part (next 30 characters) -->
                        {{ substr($application['address'], 60) }}     <br>  
                        {{-- <strong>Address of Applicant:</strong> {{ $application['address'] }}<br> --}}
                        <strong>Email:</strong> {{ $application['email'] }}
                    </p>
                    <p style="font-size:14px;"><b><strong>Sub:</strong></b> Permission for transfer of {{ $application['transfer_of'] }} from
                        {{ $application['f_district'] }},{{ $application['f_state'] }} to {{ $application['t_district'] }},{{ $application['t_state'] }} for the purpose of IVF/Surrogacy- reg.</p>
                    <p><strong>Madam /Sir,</strong></p>
                    <p style="font-size:14px;">
                        This is with reference to your request on the above-mentioned subject. It is informed that the
                        National Assisted Reproductive Technology and Surrogacy Board has permitted the transfer of
                        @if($application['embryos_number'] > 0 && $application['sperm_vials'] > 0 && $application['oocytes_number'] > 0)
                        {{$application['embryos_number']}} embryo(s), {{$application['sperm_vials']}} semen vial(s), and {{$application['oocytes_number']}} oocyte(s)
                        @elseif($application['embryos_number'] > 0 && $application['sperm_vials'] > 0)
                            {{$application['embryos_number']}} embryo(s) and {{$application['sperm_vials']}} semen vial(s)
                        @elseif($application['embryos_number'] > 0 && $application['oocytes_number'] > 0)
                            {{$application['embryos_number']}} embryo(s) and {{$application['oocytes_number']}} oocyte(s)
                        @elseif($application['sperm_vials'] > 0 && $application['oocytes_number'] > 0)
                            {{$application['sperm_vials']}} semen vial(s) and {{$application['oocytes_number']}} oocyte(s)
                        @elseif($application['embryos_number'] > 0)
                            {{$application['embryos_number']}} embryo(s)
                        @elseif($application['sperm_vials'] > 0)
                            {{$application['sperm_vials']}} semen vial(s)
                        @elseif($application['oocytes_number'] > 0)
                            {{$application['oocytes_number']}} oocyte(s)
                        @else
                            no embryos, sperm, or oocytes
                        @endif                     
                        for the purpose of IVF/Surrogacy from {{$fromClinicName}},{{ $application['from_address'] }},{{ $application['f_district'] }},{{ $application['f_state'] }},{{ $application['f_pincode'] }} to {{$toClinicName}},{{ $application['to_address'] }},{{ $application['t_district'] }},{{ $application['t_state'] }},{{ $application['t_pincode'] }} in
                        accordance with section 29 of the Assisted Reproductive Technology (Regulation) Act, 2021 and
                        subject to the fulfillment of all provisions of the Assisted Reproductive Technology
                        (Regulation) Act, 2021 and Surrogacy (Regulation) Act, 2021 as per procedures involved /
                        applicable in your case.
                    </p>
                    <p style="font-size:14px;">It may be noted that exposure to X-ray may adversely influence the quality of embryos/ gametes.
                    </p>
                    <div class="card-body">
                        <div class="card-iec-number" style="float: left;">
                            <img src="data:image/png;base64, {!! base64_encode($qrcode) !!} " width="100" height="100">
                        </div>
                        <div class="signature" style="float: right;">
                            <p><strong>Yours faithfully,</strong></p>
                    <p><strong>(N. Sriramasubramanian)</strong><br>
                        <strong>Under Secretary to the Government of India</strong>
                    </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card-body">
            <div class="card-iec-number">
                <img src="data:image/png;base64, {!! base64_encode($qrcode) !!} " width="200" height="200">
            </div>
        </div> --}}
    </div>
</div>
   



</body>

</html>