@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container-fluid">
   
    <style nonce="{{$cspNonce}}">
    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }

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
</style>


    <div class="row">
        <div class="col-12">
            {{-- <div class="alert alert-success col-xs-12" style="background-color: #0b5ed7a1; color:white;">
                <h4 class="float-left" style="text-align:end; color:white;">Patient UHID: {{ $application->patient_uhid }}</h4>
                <h4 class="float-right" style="text-align:end; color:white;">Patient UHID: {{ $application->patient_uhid }}</h4>
            </div> --}}

        

            <div class="alert alert-success col-xs-12 d-flex justify-content-between csp-clinic-banner">
                <h4 class="float-left csp-clinic-banner-text">Name of the ART Clinic: {{ $application->name_of_clinic }}</h4>
                <h4 class="float-right csp-clinic-banner-text">Patient UHID: {{ $application->patient_uhid }}</h4>
            </div>


            <form action="" method="POST">
                @csrf
                
                <div class="card csp-clinic-card-left">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                           
                            <h4 class="card-title csp-clinic-title-blue">Patient information form for ART Clinic</h4>
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
                                                            From Oocyte Donor that she has not donated oocytes more than once in her life time.</label>  
                                                 
                                              
                                               </div>
                                        </div>
                                        @endif
                                        @if (!empty($application->declaration1)) 
                                        <div class="col-md-12">
                                           
                                               
                                               
                                                <div class="col-12">
                                                   
                                                        <label colspan="2">
                                                            From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.</label>  
                                              
                                            </div>
                                        </div>
                                        @endif

                                        {{-- @if (!empty($application->nationality_wife == 'Indian')) 
                                        <tr>
                                            <th colspan="2">
                                                Nationality of the Wife</th>
                                            <td colspan="2">{{ $application->nationality_wife }}</td>                                            
                                        </tr>
                                        @endif
                                        @if (!empty($application->nationality_wife == 'Foreigner')) 
                                        <tr>
                                            <th >
                                                Nationality of the Wife</th>
                                            <td >{{ $application->nationality }}</td> 
                                            <th colspan="2">Country Name</th>
                                            <td >{{ $CountryName_wife }}</td> 
                                        </tr>
                                        @endif --}}




                                       @if (!empty($application->age_hus_wife)) 
                                        <tr>
                                            <th >Husband Age</th>
                                            <td >{{ $application->age_hus_wife }}</td> 
                                            <th colspan="2">Wife Age</th>
                                            <td >{{ $application->wife_age }}</td> 
                                        </tr>
                                        @endif

                                        @if (!empty($application->age_of_women)) 
                                        <tr>
                                            <th colspan="2">Age of Woman</th>
                                            <td colspan="4">{{ $application->age_of_women }}</td>                                           
                                        </tr>
                                        @endif

                                        @if (!empty($application->nationality == 'Indian')) 
                                        <tr>
                                            <th colspan="2">
                                                Nationality of the Husband</th>
                                            <td colspan="4">{{ $application->nationality }}</td>                                            
                                        </tr>
                                        @endif
                                        @if (!empty($application->nationality == 'Foreigner')) 
                                        <tr>
                                            <th >
                                                Nationality of the Husband</th>
                                            <td >{{ $application->nationality }}</td> 
                                            <th colspan="2">Country</th>
                                            <td >{{ $CountryName }}</td> 
                                        </tr>
                                        @endif

                                        @php
                                        $nationalityLabel = !empty($application->age_of_women) ? 'Nationality' : 'Nationality of the Wife';
                                        @endphp
                                        
                                        @if (!empty($application->nationality_wife) && $application->nationality_wife == 'Indian') 
                                        <tr>
                                            <th colspan="2">{{ $nationalityLabel }}</th>
                                            <td colspan="4">{{ $application->nationality_wife }}</td>                                            
                                        </tr>
                                        @endif
                                        
                                        @if (!empty($application->nationality_wife) && $application->nationality_wife == 'Foreigner') 
                                        <tr>
                                            <th>{{ $nationalityLabel }}</th>
                                            <td>{{ $application->nationality }}</td> 
                                            <th colspan="2">Country</th>
                                            <td>{{ $CountryName_wife }}</td> 
                                        </tr>
                                        @endif  














                                        @if (!empty($application->cause_of_infretily)) 
                                        <tr>
                                            <th colspan="2">Cause of Infertility</th>
                                            <td colspan="4">{{ $application->cause_of_infretily }}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($application->art_proc_undertaken != 'Others')) 
                                        <tr>
                                            <th colspan="2">
                                                ART Procedure Undertaken</th>
                                            <td colspan="4">{{ $application->art_proc_undertaken }}</td>                                           
                                        </tr>
                                        @endif
                                        @if (!empty($application->art_proc_undertaken == 'Others')) 
                                        <tr>
                                            <th >
                                                ART Procedure Undertaken</th>
                                            <td >{{ $application->art_proc_undertaken }}</td> 
                                            <th colspan="2">Others</th>
                                            <td colspan="2">{{ $application->art_undertaken_other }}</td> 
                                        </tr>
                                        @endif


                                        @if (!empty($application->types_of_treat == 'ART Treatment using donor gametes'))
                                        <tr>
                                            <th >
                                                Types of Treatment</th>
                                            <td >{{ $application->types_of_treat }}</td> 
                                            <th colspan="2">Type of Donation</th>
                                            <td colspan="2">{{ $application->types_of_treat1 }}</td> 
                                        </tr>
                                        @endif
                                        @if (!empty($application->types_of_treat != 'ART Treatment using donor gametes'))
                                        <tr>
                                            <th colspan="2">
                                                Types of Treatment</th>
                                            <td colspan="4">{{ $application->types_of_treat }}</td>                                             
                                        </tr>
                                        @endif

                                        <tr>
                                            <th >
                                                Total No. of Treatment Cycle(s) Undertaken</th>
                                            <td >{{ $application->total_num_of_cyc }}</td> 
                                            <th colspan="2">No. of Cycles Cancelled/Failed, if any</th>
                                            <td colspan="2">{{ $application->no_cycles }}</td> 
                                        </tr>
                                        @if (!empty($application->cyc_canc_failure_reason)) 
                                        <tr>
                                            <th colspan="2">Cycle Cancellation and reason</th>
                                            <td colspan="4">{{ $application->cyc_canc_failure_reason }}</td>                                           
                                        </tr>
                                        @endif
                                       
                                        <tr>
                                            <th colspan="2">
                                                Treatment Outcome</th>
                                            <td colspan="4">{{ $application->treat_outcomes }}</td> 
                                           
                                        </tr>
                                       
                                        @if (!empty($application->treat_outcomes == 'Pregnant'))
                                        <tr>
                                            <th colspan="2">Pregnancy Outcome</th>
                                            <td colspan="4">{{ $application->preganancy_outcome }}</td>                                      
                                        </tr>
                                        @endif

{{-- 
                                        @if (!empty($application->preganancy_outcome == 'live birth'))
                                        <tr>
                                            <th>
                                                Live Birth Pregnancy Outcome</th>
                                            <td >{{ $application->l_birth }}</td>   
                                            <th  colspan="2">Gender of the child born</th>
                                            <td  colspan="4">{{ str_replace(',', ', ', $application->gender_child) }}</td>                                          
                                        </tr>
                                        @endif --}}
                                         {{-- @if (!empty($application->l_birth == 'Higher Order')) 
                                        <tr>
                                            <th colspan="2">
                                                Specify Number & Gender of the children Born</th>
                                            <td colspan="4">{{ $application->other_gender }}</td> 
                                           
                                        </tr>
                                        @endif --}}

                                        {{-- @if (!empty($application->male_number)) 
                                        <tr>
                                            <th colspan="2">
                                                Number of Male</th>
                                            <td colspan="4">{{ $application->male_number }}</td> 
                                           
                                        </tr>
                                        @endif
                                        @if (!empty($application->female_number)) 
                                        <tr>
                                            <th colspan="2">
                                                Number of FeMale</th>
                                            <td colspan="4">{{ $application->female_number }}</td> 
                                           
                                        </tr>
                                        @endif --}}
                                        {{-- @if (!empty($application->l_birth))
                                        <tr>
                                            <th colspan="2">Live Birth Pregnancy Outcome</th>
                                            <td colspan="4">{{ $application->l_birth }}</td>   
                                            
                                        </tr>
                                        @endif --}}
                                        @if (!empty($application->preganancy_outcome))
                                        <tr>
                                            @if (!empty($application->l_birth))
                                            <th>Live Birth Pregnancy Outcome</th>
                                            <td>{{ $application->l_birth }}</td>
                                            @endif
                                            

                                            <th colspan="2">Gender of the child born</th>
                                            <td colspan="4">
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
                                   




                                        <tr>
                                            <th colspan="2">
                                                Complications, If any</th>
                                            <td colspan="4">{{ $application->complicatoins_if_any }}</td> 
                                           
                                        </tr>
                                        <tr>
                                            <th colspan="2">Remarks/ Any other relevant information</th>
                                            <td colspan="4">{{ $application->remark }}</td> 
                                           
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