@extends('layouts.admin.admin_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-alert-margin{
            margin-top: 10px;
        }
    </style>
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assign service to the user</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        @if(session('success'))
                        <div id="success-message" class="alert me-4 alert-success csp-admin-alert-margin">
                            {{ session('success') }}
                        
                    </div>@endif   
                        <form class="form-valide-with-icon needs-validation" novalidate name="myForm"
                            action="{{ route('admin.assign_service_data') }}"  method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6"> 
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">User ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                        <option value="">Select</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->userid }}" {{ old('user_id') == $user->userid ? 'selected' : '' }}>
                                                {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6"> 
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">Service Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    <select name="service_id" id="service_id" class="form-control @error('service_id') is-invalid @enderror" required>
                                        <option value="">Select</option>
                                        @foreach ($services as $service_id)
                                            <option value="{{ $service_id->id }}" {{ old('service_id') == $service_id->id ? 'selected' : '' }}>
                                                {{ $service_id->service_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            </div>         
                            <button type="submit" name="submit" class="btn me-2 btn-primary">Submit</button>
                            <!--button type="submit" class="btn btn-danger light">Cancel</button-->
                        </form>
                                                            <!-- Loader div -->
                                                                        <!-- Loader -->
                                        <!-- <div id="loader" style="display:none;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection