@extends('layouts.admin.ssa_master')

@section('content')

<style nonce="{{$cspNonce}}">
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
                    <h4 class="card-title">List of Registered Clinic/Bank</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table id="example3" class="display csp-clinic-table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Clinic Name</th>
                                    <th>Address</th>
                                    <th>Clinic Type</th>
                                    <th>Cliniclevel</th>
                                    <th>Application Number</th>
                                    <!-- <th>View</th>   -->
                                    <th>Action</th>                                
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($clinicForms as $key => $form)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $form->name }}</td>

                                    <td>{{ $form->address }}</td>
                                    <td>
                                        {{
                                            [
                                                'ARTCLINIC' => 'ART Clinic',
                                                'ARTBANK' => 'ART Bank',
                                                'ARTSURROGACY' => 'Surrogacy Clinic',
                                            ][$form->clinic_type] ?? $form->clinic_type
                                        }}
                                    </td>

                                    <td>{{ $form->level ?? '-' }}</td>

                                    <td>{{ $form->application_no }}</td>

                                    <!-- <td>
                                        @php
                                            $viewRoute = match($clinicTypeValue) {
                                                'ARTCLINIC'    => 'clinic.clinicForm_view',
                                                'ARTBANK'      => 'clinic.bankForm_view',
                                                'ARTSURROGACY' => 'clinic.sclinicForm_view',
                                            };
                                        @endphp

                                        <a href="{{ route($viewRoute, ['id' => encrypt($form->id)]) }}"
                                           class="btn csp-clinic-btn">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td> -->

                                    <td>
                                        <a href="{{ route('suspension.sa.application_form', [
                                                'encryptedClinicId' => Crypt::encryptString($form->clinic_id)
                                            ]) }}"
                                           >
                                            Action
                                        </a>
                                    </td>

                                </tr>

                                @empty

                                <tr>
                                    <td colspan="7" class="text-center">
                                        No Record Found.
                                    </td>
                                </tr>

                                @endforelse

                                </tbody>
                        </table> 
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection