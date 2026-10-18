<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOC Application Form</title>
    <style nonce="{{ $cspNonce }}">

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

        .applicant-detail-bc-cspnoc-thirtyone{
            background-color: #0b5ed7a1; text-align: left;
        }
        
    </style>
</head>
<body>
     <!-- Main Heading -->
     <div class="main-heading">Application form for transfer of Gametes (sperms/Oocyte)/Embryos (Within
        and Outside India)</div>
     <div class="application-number">
        Application No: {{ $application->application_no }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <tbody>
                    <!-- Applicant Details -->
                    <tr>
                        <th colspan="4" class="applicant-detail-bc-cspnoc-thirtyone">Applicant Details</th>
                    </tr>
                    <tr>
                                            <th>Name of the Applicant</th>
                                            <td>{{ $application->name_applicant ?? 'N/A' }}</td>                                                                                     
                                            <th>Marital Status</th>
                                            <td>{{ $application->m_status ?? 'N/A' }}</td>
                                        </tr>

                                     
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ $application->gender ??  'N/A' }}</td> 
                                            <th>Nationality of the Applicant</th>
                                            <td>{{ $application->nationality_applicant ?? 'N/A' }}</td> 
                                       </tr>

                                        @if ($application->nationality_applicant == 'Foreigner')
                                        <tr>
                                               <th>Country of the Applicant</th>
                                               <td>{{ $application->country_applicant ?? 'N/A' }}</td>
                                               <th>Address</th>
                                               <td>{{ $application->address ?? 'N/A' }}</td>                     
                                        </tr>
                                        @else
                                        <tr>
                                               <th>Country of the Applicant</th>
                                               <td>{{ $application->country_applicant ?? 'N/A' }}</td>
                                               <th>Address</th>
                                               <td >{{ $application->address ?? 'N/A' }}</td>                     
                                        </tr>
                                        @endif 
                                        <tr>
                                            
                                            @if ($application->country_applicant == 'India')
                                            <th>Pincode</th>
                                            <td>{{ $application->pincode ?? 'N/A' }}</td>
                                            <th>State</th>
                                            <td>{{ $application->state ?? 'N/A'  }}</td>
                                            @else
                                            <th>Zipcode</th>
                                            <td>{{ $application->zipcode ?? 'N/A' }}</td>
                                            <th>Contact Number</th>
                                            <td>{{ $application->countryCode ?? 'N/A'}}{{ $application->mobileno ?? 'N/A'}}</td>
                                            @endif
                                        </tr>
                                        @if ($application->country_applicant == 'India')
                                        <tr>
                                            
                                            <th>District</th>
                                            <td>{{ $application->district ?? 'N/A'  }}</td>
                                            <th>Email Address</th>
                                            <td>{{ $application->email ?? 'N/A'  }}</td>
                                        </tr>
                                         @endif
                                        <tr>
                                            
                                           
                                        </tr>
                                        <tr>
                                            <th>Aadhar Number</th>
                                            <td>{{ $application->aadhar_applicant ??  'N/A' }}</td>
                                            <th>Passport Number</th>
                                            @if($application->passport_applicant)
                                            <td>XXXXX{{ substr($application->passport_applicant, -4) }}</td>
                                            @else
                                            <td>N/A</td>
                                            @endif
                                        </tr>
                                        
                                         <tr>
                                            <th>PAN Number</th>
                                            @if($application->pan_applicant)
                                            <td>XXXXXX{{ substr($application->pan_applicant, -4) }}</td>
                                               @else
                                                 <td>N/A</td>
                                            @endif
                                            <th>Date of Birth</th>
                                            <td>
                                                {{ $application->dob_applicant ? \Carbon\Carbon::parse($application->dob_applicant)->format('d-m-Y') : 'N/A' }}
                                            </td>
                                        </tr>

                                           @if($application->oci_applicant)
                                         <tr>
                                            <th>Oci Number</th>
                                            <td>{{$application->oci_applicant ?? 'N/A'}}</td>   
                                        </tr>
                                        @endif
                                     @if($application->mobileno)
                                        <tr>
                                            <th>Mobile Number</th>
                                            <td>{{$application->countryCode ?? 'N/A'}} {{$application->mobileno ?? 'N/A'}}</td> 
                                            @endif 
                                            @if($application->oci_applicant)
                                            <th>Oci Number</th>
                                             <td>{{$application->oci_applicant ?? 'N/A'}}</td> 
                                             @endif  
                                        </tr>
                                   
                                            <!-- Spouse Details (Conditional Rendering) -->
                                            @if (!empty($application->name_spouse) || 
                                                !empty($application->aadhar_spouse) || 
                                                !empty($application->passport_spouse) || 
                                                !empty($application->pan_spouse) || 
                                                !empty($application->dob_spouse))
                                                <tr>
                                                    <th colspan="4" class="applicant-detail-bc-cspnoc-thirtyone">Spouse Details</th>
                                                </tr>
                                                <tr>
                                                <th>Name of the Spouse</th>
                                                <td>{{ $application->name_spouse ?? 'N/A'  }}</td>
                                                <th>Aadhar Number</th>
                                                <td>{{ $application->aadhar_spouse ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender Spouse</th>
                                                <td>{{ $application->gender_sp ?? 'N/A'  }}</td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Nationality of the Spouse</th>
                                                    <td>{{ $application->nationality_spouse ?? 'N/A' }}</td> 
                                                 @if($application->nationality_spouse == 'Foreigner')
                                                    <th>Country of the Spouse</th>
                                                <td>{{ $application->country_applicant_spouse ?? 'N/A' }}</td>
                                                @else
                                                 <th>Country of the Spouse</th>
                                                 <td>India</td>
                                                 @endif
                                            </tr>
                                            <tr>
                                                <th>Email of the Spouse</th>
                                                    <td>{{ $application->email_spouse ?? 'N/A'  }}</td> 
                                                    <th>Mobile Number of the Spouse </th>
                                                    <td>{{ $application->country_code_sp ?? 'N/A' }} {{ $application->mobile_spouse ?? 'N/A' }}</td>
                                            </tr>  
                                            <tr>
                                                <th>Passport Number</th>
                                                @if($application->passport_spouse)
                                                <td>XXXXX{{ substr($application->passport_spouse, -4) }}</td>
                                                @else
                                                <td>N/A</td>
                                                @endif
                                                <th>PAN Number</th>
                                                @if($application->pan_spouse)
                                                <td>XXXXXX{{ substr($application->pan_spouse, -4) }}</td>
                                                @else
                                                <td>N/A</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td>{{ \Carbon\Carbon::parse($application->dob_spouse)->format('d-m-Y') }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                             @if($application->oci_spouse)
                                         <tr>
                                            <th>Oci Number</th>
                                            <td>{{$application->oci_spouse ?? 'N/A'}}</td>   
                                        </tr>
                                        @endif
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    
                    <tbody>
                        <tr>
                            <th colspan="3" class="applicant-detail-bc-cspnoc-thirtyone">Transfer Details</th>
                        </tr>
                        @php
                            $count = 1;
                             // Convert the transfer_of string to an array if it's a comma-separated string
                            $transferOfArray = is_array($application->transfer_of) 
                                                ? $application->transfer_of 
                                                : explode(',', $application->transfer_of);
                        @endphp
                        
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>Transfer of</td>
                            <td>{{ $application->transfer_of ?? 'N/A' }}</td>
                        </tr>
                        @if(in_array('Embryos', $transferOfArray))
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>Quantity of Embryos</td>
                            <td>{{ $application->embryos_number ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        @if(in_array('Sperms', $transferOfArray))
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>Quantity of Sperms</td>
                            <td>{{ $application->sperm_vials ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        @if(in_array('Oocytes', $transferOfArray))
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>Quantity of Oocytes</td>
                            <td>{{ $application->oocytes_number ?? 'N/A' }}</td>
                        </tr>
                        @endif


                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>Purpose of Transfer</td>
                            <td>{{ $application->purpose_of_transfer ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>Transfer</td>
                            <td>{{ $application->transfer ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-header">
         
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                    </thead>
                    <tr>
                        <th colspan="2" class="">Transferring Clinic</th>
                    </tr>
                    <tbody>
                        <tr>                                           
                            <th>Status</th>
                            <td>{{ $application->status_from_clinic ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                           
                            <th>Clinic Type</th>
                            <td>{{ $application->status_clinic ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            @if (!empty($fromClinicName1))
                            <th>Name of the Clinic</th>
                            <td>{{ $fromClinicName1}}</td>
                            @elseif (!empty($fromClinicName))
                            <th>Name of the Clinic</th>
                            <td>{{ $fromClinicName}}</td>
                            @elseif (!empty($fromClinicName2))
                            <th>Name of the Clinic</th>
                            <td>{{ $fromClinicName2}}</td>
                            @endif 
                           
                        </tr>
                        @if (!empty($application->from_applicationno))
                        <tr>                                           
                            <th>Application Number</th>
                            <td>{{ $application->from_applicationno ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        @if (!empty($application->from_regno))
                        <tr>                                           
                            <th>Registration Number</th>
                            <td>{{ $application->from_regno ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        @if (!empty($application->from_doctor))
                                        <tr>                                           
                                            <th>Name of the Doctor</th>
                                            <td>{{ $application->from_doctor }}</td>
                                        </tr>
                                        @endif
                        <tr>                                           
                            <th>Address</th>
                            <td>{{ $application->from_address ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                            
                            <th>Pincode</th>
                            <td>{{ $application->f_pincode ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                            
                            <th>State</th>
                            <td>{{ $application->f_state ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                            
                            <th>District</th>
                            <td>{{ $application->f_district ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                            
                            <th>Contact Number</th>
                            <td>{{ $application->f_contact ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                            
                            <th>Email</th>
                            <td>{{ $application->f_email ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
               
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="2" class="applicant-detail-bc-cspnoc-thirtyone">Receiving Clinic</th>
                        </tr>
                        @php
                            $count = 1;
                        @endphp
                            <tr>                                           
                                <th>Status</th>
                                <td>{{ $application->to_status_from_clinic ?? 'N/A' }}</td>
                            </tr>
                            <tr>                                           
                                <th>Clinic Type</th>
                                <td>{{ $application->to_status_clinic.' '.'Clinic' ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                @if (!empty($application->to_name_clinic))
                                <th>Name of the Clinic</th>
                                <td>{{ clinicName($application->to_name_clinic) ?? 'N/A'}}</td>
                                @elseif (!empty($application->to_name_clinic1))
                                <th>Name of the Clinic</th>
                                <td>{{ $application->to_name_clinic1 ?? 'N/A'}}</td>
                                @elseif (!empty($application->to_name_clinic2))
                                <th>Name of the Clinic</th>
                                <td>{{ $application->to_name_clinic2 ?? 'N/A'}}</td>
                                @endif 
                            </tr>
                            @if (!empty($application->to_applicationno))
                            <tr>                                           
                                <th>Application Number</th>
                                <td>{{ $application->to_applicationno ?? 'N/A'}}</td>
                            </tr>
                            @endif
                            @if (!empty($application->to_regno))
                            <tr>                                           
                                <th>Registration Number</th>
                                <td>{{ $application->to_regno ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->to_doctor))
                                        <tr>                                           
                                            <th>Name of the Doctor</th>
                                            <td>{{ $application->to_doctor }}</td>
                                        </tr>
                                        @endif
                        @if (!empty($CountryName)) 
                        <tr>                                           
                            <th>Name of the Country</th>
                            <td>{{ $CountryName ?? 'N/A' }}</td>
                        </tr>
                        @endif

                         @if (!empty($CountryName)) 
                            <tr>
                                <th>Name of the Clinic</th>
                                <td>{{ $application->to_name_clinic2 ?? 'N/A'}}</td>
                            </tr>
                            @endif
                            <tr>
                                
                                <th>Address</th>
                                <td>{{ $application->to_address ?? 'N/A' }}</td>
                            </tr>
                            @if (!empty($application->t_pincode))
                            <tr>
                            
                                <th>Pincode</th>
                                <td>{{ $application->t_pincode ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->t_pincode))
                            <tr>
                            
                                <th>State</th>
                                <td>{{ $application->t_state ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->t_district))
                            <tr>
                            
                                <th>District</th>
                                <td>{{ $application->t_district ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->t_contact))
                            <tr>
                                
                                <th>Contact Number</th>
                                <td>{{ $application->t_contact ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            <tr>
                                
                                <th>Email</th>
                                <td>{{ $application->t_email ?? 'N/A' }}</td>
                            </tr>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                       
                    </thead>
                    <tbody>
                     
                        @php
                        $key = 1;
                        $foldername = sanitizeFolderName($application->application_no);
                        $applicant = 'applicant/';
                        $registry = 'registry/';

                        $fullPath1 = folderpath('noc_application_blade') . $foldername . '/' . $applicant;
                        $fullPath2 = folderpath('noc_application_blade') . $foldername . '/' . $registry;
                        @endphp
                        @foreach ($get_docfileData as $docfile)
                        @php
                            if($application->noc_userid == $docfile->noc_user_id) {
                                $filePath = $fullPath1 . $docfile->doc_upload_ref;    
                            }else {
                                $filePath = $fullPath2 . $docfile->doc_upload_ref;
                            }
                            $encryptedPath = encrypt($filePath);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $docfile->upload_desc }}</td>
                            <td>
                            <a href="{{ route('view.file', ['path' => $encryptedPath]) }}" class="link" target="_blank"><i class="fa fa-download"></i>Download</a>
                            </td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
