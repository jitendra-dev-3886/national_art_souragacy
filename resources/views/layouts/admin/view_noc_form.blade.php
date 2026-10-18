@extends('layouts.admin.admin_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-message-div2{
            background-color: #0b0283;
        }
        .csp-admin-div-tt{
            display: flex; justify-content: space-between; align-items: center;
        }
        .csp-admin-app-h4{
            margin: 0;color: white;
        }
        .csp-admin-opacity{
             opacity:0.8
        }

        .csp-admin-div1{
            display: flex; justify-content: space-between; align-items: center;
        }
        .csp-admin-app-h4{
            text-align:end; color:white;
        }

        .csp-admin-opacity{
            opacity:0.8;
        }
        .csp-admin-personal{
            color:#0b5ed7a1;
        }
        .csp-admin-th{
            background-color: #0b5ed7a1; color:white; text-align: center;
        }
        .csp-admin-card-title{
            background-color: #f39c12;
        }
        .csp-admin-medical-file{
            padding: 6px 12px;background: #0b0283;color: #fff; border-radius: 30px;margin-left: 5px;
        }
        .csp-admin-color-white{
            color:white;
        }
        .csp-admin-align-center{
            text-align: center;
        }
        .csp-admin-text-margin{
            margin-top: 4px;
        }
        .csp-admin-text-p{
            font-size: 12px; color: #e92a2a;
        }
        .csp-admin-button{
            background-color: #0b0283; border-color:#0b0283;
        }
        .csp-admin-button2{
            background-color:#b10826
        }
        .csp-admin-img-style{
            width: 82px; height: 46px; margin-left: -185px;
        }
        .csp-admin-submit{
            margin-left:881px; margin-top: 19px;background-color: #0b0283; border-color:#0b0283;
        }
        .csp-admin-anchor{
            margin-left: 768px; margin-top: 19px;background-color: #81142c; border-color:#81142c;
        }
        .csp-admin-anchor2{
            background-color:141481;border-color: 141481;
        }
        .csp-admin-label{
            padding: 6px 12px;background: #0b0283;color: #fff; border-radius: 30px;margin-left: 5px;
        }
        .csp-admin-label2{
            margin-left: 59px;
        }
        .csp-admin-div-margin{
            margin-left: 44px;
        }
        .csp-admin-div-margin2{
            margin-left:-138px;
        }
        .csp-admin-div-margin3{
            margin-left: 530px;
        }
        .csp-admin-submit2{
            margin-left: 879px; margin-top: -58px; background-color: #141481; border-color: #141481;
        }
        .csp-admin-last{
            --bs-btn-border-color:#6569e3
        }
        .margin111-top {
            margin-top: 15px;
        }

    </style>
    {{-- @php dd($medical_status->medical_report); @endphp --}}

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
            <style nonce="{{ $cspNonce }}">
                .table tbody tr td:last-child { text-align: start; padding-right: 1.563rem; }
                .table thead tr th:last-child { text-align: start; } -->
    </style>
    <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif --}}

    @if (session('success'))
        <div class="col-lg-6 offset-lg-3">
            <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                <strong> {{ session('success') }}</strong>
            </div>
        </div>
    @endif


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12 csp-admin-message-div2">
                        <div class="csp-admin-div-tt">
                            <h4 class="csp-admin-app-h4">Application Number: {{ $nocForm->application_no }}</h4>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header position-relative d-flex justify-content-between align-items-center">
                            <div></div>
                            <h4 class="card-title position-absolute top-50 start-50 translate-middle text-primary csp-admin-opacity">
                                Noc application for foreigner for Transferring Outside India
                            </h4>
                            <div></div>
                        </div>
                        <div class="card-header">
                            <h4 class="card-title">Basic Details</h4>
                        </div>
                        <div class="card-body">

                            <form id="registrationForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Name of the Applicant</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            disabled="disabled" value="{{ $nocForm->name_applicant }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Marital Status</label>
                                        <input type="text" class="form-control" id="marital" name=""
                                            disabled="disabled" value="{{ $nocForm->m_status }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="password" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->address }}" required>

                                    </div>

                                    @if($nocForm->nationality_applicant == 'Foreigner')
                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->country_applicant }}" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>
                                        <div class="col-md-3">
                                            <label for="username" class="form-label">Zipcode</label>
                                            <input type="text" class="form-control" id="" name=""
                                                disabled="disabled" value="{{ $nocForm->zipcode }}" required>
                                            <div class="invalid-feedback">Please enter your full name.</div>
                                        </div>
                                    
                                     @else
                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Pincode</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->pincode }}" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">State</label>
                                        <input type="email" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->state }}" required>

                                    </div>
                                 @endif
                               <!--      <div class="col-md-3">
                                        <label for="email" class="form-label">Marital Status</label>
                                        <input type="text" class="form-control" id="marital" name=""
                                            disabled="disabled" value="{{ $nocForm->district }}" required>

                                    </div> -->

                                    <div class="col-md-3">
                                        <label for="password" class="form-label">Email Address</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->email }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Date of Birth</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->dob_applicant }}" required>
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
                            @php 
                            $arr = array('bg-primary','bg-secondary','bg-success','bg-warning');
                            $i=0;
                            @endphp

                            @foreach ($links as $link => $title)
                                @php
                                    $bgColor = $linkColors[$link] ?? '#f39c12';
                                @endphp

                                <div class="{{ $tabcss }} col-md-3">
                                    <div class="card-tiless @php echo $arr[$i]; @endphp ">
                                        <div class="card-block p-22">
                                            <p class="text-dark text-center py-11">
                                                <a href="{{ url('admin/' . $link) }}/{{ Crypt::encrypt($noc_enc) }}" target="_blank" class="csp-admin-color-white">
                                                    <h4 class="text-white csp-admin-align-center"> {{ $title }}</h4>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                   
                            <div class="card-body">
                                <div class="form-group">
                                  
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('nocgenrate_foreigner') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="created_at" value="{{ $created_at }}">
                                        <input type="hidden" name="level_id" value="{{ $level_id }}">
                                        <input type="hidden" name="application_id" value="{{ $noc_enc }}">

                                        <div class="row csp-admin-div-margin">
                                            <div class="col-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="internal_recommanation"
                                                        type="checkbox" value="YES" autocomplete="off">
                                                    <label class="form-check-label" for="gridCheck"><strong>
                                                            Internal Recommendation</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="external_commitee"
                                                        type="checkbox" value="YES" autocomplete="off">
                                                    <label class="form-check-label" for="gridCheck"><strong>
                                                            External committee Recommendation</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="appex_commitee" type="checkbox"
                                                        value="YES" autocomplete="off">
                                                    <label class="form-check-label" name="appex_commitee"
                                                        for="gridCheck"><strong>
                                                            Apex committee Approval check</strong>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="approval_checked" value="YES" autocomplete="off">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="approval_checked"
                                                        value="All the necessary approval Checked after the define the application in">
                                                    <label class="form-check-label" for="gridCheck"><strong>
                                                            All the necessary approval Checked after the define the
                                                            application in </strong>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="inputFile" id="uplable" class="csp-admin-label2"
                                                    class=" col-sm-2  col-form-label">Remarks</label>
                                            </div>
                                            <div class="col-sm-3 csp-admin-div-margin2">
                                                <textarea id="w3review" name="remarks" rows="2" placeholder="remarks" class="form-control csp-admin-text-margin"></textarea>
                                            </div>

                                            <div class="col-sm-2">
                                                <input type="file" class="form-control" placeholder="upload sign noc"
                                                    id="inputFile" name="uploadfile" accept=".pdf" autocomplete="off">
                                            </div>
                                            <div class="col-sm-2 csp-admin-last">
                                                <a href="{{ url('noc/noc-pdf/' . $noc_enc) }}" id="generateNocBtn" class="btn btn-info csp-admin-anchor2">Genrate Noc</a>
                                            </div>

                                            <div class="col-sm-2 csp-admin-div-margin3">
                                                <input type="submit" value="Submit" name="submit" class="btn btn-primary csp-admin-submit2" />
                                            </div>
                                        </div>
                                    </form>
                 
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

@endsection();
    

<script nonce="{{ $cspNonce }}"  src="{{ url('public/js/jquery.min.js') }}"></script>
<script nonce="{{ $cspNonce }}" >

    
$(document).ready(function() {
    $('#inputFile_id').change(function(evt){

        var textareas = document.getElementsByClassName('fileupload');
           for (var i = 0; i < textareas.length; i++) {
            var fileInput = document.getElementsByClassName('inputFile_id')[i];
            if(textareas[i].value == ''){
                alert('Please input file description');
                $('.inputFile_id').eq(i).val('');
                return false;
                
              }
            
           }
    });
});
    $(document).ready(function() {
        var addCount = 0;
        var maxFields = 3; // Maximum number of fields allowed to be added

        // Initially hide the "Hide" button
        $("#hideButton").hide();

        // Handle the click event for the "Add More" button
        $("#add-more").click(function() {
            if (addCount < maxFields) { // Only allow adding up to 3 fields
                var newFieldGroup = $("#fields-container").first().clone();

                newFieldGroup.find("#uplable").text('');
                newFieldGroup.find("textarea").val('');
                newFieldGroup.find("input[type='file']").val('');

                var newId = "fields-container-" + Date.now();
                newFieldGroup.attr('id', newId);

                newFieldGroup.find(".addmore").hide();
                newFieldGroup.find("#resetInput").hide();
                newFieldGroup.find("#hideButton").show();
                $("#fields-container").last().after(newFieldGroup);

                addCount++; // Increment the counter after adding a new field
            }

            // Hide the "Add More" button if the maximum number of fields is reached
            if (addCount >= maxFields) {
                $(this).hide(); // Optionally hide the "Add More" button after reaching the limit
            }
        });

        // Handle the click event for the "Hide" button to remove a field
        $(document).on('click', '#hideButton', function() {
            var parentGroup = $(this).closest('.form-group');
            parentGroup.remove();

            addCount--; // Decrement the counter when a field is removed

            // Show the "Add More" button again if fields are removed and the count is less than the max
            if (addCount < maxFields) {
                $("#add-more").show(); // Re-show the "Add More" button
            }
        });

        $(document).on('click', '#resetInput', function() {
               // alert('sdfsdf');
                const inputContainer = document.getElementById('input-container');
                const fileInputs = inputContainer.querySelectorAll('input[type="file"]');
                fileInputs.forEach(function(input) {
                    input.value = '';
                    $('#mess').show();
                });
            });

            $('#inputFile_id').on('change', function() {
                var fileName = $(this).val();
                 if(fileName !=''){
                    $('#mess').hide();
                 }
              });
    });
</script>
