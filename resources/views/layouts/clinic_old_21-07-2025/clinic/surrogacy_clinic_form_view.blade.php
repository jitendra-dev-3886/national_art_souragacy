@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container-fluid">   
    <style nonce="{{$cspNonce}}">
    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
    .csp-clinic-card-left {
        text-align: left;
    }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-btn-primary {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-table-header {
        background-color: #d3d8fd;
        text-align: center;
    }
</style>


    <div class="row">
        <div class="col-12">
            {{-- <div class="alert alert-success col-xs-12" style="text-align:end; color: black;">                
                @foreach($application as $application_num)
                <p><strong>Application Number:</strong> {{ $application_num->app_no->applicationno }}</p>
                @endforeach
            </div> --}}

            <form action="" method="POST">
                @csrf
                
                <div class="card csp-clinic-card-left">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{-- <h4 class="card-title" style="color:green;"></h4> --}}
                            @foreach($application as $application_num)
                           
                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> {{ $application_num->sapp_no->applicationno }}</h4>

                            @endforeach
                         
                            <a href="{{ route('clinic.sclinicgeneratePdf', ['id' => Crypt::encrypt($application_num->id)]) }}" 
                                class="link btn btn-primary csp-clinic-btn-primary" target="_blank">
                                    Download PDF
                                </a>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                            
                                            <th colspan="8" class="csp-clinic-table-header">Surrogacy Clinic Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                        @foreach($application as $application_no)
                                         <tr>
                                            <th colspan="2">Name of the Clinic</th>
                                            <td colspan="8">{{ $signup_data->clinicname }}</td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">Address</th>
                                            <td colspan="8">{{ $signup_data->address }}</td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">State</th>
                                            <td>{{ $signup_data->state }}</td>                                                                                     
                                            <th>District</th>
                                            <td>{{ $signup_data->district }}</td>
                                            <th>Pincode</th>
                                            <td>{{ $signup_data->pincode }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Nature</th>
                                            <td>{{ $signup_data->nature }}</td>                                                                                     
                                            <th>Email ID</th>
                                            <td>{{ $signup_data->email }}</td>
                                            <th>Contact Number</th>
                                            <td>{{ $signup_data->contactno }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Fax</th>
                                            <td colspan="2">{{ $application_no->fax ?? '-'}}</td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2">{{ $application_no->website ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your Surrogacy Clinic</th>                                            
                                            <td colspan="8">{{ \Carbon\Carbon::parse($application_no->dateestab)->format('m-d-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic is registered under MTP Act</th>
                                            <td>{{ $application_no->mtpact }}</td>
                                            <th colspan="2">Whether your ART Clinic is registered under PCPNDT Act</th>
                                            <td colspan="2">{{ $application_no->pcpndtact }}</td>
                                        </tr>  
                                        
                                        <tr>
                                        
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                        <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td colspan="2">{{ $signup_data->personname }}</td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2">{{ $signup_data->mobile }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8">{{ $signup_data->email_contact_person }}</td>
                                            
                                        </tr>
                                                                            
                                        <tr>
                                               <th colspan="8" class="csp-clinic-table-header">Details of the Director Available at your Surrogacy Clinic</th>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic has Director</th>
                                            <td colspan="8">{{ $application_no->director }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Name</th>
                                            <th colspan="2">Qualification</th>
                                            <th colspan="3">Registration No. (if applicable)</th>
                                        </tr>
                                        @foreach($directors as $director)
                                        <tr>
                                            <td colspan="2">{{ $director->name_director }}</td>
                                            <td colspan="2">{{ $director->quali_director }}</td>
                                            <td colspan="3">{{ $director->reg_director ?? '-'}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                               <th colspan="8" class="csp-clinic-table-header">Details of the Staff Available at your Surrogacy Clinic</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Name of the Post</th>
                                            <th colspan="2">Name of the Staff</th>
                                            <th colspan="2">Qualification</th>
                                            <th colspan="2">Registration No (if applicable)</th>
                                        </tr>
                                        @foreach($staff as $staffs)
                                        <tr>
                                            <td colspan="2">{{ $staffs->post_otherstaff }}</td>
                                            <td colspan="2">{{ $staffs->name_otherstaff }}</td>
                                            <td colspan="2">{{ $staffs->quali_otherstaff }}</td>
                                            <td colspan="2">{{ $staffs->regno ?? '-'}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                              <th colspan="8" class="csp-clinic-table-header">Equipment Details</th>
                                        </tr>
                                        <tr>
                                            <th colspan="8">Name of Equipments</th>                                            
                                        </tr>
                                        @foreach($equipment as $equipments)
                                        <tr>
                                            <td colspan="8">{{ $equipments->equipmentname }}</td>                                           
                                        </tr>
                                        @endforeach
                                        <tr>
                                          <th colspan="8" class="csp-clinic-table-header">Procedure Undertaken</th>
                                        </tr>
                                        @foreach($application as $application_no)
                                        <tr>
                                            <th colspan="2"> Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                                            <td>{{ $application_no->iuih }}</td>
                                            <th colspan="2">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                                            <td colspan="2">{{ $application_no->iuid }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">  In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                                            <td>{{ $application_no->ivfet }}</td>
                                            <th colspan="2">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                                            <td colspan="2">{{ $application_no->icsi }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Pre-implantation Genetic Testing (PGT)</th>
                                            <td>{{ $application_no->pgt }}</td>
                                            <th colspan="2">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                                            <td colspan="2">{{ $application_no->spermandoocyte }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Any Other Procedure</th>
                                            <td>{{ $application_no->anyotherprocedure }}</td>
                                            <th colspan="2">If yes, please specify</th>
                                            <td colspan="2">{{ $application_no->otherprocedure }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">Any Other Details</th>
                                            <td colspan="8">{{ $application_no->otherdetails }}</td>
                                        </tr>
                                        @endforeach 
                                        {{-- <tr>                                                                                                                            
                                            <th colspan="2">Whether your ART Clinic is registered under MTP Act</th>
                                            <td>{{ $application->mtpact }}</td>
                                            <th colspan="2">Whether your ART Clinic is registered under PCPNDT Act</th>
                                            <td colspan="2">{{ $application->pcpndtact }}</td>
                                        </tr> --}}
                                        {{-- @if (empty($application->country_applicant))
                                        <tr>
                                            <th colspan="2">Nationality of the Applicant</th>
                                            <td colspan="2">{{ $application->nationality_applicant }}</td> 
                                        </tr>
                                        @elseif (!empty($application->country_applicant))
                                        <tr>
                                            <th>Nationality of the Applicant</th>
                                                <td>{{ $application->nationality_applicant }}</td>                            
                                                <th>Country of the Applicant</th>
                                                <td>{{ $application->country_applicant }}</td>                     
                                        </tr>
                                        @endif 
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $application->address }}</td>
                                            <th>Pincode</th>
                                            <td>{{ $application->pincode }}</td>
                                        </tr>
                                        <tr>
                                            <th>State</th>
                                            <td>{{ $application->state }}</td>
                                            <th>District</th>
                                            <td>{{ $application->district }}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td>{{ !empty($application->contactno) ? $application->contactno : 'N/A' }}</td>
                                            <th>Email Address</th>
                                            <td>{{ $application->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Aadhar Number</th>
                                            <td>XXXXXXXX{{ substr($application->aadhar_applicant, -4) }}</td>
                                            <th>Passport Number</th>
                                            <td>XXXXX{{ substr($application->passport_applicant, -4) }}</td>
                                        </tr>
                                        <tr>
                                            <th>PAN Number</th>
                                            <td>XXXXXX{{ substr($application->pan_applicant, -4) }}</td>
                                            <th>Date of Birth</th>
                                            <td>
                                                {{ $application->dob_applicant ? \Carbon\Carbon::parse($application->dob_applicant)->format('d-m-Y') : 'N/A' }}
                                            </td>
                                        </tr>
                    
                                        <!-- Spouse Details (Conditional Rendering) -->
                                        @if (!empty($application->name_spouse) || 
                                             !empty($application->aadhar_spouse) || 
                                             !empty($application->passport_spouse) || 
                                             !empty($application->pan_spouse) || 
                                             !empty($application->dob_spouse))
                                            <tr>
                                                <th colspan="4" style="background-color: #fdd3d9; text-align: center;">Spouse Details</th>
                                            </tr>
                                            <tr>
                                                <th>Name of the Spouse</th>
                                                <td>{{ $application->name_spouse }}</td>
                                                <th>Aadhar Number</th>
                                                <td>XXXXXXXX{{ substr($application->aadhar_spouse, -4) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nationality of the Spouse</th>
                                                    <td>{{ $application->nationality_spouse }}</td> 
                                                    <th>Country of the Spouse</th>
                                                    <td>{{ $application->country_spouse }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email of the Spouse</th>
                                                    <td>{{ $application->email_spouse }}</td> 
                                                    <th>Mobile Number of the Spouse</th>
                                                    <td>{{ $application->mobile_spouse }}</td>
                                            </tr>  
                                            <tr>
                                                <th>Passport Number</th>
                                                <td>XXXXX{{ substr($application->passport_spouse, -4) }}</td>
                                                <th>PAN Number</th>
                                                <td>XXXXXX{{ substr($application->pan_spouse, -4) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td>{{ \Carbon\Carbon::parse($application->dob_spouse)->format('d-m-Y') }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr> --}}
                                        {{-- @endif --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    


                    {{-- <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title" style="color:green;">Purpose Details</h4>
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
                                            <td>{{ $application->transfer_of }}</td>
                                        </tr>
                                        @if(in_array('Embryos', $transferOfArray))
                                        <tr>
                                           
                                            <th>Quantity of Embryos</th>
                                            <td>{{ $application->embryos_number }}</td>
                                        </tr>
                                        @endif
                                        @if(in_array('Sperms', $transferOfArray))
                                        <tr>
                                           
                                            <th>Quantity of Sperms</th>
                                            <td>{{ $application->sperm_vials }}</td>
                                        </tr>
                                        @endif
                                        @if(in_array('Oocytes', $transferOfArray))
                                        <tr>
                                           
                                            <th>Quantity of Oocytes</th>
                                            <td>{{ $application->oocytes_number }}</td>
                                        </tr>
                                        @endif


                                        <tr>
                                            
                                            <th>Purpose of Transfer</th>
                                            <td>{{ $application->purpose_of_transfer }}</td>
                                        </tr>
                                        <tr>
                                           
                                            <th>Transfer</th>
                                            <td>{{ $application->transfer }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    

                    {{-- <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title" style="color:green;">From Clinic</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        @php
                                           
                                        @endphp
                    
                                        <tr>
                                          
                                            <th>Name of the Clinic</th>
                                            <td>{{ $fromClinicName }}</td>
                                        </tr>
                                        <tr>                                           
                                            <th>Address</th>
                                            <td>{{ $application->from_address }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>Pincode</th>
                                            <td>{{ $application->f_pincode }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>State</th>
                                            <td>{{ $application->f_state }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>District</th>
                                            <td>{{ $application->f_district }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>Contact Number</th>
                                            <td>{{ $application->f_contact }}</td>
                                        </tr>
                                        <tr>                                            
                                            <th>Email</th>
                                            <td>{{ $application->f_email }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title" style="color:green;">To Clinic</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                       
                                    </thead>
                                    <tbody>
                                        @php
                                            
                                           
                                        @endphp
                                       @if (!empty($CountryName)) 
                                       <tr>                                           
                                           <th>Name of the Country</th>
                                           <td>{{ $CountryName }}</td>
                                       </tr>
                                       @endif
                                       @if (!empty($toClinicName)) 
                                        <tr>                                            
                                            <th>Name of the Clinic</th>
                                            <td>{{ $toClinicName}}</td>
                                            
                                        </tr>
                                        @endif
                                        @if (!empty($CountryName)) 
                                        <tr>
                                            
                                            <th>Name of the Clinic</th>
                                            <td>{{ $application->to_name_clinic2}}</td>
                                            
                                        </tr>
                                        @endif
                                        <tr>
                                            
                                            <th>Address</th>
                                            <td>{{ $application->to_address }}</td>
                                        </tr>
                                        @if (!empty($application->t_pincode))
                                        <tr>
                                           
                                            <th>Pincode</th>
                                            <td>{{ $application->t_pincode }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->t_pincode))
                                        <tr>
                                           
                                            <th>State</th>
                                            <td>{{ $application->t_state }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->t_district))
                                        <tr>
                                           
                                            <th>District</th>
                                            <td>{{ $application->t_district }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->t_contact))
                                        <tr>
                                            
                                            <th>Contact Number</th>
                                            <td>{{ $application->t_contact }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            
                                            <th>Email</th>
                                            <td>{{ $application->t_email }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    
                    <!-- Other Sections: Purpose Details, Clinic Details, Documents, etc. -->
                    <!-- Similar structure as the Personal Details section above -->

                    {{-- <div class="col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title" style="color:green;">Documents</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>                                     
                                    </thead>
                                    <tbody>                                      
                                        @php
                                        $docTypeMapping = [                                          
                                            'target_file_affidavit_embryos_outside' => 'Form: 17 (Affidavit for transfer of embryos outside
                                            India)',
                                            'target_file_affidavit_gametes_outside' => 'Form: 18 (Affidavit for transfer of gametes (sperm/oocyte) outside India)',
                                            'target_file_affidavit_embryos_within'  => 'Form: 19 (Affidavit for transfer of embryos within
                                                                                        India)',
                                            'target_file_affidavit_gametes_within'  =>  'Form: 20 (Affidavit for transfer of gametes (sperms/oocytes) within India)',
                                            'target_file_affidavit_clinic_holding_embryos' =>  'Form: 21 (Affidavit from the clinic holding the frozen embryos)',
                                            'target_file_affidavit_clinic_holding_gametes' =>  'Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))',
                                            'target_file_affidavit_clinic_receiving_embryos' =>  'Form: 23 (Affidavit from clinic receiving the frozen embryos)',
                                            'target_file_affidavit_clinic_receiving_gametes' =>  'Form: 24 (Affidavit from clinic receiving the frozen gametes)',
                                            'target_file_copy_aadhar' => 'Copy of Aadhar Card of Applicant',
                                            'target_file_copy_passport' => 'Copy of Passport Card of Applicant',
                                            'target_file_copy_aadhar_card_spouse' => 'Copy of Aadhar Card of Spouse',
                                            'target_file_copy_passport_spouse' => 'Copy of Passport of Spouse',
                                            'target_file_ssn' => 'Copy of SSN (If Person of Indian Origin/Foreigner)',
                                            'target_file_dob_proof_applicant' => 'Date of Birth proof of Applicant',
                                            'target_file_dob_proof_spouse' => 'Date of Birth proof of Spouse',
                                            'target_file_sign_applicant' => 'Declaration of the Applicant',
                                            'target_file_sign_spouse' => 'Declaration of the Spouse',
                                            'target_file_other_docs' => 'Medical Record/Document',

                                            
                                           




                                        ];
                                    @endphp

                                    @php
                                        $key = 1;
                                    @endphp
                                        @foreach ($get_docfileData as $docfile)
                                        
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $docTypeMapping[$docfile->doc_type] ?? $docfile->doc_type }}</td>
                                            <td>
                                                @if ($docfile->doc_id == 3 && $docfile->doc_type == 'target_file_affidavit_embryos_within')
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
                                                    @elseif ($docfile->doc_id == 23 && $docfile->doc_type == 'target_file_sign_spouse')
                                                    <a href="{{ asset('noc_documents/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                        <i class="fa fa-download"></i>
                                                    </a>  
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach                                         
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </form>
        </div>
    </div>
</div>
@endsection