@extends('layouts.admin.ssa_master')
@section('content')
    <div class="container-fluid">
        <style nonce="{{ $cspNonce }}">
            .table tbody tr td:last-child {
                text-align: start !important;
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
                @foreach ($application as $application_num)
                <p><strong>Application Number:</strong> {{ $application_num->app_no->applicationno }}</p>
                @endforeach
            </div> --}}

                <form action="" method="POST">
                    @csrf

                    <div class="card csp-clinic-text-left">

                        <div class="col-lg-12">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                {{-- <h4 class="card-title" style="color:green;"></h4> --}}
                                <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong>
                                    {{ $application->application_no }}</h4>
                                <a href="{{ route('change_name.ssa.application.pdf', ['encryptedId' => Crypt::encryptString($application->id)]) }}"
                                    class="link btn btn-primary csp-clinic-btn-blue" target="_blank">Download PDF</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                        <thead>
                                            @if ($application->clinic_type == 'ARTCLINIC')
                                                <tr>
                                                    <th colspan="8" class="csp-clinic-table-header">
                                                        ART Clinic Details
                                                    </th>
                                                </tr>
                                            @elseif ($application->clinic_type == 'ARTBANK')
                                                <tr>
                                                    <th colspan="8" class="csp-clinic-table-header">
                                                        ART Bank Details
                                                    </th>
                                                </tr>
                                            @elseif ($application->clinic_type == 'ARTSURROGACY')
                                                <tr>
                                                    <th colspan="8" class="csp-clinic-table-header">
                                                        Surrogacy Clinic Details
                                                    </th>
                                                </tr>
                                            @endif
                                        </thead>
                                        <tbody>
                                            <!-- Applicant Details -->

                                            <tr>
                                                <th colspan="2">Name of the Clinic</th>
                                                <td colspan="8">{{ $application->name }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Clinic Registration</th>
                                                <td colspan="8">{{ $application->registration_no }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Application No</th>
                                                <td colspan="8">{{ $application->application_no }}</td>
                                            </tr>
                                           <th colspan="2">Clinic Type</th>
                                                            <td colspan="8">
                                                @switch($application->clinic_type)
                                                @case('ARTCLINIC')
                                                ART Clinic
                                                @break

                                                @case('ARTBANK')
                                                ART Bank
                                                @break

                                                @case('ARTSURROGACY')
                                                Surrogacy Clinic
                                                @break

                                                @default
                                                {{ $application->clinic_type }}
                                                @endswitch
                                                </td>
                                            </tr>
                                            @if ($application->clinic_type == 'ARTCLINIC')
                                                <tr>
                                                    <th colspan="2">Level of the Clinic</th>
                                                    <td colspan="8">{{ $application->level }}</td>
                                                </tr>
                                            @endif

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

                                            <tr>


                                                <th colspan="1">Current Registration Date</th>
                                                <td colspan="6">
                                                    {{ $clinic->rgistration_date ? \Carbon\Carbon::parse($clinic->rgistration_date)->format('d-m-Y') : '' }}
                                                </td>
                                            </tr>
                                            <tr>

                                                <th colspan="8" class="csp-clinic-table-header">Proposed New Name Details
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Proposed New Name Of the Clinic</th>
                                                <td colspan="8">{{ $application->proposed_clinic_name }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Effective Date of Name change</th>
                                                <td colspan="8"> {{ $application->name_change_effective_date ? \Carbon\Carbon::parse($application->name_change_effective_date)->format('d-m-Y') : '' }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Reason for Change of Name</th>
                                                <td colspan="8">{{ $application->reason_for_name_change }}</td>

                                            </tr>

                                            <tr>
                                                <th colspan="2">Name of Authorized Signatory</th>
                                                <td colspan="8">{{ $application->authorized_signatory_name }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Designation</th>
                                                <td colspan="8">{{ $application->designation }}</td>
                                            </tr>
                                            <tr>
                                                <th colspan="2">Contact Number</th>
                                                <td colspan="8">{{ $application->contact_number }}</td>

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
