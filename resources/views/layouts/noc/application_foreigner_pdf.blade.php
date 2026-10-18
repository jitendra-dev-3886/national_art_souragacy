<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOC Application Form</title>
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
    </style>
</head>
<body>
     <!-- Main Heading -->
     <div class="main-heading">Application form for transfer of Gametes (sperms Oocyte)/Embryos (Within
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
                        <th colspan="4" style="background-color: #0b5ed7a1; text-align: left;">Applicant Details</th>
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
                                            <td>{{ $application->mobileno ?? 'N/A'}}</td>
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

                                        <!-- Spouse Details (Conditional Rendering) -->
                                        @if (!empty($application->name_spouse) || 
                                            !empty($application->aadhar_spouse) || 
                                            !empty($application->passport_spouse) || 
                                            !empty($application->pan_spouse) || 
                                            !empty($application->dob_spouse))
                                            <tr>
                                                <th colspan="4" style="background-color: #0b5ed7a1; text-align: left;">Spouse Details</th>
                                            </tr>
                                            <tr>
                                                <th>Name of the Spouse</th>
                                                <td>{{ $application->name_spouse ?? 'N/A'  }}</td>
                                                <th>Aadhar Number</th>
                                                <td>{{ $application->aadhar_spouse ?? 'N/A' }}</td>
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
                                                    <td>{{ $application->mobile_spouse ?? 'N/A' }}</td>
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
    
            {{-- <h4 class="card-title" style="color:green;">Purpose Details</h4> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    
                    <tbody>
                        <tr>
                            <th colspan="3" style="background-color: #0b5ed7a1; text-align: left;">Transfer Details</th>
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
            {{-- <h4 class="card-title" style="color:green;">From Clinic</h4> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                        {{-- <tr>
                            <th>ID</th>
                            <th>Particulars</th>
                            <th>Details</th>
                        </tr> --}}
                    </thead>
                    <tr>
                        <th colspan="2" style="background-color: #0b5ed7a1; text-align: left;">Transferring Clinic</th>
                    </tr>
                    <tbody>
                        @php
                            //$count = 1;
                        @endphp
                        <tr>                                           
                            <th>Status</th>
                            <td>{{ $application->status_from_clinic ?? 'N/A' }}</td>
                        </tr>
                        <tr>                                           
                            <th>Clinic Type</th>
                            <td>{{ $application->status_clinic ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            {{-- <td>{{ $count++ }}</td> --}}
                            @if (!empty($fromClinicName))
                            <th>Name of the Clinic</th>
                            <td>{{ $fromClinicName}}</td>
                            @elseif (!empty($fromClinicName1))
                            <th>Name of the Clinic</th>
                            <td>{{ $fromClinicName1}}</td>
                            @elseif(!empty($fromClinicName2))
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
            {{-- <h4 class="card-title" style="color:green;">To Clinic</h4> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                        {{-- <tr>
                            <th>ID</th>
                            <th>Particulars</th>
                            <th>Details</th>
                        </tr> --}}
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="2" style="background-color: #0b5ed7a1; text-align: left;">Receiving Clinic</th>
                        </tr>
                        @php
                            $count = 1;
                        @endphp
                            <tr>                                           
                                <th>Status</th>
                                <td>{{ $application->to_status_from_clinic ?? 'N/A' }}</td>
                            </tr>
                            <tr>                                           
                                <th>Clinic</th>
                                <td>{{ $application->to_status_clinic ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                {{-- <td>{{ $count++ }}</td> --}}
                                @if (!empty($toClinicName))
                                <th>Name of the Clinic</th>
                                <td>{{ $toClinicName ?? 'N/A'}}</td>
                                @elseif (!empty($toClinicName1))
                                <th>Name of the Clinic</th>
                                <td>{{ $toClinicName1 ?? 'N/A'}}</td>
                                @elseif (!empty($toClinicName2))
                                <th>Name of the Clinic</th>
                                <td>{{ $toClinicName2 ?? 'N/A'}}</td>
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
                            {{-- @if (!empty($CountryName)) 
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Name of the Country</td>
                                <td>{{ $CountryName ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($toClinicName)) 
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Name of the Clinic</td>
                                <td>{{ $toClinicName ?? 'N/A'}}</td>
                               
                            </tr>
                            @endif
                            @if (!empty($CountryName)) 
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Name of the Clinic</td>
                                <td>{{ $application->to_name_clinic2 ?? 'N/A'}}</td>
                                
                            </tr>
                            @endif
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Address</td>
                                <td>{{ $application->to_address ?? 'N/A' }}</td>
                            </tr>
                            @if (!empty($application->t_pincode))
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Pincode</td>
                                <td>{{ $application->t_pincode ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->t_pincode))
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>State</td>
                                <td>{{ $application->t_state ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->t_district))
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>District</td>
                                <td>{{ $application->t_district ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            @if (!empty($application->t_contact))
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Contact Number</td>
                                <td>{{ $application->t_contact ?? 'N/A' }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>Email</td>
                                <td>{{ $application->t_email ?? 'N/A' }}</td>
                            </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card-header">
            {{-- <h4 class="card-title" style="color:green;">Documents</h4> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                    <thead>
                       
                    </thead>
                    <tbody>
                     
                        @php
                    //     $docTypeMapping = [
                          
                    //         'target_file_affidavit_embryos_outside' => 'Form: 17 (Affidavit for transfer of embryos outside
                    //         India)',
                    //         'target_file_affidavit_gametes_outside' => 'Form: 18 (Affidavit for transfer of gametes (sperm/oocyte) outside India)',
                    //         'target_file_affidavit_embryos_within'  => 'Form: 19 (Affidavit for transfer of embryos within
                    //                                                     India)',
                    //         'target_file_affidavit_gametes_within'  =>  'Form: 20 (Affidavit for transfer of gametes (sperms/oocytes) within India)',
                    //         'target_file_affidavit_clinic_holding_embryos' =>  'Form: 21 (Affidavit from the clinic holding the frozen embryos)',
                    //         'target_file_affidavit_clinic_holding_gametes' =>  'Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))',
                    //         'target_file_affidavit_clinic_receiving_embryos' =>  'Form: 23 (Affidavit from clinic receiving the frozen embryos)',
                    //         'target_file_affidavit_clinic_receiving_gametes' =>  'Form: 24 (Affidavit from clinic receiving the frozen gametes)',
                    //         'target_file_copy_aadhar' => 'Copy of Aadhar Card of Applicant',
                    //         'target_file_copy_passport' => 'Copy of Passport Card of Applicant',
                    //         'target_file_copy_aadhar_card_spouse' => 'Copy of Aadhar Card of Spouse',
                    //         'target_file_copy_passport_spouse' => 'Copy of Passport of Spouse',
                    //         'target_file_ssn' => 'Copy of SSN (If Person of Indian Origin/Foreigner)',
                    //         'target_file_dob_proof_applicant' => 'Date of Birth proof of Applicant',
                    //         'target_file_dob_proof_spouse' => 'Date of Birth proof of Spouse',
                    //         'target_file_sign_applicant' => 'Declaration of the Applicant',
                    //         'target_file_other_docs' => 'Medical Record/Document',
                    //         'copy_of_identity_proof_applicant' => 'copy_of_identity_proof_applicant',
                    //         'copy_of_identity_proof_spouse' => 'copy_of_identity_proof_spouse',
                    //         'oci_applicant' => 'oci_applicant_file', 
                    //         'oci_spouse' => 'oci_spouse_file',  
                    //         'front_attachment' => 'front_attachment',
                    //         'back_attachment' => 'back_attachment',
                            
                    //     ];
                    // @endphp

                    @php
                        $key = 1;
                    @endphp
                        @foreach ($get_docfileData as $docfile)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $docfile->upload_desc }}</td>
                            <td><a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                <i class="fa fa-download"></i>Download
                            </a>


                                {{-- @if ($docfile->doc_id == 3 && $docfile->doc_type == 'target_file_affidavit_embryos_within')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 1 && $docfile->doc_type == 'target_file_affidavit_embryos_outside')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 2 && $docfile->doc_type == 'target_file_affidavit_gametes_outside')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 3 && $docfile->doc_type == 'target_file_affidavit_embryos_within')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 4 && $docfile->doc_type == 'target_file_copy_aadhar')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 5 && $docfile->doc_type == 'target_file_copy_passport')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 6 && $docfile->doc_type == 'target_file_copy_aadhar_card_spouse')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 7 && $docfile->doc_type == 'target_file_copy_passport_spouse')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 8 && $docfile->doc_type == 'target_file_ssn')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 9 && $docfile->doc_type == 'target_file_dob_proof_applicant')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 10 && $docfile->doc_type == 'target_file_dob_proof_spouse')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 13 && $docfile->doc_type == 'target_file_other_docs')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 15 && $docfile->doc_type == 'target_file_affidavit_gametes_within')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 16 && $docfile->doc_type == 'target_file_affidavit_clinic_holding_embryos')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 17 && $docfile->doc_type == 'target_file_affidavit_clinic_holding_gametes')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 18 && $docfile->doc_type == 'target_file_affidavit_clinic_receiving_embryos')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @elseif ($docfile->doc_id == 19 && $docfile->doc_type == 'target_file_affidavit_clinic_receiving_gametes')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a>  
                                    @elseif ($docfile->doc_id == 22 && $docfile->doc_type == 'target_file_sign_applicant')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 

                                     @elseif ($docfile->doc_id == 26 && $docfile->doc_type == 'copy_of_identity_proof_applicant')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 

                                     @elseif ($docfile->doc_id == 27 && $docfile->doc_type == 'copy_of_identity_proof_spouse')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 

                                      @elseif ($docfile->doc_id == 28 && $docfile->doc_type == 'oci_applicant_file')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 

                                      @elseif ($docfile->doc_id == 29 && $docfile->doc_type == 'oci_spouse_file')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 

                                    @elseif ($docfile->doc_id == 24 && $docfile->doc_type == 'front_attachment')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 

                                     @elseif ($docfile->doc_id == 25 && $docfile->doc_type == 'back_attachment')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 
                                    
                                    @elseif ($docfile->doc_id == 8 && $docfile->doc_type == 'target_file_ssn')
                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                        <i class="fa fa-download"></i>
                                    </a> 
                                @endif --}}
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
