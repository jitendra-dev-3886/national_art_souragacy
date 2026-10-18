
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
    .signature-right {
    text-align: right;
    margin-top: 80px; /* space for signature and stamp */
    }
    </style>
   



</head>
<body>
     <!-- Main Heading -->
     @php
         $clinic_ = $application->clinic_type == 'ARTCLINIC' ? 'ART' : 'Surrogacy';
     @endphp
     <div class="main-heading">Change Address Application form for {{ $clinic_ }} Clinic</div>
     <div class="application-number">
         <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> {{ $application->applicationno }}</h4>
     </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <tbody>
                    <!-- ART Clinic Details -->
                    <tr>
                     
                        <th colspan="10" class="csp-clinic-table-header">{{ $clinic_ }} Clinic Details</th>
                    </tr>
                    
                    <!-- Application Details -->
                    <tr>
                        <th colspan="3">Name of the Clinic</th>
                        <td colspan="7">{{ $application->clinicname }}</td> 
                    </tr>
                    <tr>
                        <th colspan="3">Address</th>
                        <td colspan="7">{{ $application->address }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">State</th>
                        <td colspan="2">{{ $application->state }}</td>
                        <th colspan="2">District</th>
                        <td colspan="2">{{ $application->district }}</td>
                        <th>Pincode</th>
                        <td>{{ $application->pincode }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Nature</th>
                        <td colspan="2">{{ $application->nature }}</td>
                        <th colspan="2">Email ID</th>
                        <td colspan="2">{{ $application->email }}</td>
                        <th>Contact Number</th>
                        <td>{{ $application->contactno }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Fax</th>
                        <td colspan="3">{{ $application->fax ?? '-'}}</td>
                        <th colspan="2">Website</th>
                        <td colspan="2">{{ $application->website ?? '-'}}</td>
                    </tr>
            
                    <!-- Contact Person Details -->
                    <tr>
                        
                        <th colspan="10" class="csp-clinic-table-header">Contact Person Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name of the Contact Person</th>
                        <td>{{ $application->contact_person_name }}</td>
                        <th colspan="2">Mobile Number</th>
                        <td colspan="2">{{ $application->contact_person_mobile }}</td>
                    </tr>
              
                    <tr>
                        <th colspan="4">Date of Establishment</th>
                        <td colspan="6">{{ $application->dateestab }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Registered under MTP Act</th>
                        <td colspan="6">{{ $application->mtpact }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Registered under PCPNDT Act</th>
                        <td colspan="6">{{ $application->pcpndtact }}</td>
                    </tr>
                    <tr>
                        <th colspan="4">Director Available</th>
                        <td colspan="6">{{ $application->director }}</td>
                    </tr>
            
                    <!-- Directors -->
                    @if(trim($application->director) === 'Yes')
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
                        <td colspan="3">{{ $staffs->post }}</td>
                        <td colspan="3">{{ $staffs->name }}</td>
                        <td colspan="2">{{ $staffs->qualification }}</td>
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
                    <tr>
                        <th colspan="5">Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                        <td colspan="5">{{ $application->iuih }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                        <td colspan="5">{{ $application->iuid }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                        <td colspan="5">{{ $application->ivfet }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                        <td colspan="5">{{ $application->icsi }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Pre-implantation Genetic Testing (PGT)</th>
                        <td colspan="5">{{ $application->pgt }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                        <td colspan="5">{{ $application->spermandoocyte }}</td>
                    </tr>
                    <tr>
                        <th colspan="5">Any Other Procedure</th>
                        <td colspan="5">{{ $application->anyotherprocedure }}</td>
                    </tr>
                    @if(trim($application->anyotherprocedure) === 'Yes')
                    <tr>
                        <th colspan="5">If yes, please specify</th>
                        <td colspan="5">{{ $application->otherprocedure }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="5">Other Details</th>
                        <td colspan="5">{{ $application->otherdetails }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="signature-right">
                    <b>Name &amp; Signature (with seal) of the {{ $clinic_ }} Clinic Authority</b>
        </div>
    </div>
    
   
  
    
</body>
</html>
