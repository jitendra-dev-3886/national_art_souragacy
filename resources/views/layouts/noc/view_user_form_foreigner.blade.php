@extends('layouts.noc.noc_master')
@section('content')
    <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12" style="background-color: #0b0283;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="margin: 0;color: white;">Application Number: {{ $nocForm->application_no }}</h4>
                            <a href="{{ url('noc/myapplication') }}" class="button" style="margin: 0;color: white;">Back</a>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Basic Details</h4>
                        </div>
                        <div class="card-body">

                            <form id="registrationForm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Name of the Applicant</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            disabled="disabled" value="{{ $nocForm->name_applicant ?? 'N/A' }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Marital Status</label>
                                        <input type="text" class="form-control" id="marital" name=""
                                            disabled="disabled" value="{{ $nocForm->m_status ?? 'N/A' }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="password" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->address ?? 'N/A' }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Pincode</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->pincode ?? 'N/A' }}" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>

                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <label for="email" class="form-label">State</label>
                                        <input type="email" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->state ?? 'N/A' }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Marital Status</label>
                                        <input type="text" class="form-control" id="marital" name=""
                                            disabled="disabled" value="{{ $nocForm->district ?? 'N/A' }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="password" class="form-label">Email Address</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->email ?? 'N/A' }}" required>

                                    </div>

                                    <div class="col-md-3">
                                        <label for="username" class="form-label">Date of Birth</label>
                                        <input type="text" class="form-control" id="" name=""
                                            disabled="disabled" value="{{ $nocForm->dob_applicant ?? 'N/A' }}" required>
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
                                    <div class="card-tiless" style="background-color:{{ $bgColor }};">
                                        <div class="card-block p-22">
                                            <p class="text-dark text-center py-11">
                                                <a href="{{ url('noc/' . $link) }}/{{ Crypt::encrypt($noc_enc) }}/{{ Crypt::encrypt($level_id) }}" target="blank"
                                                    style="color:white;">
                                                    <h4 class="text-white" style="text-align: center;">
                                                        {{ $title }}</h4>
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
                    <div class="alert alert-success" style="background-color: white;">
                        <h4 class="m-0">Remarks</h4>
                    </div>
                    <!-- <div class="card"> -->
                    <form action="{{ route('add_user_remarks_foreigner') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="level_id" value="{{ $level_id }}">
                        <input type="hidden" name="application_id" value="{{ $noc_enc }}">
                        <input type="hidden" name="created_at" value="{{ $created_at }}">
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
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                        @if (!empty(trim($medical_status->medical_report))) 
                            <div class="form-group row">
                                <label for="inputFile" id="uplable" class="col-sm-2 col-form-label">Upload Medical Report</label>
                                <div class="col-sm-1" style="margin-top: 10px;">
                                    <input type="checkbox" @if (!empty(trim($medical_status->medical_report)) && $medical_status->medical_report === 'medical_report') checked @endif
                                        id="medical_report" name="medical_report" class="form-check-input" value="medical_report" />
                                </div>
                                <div class="col-sm-5" style="margin-left: -77px;">
                                    <input type="file" class="form-control" name="uploadfileMedical[]" accept=".pdf" style="width: 682px;" id="fileInput_medical" onchange="validateFile()">
                                    <p style="font-size: 12px; color: #e92a2a;" id="mess_medical">The maximum file size allowed for
                                        upload is 5 MB.</p>
                                </div>
                                <div class="col-sm-2">
                                    <img src="{{ url('public/images/refresh.png') }}" style="width: 61px; height: 38px; margin-left: 77px;" id="resetInput_medical" />
                                </div>
                            </div>
                             @endif

                           </br>

                                <div class="form-group row" id="fields-container">
                                    <!-- Label for the file input -->
                                    <label for="inputFile" id="uplable" class="col-sm-2 col-form-label">Upload
                                        File</label>

                                    <!-- Textarea for upload description -->
                                    <div class="col-sm-4" id="col-sm-4">
                                        <textarea style="margin-top: 4px;" id="w3review" name="uploadremarks[]" rows="2"
                                            placeholder="File Description" class="form-control"></textarea>
                                    </div>

                                    <!-- File input field -->
                                    <div class="col-sm-2 input-container" id="input-container">
                                        <input type="file" class="form-control inputFile_id" id="inputFile_id"
                                            name="uploadfile[]" accept=".pdf">
                                        <p style="font-size: 12px; color: #e92a2a;" id="mess">The maximum file size allowed for
                                            upload is 250 KB.</p>
                                    </div>

                                    <!-- Buttons for adding more files or removing an existing input -->
                                    <div class="col-sm-2" style="--bs-btn-border-color:#6569e3">
                                        <button type="button" id="add-more" class="btn btn-primary addmore"
                                            style="background-color: #0b0283; border-color:#0b0283;">+</button>
                                        <button id="hideButton" class="btn btn-danger" style="background-color:#b10826">
                                            -
                                        </button>

                                    </div>
                                    <img src="{{ url('public/images/refresh.png') }}"
                                        style="width: 82px; height: 46px; margin-left: -185px;" id="resetInput">
                                </div>

                                <br>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Remarks</label>
                                    <div class="col-sm-6">
                                        <textarea id="w3review" name="remarks" rows="8" placeholder="Remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    {{-- <label for="inputEmail" class="col-sm-2 col-form-label">Select Your Recommendation</label> --}}
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Select Your Reply</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="level_action">
                                            <option value="">Select</option>
                                            <option value="5">Reply back</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-sm-8"></div>
                                    <div class="col-sm-2">
                                        <input type="submit" style="background-color: #0b0283; border-color:#0b0283;"
                                            value="Submit" name="submit" class="btn btn-primary" />
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <input type="submit"
                                            style="margin-left:881px;
                                   margin-top: 19px;background-color: #0b0283; border-color:#0b0283;"
                                            value="Submit" name="submit" class="btn btn-primary" />

                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary" style="margin-left: 768px;
                                   margin-top: 19px;background-color: #81142c; border-color:#81142c;" href="{{ route('noc.myapplication') }}">Close</a>

                                    </div>
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


    <style nonce="{{ $cspNonce }}">
        .margin111-top {
            margin-top: 15px;
        }
    </style>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
    {{-- <script nonce="{{ $cspNonce }}">
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

</script> --}}

    <script nonce="{{ $cspNonce }}">
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
                const inputContainer = document.getElementById('input-container');
                const fileInputs = inputContainer.querySelectorAll('input[type="file"]');
                fileInputs.forEach(function(input) {
                    input.value = '';
                    $('#mess').show();
                });
            });

            $(document).on('click', '#resetInput_medical', function() {
                const inputContainer = document.getElementById('fileInput_medical');
                inputContainer.value = ''; 
                $('#mess_medical').show();    
            });


            $('#fileInput_medical').on('change', function() {
                var fileName = $(this).val();
                 if(fileName !=''){
                    $('#mess_medical').hide();
                 }
              });


              $('#inputFile_id').on('change', function() {
                var fileName = $(this).val();
                 if(fileName !=''){
                    $('#mess').hide();
                 }
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




<script nonce="{{ $cspNonce }}">
   
    $('#fileInput_medical').on('change', function () {
    const fileInput = this; // use `this` to refer to the current input element
    const file = fileInput.files[0];

    if (!file) {
        alert('Please select a file to upload.');
        return;
    }

    // Check file size (5MB in bytes)
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        alert('File is too large. Maximum size is 5MB.');
        fileInput.value = ''; // Reset the file input
        return;
    }

    // Check if the file is a PDF
    if (file.type !== 'application/pdf') {
        alert('Please upload a PDF file.');
        fileInput.value = ''; // Reset the file input
        return;
    }

    // Optional: Proceed with file upload or further processing here
});

</script>
