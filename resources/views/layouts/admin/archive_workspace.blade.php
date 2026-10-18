@extends('layouts.admin.admin_master')
@section('content')

<style nonce="{{ $cspNonce }}">
    .csp-admin-message-alert{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .margin111-top {
        margin-top: 15px;
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

    .loader-container.active {
        display: flex; /* Show loader when active */
    }
    .csp-admin-card-header{
        background-color: #0000002e;
    }
    .csp-admin-message-danger{
        background-color: #830202; border-color: #830202; color: white;
    }
    .csp-admin-archive-label{
        color: #212130;
    }
    .csp-admin-al{
        width: 133px;
    }
    .csp-admin-display-none{
        display:none;
    }
    .csp-admin-heading{
        border: 1px solid rgb(5 5 201); width: 1108px; position: relative; left: -48px; margin: 20px auto;
    }
    .csp-admin-label-widh{
        width: 81px;
    }
    .csp-admin-remark-label{
        width: 100px;
    }
    .csp-admin-remark-color{
        color:#ff0000;
    }

    .csp-admin-other-remark{
        width:300px;
    }
    .widthselect{
        width:100%;
    }
</style>


 <link href="{{ url('public/css/select2.min.css') }}" rel="stylesheet"/>

    @if (session('success'))
        <div class="col-lg-6 offset-lg-3">
            <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-alert">
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

        <div class="row">
            <div class="col-md-12">
                
                <div class="card card-success">
                    <div class="card-header csp-admin-card-header">
                        <h3 class="card-title"><strong>Archive Work Space</strong></h3>
                    </div>
                    
                    <div class="container mt-5">
                        <div class="card border rounded p-5">
                        <form action="{{ route('add_archive') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="action_taken_by" value="{{ $user->username }}">
                            <input type="hidden" name="action_taken_id" value="{{ $user->userid }}">
                            <input type="hidden" name="type_of_clinic" id="type_of_clinic" value="">
                            <input type="hidden" name="archive_id" id="archive_id" value="">
                            <input type="hidden" name="userid" id="userid" value="">
                            {{-- <input type="hidden" name="application_no" id="application_no" value=""> --}}
                            @csrf

                            <div class="row csp-admin-display-none" id="errmess">
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>Data is not found</strong>
                                </div></label>
                            </div>
                            <div class="row csp-admin-display-none" id="for_approval">
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>Archive request is already under process.</strong>
                                </div></label>
                            </div>
                            <div class="row csp-admin-display-none" id="approved">
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>This application is already archived.</strong>
                                </div></label>
                            </div>
                            <div class="row csp-admin-display-none" id="unarchived_pending">
                                <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-danger">
                                    <strong>This application is pending for unarchived.</strong>
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
                            <div id="loader" class="loader-container csp-admin-display-none" >
                              <img src="{{url('public/images/loader.gif')}}" width="80px;">
                          </div>
                            <div class="row">
                                <div class="col-md-10 d-flex align-items-center">
                                    <label for="Archive" class="csp-admin-al"><strong>Application
                                        No.</strong></label>
                                        <select class="js-data-example-ajax widthselect" id="searchApp" name="searchApp"></select>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary" id="submitSearchOwn">Search</button>
                                </div>
                            </div>
                            <hr class="csp-admin-heading">

                            </br>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="application_no" class="form-label"><strong>Application Number</strong></label>
                                    <input type="text" class="form-control blankdata" readonly id="application_no" name="application_no" placeholder="Application No." value="">
                                </div>
                                <div class="col-md-4 mb-3" class="csp-admin-display-none" id="clinic_level_container">
                                    <label for="clinic_level" class="form-label"><strong>Clinic Level</strong></label>
                                    <input type="text" class="form-control blankdata" readonly id="clinic_level"
                                        name="clinic_level" placeholder="Clinic Level" value="">
                                </div>
                            </div>
                            {{-- <div class="row">                               
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
                            </div> --}}
                            
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
                                    <label for="Archive" class="col-form-label me-2 csp-admin-lable-width"><strong>Mobile
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
                            <hr class="csp-admin-heading">
                            {{-- <div class="row">
                                <div class="col-md-12 mb-2" id="remark_hide">
                                    <label for="Archive" style="width: 100px;" class="col-form-label me-1">
                                        <strong>Remarks<span style="color:#ff0000">*</span></strong>
                                    </label>
                                    <select id="remarks_select" name="remarks_select" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Duplicate Application as reported by State/UT">Duplicate Application as reported by State/UT</option>
                                        <option value="Application withdrawn/ Requested for cancellation as reported by State/UT">Application withdrawn/ Requested for cancellation as reported by State/UT</option>
                                        <option value="Closure of business">Closure of business</option>
                                        <option value="Any Other">Any Other</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <textarea id="remarks" name="remarks" class="form-control blankdata"  rows="4" cols="50" placeholder="Enter your Other Remarks here..."></textarea><br>
                                </div>
                                @error('remarks')
                                    <div class="remarks" style="margin-top: 10px; color: red;">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="row">
                                <div class="col-md-12 mb-2" id="remark_select_box">
                                    <label for="remarks_select" class="col-form-label" class="csp-admin-remark-lable">
                                        <strong>Remarks<span class="csp-admin-remark-color">*</span></strong>
                                    </label>
                                    <select id="remarks_select" name="remarks_select" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Duplicate Application as reported by State/UT">Duplicate Application as reported by State/UT</option>
                                        <option value="Application withdrawn/ Requested for cancellation as reported by State/UT">Application withdrawn/ Requested for cancellation as reported by State/UT</option>
                                        <option value="Closure of business">Closure of business</option>
                                        <option value="Any Other">Any Other</option>
                                    </select>
                                </div>
                            
                                <div class="col-md-12 mb-2" id="remark_input_box" class="csp-admin-display-none">
                                    <label for="other_remark_input" class="col-form-label csp-admin-other-remark">
                                        <strong>Other Remarks</strong><span class="csp-admin-remark-color">*</span>
                                    </label>
                                    <input type="text" id="other_remark_input" name="other_remark_input" class="form-control" placeholder=" remark">
                                </div>
                            
                                <!-- Hidden input to store final remark -->
                                <input type="hidden" name="remarks" id="remarks">
                            </div>
                            </br>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="hidebtnsubmit" class="csp-admin-display-none">Submit</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary">Close</a>
                            </div>
                            {{-- <button type="submit" class="btn btn-primary" id="hidebtnsubmit" class="csp-admin-display-none">Submit</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Close</a> --}}
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </br>

        
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
 <script nonce="{{ $cspNonce }}"  src="{{ url('public/js/select2.min.js') }}"></script> 

<!-- Include jQuery -->


<!-- Include JS for Select2 -->



<script nonce="{{ $cspNonce }}">   
    $('.js-data-example-ajax').select2({   
        ajax: {            
          url: '{{ route("fetch.applications") }}',  // Use the Laravel route helper to get the URL
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
                //  text: item.applicationno // Adjust according to your actual data
                  text: item.applicationno + ' - ' + item.clinicname
                };
              })
            };
          }
        }
      });
    //});
 </script>

















<script nonce="{{ $cspNonce }}">
    $(document).ready(function(){
        // When dropdown changes
        $('#remarks_select').on('change', function(){
            if($(this).val() === 'Any Other'){
                $('#remark_select_box').hide();
                $('#remark_input_box').show();
                $('#other_remark_input').focus();
            }
        });
    
        // On blur of input field, if empty revert back
        $('#other_remark_input').on('blur', function(){
            if ($(this).val().trim() === '') {
                $('#remark_input_box').hide();
                $('#remark_select_box').show();
                $('#remarks_select').val('');
            }
        });
    
        // On form submit, store the correct value in hidden input
        $('form').on('submit', function(e){
            let finalRemark = '';
            if ($('#remark_input_box').is(':visible') && $('#other_remark_input').val().trim() !== '') {
                finalRemark = $('#other_remark_input').val().trim();
            } else {
                finalRemark = $('#remarks_select').val();
            }
    
            $('#remarks').val(finalRemark);
        });
    });
    </script>
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

<script nonce="{{ $cspNonce }}">

function submitSearch(event) {
    if (event) event.preventDefault(); // Prevent normal form submit if event passed

    // Hide any previous messages
    $('#errmess, #for_approval, #approved, #unarchived_pending').hide();

    // Get selected radio button value and input value
    const radioButton = document.querySelector('input[name="searchOption"]:checked')?.value;
    const searchApp = document.querySelector('.js-data-example-ajax')?.value;

    if (!radioButton || !searchApp) {
        console.log("Please select a search option and fill the search input.");
        return false; // Validation failed
    }

    $.ajax({
        url: '{{ route("admin.fetchArchive") }}',
        method: 'GET',
        data: {
            radioButton: radioButton,
            searchApp: searchApp,
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $('#loader').show();
        },
        success: function(data) {
            $('#loader').hide();

            if (data && Object.keys(data).length > 0) {
                const record = data[0];

                if (record.archive_status == 1) {
                    $('#for_approval').show();
                    $('#hidebtnsubmit').hide();
                    $('.blankdata').val('');
                    return;
                } 
                else if (record.archive_status == 2) {
                    $('#approved').show();
                    $('#hidebtnsubmit').hide();
                    $('.blankdata').val('');
                    return;
                }
                else if (record.archive_status == 3) {
                    $('#unarchived_pending').show();
                    $('#hidebtnsubmit').hide();
                    $('.blankdata').val('');
                    return;
                }

                // Populate fields with returned data
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

                $('#hidebtnsubmit').show();
            } else {
                $('#hidebtnsubmit').hide();
                $('#errmess').show();
                $('.blankdata').val('');
            }
        },
        error: function(xhr, status, error) {
            $('#loader').hide();
            console.error('AJAX Error:', error);
        }
    });

    return false; // prevent form submit
}

$(document).ready(function () {
    $('#submitSearchOwn').on('click', function (e) {
        // Run submitSearch and prevent default if validation fails
        if (!submitSearch(e)) {
            e.preventDefault();
        }
    });
});
</script>


@endsection();