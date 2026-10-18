@extends('layouts.admin.admin_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .csp-admin-message-div{
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">             
                <div class="card-header">                
                    <h4 class="card-title">Add Role</h4>
                </div>              
                <div class="card-body">
                    <div class="basic-form">  
                        @if(session('success'))
                        <div id="success-message" class="alert me-4 alert-success csp-admin-message-div">
                            {{ session('success') }}
                        
                    </div>@endif                         
                        <form class="form-valide-with-icon needs-validation" novalidate name="myForm"
                            action="{{ route('admin.add_user_role_store') }}" method="POST">
                            @csrf                          
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">Role Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    <input type="text" name="role_name" id="role_name"
                                                    value="<?php //echo $row2['personname'];?>" class="form-control" >
                                                    @error('role_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>                                   
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">Description</label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    <textarea name="description" rows="4" cols="50" class="form-control" id="description" placeholder="Enter description here..."></textarea>
                                    @error('description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn me-2 btn-primary">Submit</button>
                            <!--button type="submit" class="btn btn-danger light">Cancel</button-->
                        </form>
                           <!-- Success Message -->
                            <div id="success-message" class="alert me-4 alert-success" style="display: none; margin-top: 10px;">
                                    Add Role Successfully!
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection