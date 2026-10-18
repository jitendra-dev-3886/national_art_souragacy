@extends('layouts.clinic.clinic_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-clinic-alert {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-clinic-btn {
            background-color: #0b49f9;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-clinic-table {
            min-width: 845px;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                @if (session('success'))
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show csp-clinic-alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>

                            <p class="">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Applications</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display csp-clinic-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Clinic Name</th>
                                        <th>Address</th>
                                        <th>Clinic level</th>
                                        <th>Application Number</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- ART Clinics --}}

                                    @php $i=1 @endphp
                                    @if (!empty($clinicForms['artClinics']) && count($clinicForms['artClinics']) > 0)
                                        @foreach ($clinicForms['artClinics'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->clinicname }}</td>
                                                <td>{{ $form->address }}</td>
                                                <td>{{ $form->cliniclevel }}</td>
                                                <td>{{ $form->applicationno ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('clinic.clinicForm_view', ['id' => encrypt($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $form->appstatus }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if (!empty($clinicForms['bankClinics']) && count($clinicForms['bankClinics']) > 0)
                                        @foreach ($clinicForms['bankClinics'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->clinicname }}</td>
                                                <td>{{ $form->address }}</td>
                                                <td>{{ $form->cliniclevel ?? '-' }}</td>
                                                <td>{{ $form->applicationno ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('clinic.bankForm_view', ['id' => encrypt($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $form->appstatus }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if (!empty($clinicForms['surrogacyClinics']) && count($clinicForms['surrogacyClinics']) > 0)
                                        @foreach ($clinicForms['surrogacyClinics'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->clinicname }}</td>
                                                <td>{{ $form->address }}</td>
                                                <td>{{ $form->cliniclevel }}</td>
                                                <td>{{ $form->applicationno ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('clinic.sclinicForm_view', ['id' => encrypt($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $form->appstatus }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if (!empty($clinicForms['renewalsurrogacyClinics']) && count($clinicForms['renewalsurrogacyClinics']) > 0)
                                        @foreach ($clinicForms['renewalsurrogacyClinics'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->clinicname ?? '' }}</td>
                                                <td>{{ $form->address ?? '' }}</td>
                                                <td>{{ $form->cliniclevel ?? '' }}</td>
                                                <td>{{ $form->applicationno ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('renewal.sc_renewalform_view', ['encryptedId' => Crypt::encryptString($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        {{-- {{ route('renewal.sc_renewalform_view', ['encryptedId' => Crypt::encryptString($application->id)]) }} --}}
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($form->appstatus == 'Rejected')
                                                        <span>Rejected, <br>please resubmit <br>the renewal form</span>
                                                    @else
                                                        <span>{{ $form->appstatus }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if (!empty($clinicForms['change_address']) && count($clinicForms['change_address']) > 0)
                                        @foreach ($clinicForms['change_address'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->clinicname ?? '' }}</td>
                                                <td>{{ $form->address ?? '' }}</td>
                                                <td>{{ $form->cliniclevel ?? '' }}</td>
                                                <td>{{ $form->applicationno ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('change_address.application.view', ['encryptedId' => Crypt::encryptString($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $form->appstatus }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if (!empty($clinicForms['change_name']) && count($clinicForms['change_name']) > 0)
                                        @foreach ($clinicForms['change_name'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->name ?? '' }}</td>
                                                <td>{{ $form->address ?? '' }}</td>
                                                <td>{{ $form->level ?? '' }}</td>
                                                <td>{{ $form->application_no ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('cn.application.view', ['encryptedId' => Crypt::encryptString($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#statusModal{{ $form->id }}">
                                                        {{ $form->appstatus }}
                                                    </a>
                                                  </tr>
                                        @endforeach
                                    @endif
                                    @if (!empty($clinicForms['changeManpower']) && count($clinicForms['changeManpower']) > 0)
                                        @foreach ($clinicForms['changeManpower'] as $form)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $form->clinicname ?? '' }}</td>
                                                <td>{{ $form->address ?? '' }}</td>
                                                <td>{{ $form->level ?? '' }}</td>
                                                <td>{{ $form->application_no ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('manpower.ssaChangeManpowerView', ['encryptedId' => Crypt::encryptString($form->id)]) }}"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($form->app_status == 'Rejected')
                                                        <a type="button" class="btn btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#manpowerejectresion{{ $form->id }}">{{ $form->app_status }}</a>
                                                    @else
                                                        {{ $form->app_status }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="manpowerejectresion{{ $form->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                {{ $form->clinicname ?? '' }}</h5>
                                                            {{-- <button type="button" class="close p-0" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button> --}}
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $form->remark ?? '' }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif



                                    {{-- @if (!empty($clinicForms['change_name']) && count($clinicForms['change_name']) > 0)
                                    @foreach ($clinicForms['change_name'] as $form)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $form->name ?? '' }}</td>
                                        <td>{{ $form->address ?? '' }}</td>
                                        <td>{{ $form->level ?? '' }}</td>
                                        <td>{{ $form->application_no ?? '-' }}</td>
                                         <td>
                                            <a href="{{ route('application.viewcn', ['encryptedId' => Crypt::encryptString($form->id)]) }}" class="btn btn csp-clinic-btn">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>{{ $form->appstatus}}</td>
                                    </tr>
                                    @endforeach
                                @endif --}}

                                </tbody>
                            </table>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal{{ $form->id }}" tabindex="-1"
        aria-labelledby="statusModalLabel{{ $form->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel{{ $form->id }}">Reason for Rejection:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">


                    {{ $form->reason_for_rejection ?? 'No rejection reason available.' }}

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    </td>
@endsection
