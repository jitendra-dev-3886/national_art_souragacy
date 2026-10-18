@extends('layouts.clinic.clinic_master')
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
                <strong>Success!</strong> Application has been created successfully.
                <p class="">Application No: {{ session('success') }}</p>
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
                                    <th>Cliniclevel</th>
                                    <th>Application Number</th>
                                    <th>View</th>  
                                    <th>Action</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1 @endphp
                                @foreach ($clinicForms as $form)
                                    @if(@$form->artclinics->app_no->applicationno)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $form->clinicname }}</td>
                                        <td>{{ $form->address }}</td>
                                        <td>{{ $form->artclinics->cliniclevel }}</td>
                                        <td>{{ $form->artclinics->app_no->applicationno }}</td>
                                        <td>
                                            <a href="{{ route("clinic.clinicForm_view", ['id' => encrypt($form->artclinics->id)]) }}" class="btn btn csp-clinic-btn">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif

                                    @if(@$form->bankclinics->bapp_no->applicationno)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $form->clinicname }}</td>
                                        <td>{{ $form->address }}</td>
                                        <td>-</td>
                                        <td>{{ $form->bankclinics->bapp_no->applicationno }}</td>
                                        <td>
                                            <a href="{{ route("clinic.bankForm_view", ['id' => encrypt($form->bankclinics->id)]) }}" class="btn btn csp-clinic-btn">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route("clinic.add_bank_application_form", ['id' => encrypt($form->bankclinics->id)]) }}" class="btn btn csp-clinic-btn">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif

                                    @if(@$form->surrogacyclinics->sapp_no->applicationno)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $form->clinicname }}</td>
                                        <td>{{ $form->address }}</td>
                                        <td>-</td>
                                        <td>{{ $form->surrogacyclinics->sapp_no->applicationno }}</td>
                                        <td>
                                            <a href="{{ route("clinic.sclinicForm_view", ['id' => encrypt($form->surrogacyclinics->id)]) }}" class="btn btn csp-clinic-btn">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td></td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
