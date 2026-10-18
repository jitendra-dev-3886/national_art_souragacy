@extends('layouts.admin.admin_master')
@section('content')
<style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #b8b8bd; border-color: #0b5ed7; color: white;
        }
        .csp-admin-message-danger{
            background-color: #830202; border-color: #830202; color: white;
        }
        .loader-container {
            display: none; /* Hide loader by default */
            position: fixed; /* Position it fixed so it stays in place */
            top: 550;
            left: 940;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0); /* Optional: background overlay */
            z-index: 10; /* Low z-index so input is above it */
        }
        .csp-admin-archive-hr{
            border: 1px solid rgb(5 5 201); width: 1108px; position: relative; left: -48px; margin: 20px auto;
        }

        .loader-container.active {
            display: flex; /* Show loader when active */
        }
        .csp-admin-archive-label{
            color: #212130;
        }
        .csp-admin-div-none{
            display: none;
        }
        .csp-admin-label-width{
            width: 81px;
        }
        .csp-admin-label-100{
            width: 100px;
        }

        .csp-admin-textarea{
            margin-left:-28px;
        }
        .csp-admin-remark{
            margin-top: 10px; color: red;
        }
        .csp-admin-submit{
            display:none; margin-left:66px;
        }

    </style>
    {{-- @php dd($medical_status->medical_report); @endphp --}}

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
                                    <style nonce="{{ $cspNonce }}">
                                        .table tbody tr td:last-child { text-align: start; padding-right: 1.563rem; }
                                        .table thead tr th:last-child { text-align: start; } -->
    </style>
    {{-- <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
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
        <!-- {{-- <div class="row">
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12" style="background-color: #0b0283;">
                        {{-- <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="margin: 0;color: white;">Application Number: {{ $data->appno }}</h4>

                        </div> --}}
        {{-- </div>
                </div>
            </div>
        </div> --}} -->

<link href="/css/select2.min.css" rel="stylesheet"/>
        <div class="row">
            <div class="col-md-12">
                
                <div class="card card-success">
                    <div class="card-header csp-admin-message-div">
                        <h3 class="card-title" ><strong>Unarchive Work Space</strong></h3>
                    </div>
                    
                    <div class="container mt-5">
                        <div class="card border rounded p-5">
                        <form action="{{ route('add_unarchive') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action_taken_by" value="{{ $user->username }}">
                            <input type="hidden" name="action_taken_id" value="{{ $user->userid }}">
                            <input type="hidden" name="type_of_clinic" id="type_of_clinic" value="">
                            <input type="hidden" name="archive_id" id="archive_id" value="">
                            <input type="hidden" name="userid" id="userid" value="">
                            {{-- <input type="hidden" name="application_no" id="application_no" value=""> --}}
                            @csrf

                            <div class="row csp-admin-div-none" id="errmess" >
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>Data is not found</strong>
                                </div></label>
                            </div>
                            <div class="row csp-admin-div-none" id="for_approval">
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>Archive request is already under process.</strong>
                                </div></label>
                            </div>
                            <div class="row csp-admin-div-none" id="approved">
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>This application is already archived.</strong>
                                </div></label>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="Archive" class="col-form-label me-2 csp-admin-archive-label"><strong>ART Clinic</strong></label>
                                    <input type="radio" id="art_clinic" name="searchOption" value="art_clinic">
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="Archive" class="col-form-label me-2 csp-admin-archive-label"><strong>ART Bank</strong></label>
                                    <input type="radio" id="art_bank" name="searchOption" value="art_bank">
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <label for="Archive" class="col-form-label me-2 csp-admin-archive-label"><strong>Surrogacy Clinic</strong></label>
                                    <input type="radio" id="art_surrogacy" name="searchOption" value="art_surrogacy">
                                </div>
                            </div>
                            </br>
                            <div id="loader" class="loader-container csp-admin-div-none">
                              <img src="{{url('public/images/loader.gif')}}" width="80px;">
                          </div>
                          <div class="row">
                            <div class="col-md-10 d-flex align-items-center">
                                <label for="Archive" class="col-form-label me-2 csp-admin-label-width"><strong>Application
                                    No.</strong></label>
                                <!-- {{-- <input type="text" id="searchApp" name="searchApp" class="form-control" placeholder="Enter Application No."
                                    value=""> --}}
                                    {{-- <select id="searchApp" name="searchApp" style="width: 200px;">
                                        <option value="">Select Application Number</option>
                                    </select> --}} -->
                                    <select class="js-data-example-ajax" id="searchApp" name="searchApp"></select>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="submit" class="btn btn-primary" id="searchButton">Search</button>
                            </div>
                        </div>
                        <hr class="csp-admin-archive-hr">

                        </br>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="application_no" class="form-label"><strong>Application Number</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="application_no"
                                    name="application_no" placeholder="Application No." value="">
                            </div>
                            <div class="col-md-4 mb-3 csp-admin-div-none" id="clinic_level_container">
                                <label for="clinic_level" class="form-label"><strong>Clinic Level</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="clinic_level"
                                    name="clinic_level" placeholder="Clinic Level" value="">
                            </div>
                        </div>
                        <!-- {{-- <div class="row">                               
                            <div class="col-md-8 d-flex align-items-center">
                                <label for="application_no" class="col-form-label me-2"><strong>Application Number</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="application_no"
                                    name="application_no" placeholder="Application No." value="">                                    
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <label for="Archive" class="col-form-label me-1"><strong>Clinic Level</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="clinic_level"
                                    name="clinic_level" placeholder="Clinic Level" value="">
                            </div>                             
                        </div> --}} -->
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="Archive" class="col-form-label me-1"><strong>Clinic Name</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="clinic_name"
                                    name="clinic_name" placeholder="Clinic Name" value="">
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="remarks" class="col-form-label me-3"><strong>Address</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="address"
                                    name="address" placeholder="Address" value="">
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="description" class="col-form-label me-2"><strong>State</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="state"
                                    name="state" placeholder="State" value="">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="Archive"
                                    class="col-form-label me-2"><strong>District</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="district"
                                    name="district" placeholder="District" value="">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="remarks" class="col-form-label me-1"><strong>Pincode</strong></label>
                                <input type="text" class="form-control blankdata " readonly id="pincode"
                                    name="pincode" placeholder="Pincode" value="">
                            </div>  
                        </div>

                        </br>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="Archive" class="col-form-label me-2 csp-admin-label-width"><strong>Mobile
                                    No</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="mobile_no"
                                    name="mobile_no" placeholder="Mobile No" value="">
                            </div>

                            <div class="col-md-4 mb-3">
                              <label for="description" class="col-form-label me-3"><strong>Email</strong></label>
                              <input type="text" class="form-control blankdata" readonly id="email"
                                  name="email" placeholder="Email" value="">
                          </div>


                            <div class="col-md-4 mb-3">
                                <label for="description" 
                                    class="col-form-label me-2"><strong>Date of Online form Submission</strong></label>
                                <input type="text" class="form-control blankdata" readonly id="date"
                                    name="date" placeholder="Date of Online form Submission" value="">
                            </div>
                        </div>
                            </br>
                            <hr class="csp-admin-archive-hr">
                            <div class="row">
                                <div class="col-md-12 d-flex align-items-center">
                                    <label for="Archive" class="col-form-label me-1 csp-admin-label-100"><strong>Remarks</strong></label>
                                    <textarea id="remarks" name="remarks" class="form-control blankdata csp-admin-textarea" rows="4" cols="50"
                                        placeholder="Enter your Remarks here..."></textarea><br>
                                </div>
                                @error('remarks')
                                       <div class="remarks csp-admin-remark" >{{ $message }}</div>
                                @enderror

                            </div>
                            </br>
                            <button type="submit" class="btn btn-primary csp-admin-submit" id="hidebtnsubmit">Submit</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </br>

        


<style nonce="{{ $cspNonce }}">
    .margin111-top {
        margin-top: 15px;
    }
</style>
<!-- <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script> 
<script nonce="{{ $cspNonce }}">
    $(document).ready(function(){
        $('input[name="searchOption"]').on('change', function(){
            if($('#art_clinic').is(':checked')){
                $('#clinic_level_container').show();
            } else {
                $('#clinic_level_container').hide();
            }
        });
    });
</script>


{{-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('input[name="searchOption"]').change(function() {
            $("#application_no").val('');
            $("#clinic_name").val('');
            $("#clinic_level").val('');
            $("#address").val('');
            $("#email").val('');
            $("#mobile_no").val('');
            $("#state").val('');
            $("#district").val('');
            $("#pincode").val('');
            $("#date").val('');
            let selectedValue = $('input[name="searchOption"]:checked').val(); // Get selected radio button value
         //   let token = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token
    // console.log(selectedValue);
            if (selectedValue) {
                $.ajax({
                    url: "{{ route('unfetch.applications') }}",
                    type: "GET",
                    data: { applicationType: selectedValue, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        $('#searchApp').empty().append('<option value="">Select Application Number</option>');
                        $.each(response, function(index, value) {
                            $('#searchApp').append('<option value="' + value + '">' + value + '</option>');
                        });
                    },
                    error: function() {
                        alert("Error fetching application numbers");
                    }
                });
            }
        });
    });
    </script> --}}




    <script nonce="{{ $cspNonce }}">
        $(document).ready(function(){
            $('input[name="searchOption"]').on('change', function(){
                $(".js-data-example-ajax").val('');
                $("#application_no").val('');
                $("#clinic_name").val('');
                $("#clinic_level").val('');
                $("#address").val('');
                $("#email").val('');
                $("#mobile_no").val('');
                $("#state").val('');
                $("#district").val('');
                $("#pincode").val('');
                $("#date").val('');
                
                if($('#art_clinic').is(':checked')){
                    $('#clinic_level_container').show();
                } else {
                    $('#clinic_level_container').hide();
                }
            });
        });
    </script>








<script nonce="{{ $cspNonce }}" >
    $(document).ready(function () {
        $('#searchButton').on('click', function (event) {
            event.preventDefault(); // Prevents form from submitting normally
            $('#errmess').css('display', 'none');

            const radioButton = $('input[name="searchOption"]:checked').val();
            const searchApp = $('.js-data-example-ajax').val();

            if (radioButton && searchApp) {
                $.ajax({
                    url: '{{ route('admin.unfetchArchive') }}',
                    method: 'GET',
                    data: {
                        radioButton: radioButton,
                        searchApp: searchApp,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#loader').show();
                    },
                    success: function (data) {
                        $('#loader').hide();

                        if (data && Object.keys(data).length > 0) {
                            const record = data[0];

                            $('#application_no').val(record.applicationno || '');
                            $('#archive_id').val(record.id || '');
                            $('#userid').val(record.userid || '');
                            $('#clinic_name').val(record.clinicname || '');
                            $('#clinic_level').val(record.cliniclevel || '');
                            $('#address').val(record.address || '');
                            $('#email').val(record.email || '');
                            $('#mobile_no').val(record.mobile || '');
                            $('#user_name').val(record.email || '');
                            $('#state').val(record.state || '');
                            $('#district').val(record.district || '');
                            $('#pincode').val(record.pincode || '');
                            $('#date').val(record.datetime_decision || '');
                            $('#type_of_clinic').val(record.type_of_clinic || '');

                            $('#hidebtnsubmit').css('display', 'block');
                        } else {
                            $('#hidebtnsubmit').css('display', 'none');
                            $('#errmess').css('display', 'block');
                            $('.blankdata').val('');
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#loader').hide();
                        console.error('AJAX Error:', error);
                    }
                });
            } else {
                console.log("Please select a search option and fill the search input.");
            }
        });
    });
</script>
<script nonce="{{ $cspNonce }}" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script nonce="{{ $cspNonce }}">   
    $('.js-data-example-ajax').select2({   
        
          ajax: {            
          url: '{{ route("unfetch.applications") }}',  // Use the Laravel route helper to get the URL
          type: 'POST',  // Change to POST request
          dataType: 'json',
          data: function (params) {
            return {
              q: params.term ,// Send the search term via POST as 'q'
              selected_type: $('input[name="searchOption"]:checked').val(),
              
              _token: '{{ csrf_token() }}' ,
            };
          },
          processResults: function (data) {
            // Process the results from the server and return them in the expected format
            return {
              results: data.items.map(function (item) {
                return {
                  id: item.id,
                  text: item.applicationno // Adjust according to your actual data
                };
              })
            };
          }
        }
      });
    //});
 </script>
@endsection();