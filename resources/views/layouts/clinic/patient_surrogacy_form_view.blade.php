@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
    .csp-clinic-banner {
        background-color: #0b5ed7a1;
        color: white;
    }

    .csp-clinic-banner-text {
        color: white;
    }

    .csp-clinic-card-left {
        text-align: left;
    }

    .csp-clinic-title-blue {
        
        color: #0b5ed7a1;
    }


    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
</style>




<div class="container-fluid">
   

    <div class="row">
        <div class="col-12">
            {{-- <div class="alert alert-success col-xs-12" style="background-color: #0b5ed7a1; color:white;">
                <h4 class="float-left" style="text-align:end; color:white;">Patient UHID: {{ $application->patient_uhid }}</h4>
                <h4 class="float-right" style="text-align:end; color:white;">Patient UHID: {{ $application->patient_uhid }}</h4>
            </div> --}}


            <div class="alert alert-success col-xs-12 d-flex justify-content-between csp-clinic-banner">
                <h4 class="float-left csp-clinic-banner-text">Name of the Surrogacy Clinic: {{ $application->name_of_clinic }}</h4>
                <h4 class="float-right csp-clinic-banner-text">Patient UHID: {{ $application->pati_uhid }}</h4>
            </div>



            <form action="" method="POST">
                @csrf
               
                <div class="card csp-clinic-card-left">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                          
                            <h4 class="card-title csp-clinic-title-blue">Patient information form for Surrogacy Clinic</h4>
                            {{-- <a href="{{ route('noc.nocgeneratePdf', ['id' => Crypt::encrypt($application->id)]) }}" class="link btn btn-primary" target="_blank" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">
                                Download PDF
                            </a> --}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <tbody>
                                        <!-- Applicant Details -->
                                        {{-- <tr>
                                            <th colspan="4" style="background-color: #0b5ed7a1; color:white; text-align: center;">Applicant Details</th>
                                        </tr> --}}
                                        {{-- <tr>
                                            <th>Name of the Clinic</th>
                                            <td>{{ $application->name_of_clinic }}</td> 
                                        </tr> --}}
                                        {{-- @if (empty($application->country_applicant)) --}}

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>Required Affidavit regarding
                                                        following to be taken on record:</strong></label>                                               
                                               </div>
                                        </div>



                                        @if (!empty($application->declaration)) 
                                        <div class="col-md-12">   
                                                <div class="col-12">                                                   
                                                        <label colspan="2">
                                                            From Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime</label>  
                                                </div>
                                        </div>
                                        @endif
                                        @if (!empty($application->declaration1)) 
                                        <div class="col-md-12">
                                           
                                               
                                                <div class="col-12">
                                                   
                                                        <label colspan="2">
                                                            From intending
                                                            couple or single woman (widow or divorcee) that they/she
                                                            do/does not have any surviving child biologically or through
                                                            adoption or through surrogacy earlier .</label>  
                                                   
                                              
                                            </div>
                                        </div>
                                        @endif
                                        @if (!empty($application->declaration3)) 
                                        <div class="col-md-12">
                                           
                                               
                                                <div class="col-12">
                                                   
                                                        <label colspan="2">
                                                            From Oocyte Donor that she has not donated oocytes more than once in her life time.</label>  
                                                   
                                             
                                            </div>
                                        </div>
                                        @endif
                                        @if (!empty($application->declaration4)) 
                                        <div class="col-md-12">
                                          
                                               
                                                <div class="col-12">
                                                   
                                                        <label colspan="2">
                                                            From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.</label>  
                                                   
                                             
                                            </div>
                                        </div>
                                        @endif






















                                        @if (!empty($application->nationality == 'Indian')) 
                                        <tr>
                                            <th colspan="2">
                                                Nationality of the Husband</th>
                                            <td colspan="2">{{ $application->nationality }}</td>                                            
                                        </tr>
                                        @endif
                                        @if (!empty($application->nationality == 'OCI Card Holders')) 
                                        <tr>
                                            <th >
                                                Nationality of the Husband</th>
                                            <td >{{ $application->nationality }}</td> 
                                            <th >Country</th>
                                            <td >{{ $CountryName }}</td> 
                                        </tr>
                                        @endif


                                        @php
                                        $nationalityLabel = !empty($application->age_of_women) ? 'Nationality' : 'Nationality';
                                    @endphp
                                    
                                    @if (!empty($application->nationality_wife) && $application->nationality_wife == 'Indian') 
                                    <tr>
                                        <th colspan="2">{{ $nationalityLabel }}</th>
                                        <td colspan="2">{{ $application->nationality_wife }}</td>                                            
                                    </tr>
                                    @endif
                                    
                                    @if (!empty($application->nationality_wife) && $application->nationality_wife == 'OCI Card Holders') 
                                    <tr>
                                        <th >{{ $nationalityLabel }}</th>
                                        <td>{{ $application->nationality }}</td> 
                                        <th >Country</th>
                                        <td>{{ $CountryName_wife }}</td> 
                                    </tr>
                                    @endif  









                                       @if (!empty($application->age)) 
                                        <tr>
                                            <th >Husband Age</th>
                                            <td >{{ $application->age }}</td> 
                                            <th >Wife Age</th>
                                            <td >{{ $application->wife_age }}</td> 
                                        </tr>
                                        @endif
                                        @if (!empty($application->age_of_women)) 
                                        <tr>
                                            <th colspan="2">Age of Women</th>
                                            <td colspan="2">{{ $application->age_of_women }}</td>                                           
                                        </tr>
                                        @endif









                                        {{-- <tr>
                                            <th colspan="2">Cause of Infertility</th>
                                            <td colspan="2">{{ $application->cause_of_infretily }}</td>
                                        </tr> --}}
                                        {{-- @if (!empty($application->art_undertaken_other))  --}}
                                        @if (!empty($application->num_pre_child == 'No')) 
                                        <tr>
                                            <th colspan="2">
                                                Having Surviving Child</th>
                                            <td colspan="2">{{ $application->num_pre_child }}</td>                                             
                                        </tr>
                                        @endif

                                        @if (!empty($application->num_pre_child == 'Yes'))
                                        <tr>
                                            <th >
                                                Having Surviving Child</th>
                                            <td >{{ $application->num_pre_child }}</td> 
                                            <th >Details of Child</th>
                                            <td >{{ $application->child_give_details }}</td> 
                                        </tr>
                                        @endif




                                        @php
                                        $docTypeMapping = [
                                            'target_file_surrogacypatient_child_medicalcertificate_docs' => '<strong>Medical Certificate of the Child</strong>',
                                            'target_file_surrogacypatient_medicalcertificate_docs' => '<strong>Certificate of Medical Indication issued by District Medical Board</strong>',
                                            ];
                                        @endphp 
                                        
                                        
                                       
                                        {{-- @if (!empty($application->num_pre_child == 'Yes')) --}}
                                                
                                         @php
                                         $key = 1;
                                        @endphp
                                         @foreach ($get_docfileData as $docfile)

                                         <tr>
                                            {{-- <td>{{ $loop->iteration }}</td> --}}
                                            <td colspan="2">{!! $docTypeMapping[$docfile->doc_type] ?? $docfile->doc_type !!}</td>
                                            <td colspan="2">
                                                @if (!empty($application->num_pre_child) && $application->num_pre_child == 'Yes' && $docfile->doc_type == 'target_file_surrogacypatient_child_medicalcertificate_docs')
                                                <!-- Only allow download for this specific document if num_pre_child is Yes -->
                                                <a href="{{ asset('artprojfiles/surrogacy_patient_medical_docs/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @elseif ($docfile->doc_type != 'target_file_surrogacypatient_child_medicalcertificate_docs')
                                                <!-- Other documents are always downloadable -->
                                                <a href="{{ asset('artprojfiles/surrogacy_patient_medical_docs/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            @endif
                                                {{-- @if ($docfile->doc_id == 28 && $docfile->doc_type == 'target_file_surrogacypatient_child_medicalcertificate_docs')
                                                    <a href="{{ asset('surrogacy_patient_medical_docs/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    @elseif ($docfile->doc_id == 27 && $docfile->doc_type == 'target_file_surrogacypatient_medicalcertificate_docs')
                                                    <a href="{{ asset('surrogacy_patient_medical_docs/'.basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                        <i class="fa fa-download"></i>
                                                    </a>                                                   
                                                @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                        {{-- @endif --}}






                                        <tr>
                                            <th colspan="2">
                                                Medical Condition Necessitating Surrogacy</th>
                                            <td colspan="2">{{ $application->medical_surrogacy }}</td> 
                                            {{-- <th >Upload Certificate of Medical
                                                Indication issued by District Medical Board</th>
                                            <td >{{ $application->surrogacypatient_medicalcertificate_docs }}</td>  --}}
                                        </tr>
                                        @if (!empty($application->types_of_treat == 'Surrogacy using donor gametes')) 
                                        <tr>
                                            <th >
                                                Type of Treatment</th>
                                            <td >{{ $application->types_of_treat }}</td>

                                            <th >Gamete Source</th>
                                            <td >{{ $application->types_of_treat1 }}</td> 
                                        </tr>
                                        @endif
                                        @if (!empty($application->types_of_treat == 'Surrogacy using own gametes(Self Egg and Self Sperm)'))                                         
                                        <tr>
                                            <th colspan="2">
                                                Type of Treatment</th>
                                            <td colspan="2">{{ $application->types_of_treat }}</td> 
                                        </tr>
                                        @endif

                                        <tr>
                                            <th colspan="2">Surrogate Mother Age</th>
                                            <td colspan="2">{{ $application->surrogate_mother_age }}</td>                                           
                                        </tr>


                                        @if (!empty($application->art_undertaken)) 
                                        <tr>
                                            <th colspan="2">
                                                ART Procedure Undertaken</th>
                                            <td colspan="2">{{ $application->art_undertaken }}</td> 
                                            
                                        </tr>
                                        @endif
                                        @if (!empty($application->art_undertaken == 'Others')) 
                                        <tr>
                                            <th >
                                                ART Procedure Undertaken</th>
                                            <td >{{ $application->art_undertaken }}</td> 
                                            <th >Others</th>
                                            <td >{{ $application->art_undertaken_other }}</td> 
                                        </tr>
                                        @endif
                                        <tr>
                                            <th >
                                                Total No. of Treatment Cycle(s) Undertaken</th>
                                            <td >{{ $application->total_nun_cycles }}</td> 
                                            <th >No. of Cycles Cancelled/Failed, if any</th>
                                            <td >{{ $application->no_cycles }}</td> 
                                        </tr>
                                        @if (!empty($application->Cycle_fail_reason)) 
                                        <tr>
                                            <th colspan="2">Cycle Cancellation and
                                                reason</th>
                                            <td colspan="2">{{ $application->Cycle_fail_reason }}</td>                                           
                                        </tr>
                                        @endif







                                        <tr>
                                            <th colspan="2">
                                                Treatment Outcome</th>
                                            <td colspan="2">{{ $application->tratment_Outcome }}</td> 
                                            {{-- <th >Pregnancy Outcome</th>
                                            <td >{{ $application->preganancy_outcome }}</td>  --}}
                                        </tr>

                                        @if (!empty($application->tratment_Outcome == 'Pregnant')) 
                                        <tr>                                           
                                            <th colspan="2">Pregnancy Outcome</th>
                                            <td colspan="4">{{ $application->preganancy_outcome }}</td> 
                                        </tr>
                                        @endif

                                        @if (!empty($application->preganancy_outcome))
                                        <tr>
                                            @if (!empty($application->l_birth))
                                            <th >Live Birth Pregnancy Outcome</th>
                                            <td>{{ $application->l_birth }}</td>
                                            @endif
                                            

                                            <th >Gender of the child born</th>
                                            <td >
                                                {{ str_replace(',', ', ', $application->gender_child) }}
                                                @if (!empty($application->male_number) || !empty($application->female_number))
                                                    <br>
                                                    <small>
                                                        @if (!empty($application->male_number))
                                                            Male: {{ $application->male_number }}
                                                        @endif
                                                        @if (!empty($application->male_number) && !empty($application->female_number))
                                                            |
                                                        @endif
                                                        @if (!empty($application->female_number))
                                                            Female: {{ $application->female_number }}
                                                        @endif
                                                    </small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif



                                        {{-- @if (!empty($application->preganancy_outcome == 'live birth')) 
                                        <tr>
                                            <th >
                                                Live Birth Pregnancy Outcome</th>
                                            <td >{{ $application->l_birth }}</td> 
                                            <th >Gender of the child born</th>
                                            <td>{{ str_replace(',', ', ', $application->gender_child) }}</td>
                                           
                                        </tr>
                                        @endif --}}


                                        {{-- @if (!empty($application->l_birth == 'Higher Order')) 
                                        <tr>
                                            <th colspan="2">
                                                Specify Number & Gender of the children Born</th>
                                            <td colspan="2">{{ $application->other_gender }}</td> 
                                           
                                        </tr>
                                        @endif --}}
                                        <tr>
                                            <th colspan="2">
                                                Complications, if any</th>
                                            <td colspan="2">{{ $application->comp_if_any }}</td> 
                                           
                                        </tr>
                                        <tr>
                                            <th colspan="2">Remarks/ Any other relevant information</th>
                                            <td colspan="2">{{ $application->remark }}</td> 
                                           
                                        </tr>

                                           
                                       
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