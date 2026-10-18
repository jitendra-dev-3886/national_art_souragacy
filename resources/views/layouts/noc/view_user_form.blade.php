@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .bc-csp-noc-one{
        background-color: #0b0283;
    }
    .marcolwhit-csp-noc-two{
        margin: 0;color: white;
    }
    .text-align-csp-noc-three{
        text-align: center;
    }
    
    .colorwhite-csp-noc-four{
        color:white;
    }
    .bg-color-csp-noc-five{
        background-color: white;
    }
    .margin-top-csp-noc-six{
        margin-top: 10px;
    }
    .margin-left-csp-noc-seven{
        margin-left: -77px;
    }
    
    .width-csp-noc-eight{
        width: 682px;
    }

    .wight-height-margin-left-nine{
        width: 61px; height: 38px; margin-left: 77px;
    }

    .margin-top-csp-noc-ten{
        margin-top: 4px;
    }

    .font-size-color-csp-noc-eleven{
        font-size: 12px; color: #e92a2a;
    }

    .bc-color-border-csp-noc-thirteen{
        background-color: #0b0283; border-color:#0b0283;
    }

    .btn-bc-csp-noc-fourteen{
        background-color:#b10826
    }

    .width-hight-margin-csp-noc-fifteen{
         width:82px; height:46px; margin-left:-185px;
    }

    .mar-left-mar-top-bc-cspnoc-sixteen{
        margin-left:881px; margin-top: 19px; background-color: #0b0283; border-color:#0b0283;
    }
    .mar-left-mt-bc-br-csp-noc-seventeen{
            margin-left: 768px; margin-top: 19px;background-color: #81142c; border-color:#81142c;
    }
    .font-size-color-csp-noc-eighteen{
        font-size: 12px; color: #e92a2a;
    }

    .dis-jus-space-alig-item-csp-noc-nineteen{
        display: flex; justify-content: space-between; align-items: center;
    }
    
    .btn-btn-border-color-csp-noc-twenty{
        --bs-btn-border-color:#6569e3;
    }

</style>
    {{-- <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    <div class="container-fluid">
        @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <div class="row">
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12 bc-csp-noc-one">
                        <div class="dis-jus-space-alig-item-csp-noc-nineteen">
                            <h4 class="marcolwhit-csp-noc-two">Application Number11: {{ $nocForm->application_no }}</h4>
                            <a href="{{ url('noc/myapplication') }}" class="button marcolwhit-csp-noc-two">Back</a>

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

                                    <div class="col-md-3">
                                        <label for="email" class="form-label">Marital Status</label>
                                        <input type="text" class="form-control" id="marital" name=""
                                            disabled="disabled" value="{{ $nocForm->district }}" required>

                                    </div>

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
                            $bgColor = array('bg-primary','bg-secondary','bg-success','bg-warning');
                              $i=0;
                            @endphp
                            @foreach ($links as $link => $title)
                                {{-- @php
                                    $bgColor = $linkColors[$link] ?? '#f39c12';
                            @endphp --}}

                                <div class="{{ $tabcss }} col-md-3">
                                    <div class="card-tiless @php echo $bgColor[$i]; @endphp">
                                        <div class="card-block p-22">
                                            <p class="text-dark text-center py-11">
                                                <a href="{{ url('noc/' . $link) }}/{{ Crypt::encrypt($noc_enc) }}/{{ Crypt::encrypt($level_id) }}" target="blank"
                                                    class="colorwhite-csp-noc-four">
                                                    <h4 class="text-white text-align-csp-noc-three">
                                                        {{ $title }}</h4>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- Remarks Section -->
                    <div class="alert alert-success bg-color-csp-noc-five">
                        <h4 class="m-0">Remarks</h4>
                    </div>
                    <!-- <div class="card"> -->
                    <form action="{{ route('add_user_remarks') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                       
                        <input type="hidden" name="level_id" value="{{ $level_id }}">
                        <input type="hidden" name="application_no" value="{{ $nocForm->application_no }}">
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
                                <div class="col-sm-1 margin-top-csp-noc-six">
                                    <input type="checkbox" @if (!empty(trim($medical_status->medical_report)) && $medical_status->medical_report === 'medical_report') checked @endif
                                        id="medical_report" name="medical_report" class="form-check-input" value="medical_report" />
                                </div>
                                <div class="col-sm-5 margin-left-csp-noc-seven">
                                    <input type="file" class="form-control width-csp-noc-eight" name="uploadfileMedical[]" accept=".pdf" id="fileInput_medical">
                                    <p class="font-size-color-csp-noc-eighteen" id="mess_medical">The maximum file size allowed for
                                        upload is 5 MB.</p>
                                </div>
                                {{-- <div class="col-sm-2">
                                    <img src="{{ url('public/images/refresh.png') }}" class="wight-height-margin-left-nine" id="resetInput_medical" />
                                </div> --}}
                            </div>
                             @endif

                           </br>

                                <div class="form-group row" id="fields-container">
                                    <!-- Label for the file input -->
                                    <label for="inputFile" id="uplable" class="col-sm-2 col-form-label">Upload
                                        File</label>

                                    <!-- Textarea for upload description -->
                                    <div class="col-sm-4" id="col-sm-4">
                                        <textarea  id="w3review" name="uploadremarks[]" rows="2"
                                            placeholder="File Description" class="form-control margin-top-csp-noc-ten"></textarea>
                                    </div>

                                    <!-- File input field -->
                                    <div class="col-sm-2 input-container" id="input-container">
                                        <input type="file" class="form-control inputFile_id" id="inputFile_id"
                                            name="uploadfile[]" accept=".pdf">
                                        <p class="font-size-color-csp-noc-eleven" id="mess">The maximum file size allowed for
                                            upload is 250 KB.</p>
                                    </div>

                                    <!-- Buttons for adding more files or removing an existing input -->
                                    <div class="col-sm-2 btn-btn-border-color-csp-noc-twenty">
                                        <button type="button" id="add-more" class="btn btn-primary addmore bc-color-border-csp-noc-thirteen">+</button>
                                        <button id="hideButton" class="btn btn-danger btn-bc-csp-noc-fourteen">
                                            -
                                        </button>

                                    </div>
                                    {{--<img src="{{ url('public/images/refresh.png') }}"
                                        class="width-hight-margin-csp-noc-fifteen" id="resetInput"> --}}
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
                              

                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <input type="submit"
                                            value="Submit" name="submit" class="btn btn-primary mar-left-mar-top-bc-cspnoc-sixteen" />
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary mar-left-mt-bc-br-csp-noc-seventeen" href="{{ route('noc.myapplication') }}">Close</a>

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
    {{-- <script nonce="{{ $cspNonce }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> --}}


    <style nonce="{{ $cspNonce }}">
        .margin111-top {
            margin-top: 15px;
        }
    </style>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
   

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


            document.addEventListener('DOMContentLoaded', function () {
            const maxFileSize = 250 * 1024; // 250 KB

            // Delegate event for dynamic elements
            document.body.addEventListener('change', function (e) {
                if (e.target && e.target.classList.contains('inputFile_id')) {
                    const fileInput = e.target;
                    const file = fileInput.files[0];

                    if (!file) return;

                    // Check file size
                    if (file.size > maxFileSize) {
                        alert('File size exceeds 250 KB.');
                        fileInput.value = ''; // Reset file input
                        return;
                    }

                    // Find corresponding description textarea in the same row
                    const parentRow = fileInput.closest('.form-group');
                    const description = parentRow.querySelector('textarea[name="uploadremarks[]"]');

                    //alert(description);

                    if (!description || description.value.trim() === '') {
                        alert('Please enter a description before uploading a file.');
                        fileInput.value = ''; // Reset file input
                        description.style.borderColor = 'red'; // Optional visual feedback
                        return;
                    } else {
                        description.style.borderColor = ''; // Reset border color if valid
                    }

                    // Optional: visual feedback on success
                    fileInput.style.borderColor = 'green';
                }
            });
        });

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

   
  $('#fileInput_medical').on('change', function () {
    
      const fileInput = document.getElementById('fileInput_medical');
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
      const fileType = file.type;
      if (fileType !== 'application/pdf') {
          alert('Please upload a PDF file.');
          fileInput.value = ''; // Reset the file input
          return;
      }
  });

</script>

@endsection();

