@extends('layouts.admin.ssa_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .color-csp-email-change {
            color: red;
        }
    .marquee-container-csp-email-change {
        width: 100%;
        overflow: hidden;
        background-color: #ffffff;
        color: #f01717;
        padding: 10px 0;
        font-weight: bold;
        white-space: nowrap;
    }

    .marquee-text-csp-email-change {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 12s linear infinite;
    }

    @keyframes marquee {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(-100%);
        }
    }
</style>


<div class="container-fluid">
    <div class="card shadow">
        <div class="marquee-container-csp-email-change">
            <div class="marquee-text-csp-email-change">
                This Clinic Email Change facility is available till 13-08-2026.
            </div>
        </div>
        <div class="card-header bg-light text-white">
            <h4>Clinic Email Change Request</h4>
        </div>

        <div class="card-body">
           @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form id="clinicForm" action="{{ route('clinic.email_change') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Application No</label>
                        <input type="text" id="clinic_applicaion_no" name="application_no" class="form-control" value="{{ old('application_no') }}">
                        <small class="text-danger" id="application_no_error"></small>
                        @error('application_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Registration No</label>
                        <input type="text" id="registration_no" name="registration_no" class="form-control" value="{{ old('registration_no') }}">
                        <small class="text-danger" id="registration_no_error"></small>
                        @error('registration_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="row mb-3">
                        <div class="col-md-6">
                        <label class="form-label">Date of Registration</label>
                        <input type="date" id="registration_date" name="registration_date" class="form-control" value="{{ old('registration_date') }}">
                        <small class="text-danger" id="registration_date_error"></small>
                        @error('registration_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                        <label class="form-label">Name Of  Clinic/Bank</label>
                        <input type="text" id="clinic_name" name="clinic_name" class="form-control" value="{{ old('clinic_name') }}" readonly>
                        <small class="text-danger" id="clinic_name_error"></small>
                        @error('clinic_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

            
               </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input type="text" id="state" name="state" class="form-control" value="{{ old('state') }}" readonly>
                        <small class="text-danger" id="state_error"></small>
                        @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">District</label>
                        <input type="text" id="district" name="district" class="form-control" value="{{ old('district') }}" readonly>
                        <small class="text-danger" id="district_error"></small>
                        @error('district') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Type of Clinic/Bank</label>
                        <input type="text" id="clinic_type" name="clinic_type" class="form-control" value="{{ old('clinic_type') }}" readonly>
                        <small class="text-danger" id="clinic_type_error"></small>
                        @error('clinic_type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Level of the Clinic</label>
                        <input type="text" id="clinic_level" name="clinic_level" class="form-control" value="{{ old('clinic_level') }}" readonly>
                        <small class="text-danger" id="clinic_level_error"></small>
                        @error('clinic_level') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>


                {{-- <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name of Contact Person</label>
                        <input type="text" id="contact_person_name" name="contact_person_name" class="form-control" value="{{ old('contact_person_name') }}">
                        <small class="text-danger" id="contact_person_name_error"></small>
                        @error('contact_person_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile of Contact Person</label>
                        <input type="text" id="contact_mobile" name="contact_mobile" class="form-control" value="{{ old('contact_mobile') }}">
                        <small class="text-danger" id="contact_mobile_error"></small>
                        @error('contact_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div> --}}


                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Registered Clinic Contact</label>
                        <input type="text" id="clinic_phone" name="clinic_phone" class="form-control" value="{{ old('clinic_phone') }}" readonly>
                        <small class="text-danger" id="clinic_phone_error"></small>
                        @error('clinic_phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" readonly>
                        <small class="text-danger" id="address_error"></small>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Registered Email ID of Clinic</label>
                        <input type="email" id="old_clinic_email" name="old_clinic_email" class="form-control" value="{{ old('old_clinic_email') }}" readonly>
                        <small id="emailAlert" class="text-success d-none"></small>

                        <!-- Load Details Button -->
                        {{-- <button type="button" id="loadDetailsBtn" class="btn btn-info mt-2 d-none">Load Details</button> --}}

                        @error('old_clinic_email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reason for Change of Registered Email ID</label>
                        <input type="text" id="change_reason" name="change_reason" class="form-control" value="{{ old('change_reason') }}">
                        <small class="text-danger" id="change_reason_error"></small>
                        @error('change_reason') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div> 
                <div id="emailRecordsTable" class="mt-3 d-none">
                            <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                            <tr>
                            <th>Sr. No.</th>
                            <th>Application Type</th>
                            <th>Application No</th>
                            <th>Registration No</th>
                            </tr>
                            </thead>
                            <tbody id="emailRecordsBody"></tbody>
                            </table>
                </div>
                <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Desired Email ID</label>
                            <input type="email" id="new_clinic_email" name="new_clinic_email" class="form-control" value="{{ old('new_clinic_email') }}">
                            <small class="text-danger" id="new_clinic_email_error"></small>
                            <div id="availability" class="mt-2"></div>
                            @error('new_clinic_email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirm Desired Email ID</label>
                            <input type="email" id="new_clinic_email_confirm" name="new_clinic_email_confirm" class="form-control">
                            <small class="text-danger" id="new_clinic_email_confirm_error"></small>
                        </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Desired Mobile Number of Clinic</label>
                        <input type="number" id="new_clinic_mobile" name="new_clinic_mobile" class="form-control" value="{{ old('new_clinic_mobile') }}" pattern="[4-9][0-9]{9}" maxlength="10">
                        <small class="text-danger" id="new_clinic_mobile_error"></small>
                        @error('new_clinic_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Desired Mobile Number</label>
                        <input type="number" id="new_clinic_mobile_confirm" class="form-control" pattern="[4-9][0-9]{9}" maxlength="10">
                        <small class="text-danger" id="new_clinic_mobile_confirm_error"></small>
                    </div>
                </div>
                <div class="row mb-3">
                   <label class="form-label">Upload Request Letter (PDF/JPG/PNG)</label>
                    <input type="file" id="request_letter_path" name="request_letter_path" class="form-control">
                    <small class="text-danger" id="request_letter_path_error"></small>
                    @error('request_letter_path') 
                    <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>
                <div class="row mb-3 card-header bg-white">
                    <h4 class="card-header bg-light">Details of the Person who requested for Access change</h4>
                </div>
                
                    
                    
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Name Of Authorized Person</strong></label>
                        <input type="text" id="authorized_person_name" name="authorized_person_name" class="form-control" value="{{ old('authorized_person_name') }}">
                        <small id="authorized_person_name_error" class="error text-danger"></small>
                        @error('authorized_person_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Designation</strong></label>
                        <input type="text" id="authorized_person_designation" name="authorized_person_designation" class="form-control" value="{{ old('authorized_person_designation') }}">
                        <small class="text-danger" id="authorized_person_designation_error"></small>
                        @error('authorized_person_designation') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Mobile No</strong></label>
                        <input type="number" id="authorized_person_mobile" name="authorized_person_mobile" class="form-control" value="{{ old('authorized_person_mobile') }}" pattern="[4-9][0-9]{9}" maxlength="10">
                        <small id="authorized_person_mobile_error" class="error text-danger"></small>
                        @error('authorized_person_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><strong>Email ID</strong></label>
                        <input type="email" id="authorized_person_email" name="authorized_person_email" class="form-control" value="{{ old('authorized_person_email') }}">
                        <small class="text-danger" id="authorized_person_email_error"></small>
                        @error('authorized_person_email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="row mb-3">
                        <div class="col-md-12">
                            <input class="form-check-input" type="checkbox" id="declaration"
                                name="declaration" {{ old('declaration') == 'on' ? 'checked' : '' }}>
                            <label class="form-check-label" for="declaration">
                                The clinic/bank undertakes that the request for mail access change is being made solely due to inability to access the previously registered email ID, and that it does not imply any change of ownership.<span class="color-csp-email-change">*</span>
                            </label>
                            </br>
                            <small class="text-danger" id="declaration_error"></small>
                            @error('declaration')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary mt-3" type="submit" id="submitBtn" >Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script nonce="{{ $cspNonce }}" src="{{ url('public/js/validate.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">
  const constraints = {
    application_no: { 
        presence: { allowEmpty: false, message: "^Application No is required" },
       
    },
    registration_no: { 
        presence: { allowEmpty: false, message: "^Registration No is required" }
    },
    registration_date: { 
        presence: { allowEmpty: false, message: "^Registration Date is required" }
    },
    clinic_name: { 
        presence: { allowEmpty: false, message: "^Clinic Name is required" }
    },
    address: { 
        presence: { allowEmpty: false, message: "^Address is required" }
    },
    state: { 
        presence: { allowEmpty: false, message: "^State is required" }
    },
    district: { 
        presence: { allowEmpty: false, message: "^District is required" }
    },
    clinic_type: { 
        presence: { allowEmpty: false, message: "^Organization Type is required" }
    },
    // contact_person_name: { 
    //     presence: { allowEmpty: false, message: "^Contact Person is required" }
    // },
    // contact_mobile: { 
    //     presence: { allowEmpty: false, message: "^Contact Mobile is required" },
    //     format: {
    //         pattern: "^[0-9]{10}$",
    //         message: "^Contact Mobile must be 10 digits"
    //     }
    // },
    clinic_phone: { 
        presence: { allowEmpty: false, message: "^Clinic Contact is required" }
    },
    old_clinic_email: { 
        presence: { allowEmpty: false, message: "^Clinic Email is required" },
        email: { message: "^Invalid Clinic Email" }
    },
    new_clinic_email: { 
        presence: { allowEmpty: false, message: "^Changed Email is required" },
        email: { message: "^Invalid Changed Email" }
    },
    new_clinic_mobile: { 
        presence: { allowEmpty: false, message: "^Changed Mobile is required" },
        format: {
            pattern: "^[4-9][0-9]{9}$",
            message: "^Please enter a valid mobile number."
        }
    },
    change_reason: { 
        presence: { allowEmpty: false, message: "^Reason for Change is required" }
    },
    request_letter_path: { 
        presence: { allowEmpty: false, message: "^Please upload Request Letter" }
    },
    authorized_person_name: { 
        presence: { allowEmpty: false, message: "^Name Of Authorized Person is required" }
    },
     authorized_person_designation: { 
        presence: { allowEmpty: false, message: "^Designation Of Authorized Person is required" }
    },
     authorized_person_mobile: { 
        presence: { allowEmpty: false, message: "^Mobile Of Authorized Person is required" },
        format: {
            pattern: "^[4-9][0-9]{9}$",
            message: "^Please enter a valid mobile number."
        }
    },
    authorized_person_email: { 
        presence: { allowEmpty: false, message: "^Authorized person email is required" }
    },
    declaration: { 
        presence: { allowEmpty: false, message: "^please check the declaration." }
    }
};
$('input').on('input change', function () {
    const fieldName = $(this).attr('name');
    $('#' + fieldName + '_error').text('');
});
document.getElementById('clinicForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = document.getElementById('clinicForm');
    const formData = {};
    const errorFields = document.querySelectorAll('.error');

    
    errorFields.forEach(e => e.innerText = "");

    new FormData(form).forEach((value, key) => {
        if (value instanceof File && value.size === 0) {
            formData[key] = "";
        } else {
            formData[key] = value;
        }
    });

    const errors = validate(formData, constraints);

    if (errors) {
        Object.keys(errors).forEach(field => {
            document.getElementById(field + "_error").innerText = errors[field][0];
        });
    } else {
        form.submit();
    }
});


$(document).ready(function () {

   $('#clinic_applicaion_no, #registration_no').on('blur', function () {

    let application_no = $('#clinic_applicaion_no').val();
    let registration_no = $('#registration_no').val();

    if(application_no === "" || registration_no === ""){
        return;
    }

    $.ajax({
        url: "{{ route('check.applicaion_no') }}",
        type: "GET",
        data: { 
            application_no: application_no,
            registration_no: registration_no
        },
        success: function (res) {

            $("#application_no_error").text("");

            // if (!res.exists) {
                
            //     $('#clinicForm')[0].reset();
            //     $("#application_no_error").text("Application Number not found");
            //     return;
            // }
            // Case 1: Application not found
            if (!res.exists) {
                $("#application_no_error").text(res.message);
                $("#emailRecordsBody").empty();
                $("#emailRecordsTable").addClass("d-none");
                $("#emailAlert").addClass("d-none");
                $('#clinicForm')[0].reset();
                return;
            }
            if (!res.match) {
                $("#application_no_error").text(res.message);
                $("#emailRecordsBody").empty();
                $("#emailRecordsTable").addClass("d-none");
                $("#emailAlert").addClass("d-none");
                $('#clinicForm')[0].reset();
                return;
            }
            let d = res.data;

            $('#registration_date').val(d.rgistration_date);
            $('#clinic_name').val(d.name);
            $('#state').val(d.state);
            $('#district').val(d.district);
            $('#clinic_type').val(d.clinic_type);
            $('#clinic_level').val(d.level);
            // $('#contact_person_name').val(d.contact_person_name);
            // $('#contact_mobile').val(d.mobile);
            $('#clinic_phone').val(d.contact_number_clinic);
            $('#address').val(d.address);
            $('#old_clinic_email').val(d.email);
            if (res.data2.length > 0) {

                    $("#emailAlert")
                        .removeClass("d-none")
                        .text("Following clinics/bank exists with this email id");

                    $("#emailRecordsTable").removeClass("d-none");

                    let rows = "";
                    let sn = 0;
                    res.data2.forEach(function (item) {
                        sn+=1;
                        rows += `
                            <tr>
                                <td>${sn}</td>
                                <td>${item.clinic_type_label ?? '-'}</td>
                                <td>${item.application_no}</td>
                                <td>${item.registration_no}</td>
                            </tr>
                            <input type="hidden" name="clinic_record[${sn}][clinic_type]" value="${item.clinic_type_label ?? ''}">
                            <input type="hidden" name="clinic_record[${sn}][application_no]" value="${item.application_no}">
                            <input type="hidden" name="clinic_record[${sn}][registration_no]" value="${item.registration_no}">
                        `;
                    });

                    $("#emailRecordsBody").html(rows);

                }

        },
        error: function(xhr) {
        console.log(xhr.responseText);
        $("#application_no_error").text("Server error. Please try again.");
        }
    });

});

});


$(document).ready(function () {

    // ============================
    // EMAIL CONFIRM VALIDATION
    // ============================
    $("#new_clinic_email, #new_clinic_email_confirm").on("keyup blur", function () {
        let email = $("#new_clinic_email").val().trim();
        let confirmEmail = $("#new_clinic_email_confirm").val().trim();

        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Invalid email format
        if (email !== "" && !emailPattern.test(email)) {
            $("#new_clinic_email_error").text("Enter a valid email address.");
        } else {
            $("#new_clinic_email_error").text("");
        }

        // Email mismatch
        if (email !== "" && confirmEmail !== "" && email !== confirmEmail) {
            $("#new_clinic_email_confirm_error").text("Email and Confirm Email do not match.");
        } else {
            $("#new_clinic_email_confirm_error").text("");
        }
    });



    $("#new_clinic_mobile, #new_clinic_mobile_confirm").on("keyup blur", function () {
        let mobile = $("#new_clinic_mobile").val().trim();
        let confirmMobile = $("#new_clinic_mobile_confirm").val().trim();

        let mobilePattern = /^[1-9][0-9]{9}$/;

        // Invalid mobile format
        if (mobile !== "" && !mobilePattern.test(mobile)) {
            $("#new_clinic_mobile_error").text("Enter a valid 10-digit mobile number.");
        } else {
            $("#new_clinic_mobile_error").text("");
        }

        // Mobile mismatch
        if (mobile !== "" && confirmMobile !== "" && mobile !== confirmMobile) {
            $("#new_clinic_mobile_confirm_error").text("Mobile numbers do not match.");
        } else {
            $("#new_clinic_mobile_confirm_error").text("");
        }
    });

    $("#clinicForm").on("submit", function (e) {

        let email = $("#new_clinic_email").val().trim();
        let confirmEmail = $("#new_clinic_email_confirm").val().trim();

        let mobile = $("#new_clinic_mobile").val().trim();
        let confirmMobile = $("#new_clinic_mobile_confirm").val().trim();

        // Block submit if mismatch
        if (email !== confirmEmail) {
            e.preventDefault();
            $("#new_clinic_email_confirm_error").text("Email does not match!");
        }

        if (mobile !== confirmMobile) {
            e.preventDefault();
            $("#new_clinic_mobile_confirm_error").text("Mobile number does not match!");
        }
    });

});

$(document).on('blur', '#new_clinic_email', function () {
                // $('#email').blur(function () {
                        //alert('fgfd');
                        //console.log('check 1');
                var new_clinic_email = $(this).val();
                //console.log(email);
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
                if (new_clinic_email == "") {
                    $('#availability').html('');
                } else {
                    $.ajax({
                        url: '{{ route('clinic.checkEmailaccess') }}', // Laravel route
                        method: "POST",
                        data: {
                            new_clinic_email: new_clinic_email,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            if (response.status === 'exists') {
                                $('#availability').html(
                                    '<span class="text-danger">Email ID already exists with NARTSR. Please ask the Clinic to give a valid one.</span>'
                                );
                                $('#submitBtn').attr("disabled", true);
                            } else if (!regex.test(new_clinic_email)) {
                                $('#availability').html(
                                    '<span class="text-danger">Please enter a valid email id</span>'
                                );
                            } else {
                                $('#availability').html(
                                    '<span class="text-success">This email may Allow for the clinic.</span>'
                                );
                                $('#submitBtn').attr("disabled", false);
                            }
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

</script>

@endsection
