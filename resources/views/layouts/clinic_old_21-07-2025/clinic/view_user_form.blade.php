@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{$cspNonce}}">
    .csp-clinic-bg-darkblue {
        background-color: #141481;
    }

    .csp-clinic-bg-white {
        background-color: white;
    }

    .csp-clinic-text-white {
        color: white;
    }

    .csp-clinic-m-0 {
        margin: 0;
    }

    .csp-clinic-flex-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .csp-clinic-link-white {
        color: white;
        text-decoration: none;
    }

    .csp-clinic-text-center {
        text-align: center;
    }

    .csp-clinic-textarea-margin {
        margin-top: 4px;
    }

    .csp-clinic-btn-border {
        --bs-btn-border-color: #6569e3;
    }

    .csp-clinic-btn-darkblue {
        background-color: #141481;
        border-color: #141481;
    }

    .csp-clinic-btn-red {
        background-color: #b10826;
        border-color: #b10826;
        color: white;
    }

    .csp-clinic-btn-submit {
        margin-left: 878px;
        margin-top: 19px;
        background-color: #141481;
        border-color: #141481;
        color: white;
    }
     .margin111-top {
    margin-top: 15px;
}
</style>





    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style nonce="{{$cspNonce}}">
        .table tbody tr td:last-child { text-align: start; padding-right: 1.563rem; }
        .table thead tr th:last-child { text-align: start; } -->
    </style>
<script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="col-xs-12">
                      

                                    <div class="alert alert-success col-xs-12 csp-clinic-bg-darkblue">
                                        <div class="csp-clinic-flex-between">
                                            <h4 class="csp-clinic-text-white csp-clinic-m-0">
                                                Application Number: {{ $nocForm->application_no }}
                                            </h4>

                                
                            </div>
                        </div>
                    </div>

                   <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title">Basic Details</h4>
                        </div>
                            <div class="card-body">
                                
                              <form id="registrationForm">
                                    <div class="row">
                                            <div class="col-md-3">
                                                <label for="username" class="form-label">Name of the Applicant</label>
                                                <input type="text" class="form-control" id="username" name="username" disabled="disabled" value="{{$nocForm->name_applicant}}" required>
                                                
                                            </div>

                                            <div class="col-md-3">
                                                <label for="email" class="form-label">Marital Status</label>
                                                <input type="text" class="form-control" id="marital" name="" disabled="disabled" value="{{$nocForm->m_status}}" required>
                                                
                                            </div>

                                            <div class="col-md-3">
                                                <label for="password" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="" name="" disabled="disabled" value="{{$nocForm->address}}" required>
                                                
                                            </div>

                                            <div class="col-md-3">
                                                <label for="username" class="form-label">Pincode</label>
                                                <input type="text" class="form-control" id="" name="" disabled="disabled" value="{{$nocForm->pincode}}" required>
                                                <div class="invalid-feedback">Please enter your full name.</div>
                                            </div>
                                    
                                    </div>

                                    <div class="row mt-3">
                                            <div class="col-md-3">
                                            <label for="email" class="form-label">State</label>
                                            <input type="email" class="form-control" id="" name="" disabled="disabled" value="{{$nocForm->state}}" required>
                                                
                                            </div>

                                            <div class="col-md-3">
                                                <label for="email" class="form-label">Marital Status</label>
                                                <input type="text" class="form-control" id="marital" name="" disabled="disabled" value="{{$nocForm->district}}" required>
                                                
                                            </div>

                                            <div class="col-md-3">
                                                <label for="password" class="form-label">Email Address</label>
                                                <input type="text" class="form-control" id="" name="" disabled="disabled" value="{{$nocForm->email}}" required>
                                                
                                            </div>

                                            <div class="col-md-3">
                                                <label for="username" class="form-label">Date of Birth</label>
                                                <input type="text" class="form-control" id="" name="" disabled="disabled" value="{{$nocForm->dob_applicant}}" required>
                                                <div class="invalid-feedback">Please enter your full name.</div>
                                            </div>
                                    
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
        
        <div class="row">
                                                 
        <div class="col-md-12">
         <div class="card">
            <div class="card-header">
                <h5><strong>Work Space</strong></h5>
                
            </div>
            <div class="card-body">
                        <div class="row">
                                @foreach ($links as $link => $title)
                                    @php                             
                                        $bgColor = $linkColors[$link] ?? '#f39c12';
                                    @endphp
                                    
                                    <div class="{{ $tabcss }} col-md-3">
                                        {{-- <div class="card-tiless" style="background-color:{{ $bgColor }};"> --}}
                                            <div class="card-tiless" id="dynamicCardBg">
                                       

                                            <div class="card-block p-22">
                                                <p class="text-dark text-center py-11">
                                                   
                                                    <a href="{{ url('noc/'.$link) }}/{{ $noc_enc }}" class="csp-clinic-link-white">
                                                    <h4 class="csp-clinic-text-white csp-clinic-text-center">{{ $title }}</h4>
                                                    </a>   



                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        <!-- </div> -->
                        <!-- Remarks Section -->
                    
                        <div class="alert alert-success csp-clinic-bg-white">
                            <h4 class="m-0">Add Remarks</h4>
                        </div>
                        <!-- <div class="card"> -->
                        <form action="{{ route('add_user_remarks') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                      <input type="hidden" name="level_id" value="{{ $level_id }}">
                        <input type="hidden" name="application_id" value="{{ $noc_enc }}">
                            <div class="card-body">
                                <div class="form-group">
                                @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="form-group row" id="fields-container">
                                    <label for="inputFile" id="uplable" class="col-sm-2 col-form-label">Upload File</label>
                                    <div class="col-sm-4" id="col-sm-4">
                                  
                                     <textarea id="w3review" name="uploadremarks[]" rows="2"placeholder="Upload Description"class="form-control csp-clinic-textarea-margin"></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                    <input type="file" class="form-control" id="inputFile" name="uploadfile[]" accept=".pdf">
                                    </div>
                                  
                                    <div class="col-sm-1 csp-clinic-btn-border">

                                 
                                    <button type="button" id="add-more"class="btn btn-primary addmore csp-clinic-btn-darkblue">+</button>
                                   
                                    <button id="hideButton"class="btn btn-danger csp-clinic-btn-red"><i class="fa fa-trash" aria-hidden="true"></i></button>

                                        

                              
                                    </div>
                                </div>
                               
                                <br>

                                <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Remarks</label>
                                <div class="col-sm-6">
                                    <textarea id="w3review" name="remarks" rows="4" placeholder="Remarks..." class="form-control" ></textarea>
                                </div>
                            </div>
                               <br>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Select Your Recommendation</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="level_action" >
                                        <option value="">Select Your Recommendation</option>
                                        <option value="5">Reply back to assignee</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <input type="submit"                                  
                                     value="Submit" name="submit" class="btn btn-primary csp-clinic-btn-submit " />


                                </div> 
                            </div>
                         </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<script src="{{ url('public/js/jquery.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function(){
    $("#hideButton").hide();
    $("#add-more").click(function(){
        var newFieldGroup = $("#fields-container").first().clone();
        
        newFieldGroup.find("#uplable").text('');
        newFieldGroup.find("textarea").val('');
        newFieldGroup.find("input[type='file']").val('');

        var newId = "fields-container-" + Date.now();
        newFieldGroup.attr('id', newId);

        newFieldGroup.find(".addmore").hide();
        newFieldGroup.find("#hideButton").show();
        $("#fields-container").last().after(newFieldGroup);
    });

    $(document).on('click', '#hideButton', function(){
        // Remove the specific field group with the unique ID
        $(this).closest('.form-group').remove();
    });

    
});

</script>
@endsection();
<script nonce="{{ $cspNonce }}">
    window.onload = function() {
        <?php if (isset($_SESSION['success_message'])): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['success_message']; ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $_SESSION['error_message']; ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    };

     #dynamicCardBg {
        background-color: {{ $bgColor }};
    }
</script>
