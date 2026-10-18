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
                          
                          
                              <h4 class="card-title csp-clinic-text-black">
                                <strong>Application Number:</strong> {{ $application->applicationno }}
                            </h4>
                            
                         
                            <a href="{{ route('change_address.ssa.application.pdf', ['encryptedId' => Crypt::encrypt($application->id)]) }}"class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
                                    Download PDF
                            </a>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                          
                                            <th colspan="8" class="csp-clinic-table-header">ART Bank Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                        {{-- @foreach($application as $application) --}}
                                         <tr>
                                            <th colspan="2">Name of the Bank</th>
                                            <td colspan="8">{{ $application->clinicname }}</td>                                                                                     
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
                                            <th colspan="2">Date of establishment of your ART Bank</th>                                            
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
                                      
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                         <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td>{{ $application->contact_person_name }}</td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2">{{ $application->contact_person_mobile }}</td>
                                        </tr>         
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8">{{ $application->contact_person_email }}</td>
                                            
                                        </tr>                                           
                                        {{-- @endforeach --}}
                                       
                                        <tr>
                                        
                                                <th colspan="8" class="csp-clinic-table-header">Details of the Staff Available at your ART Bank</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Name</th>
                                            <th colspan="3">Designation</th>
                                            <th colspan="3">Qualification</th>
                                            {{-- <th colspan="2">Registration No (if applicable)</th> --}}
                                        </tr>
                                        @foreach($staff as $staffs)
                                        <tr>
                                            {{-- <td colspan="2">{{ $staffs->post_otherstaff }}</td> --}}
                                            <td colspan="3">{{ $staffs->name }}</td>
                                            <td colspan="3">{{ $staffs->post ?? '-'}}</td>
                                            <td colspan="3">{{ $staffs->qualification }}</td>                                           
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
                                            <th colspan="2"> a). Ejaculation</th>
                                            <td>{{ $application->ejaculation }}</td>
                                            <th colspan="2">b). Electroejaculation (in
                                                case of retrograde ejaculation)</th>
                                            <td colspan="2">{{ $application->electrojaculation }}</td>
                                        </tr> 
                                        <tr> 
                                            <th colspan="2"> ii). Processing of Sperm</th>
                                            <td>{{ $application->processing_sperm }}</td>
                                            <th colspan="2">iii). Storage of Sperm</th>
                                            <td colspan="2">{{ $application->storage_sperm }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> iv). Provision/sourcing of
                                                Oocyte Donor</th>
                                            <td>{{ $application->oocyte_doner }}</td>
                                            <th colspan="2">5. Cryopreservation of
                                                Sperm</th>
                                            <td colspan="2">{{ $application->cryopreservation_of_sperm }}</td>
                                        </tr> 
                                       
                                        <tr>
                                            <th colspan="2"> i). Sperm Slow Freezing</th>
                                            <td>{{ $application->methode_of_freezing_of_sperm }}</td>
                                            <th colspan="2">ii). Sperm Vitrification</th>
                                            <td colspan="2">{{ $application->sperm_vitrification }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> 7. Whether Freezing of
                                                Testicular Tissue</th>
                                            <td>{{ $application->freezing_of_testicular_tissue }}</td>
                                           
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