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
                           
                           
                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> {{ $clinicdata->application_no }}</h4>

                            
                         
                            {{-- <a href="{{ route('clinic.sclinicgeneratePdf', ['id' => Crypt::encrypt($application_num->id)]) }}" 
                                class="link btn btn-primary csp-clinic-btn-primary" target="_blank">
                                    Download PDF
                                </a> --}}


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                            
                                            <th colspan="8" class="csp-clinic-table-header">Application View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                        {{-- @foreach($surrogacydata as $surrogacydata) --}}
                                         <tr>
                                            <th colspan="2">Name of the Clinic</th>
                                            <td colspan="8">{{ $clinicdata->name }}</td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">Address</th>
                                            <td colspan="8">{{ $clinicdata->address }}</td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">State</th>
                                            <td>{{ $clinicdata->state }}</td>                                                                                     
                                            <th>District</th>
                                            <td>{{ $clinicdata->district }}</td>
                                            <th>Pincode</th>
                                            <td>{{ $clinicdata->pincode }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Nature</th>
                                            <td>{{ $clinicdata->nature }}</td>                                                                                     
                                            <th>Email ID</th>
                                            <td>{{ $clinicdata->email }}</td>
                                            <th>Contact Number</th>
                                            <td>{{ $clinicdata->contactno }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Fax</th>
                                            <td colspan="2">{{ $clinicdata->fax ?? '-'}}</td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2">{{ $clinicdata->website ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your Surrogacy Clinic</th>                                            
                                            {{-- <td colspan="8">{{ \Carbon\Carbon::parse($application_no->dateestab)->format('m-d-Y') }}</td> --}}
                                            <td colspan="8">{{ $clinicdata->dateestab}}</td>
                                            
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic is registered under MTP Act</th>
                                            <td>{{ $clinicdata->clinic_reg_mpt }}</td>
                                            <th colspan="2">Whether your ART Clinic is registered under PCPNDT Act</th>
                                            <td colspan="2">{{ $clinicdata->clinic_reg_pcpndt }}</td>
                                        </tr>  
                                        
                                        <tr>
                                        
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                        <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td colspan="2">{{ $clinicdata->contact_person_name }}</td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2">{{ $clinicdata->contact_person_mobile }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8">{{ $clinicdata->email }}</td>
                                            
                                        </tr>
                                                                            
                                        <tr>
                                               <th colspan="8" class="csp-clinic-table-header">Details of the Director Available at your Surrogacy Clinic</th>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic has Director</th>
                                            <td colspan="8">{{ $clinicdata->director }}</td>
                                        </tr>
                                        {{-- @endforeach --}}
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
                                            <td colspan="2">{{ $staffs->post }}</td>
                                            <td colspan="2">{{ $staffs->name }}</td>
                                            <td colspan="2">{{ $staffs->qualification }}</td>
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
                                      
                                        <tr>
                                            <th colspan="2"> Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                                            <td>{{ $clinicdata->iui_h_s }}</td>
                                            <th colspan="2">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                                            <td colspan="2">{{ $clinicdata->iui_d_s }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">  In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                                            <td>{{ $clinicdata->ivf_et }}</td>
                                            <th colspan="2">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                                            <td colspan="2">{{ $clinicdata->icsi }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Pre-implantation Genetic Testing (PGT)</th>
                                            <td>{{ $clinicdata->pgt }}</td>
                                            <th colspan="2">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                                            <td colspan="2">{{ $clinicdata->sperm_oocyte }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Any Other Procedure</th>
                                            <td>{{ $clinicdata->any_other_procedure }}</td>
                                            <th colspan="2">If yes, please specify</th>
                                            <td colspan="2">{{ $clinicdata->otherprocedure }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">Any Other Details</th>
                                            <td colspan="8">{{ $clinicdata->any_other_detail }}</td>
                                        </tr>
                                        {{--  --}}
                                       {{-- <tr>
                                          <th colspan="8" class="csp-clinic-table-header">Payment Details </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Payment Recieve </th>
                                            <td colspan="8">{{ $application_data->app_date_payment}}</td>
                                        </tr>
                                         <tr>
                                            <th colspan="2">Payment Mode</th>
                                            <td colspan="8">{{ $application_data->mode_payment }}</td>
                                        </tr>
                                         <tr>
                                            <th colspan="2">Fee amount</th>
                                            <td colspan="8">{{ $application_data->fee_amount }}</td>
                                        </tr> --}}


                                        {{--  application status--}}
                                         <tr>
                                            <th colspan="2">Application Status</th>
                                            <td colspan="8">{{ $application_data->appstatus }}</td>
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