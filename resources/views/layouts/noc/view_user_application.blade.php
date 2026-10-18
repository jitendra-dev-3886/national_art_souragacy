@extends('layouts.noc.noc_master')
@section('content')
<div class="container-fluid">
   
<style nonce="{{ $cspNonce }}">
    .table tbody tr td:last-child {
        text-align: start !important;
        padding-right: 1.563rem;
    }

    .bg-color-white-csp-noc-twenty-eight{
        background-color: #0b5ed7a1; 
        color:white;
    }
    
    .text-align-color-csp-noc-twenty-nine{
        text-align:end; color:white;
    }
    .text-align-csp-noc-thirty{
        text-align: left;
    }
    .bc-text-align-cspnoc-thirty-one{
        background-color: #0b5ed7a1; color:white; text-align: center;
    }
    .color-csp-noc-thirty-two{
       color:#0b5ed7a1;
    }
    .bg-color-br-color{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success col-xs-12 bg-color-white-csp-noc-twenty-eight">
                <h4 class="text-align-color-csp-noc-twenty-nine">Application Number: {{ $application->application_no }}</h4>
            </div>

            <form action="" method="POST">
                @csrf
                <div class="card text-align-csp-noc-thirty">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title color-csp-noc-thirty-two">Personal Details</h4>
                            <a href="{{ route('noc.nocgeneratePdf', ['id' => Crypt::encrypt($application->id)]) }}" class="link btn btn-primary bg-color-br-color" target="_blank">
                                Download PDF
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <tbody>
                                        <!-- Applicant Details -->
                                        <tr>
                                            <th colspan="4" class="bc-text-align-cspnoc-thirty-one">Applicant Details</th>
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
                                    

                                    @if($application->m_status == 'Married')
                                       
                                            <tr>
                                                <th colspan="4" class="bc-text-align-cspnoc-thirty-one">Spouse Details</th>
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
                    </div>
                    
                    
                    <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title color-csp-noc-thirty-two">Transfer Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                     
                                    </thead>
                                    <tbody>
                                        @php
                                           
                                            $transferOfArray = is_array($application->transfer_of) 
                                                                ? $application->transfer_of 
                                                                : explode(',', $application->transfer_of);
                                        @endphp
                    
                                        <tr>
                                           
                                            <th>Transfer of</th>
                                            <td>{{ $application->transfer_of ?? 'N/A' }}</td>
                                        </tr>
                                        @if(in_array('Embryos', $transferOfArray))
                                        <tr>
                                           
                                            <th>Quantity of Embryos</th>
                                            <td>{{ $application->embryos_number ?? 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if(in_array('Sperms', $transferOfArray))
                                        <tr>
                                           
                                            <th>Quantity of Sperms</th>
                                            <td>{{ $application->sperm_vials ?? 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if(in_array('Oocytes', $transferOfArray))
                                        <tr>
                                           
                                            <th>Quantity of Oocytes</th>
                                            <td>{{ $application->oocytes_number ?? 'N/A' }}</td>
                                        </tr>
                                        @endif


                                        <tr>
                                            
                                            <th>Purpose of Transfer</th>
                                            <td>{{ $application->purpose_of_transfer ? $application->purpose_of_transfer : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                           
                                            <th>Transfer</th>
                                            <td>{{ $application->transfer ? $application->transfer : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title color-csp-noc-thirty-two">Transferring Clinic</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    
                                    <tbody>
                                     
                                        <tr>                                           
                                            <th>Status</th>
                                            <td>{{ $application->status_from_clinic ? $application->status_from_clinic : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                           
                                            <th>Clinic Type</th>
                                            <td>{{ $application->status_clinic ? $application->status_clinic." ".'Clinic' : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            {{-- <td>{{ $count++ }}</td> --}}
                                            @if (!empty($fromClinicName1))
                                            <th>Name of the Clinic</th>
                                            <td>{{ $fromClinicName1 ?? 'N/A'}}</td>
                                            @elseif (!empty($fromClinicName))
                                            <th>Name of the Clinic</th>
                                            <td>{{ $fromClinicName ?? 'N/A'}}</td>
                                            @elseif (!empty($fromClinicName2))
                                            <th>Name of the Clinic</th>
                                            <td>{{ $fromClinicName2 ?? 'N/A'}}</td>
                                            @endif 
                                           
                                        </tr>
                                        @if (!empty($application->from_applicationno))
                                        <tr>                                           
                                            <th>Application Number</th>
                                            <td>{{ $application->from_applicationno ? $application->from_applicationno : 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->from_regno))
                                        <tr>                                           
                                            <th>Registration Number</th>
                                            <td>{{ $application->from_regno ? $application->from_regno : 'N/A' }}</td>
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
                                            <td>{{ $application->from_address ? $application->from_address : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>Pincode</th>
                                            <td>{{ $application->f_pincode ? $application->f_pincode : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>State</th>
                                            <td>{{ $application->f_state ? $application->f_state : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>District</th>
                                            <td>{{ $application->f_district ? $application->f_district : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>Contact Number</th>
                                            <td>{{ $application->f_contact ? $application->f_contact : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>Email</th>
                                            <td>{{ $application->f_email ? $application->f_email : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title color-csp-noc-thirty-two">Receiving Clinic</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        
                                        <tr>                                           
                                            <th>Status</th>
                                            <td>{{ $application->to_status_from_clinic ? $application->to_status_from_clinic : 'N/A' }}</td>
                                        </tr>
                                        <tr>                                           
                                            <th>Clinic Type</th>
                                            <td>{{ $application->to_status_clinic ? $application->to_status_clinic : 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            {{-- <td>{{ $count++ }}</td> --}}
                                            @if (!empty($toClinicName1))
                                            <th>Name of the Clinic</th>
                                            <td>{{ $toClinicName1 ?? 'N/A'}}</td>
                                            @elseif (!empty($fromClinicName))
                                            <th>Name of the Clinic</th>
                                            <td>{{ $toClinicName ?? 'N/A'}}</td>
                                            @elseif (!empty($fromClinicName2))
                                            <th>Name of the Clinic</th>
                                            <td>{{ $toClinicName2 ?? 'N/A'}}</td>
                                            @endif 
                                        </tr>
                                        @if (!empty($application->to_applicationno))
                                        <tr>                                           
                                            <th>Application Number</th>
                                            <td>{{ $application->to_applicationno ? $application->to_applicationno : 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->to_regno))
                                        <tr>                                           
                                            <th>Registration Number</th>
                                            <td>{{ $application->to_regno ? $application->to_regno : 'N/A' }}</td>
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
                                           <td>{{ $CountryName ? $CountryName : 'N/A' }}</td>
                                       </tr>
                                       @endif
                                        </tr>
                                       
                                        @if (!empty($application->to_name_clinic2)) 
                                        <tr>
                                            
                                            <th>Name of the Clinic</th>
                                            <td>{{ $application->to_name_clinic2 ? $application->to_name_clinic2 : 'N/A'}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $application->to_address ? $application->to_address : 'N/A' }}</td>
                                        </tr>
                                        @if (!empty($application->t_pincode))
                                        <tr>
                                           
                                            <th>Pincode</th>
                                            <td>{{ $application->t_pincode ? $application->t_pincode : 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->t_pincode))
                                        <tr>
                                           
                                            <th>State</th>
                                            <td>{{ $application->t_state ? $application->t_state : 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->t_district))
                                        <tr>
                                           
                                            <th>District</th>
                                            <td>{{ $application->t_district ? $application->t_district : 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->t_contact))
                                        <tr>
                                            
                                            <th>Contact Number</th>
                                            <td>{{ $application->t_contact ? $application->t_contact : 'N/A' }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            
                                            <th>Email</th>
                                            <td>{{ $application->t_email ? $application->t_email : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title color-csp-noc-thirty-two">Documents</h4>
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
                                               <a href="{{ route('view.file', ['path' => $encryptedPath]) }}" class="link" target="_blank">
                                               <i class="fa fa-download"></i>
                                             </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection