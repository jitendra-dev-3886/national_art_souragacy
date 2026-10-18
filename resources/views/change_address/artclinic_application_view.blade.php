@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container-fluid">   
    <style nonce="{{$cspNonce}}">
    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
   
    .csp-clinic-text-left {
        text-align: left;
    }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-btn-blue {
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
                
                <div class="card csp-clinic-text-left">

                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{-- <h4 class="card-title" style="color:green;"></h4> --}}
                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> {{ $application->applicationno }}</h4>                        
                            <a href="{{ route('change_address.ssa.application.pdf', ['encryptedId' => Crypt::encrypt($application->id)]) }}"
                                class="link btn btn-primary csp-clinic-btn-blue"
                                target="_blank">Download PDF</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                          
                                            <th colspan="8" class="csp-clinic-table-header">ART Clinic Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                    
                                         <tr>
                                            <th colspan="2">Name of the Clinic</th>
                                            <td colspan="8">{{ $application->clinicname }}</td>                                                                                     
                                        </tr>
                                           <tr>
                                            <th colspan="2">Level of the Clinic</th>
                                            <td colspan="8">{{ $application->cliniclevel }}</td>                                                                                     
                                        </tr>

                                          <tr>
                                            <th colspan="2">Old Address</th>
                                            <td colspan="8">
                                                {{ implode(', ', array_filter([
                                                $application->clinic->address ?? null,
                                                $application->clinic->district ?? null,
                                                $application->clinic->state ?? null,
                                                $application->clinic->pincode ?? null,
                                            ])) }}</td>                                                                                     
                                        </tr> 

                                        <tr>
                                            <th colspan="2">New Address</th>
                                            <td colspan="8">{{ $application->address }}</td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">New State</th>
                                            <td>{{ $application->state }}</td>                                                                                     
                                            <th>New District</th>
                                            <td>{{ $application->district }}</td>
                                            <th>New Pincode</th>
                                            <td>{{ $application->pincode }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Nature</th>
                                            <td>{{ $application->nature }}</td>                                                                                     
                                            <th>Email ID</th>
                                            <td>{{ $application->email }}</td>
                                            <th>Contact Number</th>
                                            <td>{{ $application->contactno }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Fax</th>
                                            <td >{{ $application->fax ?? '-'}}</td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2">{{ $application->website ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your ART Clinic</th>                                            
                                            {{-- <td colspan="8">{{ \Carbon\Carbon::parse($application->dateestab)->format('m-d-Y') }}</td> --}}
                                            <td colspan="1">{{ $application->dateestab
                                            ? \Carbon\Carbon::parse($application->dateestab)->format('d-m-Y') 
                                            : '' }}</td>
                                            <th colspan="1">Current Registration Date</th>
                                            <td colspan="6">{{ $application->current_registration_date
                                            ? \Carbon\Carbon::parse($application->current_registration_date)->format('d-m-Y') 
                                            : '' }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic is registered under MTP Act</th>
                                            <td>{{ $application->mtpact }}</td>
                                            <th colspan="2">Whether your ART Clinic is registered under PCPNDT Act</th>
                                            <td colspan="2">{{ $application->pcpndtact }}</td>
                                        </tr>
                                        <tr>
                                        
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                        <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td colspan="8">{{ $application->contact_person_name }}</td>
                                        </tr>   
                                        <tr>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="8">{{ $application->contact_person_mobile }}</td>
                                        </tr>      
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8">{{ $application->contact_person_email }}</td>
                                            
                                        </tr>                             
                                        <tr>
                                           
                                            <th colspan="8" class="csp-clinic-table-header">Details of the Director Available at your ART Clinic</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic has Director</th>
                                            <td colspan="8">{{ $application->director }}</td>
                                        </tr>
                                     
                                        <tr>
                                            <th colspan="3">Name</th>
                                            <th colspan="3">Qualification</th>
                                            <th colspan="3">Registration No. (if applicable)</th>
                                        </tr>
                                        @foreach($directors as $director)
                                        <tr>
                                            <td colspan="3">{{ $director->name_director }}</td>
                                            <td colspan="3">{{ $director->quali_director }}</td>
                                            <td colspan="3">{{ $director->reg_director ?? '-'}}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                           
                                            <th colspan="8" class="csp-clinic-table-header">Details of the Staff Available at your ART Clinic</th>
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
                                            <td>{{ $application->iuih }}</td>
                                            <th colspan="2">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                                            <td colspan="2">{{ $application->iuid }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">  In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                                            <td>{{ $application->ivfet }}</td>
                                            <th colspan="2">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                                            <td colspan="2">{{ $application->icsi }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Pre-implantation Genetic Testing (PGT)</th>
                                            <td>{{ $application->pgt }}</td>
                                            <th colspan="2">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                                            <td colspan="2">{{ $application->spermandoocyte }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Any Other Procedure</th>
                                            <td>{{ $application->anyotherprocedure }}</td>
                                            <th colspan="2">If yes, please specify</th>
                                            <td colspan="2">{{ $application->otherprocedure }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">Any Other Details</th>
                                            <td colspan="8">{{ $application->otherdetails }}</td>
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