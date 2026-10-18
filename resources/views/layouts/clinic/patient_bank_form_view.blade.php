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
                <h4 class="float-left csp-clinic-banner-text">Name of the Bank: {{ $application->name_of_bank }}</h4>
                <h4 class="float-right csp-clinic-banner-text">Donor ID: {{ $application->donor_id }}</h4>
            </div>



            <form action="" method="POST">
                @csrf
             
                <div class="card csp-clinic-card-left">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        
                            <h4 class="card-title csp-clinic-title-blue">Donor information form for ART Bank</h4>
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
                                      
                                        {{-- @if (!empty($application->declaration)) 
                                        <tr>
                                            <th colspan="2">
                                                From Oocyte Donor that she has not donated more than once in her life time.</th>                                                                               
                                        </tr>
                                        @endif
                                        @if (!empty($application->declaration1)) 
                                        <tr>
                                            <th colspan="2">
                                                From the ART Bank that the bank has not supplied sperm of the same donor
                                                to more than one commissioning couple/single woman.</th>                                                                               
                                        </tr>
                                        @endif --}}

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>Required Affidavit regarding
                                                        following to be taken on record:</strong></label>                                                
                                               </div>
                                        </div>

                                        @if (!empty($application->declaration)) 
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                               
                                                <div class="col-12">                                                   
                                                        <label colspan="2">
                                                            From Oocyte Donor that she has not donated oocytes more than once in her life time. </label>  
                                                 
                                              
                                               </div>
                                        </div>
                                        @endif
                                        @if (!empty($application->declaration1)) 
                                        <div class="col-md-12">
                                            <div class="mb-3">   
                                                <div class="col-12">
                                                        <label colspan="2">
                                                            From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.</label>  
                                                   
                                              </div>
                                        </div>
                                        @endif














                                        <tr>
                                            <th colspan="2">Gender</th>
                                            <td colspan="2">{{ $application->gender_donor }}</td> 
                                            {{-- <th >Wife Age</th>
                                            <td >{{ $application->wife_age }}</td>  --}}
                                        </tr>
                                      

                                        @if (!empty($application->donor_age)) 
                                        <tr>
                                            <th colspan="2">Donor age</th>
                                            <td colspan="2">{{ $application->donor_age }}</td>                                           
                                        </tr>
                                        @endif
                                        @if (!empty($application->oocyte_age)) 
                                        <tr>
                                            <th colspan="2">Oocyte Donor age</th>
                                            <td colspan="2">{{ $application->oocyte_age }}</td>
                                        </tr>
                                        @endif
                                        {{-- @if (!empty($application->art_undertaken_other))  --}}
                                        <tr>
                                            <th colspan="2">
                                                Marital status</th>
                                            <td colspan="2">{{ $application->marital_status }}</td> 
                                            {{-- <th >Others</th>
                                            <td >{{ $application->art_undertaken_other }}</td>  --}}
                                        </tr>
                                        {{-- @endif --}}
                                        @if (!empty($application->nationality == 'Indian')) 
                                        <tr>
                                            <th colspan="2">
                                                Nationality</th>
                                            <td colspan="2">{{ $application->nationality }}</td>                                            
                                        </tr>
                                        @endif
                                        @if (!empty($application->nationality == 'Foreigner')) 
                                        <tr>
                                            <th >
                                                Nationality</th>
                                            <td >{{ $application->nationality }}</td> 
                                            <th >Country</th>
                                            <td >{{ $CountryName }}</td> 
                                        </tr>
                                        @endif


                                        

                                        @if (!empty($application->gender_donor == 'Male')) 
                                        <tr>
                                            <th colspan="2">
                                                Semen Detail (in vials)</th>
                                            <td colspan="2">{{ $application->gamete_details }}</td>                                          
                                        </tr>
                                        @endif
                                        @if (!empty($application->gender_donor == 'Female')) 
                                        <tr>
                                            <th colspan="2">
                                                Oocyte details ( No of Oocyte(s) stored )</th>
                                            <td colspan="2">{{ $application->gamete_details }}</td>                                           
                                        </tr>
                                        @endif
                                        {{-- <tr>
                                            <th >
                                                Total No. of Treatment Cycle Undertaken</th>
                                            <td >{{ $application->total_num_of_cyc }}</td> 
                                            <th >No. of Cycles Cancelled/Failed, if any</th>
                                            <td >{{ $application->no_cycles }}</td> 
                                        </tr>

                                        <tr>
                                            <th colspan="2">Cycle Cancellation/failure and reason</th>
                                            <td colspan="2">{{ $application->cyc_canc_failure_reason }}</td>                                           
                                        </tr>
                                        <tr>
                                            <th >
                                                Treatment Outcome</th>
                                            <td >{{ $application->treat_outcomes }}</td> 
                                            <th >Pregnancy Outcome</th>
                                            <td >{{ $application->preganancy_outcome }}</td> 
                                        </tr>
                                        <tr>
                                            <th >
                                                Live Birth Pregnancy Outcome</th>
                                            <td >{{ $application->l_birth }}</td> 
                                            <th >Gender of the child born</th>
                                            <td>{{ str_replace(',', ', ', $application->gender_child) }}</td>
                                            
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                Details</th>
                                            <td colspan="2">{{ $application->other_gender }}</td> 
                                           
                                        </tr> --}}
                                        <tr>
                                            <th colspan="2">
                                                Complications, if any</th>
                                            <td colspan="2">{{ $application->complicatoins_if_any }}</td> 
                                           
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