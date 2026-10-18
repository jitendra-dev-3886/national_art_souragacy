
@extends('layouts.admin.admin_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .csp-admin-message-div{
        margin-top: 10px;
    }
</style>

<div class="container-fluid">
    <!--div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Form</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Validation</a></li>
        </ol>
    </div-->
    <!-- row -->
    <div class="row">

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add user</h4>
                </div>

                <div class="card-body">
                    <div class="basic-form">
                        
                            @if(session('success'))
                            <div id="success-message" class="alert me-4 alert-success csp-admin-message-div">
                                {{ session('success') }}
                            
                        </div>@endif
                        <form class="form-valide-with-icon needs-validation" novalidate name="myForm" id="userForm"
                            action="{{ route('admin.add_user_store') }}" method="POST"> 
                            @csrf                                 
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">User Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    <input type="text" name="user_name" id="user_name"
                                                    value="<?php //echo $row2['personname'];?>" class="form-control" autocomplete="off">
                                                    @error('user_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                      
                                    <div class="mb-3">
                                                <label class="text-label form-label" for="validationCustomUsername"><strong>First Name</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                <input type="text" name="first_name" id="first_name"
                                                    value="<?php //echo $row2['personname'];?>" class="form-control" autocomplete="off"
                                                    >
                                                    @error('first_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="mb-3">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Last Name</strong></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                            <input type="text" name="last_name" id="last_name"
                                                                value="<?php //echo htmlspecialchars($maskedEmail); ?>" class="form-control" autocomplete="off"
                                                                >
                                                                @error('last_name')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                        </div>
                                </div>                                  

                            </div>
                            <div class="row">
                                <div class="col-md-6">                                      
                                    <div class="mb-3">
                                                <label class="text-label form-label" for="validationCustomUsername"><strong>Designation</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                <input type="text" name="designation" id="designation"
                                                    value="<?php //echo $row2['personname'];?>" class="form-control" autocomplete="off"
                                                    >
                                                    @error('designation')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="mb-3">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Phone Number</strong></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                            <input type="text" name="phone" id="phone"
                                                                value="<?php //echo htmlspecialchars($maskedEmail); ?>" class="form-control" autocomplete="off"
                                                                >
                                                                @error('phone')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                        </div>
                                </div>                                    

                            </div>
                            <div class="row">
                                <div class="col-md-6">                                      
                                    <div class="mb-3">
                                                <label class="text-label form-label" for="validationCustomUsername"><strong>Email ID</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                                <input type="email" name="email" id="email"
                                                    value="<?php //echo $row2['personname'];?>" class="form-control" autocomplete="off"
                                                    >
                                                    @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="mb-3">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Mobile Number</strong></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i class="fa fa-mobile"></i> </span>
                                                            <input type="text" name="mobile_no" id="mobile_no"
                                                                value="<?php //echo htmlspecialchars($maskedEmail); ?>" class="form-control"
                                                                >
                                                                @error('mobile_no')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                        </div>
                                </div>
                            

                            </div>
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    <textarea name="address" id="address" rows="4" cols="50" class="form-control" placeholder="Enter your address here..."></textarea>
                                    <div class="invalid-feedback">
                                        Please Enter a Address.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">                                      
                                    <div class="mb-3">
                                                <label class="text-label form-label" for="validationCustomUsername"><strong>Password</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                <input type="password" name="password" id="password"
                                                    value="<?php //echo $row2['personname'];?>" class="form-control" autocomplete="off"
                                                    >
                                                    @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="mb-3">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Confirm Password</strong></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                                value="<?php //echo htmlspecialchars($maskedEmail); ?>" class="form-control" autocomplete="off"
                                                                >
                                                                @error('password_confirmation')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                        </div>
                                </div>
                            </div>
                            </div>                                   
                            <button type="submit" name="submit" id="submit" class="btn me-2 btn-primary">Submit</button>
                            <!--button type="submit" class="btn btn-danger light">Cancel</button-->
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection