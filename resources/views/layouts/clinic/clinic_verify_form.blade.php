<!DOCTYPE html>
<html>
<head>
    <title>Clinic Email/Access Change Request</title>

    <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet" nonce="{{ $cspNonce }}">

    <style nonce="{{ $cspNonce }}">
        body{
            background:#e9eef5;
            font-family: "Segoe UI",sans-serif;
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }
        .top-header{
            background:#84b9b9;
            padding:25px;
            color:#000000;
            text-align:center;
            font-size:26px;
            font-weight:600;
            letter-spacing:.5px;
            box-shadow:0 2px 10px rgba(0,0,0,.2);
        }
        .csp-clinic-header-content {
        background-color: #d3e5e1;
        }
        .page-container{
            display:flex;
            gap:25px;
            width:100%;
            max-width:1400px;
            margin:auto;
            padding:40px 20px;
            align-items:stretch; /* <─ ensures equal height */
        }

        .form-wrapper{
            flex:1; /* form takes full width space */
        }

        .side-panel{
            width:350px;
            background:white;
            border-radius:12px;
            padding:22px;
            box-shadow:0 4px 12px rgba(0,0,0,.08);
            display:flex;
            flex-direction:column;
            justify-content:space-between; /* optional - makes content spaced */
        }
        .color-csp-email-change {
            color: red;
        }
        .card{
            border-radius:12px;
            overflow:hidden;
        }
        .card-header{
            font-size:18px;
            font-weight:600;
        }
        .side-panel h5{
            margin-bottom:12px;
            color:#0d6efd;
        }
        .side-panel ul li{
            margin-bottom:6px;
        }
        .footer{
            background:white;
            text-align:center;
            padding:15px;
            margin-top:auto;
            box-shadow:0 -2px 8px rgba(0,0,0,.08);
            font-size:14px;
        }
        /* Responsive behaviour stays the same */
        @media(max-width:992px){
            .page-container{flex-direction:column;align-items:center;}
            .side-panel{width:100%;height:auto;}
        }
        button{padding:10px 45px;font-size:16px;border-radius:6px;}
    </style>
</head>

<body>

<div class="top-header csp-clinic-header-content">
    National ART & Surrogacy Portal
</div>

<div class="page-container">

    <!-- LEFT = FORM -->
    <div class="form-wrapper">
        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                Access Change Request Form
            </div>

            <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                <form id="clinicForm" action="{{ route('clinic.verify_access') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                                <input type="hidden" name="temptoken" value="{{ $temptoken }}">
                               <input type="hidden" name="reqno" value="{{ $reqno }}">
                    {{-- <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Application No</strong></label>
                            <input type="text" id="clinic_application_no" name="application_no" class="form-control"
                                   placeholder="Verify Application No" value="{{ old('application_no') }}">
                            <small class="text-danger" id="application_no_error"></small>
                            @error('application_no')<small class="text-danger">{{ $message }}</small>@enderror
                            <input type="hidden" name="token" value="{{ $token }}">
                               <input type="hidden" name="reqno" value="{{ $reqno }}">
                        </div>
                        

                        <div class="col-md-6">
                            <label class="form-label"><strong>Registration No</strong></label>
                            <input type="text" id="registration_no" name="registration_no" class="form-control"
                                   placeholder="Verify Registration No" value="{{ old('registration_no') }}">
                            <small class="text-danger" id="registration_no_error"></small>
                            @error('registration_no')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div> --}}

                        <table class="table table-bordered">
                                <thead>
                                <tr>
                                        <th>Clinic Type</th>
                                        <th>Application No</th>
                                        <th>Registration No</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clinics as $index => $clinicType)
                                <tr>
                                        @if ($clinicType=="ART BANK")
                                            <td><strong>ART BANK</strong></td>
                                        @elseif ($clinicType=="SURROGACY CLINIC")
                                            <td><strong>Surrogacy Clinic</strong></td>
                                        @else
                                            <td><strong>ART Clinic</strong></td>
                                        @endif
                                        <td>
                                        <input type="text"
                                        name="application_no[{{ $index }}]"
                                        class="form-control"    id="application_no_{{ $index }}"
                                        placeholder="Enter Application No">
                                        <small class="text-danger" id="error_application_no_{{ $index }}"></small>
                                        @error("application_no.$index")<small class="text-danger">{{ $message }}</small>@enderror
                                        </td>
                                        <td>
                                        <input type="text"
                                        name="registration_no[{{ $index }}]"
                                        class="form-control"
                                        placeholder="Enter Registration No">
                                        <small class="text-danger" id="error_registration_no_{{ $index }}"></small>
                                        @error("registration_no.$index")<small class="text-danger">{{ $message }}</small>@enderror
                                        </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Verify New Email</strong></label>
                            <input type="email" id="verify_new_email" name="verify_new_email" class="form-control"
                                   placeholder="Verify New Email: Enter a Valid email address." pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" value="{{ old('verify_new_email') }}">
                            <small class="text-danger" id="verify_new_email_error"></small>
                            @error('verify_new_email')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"><strong>Verify New Phone</strong></label>
                            <input type="text" id="verify_new_phone" name="verify_new_phone" class="form-control"
                                   placeholder="Verify New Phone:Enter valid 10-digit mobile number." value="{{ old('verify_new_phone') }}" pattern="[4-9][0-9]{9}" maxlength="10">
                            <small class="text-danger" id="verify_new_phone_error"></small>
                            @error('verify_new_phone')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                            <label class="form-label"><strong>Reason for Change</strong></label>
                            <input type="text" id="reason_for_change" name="reason_for_change" class="form-control"
                                   placeholder="Detail Reason for change of email" value="{{ old('reason_for_change') }}">
                            <small class="text-danger" id="reason_for_change_error"></small>
                            @error('reason_for_change')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="row mb-3 card-header bg-white">
                    <h4 class="card-header bg-light">Details of the Authorized Person of the Clinic</h4>
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
                            <div class= "form-check">
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
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary" type="submit" id="submitBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT = INFO PANEL -->
    <div class="side-panel">
        <h5>Guidelines</h5>
        <ul>
            <li>Use valid registered details only</li>
            <li>Email must be active and accessible</li>
            <li>Phone number must be reachable</li>
        </ul>
        <hr>
    </div>

</div>

<style nonce="{{$cspNonce}}">
		.footer .copyright a {
			color: #0b5ed7;
			
		}
		</style>
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://registry.artsurrogacy.gov.in/" target="_blank">ART & Surrogacy Registry</a> 2024</p>
            </div>
        </div>

<script nonce="{{ $cspNonce }}" src="{{ url('public/js/validate.min.js')}}"></script>

<script nonce="{{ $cspNonce }}">
const constraints = {
    verify_new_email:{presence:{allowEmpty:false,message:"^Verify New Email is required"}},
    verify_new_phone:{presence:{allowEmpty:false,message:"^Verify New Phone No is required"}},
    reason_for_change:{presence:{allowEmpty:false,message:"^Reason for change is required"}},
    authorized_person_name: { 
    presence: { allowEmpty: false, message: "^Name of Authorized Person is required" }
    },

    authorized_person_designation: { 
    presence: { allowEmpty: false, message: "^Designation of Authorized Person is required" }
    },

    authorized_person_mobile: { 
    presence: { allowEmpty: false, message: "^Mobile No of Authorized Person is required" },
    format: {
    pattern: "^[4-9][0-9]{9}$",
    message: "^Enter a valid mobile number"
    }
    },

    authorized_person_email: { 
    presence: { allowEmpty: false, message: "^Authorized Person Email is required" },
    email: { message: "^Enter a valid email address" }
    },
    declaration: { 
        presence: { allowEmpty: false, message: "^please check the declaration." }
    }

};
function validateArrayFields() {
    let errors = {};

    // Validate application numbers
    document.querySelectorAll("input[name^='application_no']").forEach((input, index) => {
        if (input.value.trim() === "") {
            errors[`application_no.${index}`] = ["Application No is required"];
        }
    });

    // Validate registration numbers
    document.querySelectorAll("input[name^='registration_no']").forEach((input, index) => {
        if (input.value.trim() === "") {
            errors[`registration_no.${index}`] = ["Registration No is required"];
        }
    });

    return Object.keys(errors).length ? errors : null;
}

document.getElementById('verify_new_email').addEventListener('input', function(){
    this.value = this.value.replace(/\s+/g,''); // removes spaces automatically
});
document.getElementById('verify_new_phone').addEventListener('input', function(){
    this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);
});
document.getElementById('clinicForm').addEventListener('submit', function(e){
    e.preventDefault();
    let d={},form=this;
    document.querySelectorAll('.text-danger').forEach(e=>e.innerText="");
    new FormData(form).forEach((v,k)=>d[k]=v);
    let err=validate(d,constraints);
    // Validate array fields
    let arrayErrors = validateArrayFields();
    console.log(arrayErrors);
    if (arrayErrors) {
        err = { ...(err || {}), ...arrayErrors };
    }
    if(err){
        Object.keys(err).forEach(f=>{
            
            // Handle array fields like application_no.0
            if (f.startsWith("application_no.")) {
                let index = f.split(".")[1];
                let el = document.getElementById(`error_application_no_${index}`);
                if (el) el.innerText = err[f][0];
                return;
            }

            if (f.startsWith("registration_no.")) {
                let index = f.split(".")[1];
                let el = document.getElementById(`error_registration_no_${index}`);
                if (el) el.innerText = err[f][0];
                return;
            }    

            let el=document.getElementById(f+"_error");
            if(el) el.innerText=err[f][0];
        });
        return;
    } form.submit();
});
</script>

</body>
</html>
