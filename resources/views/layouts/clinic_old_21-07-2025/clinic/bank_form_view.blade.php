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
                            @foreach($application as $application_num)
                          
                              <h4 class="card-title csp-clinic-text-black">
        <strong>Application Number:</strong> {{ $application_num->bapp_no->applicationno }}
    </h4>
                            @endforeach
                         

                            <a href="{{ route('clinic.bankgeneratePdf', ['id' => Crypt::encrypt($application_num->id)]) }}"
                                class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
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
                                        @foreach($application as $application_no)
                                         <tr>
                                            <th colspan="2">Name of the Bank</th>
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
                                            <td >{{ $application_no->fax ?? '-'}}</td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2">{{ $application_no->website ?? '-'}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your ART Bank</th>                                            
                                            <td colspan="8">{{ \Carbon\Carbon::parse($application_no->dateestab)->format('m-d-Y') }}</td>
                                        </tr> 
                                        <tr>
                                      
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                        <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td>{{ $signup_data->personname }}</td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2">{{ $signup_data->mobile }}</td>
                                        </tr>
                                       
                                        <tr>
                                            <th colspan="2">Email Address</th>                                            
                                            <td colspan="8">{{ $signup_data->email_contact_person }}</td>
                                        </tr>                                        
                                        @endforeach
                                       
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
                                            <td colspan="3">{{ $staffs->name_otherstaff }}</td>
                                            <td colspan="3">{{ $staffs->designation_otherstaff ?? '-'}}</td>
                                            <td colspan="3">{{ $staffs->quali_otherstaff }}</td>                                           
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
                                            <th colspan="2"> a). Ejaculation</th>
                                            <td>{{ $application_no->ejaculation }}</td>
                                            <th colspan="2">b). Electroejaculation (in
                                                case of retrograde ejaculation)</th>
                                            <td colspan="2">{{ $application_no->electroejaculation }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> ii). Processing of Sperm</th>
                                            <td>{{ $application_no->processingsperm }}</td>
                                            <th colspan="2">iii). Storage of Sperm</th>
                                            <td colspan="2">{{ $application_no->storagesperm }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> iv). Provision/sourcing of
                                                Oocyte Donor</th>
                                            <td>{{ $application_no->oocytedonor }}</td>
                                            <th colspan="2">5. Cryopreservation of
                                                Sperm</th>
                                            <td colspan="2">{{ $application_no->cryopreservation }}</td>
                                        </tr> 
                                       
                                        <tr>
                                            <th colspan="2"> i). Sperm Slow Freezing</th>
                                            <td>{{ $application_no->spermslow }}</td>
                                            <th colspan="2">ii). Sperm Vitrification</th>
                                            <td colspan="2">{{ $application_no->spermvitrification }}</td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> 7. Whether Freezing of
                                                Testicular Tissue</th>
                                            <td>{{ $application_no->tisticulartissue }}</td>
                                           
                                        </tr> 
                                        <tr>
                                            <th colspan="2">Any Other Details</th>
                                            <td colspan="8">{{ $application_no->otherdetails }}</td>
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