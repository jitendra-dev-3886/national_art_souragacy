<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <style nonce="{{$cspNonce}}">
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        .main-heading {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
            text-transform: uppercase;
        }
        .application-number {
            text-align: right;
            margin-right: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
            font-weight: bold;
        }
        .section-title {
            font-size: 18px;
            color: green;
            margin: 10px 0;
        }
        .card-body {
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .table-bordered {
            border: 1px solid #ddd;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table-bordered th {
            background-color: #f2f2f2;
        }
        .verticle-middle {
            vertical-align: middle;
        }
        .table-responsive-sm {
            overflow-x: auto;
        }
        th[colspan="4"] {
            font-weight: bold;
        }
        /* Add page-break for PDF */
        @page {
            margin: 20px;
        }
        .page-break {
            page-break-after: always;
        }
         td {
            word-wrap: break-word;
            white-space: normal;
        }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-table-header {
        background-color: #d3d8fd;
        text-align: center;
    }
    .csp-top-margin {
            margin-top: 50px;
        }
    </style>
   



</head>
<body>
     <!-- Main Heading -->
     <div class="main-heading">Application form for ART Clinic</div>
     <div class="application-number">
        @foreach($application as $application_num)
                           

                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> {{ $application_num->app_no->applicationno }}</h4>
    

                            @endforeach
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <tbody>
                    <!-- ART Clinic Details -->
                    <tr>
                     
                        <th colspan="10" class="csp-clinic-table-header">ART Clinic Details</th>
                    </tr>
                    
                    <!-- Application Details -->
                    @foreach($application as $application_no)
                    <tr>
                        <th colspan="3">Name of the Clinic</th>
                        <td colspan="7">{{ $application_no->clinicname }}</td> 
                    </tr>
                    <tr>
                        <th colspan="3">Address</th>
                        <td colspan="7">{{ $application_no->address }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">State</th>
                        <td colspan="2">{{ $application_no->state }}</td>
                        <th colspan="2">District</th>
                        <td colspan="2">{{ $application_no->district }}</td>
                        <th>Pincode</th>
                        <td>{{ $application_no->pincode }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Nature</th>
                        <td colspan="2">{{ $application_no->nature }}</td>
                        <th colspan="2">Email ID</th>
                        <td colspan="2">{{ $application_no->email }}</td>
                        <th>Contact Number</th>
                        <td>{{ $application_no->contactno }}</td>
                    </tr>
                    @foreach($application as $application_num)
                    <tr>
                        <th colspan="3">Fax</th>
                        <td colspan="3">{{ $application_no->fax ?? '-'}}</td>
                        <th colspan="2">Website</th>
                        <td colspan="2">{{ $application_no->website ?? '-'}}</td>
                    </tr>
                    @endforeach
            
                    <!-- Contact Person Details -->
                    <tr>
                        
                        <th colspan="10" class="csp-clinic-table-header">Contact Person Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name of the Contact Person</th>
                        <td>{{ $application_no->contact_person_name }}</td>
                        <th colspan="2">Mobile Number</th>
                        <td colspan="2">{{ $application_no->contact_person_mobile }}</td>
                    </tr>
              
                    <tr>
                        <th colspan="4">Date of Establishment</th>
                        <td colspan="6">{{$application_no->dateestab}}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Registered under MTP Act</th>
                        <td colspan="6">{{ $application_no->mtpact }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Registered under PCPNDT Act</th>
                        <td colspan="6">{{ $application_no->pcpndtact }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Director Available</th>
                        <td colspan="6">{{ $application_no->director }}</td>
                    </tr>
                    @endforeach
            
                    <!-- Directors -->
                    @if(trim($application_no->director) === 'Yes')
                    <tr>
                   
                        <th colspan="10" class="csp-clinic-table-header">Director Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name</th>
                        <th colspan="3">Qualification</th>
                        <th colspan="4">Registration No.</th>
                    </tr>
                    @foreach($directors as $director)
                    <tr>
                        <td colspan="3">{{ $director->name_director }}</td>
                        <td colspan="3">{{ $director->quali_director }}</td>
                        <td colspan="4">{{ $director->reg_director ?? '-'}}</td>
                    </tr>
                    @endforeach
                    @endif
                    <!-- Staff -->
                    <tr>
                       
                        <th colspan="10" class="csp-clinic-table-header">Staff Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Post</th>
                        <th colspan="3">Name</th>
                        <th colspan="2">Qualification</th>
                        <th colspan="2">Registration No.</th>
                    </tr>
                    @foreach($staff as $staffs)
                    <tr>
                        <td colspan="3">{{ $staffs->post_otherstaff }}</td>
                        <td colspan="3">{{ $staffs->name_otherstaff }}</td>
                        <td colspan="2">{{ $staffs->quali_otherstaff }}</td>
                        <td colspan="2">{{ $staffs->regno ?? '-'}}</td>
                    </tr>
                    @endforeach
            
                    <!-- Equipment -->
                    <tr>
                     
                        <th colspan="10" class="csp-clinic-table-header">Equipment Details</th>
                    </tr>
                    @foreach($equipment as $equipments)
                    <tr>
                        <td colspan="10">{{ $equipments->equipmentname }}</td>
                    </tr>
                    @endforeach
            
                    <!-- Procedures -->
                    <tr>
                       
                        <th colspan="10" class="csp-clinic-table-header">Procedures Undertaken</th>
                    </tr>
                    @foreach($application as $application_no)
                    <tr>
                        <th colspan="5">Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                        <td colspan="5">{{ $application_no->iuih }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                        <td colspan="5">{{ $application_no->iuid }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                        <td colspan="5">{{ $application_no->ivfet }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                        <td colspan="5">{{ $application_no->icsi }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Pre-implantation Genetic Testing (PGT)</th>
                        <td colspan="5">{{ $application_no->pgt }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                        <td colspan="5">{{ $application_no->spermandoocyte }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Any Other Procedure</th>
                        <td colspan="5">{{ $application_no->anyotherprocedure }}</td>
                    </tr>
                    @if(trim($application_no->anyotherprocedure) === 'Yes')
                    <tr>
                        <th colspan="5">If yes, please specify</th>
                        <td colspan="5">{{ $application_no->otherprocedure }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="5">Other Details</th>
                        <td colspan="5">{{ $application_no->otherdetails }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="application-number1">
                @foreach($application as $application_no)
                <p>Online Submission Date: {{ \Carbon\Carbon::parse($application_no->applicationno_datetime_submission)->format('Y-m-d') }} </p>
                @endforeach
            </div>

            {{-- <div class="application-number csp-top-margin">
                <h5 class="card-title sign-clinic-text-black ">
                    <strong>Name & Signature (with seal) of the ART Clinic Authority</strong>
                </h5>
            </div> --}}
            @if(False)
            <div class="csp-top-margin">
                <p>
                    **After submission, the PDF printout of the filled-in application form duly signed by the authorized signatory/ competent authority (with name & contact details) on behalf of the clinic/bank, shall be submitted electronically or by registered post or in-person to the Appropriate Authority under the Assisted Reproductive Technology (Regulation) Act, 2021 and The Surrogacy (Regulation) Act, 2021 through the office of Additional Chief Secretary (Health)/ Additional Secretary (Health)/ Principal Secretary (Health)/ Secretary (Health)/ Joint Secretary (Health) of the respective State/UT Government,
                    <b> within 07 days of online submission of the form alongwith the prescribed fees </b>
                </p>
            </div>
            @endif
        </div>
    </div>
    
   
  
    
</body>
</html>
