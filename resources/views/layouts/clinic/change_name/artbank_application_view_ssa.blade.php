@extends('layouts.admin.ssa_master')
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
                          
                          
                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> {{ $application->application_no }}</h4>                        
                            <a href="{{ route('change_name.ssa.application.pdf', ['encryptedId' => Crypt::encrypt($application->id)]) }}"
                                class="link btn btn-primary csp-clinic-btn-blue"
                                target="_blank">Download PDF</a>


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
                                            {{-- @foreach ($application as $application) --}}
                                            <tr>
                                                <th colspan="2">Name of the Bank</th>
                                                <td colspan="8">{{ $application->current_clinic_name }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Address</th>
                                                <td colspan="8">{{ $application->address }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">State</th>
                                                <td>{{ $application->state }}</td>
                                                <th>District</th>
                                                <td>{{ $application->district }}</td>
                                                <th>Pincode</th>
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


                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Name of the Contact Person</th>
                                                <td>{{ $clinic->contact_person_name ?? 'N/A' }}</td>
                                                <th colspan="2">Mobile Number</th>
                                                <td colspan="2">{{ $application->contact_number_clinic }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Email</th>
                                                <td colspan="8">{{ $application->contact_person_email }}</td>

                                            </tr>
                                            <tr>

                                                <th colspan="8" class="csp-clinic-table-header">Procedure Undertaken</th>
                                            </tr>

                                            <tr>
                                                <th colspan="2">a). Ejaculation</th>
                                                <td>{{ $clinic->ejaculation ?? 'N/A' }}</td>

                                                <th colspan="2">b). Electroejaculation (in case of retrograde
                                                    ejaculation)</th>
                                                <td colspan="3">{{ $clinic->electrojaculation ?? 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th colspan="2">ii). Processing of Sperm</th>
                                                <td>{{ $clinic->processing_sperm ?? 'N/A' }}</td>

                                                <th colspan="2">iii). Storage of Sperm</th>
                                                <td colspan="3">{{ $clinic->storage_sperm ?? 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th colspan="2">iv). Provision/Sourcing of Oocyte Donor</th>
                                                <td>{{ $clinic->oocyte_doner ?? 'N/A' }}</td>

                                                <th colspan="2">5. Cryopreservation of Sperm</th>
                                                <td colspan="3">{{ $clinic->cryopreservation_of_sperm ?? 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th colspan="2">i). Sperm Slow Freezing</th>
                                                <td>{{ $clinic->methode_of_freezing_of_sperm ?? 'N/A' }}</td>

                                                <th colspan="2">ii). Sperm Vitrification</th>
                                                <td colspan="3">{{ $clinic->sperm_vitrification ?? 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <th colspan="2">7. Whether Freezing of Testicular Tissue</th>
                                                <td colspan="6">{{ $clinic->freezing_of_testicular_tissue ?? 'N/A' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th colspan="2">Any Other Details</th>
                                                <td colspan="6">{{ $clinic->otherdetails ?? 'N/A' }}</td>
                                            </tr>
 <tr>
                                            <th colspan="2">Declaration</th>
                                            <td colspan="8">I/We hereby declare that the information provide above is true and correct to the best of my/our
                                                <br> knowledge and belief.I/We undertake that all the attached documents are genuine and self attested.I/We also understand that if any information is found to be false,the application may be rejected and action may be taken as per law.</td>
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