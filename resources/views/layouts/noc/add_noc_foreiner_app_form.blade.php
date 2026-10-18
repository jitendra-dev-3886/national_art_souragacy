@extends('layouts.noc.noc_master')
@section('content')

<style nonce="{{$cspNonce}}">
    .input-group-1 {
            position: relative;
            display: flex;
            padding:5px;
            align-items: stretch;
            width: 100%;
}
</style>
<script nonce="{{ $cspNonce }}">
        window.onload = function() {

            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                // Ensure the first option "Select" is shown
                const firstOption = select.querySelector('option[value=""]');
                if (firstOption) {
                    select.selectedIndex = 0; // Resets to the first "Select" option
                }
            });

            // Reset checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false; // Unchecks the checkbox
            });

            // Reset radio buttons

        }
</script>

<script nonce="{{ $cspNonce }}">
    // $(document).ready(function() {
        
    //     $('#datepicker').datepicker({
    //         changeMonth: true,      // Allows month selection
    //         changeYear: true,       // Allows year selection
    //         showButtonPanel: true,  // Shows a button panel
    //         dateFormat: 'mm/dd/yy', // Set the format to mm/dd/yyyy
    //         yearRange: '1900:2100', // Set a valid year range
    //         onClose: function(dateText, inst) {
    //             // Ensure that the format is correct when the date is closed
    //             var selectedDate = $(this).datepicker('getDate');
    //             if (selectedDate) {
    //                 $(this).val($.datepicker.formatDate('mm/dd/yy', selectedDate));
    //             }
    //         },
    //         onSelect: function(dateText, inst) {
    //             // Format the selected date properly
    //             var selectedDate = $(this).datepicker('getDate');
    //             if (selectedDate) {
    //                 $(this).val($.datepicker.formatDate('mm/dd/yy', selectedDate));
    //             }
    //         }
    //     });
    // });// comment code 
  
    // $(document).ready(function() {
    //     $('#datepicker').datepicker({
    //         changeMonth: true,      // Allows month selection
    //         changeYear: true,       // Allows year selection
    //         showButtonPanel: true,  // Shows a button panel
    //         dateFormat: 'mm/dd/yy', // Set the format to mm/dd/yyyy
    //         yearRange: '1900:2100', // Set a valid year range
    //         onClose: function(dateText, inst) {
    //             // Ensure that the format is correct when the date is closed
    //             var selectedDate = $(this).datepicker('getDate');
    //             if (selectedDate) {
    //                 $(this).val($.datepicker.formatDate('mm/dd/yy', selectedDate));
    //             }
    //         },
    //         onSelect: function(dateText, inst) {
    //             // Format the selected date properly
    //             var selectedDate = $(this).datepicker('getDate');
    //             if (selectedDate) {
    //                 $(this).val($.datepicker.formatDate('mm/dd/yy', selectedDate));
    //             }
    //         }
    //     });
    // });
</script>

</script> 

    <div class="container-fluid">
        <div class="col-lg-12">
            
            <div class="card">
                <div class="card-header position-relative d-flex justify-content-between align-items-center">
                    <div></div>
                    <h4 class="card-title position-absolute top-50 start-50 translate-middle text-primary" style="opacity:0.8;">
                        Noc application Foreigner for foreigner for Transferring Outside India
                    </h4>
                    <div></div>
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3>Application form for transfer of Gametes (sperms Oocyte)/Embryos (Outside India)</h3>


                    <div class="progress mb-4" style="height: 20px;">
                        <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                            role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            Step 1 of 2
                        </div>
                    </div>
                  
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Form -->
                    <form id="form-wizard" method="POST" action="{{ route('noc.nocforeignersubmit') }}"
                        enctype="multipart/form-data" autocomplete="off">
                        <!-- Step 1 -->
                        @csrf
                        <div id="step-1" class="step">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Name of the applicant</strong><span
                                                style="color:#ff0000">*</span></label>
                                                    <div class="input-group">
                                                        <input id="name_applicant" name="name_applicant"
                                                            placeholder="Name of the Applicant" class="form-control"
                                                            onkeyup="allLetter(document.myform.name_applicant)"
                                                            value="{{ old('name_applicant', $user_profile->name_applicant ?? '') }}"
                                                            type="text" readonly />
                                                    </div>
                                                    <!-- @error('name_applicant') -->
                                                        <!-- Display error for name_applicant -->
                                                        <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                                    @enderror -->


                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        
                                             <label class="control-label"><strong>Gender</strong><span
                                                style="color:#ff0000">*</span></label>
                                            <div class="input-group">
                                            <input id="gender" name="gender" placeholder="" class="form-control" value="{{ $user_profile->gender }}"
                                                type="text" readonly />
                                           </div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="nationality_applicant_display">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Nationality of Applicant</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">

                                            <input name="nationality_applicant" id="nationality_applicant"
                                                placeholder="Address"
                                                value="{{ old('nationality_applicant', 'Foreigner' ?? '') }}"
                                                class="form-control" type="text" readonly>

                                            {{-- <input name="nationality_applicant" id="nationality_applicant"
                                                placeholder="Address"
                                                value="{{ old('nationality_applicant', $user_profile->nationalty_type ?? '') }}"
                                                class="form-control" type="text" readonly> --}}
                                        </div>
                                        <!-- @error('nationality_applicant') -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_nationality_applicant" style="color:red;display:none;">Please
                                            Select Nationality of Applicant</p>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="col-md-5 control-label"><strong>Marital
                                                Status</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">




                                            <select name="m_status" id="m_status" class="form-control"
                                                onchange="m_status_hideError()">

                                                @if (old('m_status'))
                                                    <option value="Unmarried"
                                                        {{ old('m_status') == 'Unmarried' ? 'selected' : '' }}>Unmarried
                                                    </option>
                                                    <option value="Married"
                                                        {{ old('m_status') == 'Married' ? 'selected' : '' }}>Married
                                                    </option>
                                                    <option value="Divorced"
                                                        {{ old('m_status') == 'Divorced' ? 'selected' : '' }}>Divorced
                                                    </option>
                                                    <option value="Widow"
                                                        {{ old('m_status') == 'Widow' ? 'selected' : '' }}>Widow/Widower
                                                    </option>
                                                @else
                                                    <option value="">select</option>
                                                    <option value="Unmarried"
                                                        {{ old('m_status') == 'Unmarried' ? 'selected' : '' }}>Unmarried
                                                    </option>
                                                    <option value="Married"
                                                        {{ old('m_status') == 'Married' ? 'selected' : '' }}>Married
                                                    </option>
                                                    <option value="Divorced"
                                                        {{ old('m_status') == 'Divorced' ? 'selected' : '' }}>Divorced
                                                    </option>
                                                    <option value="Widow"
                                                        {{ old('m_status') == 'Widow' ? 'selected' : '' }}>Widow/Widower
                                                    </option>
                                                @endif

                                            </select>

                                        </div>
                                        <!-- @error('m_status') -->
                                            <!-- Display error for name_applicant -->
                                           <!--  <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_m_status" style="color:red;display:none;">Please Select Marital
                                            Status</p>
                                    </div>
                                </div>

                                <div class="col-md-2" id="gender_sp_hide" style="display:none;">
                                    <div class="mb-3">
                                        
                                             <label class="control-label"><strong>Gender Spouse</strong><span
                                                style="color:#ff0000">*</span></label>
                                            <div class="input-group">
                                            {{-- <input id="gender" name="gender" placeholder="" class="form-control" value="{{ $user_profile->gender }}"
                                                type="text" readonly /> --}}
                                            <select name="gender_sp" id="gender_sp" class="form-control">
                                                  <option value="Man">Man</option>
                                                  <option value="Woman">Woman</option>
                                            </select>
                                           </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="name_spouse_display" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Name of the Spouse</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="name_spouse" id="name_spouse" placeholder="Name of the Spouse"
                                                class="form-control" type="text" value="{{ old('name_spouse') }}"
                                                onkeyup="allLetter(this)" onkeypress="return name_spouse(event)" />
                                        </div>

                                        <!-- @error('name_spouse') -->
                                            <!-- Display error for name_applicant -->
                                           <!--  <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_name_spouse" style="color:red;display:none;">Please Select
                                            Name of the Spouse</p>
                                    </div>
                                </div>
                                <div class="col-md-4" id="nationality_spouse_display222" style="display222:none;">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Nationality of Spouse</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="nationality_spouse" id="nationality_spouse"
                                                class="form-control">
                                                @if (old('nationality_spouse'))
                                                    <option value="Indian" id="indvalue"
                                                        {{ old('nationality_spouse') == 'Indian' ? 'selected' : '' }}>
                                                        Indian
                                                    </option>
                                                    <option value="Foreigner" id="forvalue"
                                                        {{ old('nationality_spouse') == 'Foreigner' ? 'selected' : '' }}>
                                                        Foreigner</option>
                                                @else
                                                    <option value="">Select</option>
                                                    <option value="Indian" id="indvalue"
                                                        {{ old('nationality_spouse') == 'Indian' ? 'selected' : '' }}>
                                                        Indian
                                                    </option>
                                                    <option value="Foreigner" id="forvalue"
                                                        {{ old('nationality_spouse') == 'Foreigner' ? 'selected' : '' }}>
                                                        Foreigner</option>
                                                @endif

                                            </select>
                                        </div>
                                        <!-- @error('nationality_spouse') -->
                                            <!-- Display error for name_applicant -->
                                          <!--   <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_nationality_spouse" style="color:red;display:none;">Please
                                            Select Nationality of Spouse</p>

                                    </div>
                                </div>

                                <div class="col-md-4" id="country_applicant_display" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Country of the Spouse</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="country_applicant_spouse" id="country_applicant_spouse"
                                                class="form-control">
                                                <option value="">-- Select Country --</option>
                                                @if ($countries->count() > 0)
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->country_name }}"
                                                            {{ old('country_applicant_spouse') == $country->country_name ? 'selected' : '' }}>
                                                            {{ $country->country_name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Countries Available</option>
                                                @endif
                                            </select>
                                        </div>
                                        <!-- @error('country_applicant_spouse') -->
                                            <!-- Display error for name_applicant -->
                                        <!--     <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_country_applicant" style="color:red;display:none;">Please
                                            Select country of Spouse</p>
                                    </div>
                                </div>

<!-- 
                                <div class="col-md-4" id="country_spouse_display" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Spouse's Country</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="country_spouse" id="country_spouse" class="form-control">
                                                <option value="">-- Select Country --</option>
                                                @if ($countries->count() > 0)
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->country_name }}"
                                                            {{ old('country_spouse') == $country->country_name ? 'selected' : '' }}>
                                                            {{ $country->country_name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option value="">No Countries Available</option>
                                                @endif
                                            </select>
                                        </div>
                                        @error('country_spouse')
                                            Display error for name_applicant -->
                                        <!--     <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror
                                        <p id="error_message_country_spouse" style="color:red;display:none;">Please Select
                                            Spouse's Country</p>
                                    </div>
                                </div> --> 

                                <div class="col-md-4" id="email_spouse_display" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Email of the Spouse</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="email_spouse" id="email_spouse"
                                                placeholder="Email of the Spouse" class="form-control" type="email"
                                                value="{{ old('email_spouse') }}" onblur="validateEmail(this);" />
                                        </div>
                                    </div>
                                    <!-- @error('email_spouse') -->
                                        <!-- Display error for name_applicant -->
                                        <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                    @enderror -->
                                    <p id="error_message_email_spouse" style="color:red;display:none;">Please Select Email
                                        of the Spouse</p>
                                </div>
                                <div class="col-md-4" id="mobile_spouse_display" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Mobile Number of the Spouse</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                           <input name="mobile_spouse" id="mobile_spouse" maxlength="10"
                                           pattern="\d{10}" title="Please enter exactly 10 digits"
                                           placeholder="Mobile Number of the Spouse" class="form-control"
                                           type="tel" value="{{ old('mobile_spouse') }}" oninput="validateNumericInput_mobile_spouse(event)" />

                                        </div>
                                        <!-- @error('mobile_spouse') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->

                                        <p id="error_message_mobile_spouse" style="color:red;display:none;">Please Select
                                            Mobile Number of the Spouse</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-2" id="country_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Country of Applicant</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="country_applicant" id="country_applicant"
                                                placeholder="country_applicant"
                                                value="{{ old('country_applicant', $user_profile->country ?? '') }}"
                                                class="form-control" type="text" readonly>
                                        </div>
                                        <!-- @error('country_applicant') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>
                                <div class="col-md-2" id="zipcode_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Applicant's Zipcode</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="zipcode" id="zipcode" placeholder="zipcode"
                                                value="{{ old('zipcode', $user_profile->zipcode ?? '') }}"
                                                class="form-control" readonly type="number">
                                        </div>
                                        @error('zipcode')
                                            <!-- Display error for name_applicant -->
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8" id="address_class">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Address of Applicant</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="address" id="address" placeholder="Address"
                                                value="{{ old('address', $user_profile->address ?? '') }}"
                                                class="form-control" type="text" readonly>
                                        </div>
                                        <!-- @error('address') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>
                                <div class="col-md-3" id="pincode_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Pincode</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input type="number" pattern="^[0-9]{6}$" name="pincode"
                                                placeholder="Pincode should be six numbers" maxlength="6" id="pincode"
                                                class="form-control"
                                                value="{{ old('pincode', $user_profile->pincode ?? '') }}" readonly>
                                            <span id="pincodeavailability"></span>
                                        </div>
                                        <!-- @error('pincode') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_pincode" style="color:rgb(8, 8, 8);display:none;">Please
                                            Select
                                            Pincode</p>
                                    </div>
                                </div>
                                <div class="col-md-2" id="state_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>State</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="state" id="state" placeholder="State"
                                                class="form-control"
                                                value="{{ old('state', $user_profile->state ?? '') }}" readonly />
                                        </div>
                                        <!-- @error('state') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_State" style="color:red;display:none;">Please Select State
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-2" id="district_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>District</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="district" id="district" placeholder="c"
                                                class="form-control"
                                                value="{{ old('district', $user_profile->district ?? '') }}" readonly />
                                        </div>
                                        <!-- @error('district') -->
                                            <!-- Display error for name_applicant -->
                                           <!--  <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_District" style="color:red;display:none;">Please Select
                                            District</p>
                                    </div>
                                </div>
                                <div class="col-md-2" id="mobile_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Mobile Number of Applicant</strong></label>
                                        <div class="input-group">
                                            <input name="mobileno" id="mobileno"
                                                value="{{ old('mobileno', $requesttable->mobileno ?? '') }}"
                                                class="form-control" type="number" readonly />
                                        </div>
                                        <!-- @error('mobileno') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_mobileno" style="color:red;display:none;">Please Select
                                            Mobile No</p>
                                    </div>
                                </div>
                                <div class="col-md-3" id="email_hide_val">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Email Address of Applicant</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input type="email" name="email" placeholder="example@example.com"
                                                id="email" value="{{ old('email', $requesttable->email ?? '') }}"
                                                class="form-control" readonly />
                                        </div>
                                        <!-- @error('email') -->
                                            <!-- Display error for name_applicant -->
                                           <!--  <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_email" style="color:red;display:none;">Please Select Email
                                            Address</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Transfer (Outside India)</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="transfer" id="transfer" class="form-control" onchange="transfer_spouse_hideError2()">
                                                <option value="">Select</option>
                                                {{-- <option value="Within India" {{ old('transfer') == 'Within India' ? 'selected' : '' }}>Within India</option> --}}
                                                <option value="Outside India" {{ old('transfer') == 'Outside India' ? 'selected' : '' }}>Outside India</option>
                                            </select>
                                            
                                        </div>
                                        <p id="error_message_transfer" style="color:red;display:none;">Please Select
                                            Transfer (within/outside
                                            India)</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Purpose of Transfer</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="purpose_of_transfer" id="purpose_of_transfer"
                                                class="form-control" onchange="error_message_purpose_of_transfer()">
                                                <option value="">Select</option>

                                                <option  value="Invitro Fertilization"
                                                    {{ old('purpose_of_transfer') == 'Invitro Fertilization' ? 'selected' : '' }}>
                                                    Invitro Fertilization
                                                </option>
                                                {{-- <option class="hiddenval" value="Invitro Fertilization"
                                                    {{ old('purpose_of_transfer') == 'Invitro Fertilization' ? 'selected' : '' }}>
                                                    Invitro Fertilization
                                                </option> --}}
                                                <option class="" id="hiddensur" value="Surrogacy"
                                                    {{ old('purpose_of_transfer') == 'Surrogacy' ? 'selected' : '' }}>
                                                    Surrogacy</option>

                                                {{-- <option class="hiddenval hiddensur" id="hiddensur" value="Surrogacy"
                                                    {{ old('purpose_of_transfer') == 'Surrogacy' ? 'selected' : '' }}>
                                                    Surrogacy</option> --}}
                                                <option value="Future Cryopreservation"
                                                    {{ old('purpose_of_transfer') == 'Future Cryopreservation' ? 'selected' : '' }}>
                                                    Future
                                                    Cryopreservation
                                                </option>
                                                <!--option value="Other">Other</option-->
                                            </select>
                                        </div>
                                        <!-- @error('purpose_of_transfer') -->
                                            <!-- Display error for name_applicant -->
                                       <!--      <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_purpose_of_transfer" style="color:red;display:none;">Please
                                            Select Purpose of Transfer</p>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <label class="control-label"><strong>Transfer of</strong><span
                                                style="color:#ff0000">*</span></label>
                                        <div class="col-md-4 hiddenembryos">
                                            <div class="row">
                                                <div class="col-md-4 py-2">
                                                    <div class="form-check custom-checkbox mb-3">
                                                        <input type="checkbox" name="transfer_of[]" value="Embryos"
                                                            class="form-check-input inline" id="embryosCheckBox"
                                                            {{ in_array('Embryos', old('transfer_of', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="embryosCheckBox">Embryos</label>
                                                    </div>
                                                </div>

                                                <div class="col md-8" id="embryos_hidden" style="display: none;">
                                                    <div class="input-group">
                                                        <select name="embryos_number" id="embryos_number"
                                                            class="form-control"
                                                            onchange="error_message_embryos_number()">
                                                            <option value="">Select</option>
                                                            @for ($i = 1; $i <= 35; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ old('embryos_number') == $i ? 'selected' : '' }}>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        <span class="input-group-text">Number</span>
                                                    </div>
                                                   <!--  @if ($errors->has('embryos_number'))
                                                        <div class="text-danger">
                                                            {{ $errors->first('embryos_number') }}
                                                        </div>
                                                    @endif -->
                                                    <p id="error_message_embryos_number" style="color:red;display:none;">
                                                        Please Select Embryos Number</p>
                                                </div>
                                                <p id="error_message_embryosCheckBox"
                                                    style="color:red;display:none; margin-top:-18px">
                                                    Please Select checkbox</p>
                                            </div>
                                            <!--inner-->
                                        </div>
                                        <div class="col-md-4 hiddensperms" id="hiddensperms">
                                            <div class="row">
                                                <div class="col-md-4 py-2">
                                                    <div class="form-check custom-checkbox mb-3">
                                                        <input type="checkbox" name="transfer_of[]" value="Sperms"
                                                            class="form-check-input inline" id="spermsCheckBox"
                                                            {{ in_array('Sperms', old('transfer_of', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="customCheckBox1">Sperms</label>
                                                    </div>
                                                </div>
                                                <div class="col md-8" id="sperm_hidden" style="display: none;">
                                                    <div class="input-group">
                                                        <select name="sperm_vials" id="sperm_vials" class="form-control"
                                                            onchange="error_message_sperms_number()">
                                                            <option value="">Select</option>
                                                            @for ($i = 1; $i <= 35; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ old('sperm_vials') == $i ? 'selected' : '' }}>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                        <span class="input-group-text">vials</span>
                                                    </div>
                                                   <!--  @if ($errors->has('sperm_vials'))
                                                        <div class="text-danger">
                                                            {{ $errors->first('sperm_vials') }}
                                                        </div>
                                                    @endif -->
                                                    <p id="error_message_sperms_number" style="color:red;display:none;">
                                                        Please Select Sperm Vials</p>
                                                </div>
                                            </div>
                                            <!--inner-->
                                        </div>
                                        <div class="col-md-4 hiddenococytes">
                                            <div class="row">
                                                <div class="col-md-4 py-2">
                                                    <div class="form-check custom-checkbox mb-3">
                                                        <input type="checkbox" name="transfer_of[]" value="Oocytes"
                                                            class="form-check-input inline" id="oocytesCheckBox"
                                                            {{ in_array('Oocytes', old('transfer_of', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="customCheckBox1">Oocytes</label>
                                                    </div>
                                                </div>
                                                <div class="col md-8" id="oocytes_hidden" style="display: none;">
                                                    <div class="input-group">
                                                        <select name="oocytes_number" id="oocytes_number"
                                                            class="form-control"
                                                            onchange="error_message_oocytes_number()">
                                                            <option value="">Select</option>
                                                            @for ($i = 1; $i <= 35; $i++)
                                                                <option value="{{ $i }}"
                                                                    {{ old('oocytes_number') == $i ? 'selected' : '' }}>
                                                                    {{ $i }}
                                                                </option>
                                                            @endfor

                                                        </select>
                                                        <span class="input-group-text">Number</span>
                                                    </div>
                                                  <!--   @if ($errors->has('oocytes_number'))
                                                        <div class="text-danger">
                                                            {{ $errors->first('oocytes_number') }}
                                                        </div>
                                                    @endif -->
                                                    <p id="error_message_oocytes_number" style="color:red;display:none;">
                                                        Please Select Oocytes</p>
                                                </div>
                                            </div>
                                            <!--inner-->
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="exampleModalCenter">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Note:</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="modal-title mb-2">Download the following forms:-</p>
                                                <ul id="instructionList">

                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger light"
                                                    data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                           

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Date of Birth of
                                                Applicant</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="dob_applicant" id="dob_applicant" min="1926-01-01"
                                                class="form-control"
                                                type="date" value="{{ old('dob_applicant') }}" oninput="showAlert()" />
                                            <span class="input-group-text bg-light d-block">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                      <!--   @if ($errors->has('dob_applicant'))
                                            <p class="text-danger">{{ $errors->first('dob_applicant') }}</p>
                                        @endif -->
                                        <p id="error_message_dob_applicant_valid_man" style="color:red;display:none;">
                                            Age of applicant should be between 21 and 55 years</p>
                                            <p id="error_message_dob_applicant_valid_wo" style="color:red;display:none;">
                                            Age of applicant should be between 21 and 50 years</p>
                                        <p id="error_message_dob_applicant" style="color:red;display:none;">Please Select
                                            Date of Birth of
                                            Applicant</p>
                                        <small id="dob_applicant_error" class="text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-4" id="dob_spouse_info">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Date of Birth of
                                                Spouse</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input name="dob_spouse" id="dob_spouse" min="1926-01-01" placeholder="" class="form-control"
                                                type="date" 
                                                value="{{ old('dob_spouse') }}" oninput="showAlert_sp()" />
                                            <span class="input-group-text bg-light d-block">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                       <!--  @if ($errors->has('dob_spouse'))
                                            <p class="text-danger">{{ $errors->first('dob_spouse') }}</p>
                                        @endif -->

                                        <p id="error_message_dob_spouse" style="color:red;display:none;">Please Select
                                            Date of Birth of
                                            Spouse</p>
                                        <p id="error_message_dob_valid_man_sp" style="color:red;display:none;">
                                            Age of spouse should be between 21 and 50 years</p>
                                        <p id="error_message_dob_valid_wo_sp" style="color:red;display:none;">
                                            Age of spouse should be between 21 and 55 years</p>
                                        
                                        <small id="dob_spouse_error" class="text-danger"></small>
                                    </div>
                                </div>
           
                                <div class="col-md-3" id="aadhar_applicant_info">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Masked Aadhar Number of the
                                                Applicant</strong></label>
                                        <div class="input-group">
                                            <input name="aadhar_applicant" id="aadhar_applicant"
                                                placeholder="Enter last 04 digit" class="form-control input-field"
                                                onkeyup="validateAadhar(document.myform.aadhar_applicant)" maxlength="4"
                                                type="text" value="{{ old('aadhar_applicant') }}" oninput="validateNumericInput_applicant_aadhar(event)" />
                                        </div>
                                        <!-- @error('aadhar_applicant') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>
                                <style nonce="{{$cspNonce}}">
                                    .error {
                                        color: red;
                                    }

                                    .success {
                                        color: green;
                                    }
                                </style>
                                <div class="col-md-3" id="voter_applicant_info">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Voter ID Number of the
                                                Applicant</strong></label>
                                        <div class="input-group">
                                            <input name="voterid_applicant" id="voterid_applicant"
                                                placeholder="Voter ID Number" maxlength="10"
                                                class="form-control input-field" type="text"
                                                value="{{ old('voterid_applicant') }}" />
                                            <span id="validationMessage" class=""></span>
                                        </div>
                                        <!-- @error('voterid_applicant') -->
                                            <!-- Display error for name_applicant -->
                                           <!--  <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>
                                <div class="col-md-3" id="passport_applicant_info">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Passport Number of the
                                                Applicant</strong><span id="passport_number_star"
                                                style="color: rgb(255, 0, 0);display: none;margin-top: -19px;margin-left: 245px;">*</span></strong></label>
                                        <div class="input-group">
                                            <input name="passport_applicant" id="passport_applicant"
                                                placeholder="Passport Number" class="form-control input-field"
                                                maxlength="14" type="text" value="{{ old('passport_applicant') }}" />
                                        </div>
                                        <!-- @error('passport_applicant') -->
                                            <!-- Display error for name_applicant -->
                                            <!-- <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_passport_number" style="color:red;display:none;">Please fill Passport
                                            Number of the
                                            Applicant</p>
                                    </div>
                                </div>
                                <div class="col-md-3" id="pan_applicant_info">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>PAN Number of the
                                                Applicant</strong></label>
                                        <div class="input-group ">
                                            <input name="pan_applicant" id="pan_applicant" placeholder="PAN Number"
                                                class="form-control input-field" maxlength="10" type="text"
                                                onchange="validatePanNumber(this)" value="{{ old('pan_applicant') }}" />
                                        </div>
                                        @error('pan_applicant')
                                            <!-- Display error for name_applicant -->
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                <p id="error_message_proof" style="color:red; display:none;">
                                    Please fill at least one field of <Samp></Samp>Applicant ID Proof: Voter ID, Passport,
                                    PAN or Aadhar
                                    Card.</p>
                              <!-- oci card holder code -->
                                <div class="col-md-3" id="oci_card_holder_app">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>OCI Card Number of the
                                                Applicant</strong><span id="oci_number_star">
                                                </span></strong></label>
                                        <div class="input-group">
                                            <input name="oci_applicant" id="oci_applicant"
                                                placeholder="OCI Card Number" class="form-control input-field"
                                                maxlength="14" type="text" value="{{ old('oci_applicant') }}" />
                                        </div>
                                        <p id="error_message_oci_number" style="color:red;display:none;">Please Enter OCI Number of the Applicant</p>
                                    </div>
                                </div>  

 




                                <!-- oci card holder end -->

                                <span id="validationMessage" class=""></span>
                                <div class="row" id="spouse_info">

                                    <div class="col-md-3" id="passport_spouse1">
                                        <div class="mb-3">
                                            <label class="control-label">
                                                <strong>Passport Number of the Spouse<span id="passport_spouse_star" style="color:red;display:none;">*</span></strong>
                                              
                                            </label>

                                            <div class="input-group">
                                                <input name="passport_spouse" id="passport_spouse"
                                                    placeholder="Passport Number" class="form-control input-field-spouse"
                                                    maxlength="14" type="text"
                                                    value="{{ old('passport_spouse') }}" />
                                            </div>
                                            <!-- @error('passport_spouse') -->
                                               <!--  <p style="color:red;display:none;">{{ $message }}</p>
                                            @enderror -->
                                            <p id="error_message_spouse_proof" style="color:red; display:none;">
                                                Please fill <Samp></Samp>Spouse Passport for ID Proof</p>

                                        </div>
                                    </div>



                                    <div class="col-md-3" id="aadhar_spouse_info">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Masked Aadhar Number of the
                                                    Spouse</strong></label>
                                            <div class="input-group">
                                                <input name="aadhar_spouse" id="aadhar_spouse"
                                                    placeholder="Enter last 04 digit"
                                                    class="form-control input-field-spouse"
                                                    onkeyup="validateAadhar(document.myform.aadhar_spouse)" maxlength="4"
                                                    type="text" value="{{ old('aadhar_spouse') }}" oninput="validateNumericInput_mask_aadhar(event)" />
                                            </div>

                                            <!-- @error('aadhar_spouse')
                                                <p style="color:red;display:none;">{{ $message }}</p>
                                            @enderror -->
                                        </div>
                                    </div>

                                    <div class="col-md-3" id="pan_spouse_info">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>PAN Number of the
                                                    Spouse</strong></label>
                                            <div class="input-group">
                                                <input name="pan_spouse" id="pan_spouse" placeholder="PAN Number"
                                                    class="form-control input-field-spouse" maxlength="10" type="text"
                                                    onchange="validatePanNumber_spouse(this)"
                                                    value="{{ old('pan_spouse') }}" />
                                            </div>
                                          <!--   @error('pan_spouse')
                                                <p style="color:red;display:none;">{{ $message }}</p>
                                            @enderror -->
                                        </div>
                                    </div>



                                    <div class="col-md-3" id="voter_spouse_info">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Voter ID Number of the
                                                    Spouse</strong></label>
                                            <div class="input-group">
                                                <input name="voterid_spouse" id="voterid_spouse"
                                                    placeholder="Voter ID Number" class="form-control input-field-spouse"
                                                    type="text" maxlength="10" value="{{ old('voterid_spouse') }}" />
                                            </div>
                                          <!--   @error('voterid_spouse')
                                                <p style="color:red;display:none;">{{ $message }}</p>
                                            @enderror -->
                                        </div>
                                    </div>

                                    <p id="error_message_spouse_proof" style="color:red; display:none;">
                                        Please fill at least one field of <Samp></Samp>Spouse ID Proof: Voter ID, Passport,
                                        PAN or Aadhar
                                        Card.</p>


                                  <div class="col-md-3" id="oci_card_holder_sp">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>OCI Card Number of the
                                                Spouse</strong><span id="oci_number_star_sp"></span></strong></label>
                                        <div class="input-group">
                                            <input name="oci_spouse" id="oci_spouse"
                                                placeholder="OCI Card Number" class="form-control input-field"
                                                maxlength="14" type="text" value="{{ old('oci_spouse') }}" />
                                        </div>
                                        <p id="error_message_oci_number_spouse" style="color:red;display:none;">Please Enter OCI Number of the Spouse</p>
                                    </div>
                                </div> 

                                    <p id="error_message_spouse_proof" style="color:red; display:none;">
                                        Please fill at least one field of <Samp></Samp>pouse ID Proof: Voter ID, Passport,
                                        PAN or Aadhar
                                        Card.</p>

                                </div>

                            </div>

                            <button type="button" class="btn btn-primary"
                                style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" id="next-step">Next</button>

                            

                        </div>

                        <!-- Step 2 -->
                        <div id="step-2" class="step d-none">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading clearfix">
                                            <i class="icon-calendar"></i>
                                            <h4 class="panel-title" style="color:green;">Transferring Clinic<span
                                                    style="color:#ff0000">*</span>
                                            </h4>
                                        </div>

                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Clinic</span>
                                                        <select name="status_clinic" id="status_clinic"
                                                            class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="ART Clinic"
                                                                {{ old('status_clinic') == 'ART Clinic' ? 'selected' : '' }}
                                                                class="form1_clinic_select">
                                                                ART Clinic
                                                            </option>
                                                            <option value="Surrogacy Clinic"
                                                                {{ old('status_clinic') == 'Surrogacy Clinic' ? 'selected' : '' }}
                                                                class="form1_clinic_select">
                                                                Surrogacy Clinic
                                                            </option>
                                                        </select>
                                                    </div>
                                                   <!--  @error('status_clinic')
                                                        <p style="color:red;display:none;">{{ $message }}</p>
                                                    @enderror -->
                                                    <p id="error_message_status_clinic" style="color:red;display:none;">
                                                        Please Select Clinic</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Status</span>
                                                        <select name="status_from_clinic" id="status_from_clinic"
                                                            class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="Registered"
                                                                {{ old('status_from_clinic') == 'Registered' ? 'selected' : '' }}
                                                                class="form_clinic_select">
                                                                Registered
                                                            </option>
                                                            <option value="Not Registered"
                                                                {{ old('status_from_clinic') == 'Not Registered' ? 'selected' : '' }}
                                                                class="form_clinic_select">
                                                                Not
                                                                Registered
                                                            </option>
                                                            <option value="Applied for"
                                                                {{ old('status_from_clinic') == 'Applied for' ? 'selected' : '' }}
                                                                class="form_clinic_select">
                                                                Applied
                                                                for
                                                            </option>
                                                        </select>
                                                    </div>
                                                   <!--  @error('status_from_clinic')
                                                        <p style="color:red;display:none;">{{ $message }}</p>
                                                    @enderror -->
                                                    <p id="error_message_status_from_clinic"
                                                        style="color:red;display:none;">Please Select status From clinic
                                                    </p>
                                                </div>

                                            </div>


                                            <br>
                                            <div class="hide_not_registerd_mem" id="hide_not_registerd_mem">
                                                <div class="input-group" id="change_from_name_clinic">
                                                    {{-- <span class="input-group-text">Name of the Clinic</span> --}}
                                                    <select name="from_name_clinic" id="from_name_clinic"
                                                        class="form-control def" data-live-search="true">
                                                        <option value="">Name of the Clinic</option>
                                                    </select>
                                                </div>
                                                <p id="error_message_from_name_clinic" style="color:red;display:none;">
                                                    Please Select Name of the Clinic</p>
                                                <br>
                                                <div class="input-group" id="change_from_name_clinic1">
                                                    {{-- <span class="input-group-text">Name of the Clinic</span> --}}
                                                    <select name="from_name_clinic1" id="from_name_clinic1"
                                                        class="form-control ghi" data-live-search="true">
                                                        <option value="">Name of the Clinic</option>
                                                    </select>
                                                </div>
                                                <p id="error_message_from_name_clinic1" style="color:red;display:none;">
                                                    Please Select Name of the Clinic</p>
                                                <br>
                                                <div class="input-group" id="from_regno_hide11">
                                                    <span class="input-group-text name_clinic_label">Name of the
                                                        Clinic</span>
                                                    <input type="text" name="from_name_clinic2"
                                                        id="from_name_clinic11" class="form-control"
                                                        value="{{ old('from_name_clinic2') }}">
                                                </div>
                                                @error('from_name_clinic2')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror
                                                <p id="error_message_from_name_clinic11" style="color:red;display:none;">
                                                    Please Select Name of the Clinic</p>
                                                <br>
                                                <div class="input-group" id="from_doctor_hide">
                                                    <span class="input-group-text name_clinic_label">Name of the
                                                        Doctor</span>
                                                    <input type="text" name="from_doctor"
                                                        id="from_doctor" class="form-control"
                                                        value="">
                                                </div>
                                               <!--  @error('from_name_clinic2')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_from_name_clinic11" style="color:red;display:none;">
                                                    Please Select Name of the Clinic</p>
                                                <br>
                                                <div class="input-group" id="from_applicationno_hide">
                                                    <span class="input-group-text name_clinic_label">Application
                                                        Number</span>
                                                    <input type="text" name="from_applicationno"
                                                        id="from_applicationno" class="form-control"
                                                        value="{{ old('from_applicationno') }}" readonly>
                                                </div>
                                                <!-- @error('from_applicationno')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->

                                                <div class="input-group" id="from_regno_hide">
                                                    <span class="input-group-text name_clinic_label">Registration
                                                        Number</span>
                                                    <input type="text" name="from_regno" id="from_regno"
                                                        class="form-control" value="{{ old('from_regno') }}" readonly>
                                                </div>
                                                <!-- @error('from_regno')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Address</span>
                                                    <textarea id="from_address" class="form-control" name="from_address" rows="2" cols="6"
                                                        id="from_address" value="{{ old('from_address') }}" readonly></textarea>

                                                </div>
                                             <!--    @error('from_address')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_from_address" style="color:red;display:none;">Please
                                                    Select Address</p>
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Pincode</span>
                                                    <input type="text" class="form-control" id="f_pincode"
                                                        pattern="^[0-9]{6}$" name="f_pincode"
                                                        onkeyup="allnumeric(document.myform.f_pincode)"
                                                        placeholder="Pincode should be six numbers" maxlength="6"
                                                        value="{{ old('f_pincode') }}" oninput="validateNumericInput(event)" readonly>
                                                </div>
                                               <!--  @error('f_pincode')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_f_pincode" style="color:red;display:none;">Please
                                                    Select Pincode</p>
                                                <br>
                                                <br>
                                                <span id="f_pincodeavailability" style="color: red;"></span>
                                                <div class="input-group">
                                                    <span class="input-group-text">State</span>
                                                    <input type="text" class="form-control" name="f_state"
                                                        id="f_state" placeholder="State" value="">
                                                </div>
                                                <p id="error_message_f_state" style="color:red;display:none;">Please
                                                    Select state</p>
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">District</span>
                                                    <input type="text" class="form-control" name="f_district"
                                                        id="f_district" placeholder="District"
                                                        value="{{ old('f_district') }}">
                                                </div>
                                               <!--  @error('f_district')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_f_district" style="color:red;display:none;">Please
                                                    Select District</p>

                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Contact Number</span>
                                                   <input type="text" class="form-control" name="f_contact" id="f_contact" maxlength="11" pattern="\d{11}" placeholder="Contact of the Clinic" value="{{ old('f_contact') }}" oninput="validateNumericInput_contect(event)">

                                                </div>
                                               <!--  @error('f_contact')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_f_contact" style="color:red;display:none;">Please
                                                    Contact Number</p>
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Email Address</span>
                                                    <input type="email" name="f_email" id="f_email"
                                                        class="form-control" placeholder="Email Address"
                                                        value="{{ old('f_email') }}">
                                                </div>
                                               <!--  @error('f_email')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_f_email" style="color:red;display:none;">Please
                                                    Email Address</p>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12" id="to_clinic_hide">
                                    <div class="panel panel-default">
                                        <div class="panel-heading clearfix">
                                            <i class="icon-calendar"></i>
                                            <h4 class="panel-title" style="color:green;">Receiving Clinic<span
                                                    style="color:#ff0000">*</span>
                                            </h4>
                                        </div>

                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6" id="to_status_clinic_hide">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Clinic</span>
                                                        <select name="to_status_clinic" id="to_status_clinic"
                                                            class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="ART" id="form1_clinic_select_id"
                                                                {{ old('to_status_clinic') == 'ART' ? 'selected' : '' }}
                                                                class="form1_clinic_select" >
                                                                ART Clinic
                                                            </option>
                                                            <option value="Surrogacy"
                                                                {{ old('to_status_clinic') == 'Surrogacy' ? 'selected' : '' }}
                                                                class="form1_clinic_select">
                                                                Surrogacy Clinic
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <!-- @error('to_status_clinic')
                                                        <p style="color:red;display:none;">{{ $message }}</p>
                                                    @enderror -->
                                                    <p id="error_message_to_status_clinic"
                                                        style="color:red;display:none;">Please Select Clinic</p>
                                                </div>
                                                <div class="col-md-6" id="to_status_hide">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Status</span>
                                                        <select name="to_status_from_clinic" id="to_status_from_clinic"
                                                            class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="Registered"
                                                                {{ old('to_status_from_clinic') == 'Registered' ? 'selected' : '' }}
                                                                class="form_clinic_select">
                                                                Registered
                                                            </option>
                                                            <option value="Applied for"
                                                                {{ old('to_status_from_clinic') == 'Applied for' ? 'selected' : '' }}
                                                                class="form_clinic_select">
                                                                Applied
                                                                for
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <!-- @error('to_status_from_clinic')
                                                        <p style="color:red;display:none;">{{ $message }}</p>
                                                    @enderror -->
                                                    <p id="error_message_to_status_from_clinic"
                                                        style="color:red;display:none;">Please Select status</p>
                                                </div>
                                                <div class="col-md-6" id="country_hide" style="display:none;">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Country</span>
                                                        <select name="country" id="country" class="form-control">
                                                            <option value="">-- Select Country --</option>
                                                            @if ($countries->count() > 0)
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ old('country') == $country->country_name ? 'selected' : '' }}>
                                                                        {{ $country->country_name }}</option>
                                                                @endforeach
                                                            @else
                                                                <option value="">No Countries Available</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                   <!--  @error('country')
                                                        <p style="color:red;display:none;">{{ $message }}</p>
                                                    @enderror -->
                                                    <p id="error_message_country" style="color:red;display:none;">Please
                                                        Select Country</p>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="to_hide_not_registerd_mem" id="to_hide_not_registerd_mem">
                                                <div class="input-group" id="to_change_from_name_clinic">
                                                    {{-- <span class="input-group-text">Name of the Clinic</span> --}}
                                                    <select name="to_name_clinic" id="to_name_clinic"
                                                        class="form-control abc" data-live-search="true">
                                                        <option value="">Name of the Clinic</option>
                                                    </select>
                                                </div>
                                                <p id="error_message_country" style="color:red;display:none;">Please
                                                    Select Clinic</p>
                                                <br>
                                                <div class="input-group" id="to_change_from_name_clinic1">
                                                    {{-- <span class="input-group-text">Name of the Clinic</span> --}}
                                                    <select name="to_name_clinic1" id="to_name_clinic1"
                                                        class="form-control xyz" data-live-search="true">
                                                        <option value="">Name of the Clinic</option>

                                                    </select>
                                                </div>
                                                <p id="error_message_to_name_clinic1" style="color:red;display:none;">
                                                    Please Select Clinic</p>
                                                <br>
                                                <div class="input-group" id="to_regno_hide11">
                                                    <span class="input-group-text name_clinic_label">Name of the
                                                        Clinic</span>
                                                    <input type="text" name="to_name_clinic2" id="to_name_clinic11"
                                                        class="form-control" value="{{ old('to_name_clinic2') }}">
                                                </div>
                                               <!--  @error('to_name_clinic2')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <p id="error_message_to_name_clinic11"
                                                    style="color:red;display:none; margin-top: -19px;">
                                                    Please Select Clinic</p>
                                                <br>
                                                <div class="input-group" id="to_doctor_hide">
                                                    <span class="input-group-text name_clinic_label">Name of the
                                                        Doctor</span>
                                                    <input type="text" name="to_doctor"
                                                        id="to_doctor" class="form-control"
                                                        value="">
                                                </div>
                                                <br>
                                                <div class="input-group" id="to_applicationno_hide">
                                                    <span class="input-group-text name_clinic_label">Application
                                                        Number</span>
                                                    <input type="text" name="to_applicationno" id="to_applicationno"
                                                        class="form-control" value="{{ old('to_applicationno') }}"
                                                        readonly>
                                                </div>
                                               <!--  @error('to_applicationno')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <br>
                                                <div class="input-group" id="to_regno_hide">
                                                    <span class="input-group-text to_name_clinic_label">Registration
                                                        Number</span>
                                                    <input type="text" name="to_regno" id="to_regno"
                                                        class="form-control" value="{{ old('to_regno') }}" readonly>
                                                </div>
                                               <!--  @error('to_regno')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Address</span>
                                                    <textarea id="to_address" class="form-control" name="to_address" rows="2" cols="6" readonly>{{ old('to_address') }}</textarea>
                                                </div>
<!-- 
                                                @error('to_address')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <br>
                                                <div class="input-group" id="pincode_hide">
                                                    <span class="input-group-text">Pincode</span>
                                                    <input type="text" class="form-control" id="t_pincode"
                                                        pattern="^[0-9]{6}$" name="t_pincode"
                                                        onkeyup="allnumeric(document.myform.t_pincode)"
                                                        placeholder="Pincode should be six numbers" maxlength="6"
                                                        value="{{ old('t_pincode') }}" readonly>
                                                    <span id="f_pincodeavailability"></span>

                                                    <span class="input-group-text">State</span>
                                                    <input type="text" class="form-control" name="t_state"
                                                        id="t_state" placeholder="State" value="{{ old('t_state') }}"
                                                        readonly>

                                                    <span class="input-group-text">District</span>
                                                    <input type="text" class="form-control" name="t_district"
                                                        id="t_district" placeholder="District"
                                                        value="{{ old('t_district') }}" readonly>
                                                </div>

                                                @error('t_pincode')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror

                                                @error('t_state')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror

                                                @error('t_district')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror

                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Contact Number</span>
                                                    <input type="text" class="form-control" name="t_contact"
                                                        id="t_contact" maxlength="11"  placeholder="Contact of the Clinic"
                                                        value="{{ old('t_contact') }}" readonly>
                                                </div>
                                               <!--  @error('t_contact')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-text">Email Address</span>
                                                    <input type="email" name="t_email" id="t_email"
                                                        class="form-control" placeholder="Email Address"
                                                        value="{{ old('t_email') }}" readonly>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <legend>
                                    <h4 style="color: green;"><strong>Upload Documents<span style="color:#ff0000"></span>
                                    </h4>
                                    </strong>
                                </legend>
                                <div class="row">
                                    <div class="col-md-9 mb-4">
                                        <!-- <input type="checkbox" id="declaration" name="declaration"> -->
                                        <b>Note:-</b><br>
                                        <span>Upload the masked aadhar card only.</span><br>
                                        <span> First download the PDF format of Affidavits, then upload the filled-up
                                            completed affidavits in the PDF format.</span>
                                        <span> The Affidavit must be executed on Non-Judicial Stamp paper duly sworn before
                                            Metropolitan Magistrate or a Judicial Magistrate of First Class or an Executive
                                            Magistrate or a Notary Public. In case the applicant is outside India then the
                                            Affidavit may be executed through an authorized attorney in India.</span>
                                        <ul>
                                            <!-- <strong>Note:- </strong> -->
                                            <li><strong>File Type:</strong> PDF Format only.</li>
                                            <li><strong>File Size:</strong> 30 to 250 kb.</li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="col-md-4" id="form_17">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 17 (Affidavit for transfer of embryos outside
                                                India)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file" name="affidavit_embryos_outside"
                                                id="affidavit_embryos_outside" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_embryos_outside') }}" />
                                            <!-- Download Button -->
                                            <button id="customButton17" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_17.pdf']) }}"
                                                class="btn btn-secondary 17pdf" id="17pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Engish <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_17.pdf']) }}"
                                                class="btn btn-secondary 17pdf" id="17pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                        </div>
                                        <!-- @error('affidavit_embryos_outside')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_outside_embroys_1" style="color:red;display:none;">
                                            Please Select Affidavit for transfer of embryos outside</p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_18">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 18 (Affidavit for transfer of gametes (sperm/oocyte)
                                                outside India)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file" name="affidavit_gametes_outside"
                                                id="affidavit_gametes_outside" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_gametes_outside') }}" />
                                            <!-- Download Button -->
                                            <button id="customButton18" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_18.pdf']) }}"
                                                class="btn btn-secondary 18pdf" id="18pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_18.pdf']) }}"
                                                class="btn btn-secondary 18pdf" id="18pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                        </div>
                                        <!-- @error('affidavit_gametes_outside')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_affidavit_gametes_outside" style="color:red;display:none;">
                                            Please Select Affidavit for transfer of embryos outside</p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_19">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 19 (Affidavit for transfer of embryos within
                                                India)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file" name="affidavit_embryos_within"
                                                id="affidavit_embryos_within"
                                                onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_embryos_within') }}" />
                                            <!-- Download Button -->
                                            {{-- <a href="pdf_format/form_19.pdf" download="form_19.pdf"
                                                style="margin-left: 10px;"> --}}
                                            <button id="customButton19" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_19.pdf']) }}"
                                                class="btn btn-secondary 19pdf" id="19pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>

                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_19.pdf']) }}"
                                                class="btn btn-secondary 19pdf" id="19pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                            {{-- </a> --}}
                                        </div>
                                      <!--   @error('affidavit_embryos_within')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_20">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 20 (Affidavit for transfer of gametes (sperms/oocytes)
                                                within India)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file" name="affidavit_gametes_within"
                                                id="affidavit_gametes_within"
                                                onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_gametes_within') }}" />
                                            <!-- Download Button -->
                                            {{-- <a href="pdf_format/form_20.pdf" download="form_20.pdf"
                                                style="margin-left: 10px;"> --}}
                                            <button id="customButton20" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_20.pdf']) }}"
                                                class="btn btn-secondary 20pdf" id="20pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>

                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_20.pdf']) }}"
                                                class="btn btn-secondary 20pdf" id="20pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                            {{-- </a> --}}
                                        </div>
                                       <!--  @error('affidavit_gametes_within')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_21" style="display: none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 21 (Affidavit from the clinic holding the frozen
                                                embryos)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file"
                                                name="affidavit_clinic_holding_embryos"
                                                id="affidavit_clinic_holding_embryos"
                                                onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_clinic_holding_embryos') }}" />
                                            <!-- Download Button -->
                                            <button id="customButton21" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>

                                            <a href="{{ route('download-pdf', ['filename' => 'form_21.pdf']) }}"
                                                class="btn btn-secondary 21pdf" id="21pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>

                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_21.pdf']) }}"
                                                class="btn btn-secondary 21pdf" id="21pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>

                                        </div>
                                     <!--    @error('affidavit_clinic_holding_embryos')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_outside_embroys_2" style="color:red;display:none;">
                                            please select Affidavit from the clinic holding the frozen
                                            embryos</p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_22" style="display: none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 22 (Affidavit from clinic holding gametes (Sperms
                                                /oocytes))</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file"
                                                name="affidavit_clinic_holding_gametes"
                                                id="affidavit_clinic_holding_gametes"
                                                onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_clinic_holding_gametes') }}" />
                                            <!-- Download Button -->
                                            <button id="customButton22" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_22.pdf']) }}"
                                                class="btn btn-secondary 22pdf" id="22pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>

                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_22.pdf']) }}"
                                                class="btn btn-secondary 22pdf" id="22pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                        </div>
                                    <!--     @error('affidavit_clinic_holding_gametes')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->

                                        <p id="error_message_affidavit_clinic_holding_gametes"
                                            style="color:red;display:none;">
                                            Please Select Affidavit for transfer of embryos outside</p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_23" style="display: none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 23 (Affidavit from clinic receiving the frozen
                                                embryos)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file"
                                                name="affidavit_clinic_receiving_embryos"
                                                id="affidavit_clinic_receiving_embryos"
                                                onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_clinic_receiving_embryos') }}" />
                                            <!-- Download Button -->
                                            <button id="customButton23" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_23.pdf']) }}"
                                                class="btn btn-secondary 23pdf" id="23pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>

                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_23.pdf']) }}"
                                                class="btn btn-secondary 23pdf" id="23pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                        </div>
                                       <!--  @error('affidavit_clinic_receiving_embryos')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_outside_embroys_3" style="color:red;display:none;">
                                            please select Affidavit from the clinic holding the frozen
                                            embryos</p>
                                    </div>
                                </div>

                                <div class="col-md-4" id="form_24" style="display: none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            <strong>Form: 24 (Affidavit from clinic receiving the frozen
                                                gametes)</strong><span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file"
                                                name="affidavit_clinic_receiving_gametes"
                                                id="affidavit_clinic_receiving_gametes"
                                                onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('affidavit_clinic_receiving_gametes') }}" />
                                            <!-- Download Button -->
                                            <button id="customButton24" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                            <a href="{{ route('download-pdf', ['filename' => 'form_24.pdf']) }}"
                                                class="btn btn-secondary 24pdf" id="24pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                English <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                            <a href="{{ route('download-pdf', ['filename' => 'hin_form_24.pdf']) }}"
                                                class="btn btn-secondary 24pdf" id="24pdf"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                Hindi <i class="fas fa-download" style="margin-right: 5px;"></i>
                                            </a>
                                        </div>
                                       <!--  @error('affidavit_clinic_receiving_gametes')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_affidavit_clinic_receiving_gametes"
                                            style="color:red;display:none;">
                                            Please Select Affidavit for transfer of embryos outside</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of Identity Proof
                                                of
                                                Applicant</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="identity_proof_applicant" id="identity_proof_applicant"
                                                class="form-control">
                                                <option value="">Select</option>
                                                @if($user_profile->nationalty_type == 'Foreigner')
                                                 <option value="Passport_number"
                                                    {{ old('identity_proof_applicant') == 'Passport_number' ? 'selected' : '' }}>
                                                    Passport </option>

                                                @else
                                                <option value="Aadhar_number"
                                                    {{ old('identity_proof_applicant') == 'Aadhar_number' ? 'selected' : '' }}>
                                                    Masked Aadhar </option>
                                                <option value="pan_card"
                                                    {{ old('identity_proof_applicant') == 'pan_card' ? 'selected' : '' }}>
                                                    Pan Card</option>
                                                <option value="Passport_number"
                                                    {{ old('identity_proof_applicant') == 'Passport_number' ? 'selected' : '' }}>
                                                    Passport </option>
                                                <option value="voter_card"
                                                    {{ old('identity_proof_applicant') == 'voter_card' ? 'selected' : '' }}>
                                                    Voter Card</option>
                                                @endif
                                            </select>
                                            {{-- <input class="form-control" type="file" name="copy_aadhar_card"
                                                id="identity_proof_applicant_file" onchange="validateForSizepdf(this,70,250);" /> --}}
                                                <input class="form-control" type="file" name="copy_of_identity_proof_applicant"
                                                id="identity_proof_applicant_file" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('copy_of_identity_proof_applicant') }}" />
                                           

                                                 <button id="customButton25" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                        </div>

       <!--           <p id="error_message_identity_proof_applicant_dropdown" style="color:red;display:none;margin-top:19px;">please id proof form the list</p>
                 <p id="error_message_identity_proof_applicant_file" style="color:red;display:none;margin-left:290px;margin-top:-39px;">Please upload the id proof</p> -->

                                    </div>
                                </div>

                                <div class="col-md-4" id="copy_passport1" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of Passport of
                                                Applicant</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="copy_passport"
                                                id="copy_passport" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('copy_passport') }}" />
                                               
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="col-md-4" id="copy_aadhar_card_spouse1" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of Identity Proof
                                                of
                                                Spouse</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <select name="identity_proof_applicant_spouse"
                                                id="identity_proof_applicant_spouse" class="form-control">
                                                <option value="">Select</option>

                                                <option class="hide_adhaar_pan_voter" value="Aadhar_number"
                                                    {{ old('identity_proof_applicant_spouse') == 'Aadhar_number' ? 'selected' : '' }}>
                                                    Masked Aadhar </option>
                                                <option class="hide_adhaar_pan_voter" value="pan_card"
                                                    {{ old('identity_proof_applicant_spouse') == 'pan_card' ? 'selected' : '' }}>
                                                    Pan Card</option>
                                                <option  value="Passport_number"
                                                    {{ old('identity_proof_applicant_spouse') == 'Passport_number' ? 'selected' : '' }}>
                                                    Passport </option>
                                                <option class="hide_adhaar_pan_voter" value="voter_card"
                                                    {{ old('identity_proof_applicant_spouse') == 'voter_card' ? 'selected' : '' }}>
                                                    Voter Card</option>
                                                
                                            </select>
                                            <input class="form-control" type="file" name="copy_of_identity_proof_spouse"
                                                id="identity_proof_spouse_file" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('copy_of_identity_proof_spouse') }}" />
                                                 <button id="customButton26" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                        </div>
                                       <p id="error_message_dob_proof_spouse_drown"
                                                    style="color:red;display:none;">
                                                    Please select dropdown</p>
                                        <p id="error_message_dob_proof_spouse_file"
                                                    style="color:red;display:none; margin-left: 290px; margin-top: -39px;">
                                                    Please select upload file</p>
                                    </div>
                                </div>
                                <div class="col-md-4" id="copy_passport_spouse1" style="display:none;">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of Passport of
                                                Spouse</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="copy_passport_spouse"
                                                id="copy_passport_spouse" onchange="validateForSizepdf(this,30,250);" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of SSN (If
                                                Person of
                                                Indian Origin/Foreigner)</strong></label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="ssn"
                                                id="copy_ssn" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('ssn') }}" />
                                                 <button id="customButton27" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                        </div>
                                      <!--   @error('target_file_ssn')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>

                               
                                <div class="col-md-8" id="dob_proof_a" style="">
                                    <div class="row">
                                        <label class="control-label" for="signature"><strong>Date of Birth proof
                                                of
                                                Applicant</strong>
                                            <span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <select name="dob_proof_ap" id="dob_proof_ap" class="form-control">
                                                <option value="">Select</option>
                                                @if($user_profile->nationalty_type == 'Foreigner')
                                                    <option
                                                    value="Passport_number"{{ old('dob_proof_ap') == 'Passport_number' ? 'selected' : '' }}>
                                                    Passport </option>

                                                @else


                                                <option  
                                                    value="Aadhar_number"{{ old('dob_proof_ap') == 'Aadhar_number' ? 'selected' : '' }}>
                                                    Masked Aadhar </option>
                                                <option
                                                    value="pan_card"{{ old('dob_proof_ap') == 'pan_card' ? 'selected' : '' }}>
                                                    PAN </option>
                                                
                                                <option
                                                    value="Passport_number"{{ old('dob_proof_ap') == 'Passport_number' ? 'selected' : '' }}>
                                                    Passport </option>
                                                <option
                                                    value="birth_certificate"{{ old('dob_proof_ap') == 'birth_certificate' ? 'selected' : '' }}>
                                                    Birth Certificate </option>
                                                <option
                                                    value="ohter_birth_proof"{{ old('dob_proof_ap') == 'ohter_birth_proof' ? 'selected' : '' }}>
                                                    HSC/SSC Certificate </option>
                                                @endif


                                            </select>
                                        </div>
                                <!--      <p id="error_message_dob_proof_ap"
                                                    style="color:red;display:none;">
                                                    Please Select birth proof Applicant</p> -->
                                      <!--   <p id="error_message_dob_proof_ap" style="color:red;display:none;">Please Select
                                            Dob</p> -->
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <input class="form-control" type="file"
                                                        name="dob_proof_applicant" id="dob_proof_applicant"
                                                        onchange="validateForSize(this,30,250);"
                                                        value={{ old('dob_proof_applicant') }} />
                                                    <button id="customButton_dob_proof_ap" style="display: none"
                                                        class="btn btn-secondary"
                                                        style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                                </div>
                                               <!--  @error('dob_proof_applicant')
                                                    <p style="color:red;display:none;">{{ $message }}</p>
                                                @enderror -->
                                                <!-- <p id="error_message_dob_proof_applicant"
                                                    style="color:red;display:none;">
                                                    Please upload date of birth proof Applicant</p>
 -->                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8" id="dob_proof_s" style="display:none;">
                                    <div class="row">
                                        <label class="control-label" for="signature"><strong>Date of Birth proof
                                                of
                                                Spouse</strong>
                                            <span style="color:#ff0000">*</span>
                                        </label>
                                        <div class="col-md-3">
                                            <select name="dob_proof_sp" id="dob_proof_sp" class="form-control">
                                                <option value="">Select</option>
                                                <option class="hide_dobproff_adhaar_pan_birth_other"
                                                    value="Aadhar_number"{{ old('dob_proof_sp') == 'Aadhar_number' ? 'selected' : '' }}>
                                                    Masked Aadhar </option>
                                                <option class="hide_dobproff_adhaar_pan_birth_other"
                                                    value="pan_card"{{ old('dob_proof_sp') == 'pan_card' ? 'selected' : '' }}>
                                                    PAN </option>
                                                <option
                                                    value="Passport_number"{{ old('dob_proof_sp') == 'Passport_number' ? 'selected' : '' }}>
                                                    Passport </option>
                                                <option class="hide_dobproff_adhaar_pan_birth_other"
                                                    value="birth_certificate"{{ old('dob_proof_sp') == 'birth_certificate' ? 'selected' : '' }}>
                                                    Birth Certificate </option>
                                                <option class="hide_dobproff_adhaar_pan_birth_other"
                                                    value="ohter_birth_proof"{{ old('dob_proof_sp') == 'ohter_birth_proof' ? 'selected' : '' }}>
                                                    HSC/SSC Certificate </option>
                                            </select>
                                        </div>
                                      <!--   @error('dob_proof_sp')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_dob_proof_sp" style="color:red;display:none;">Please Select
                                            Dob of spouse</p>
                                        <div class="col-md-9">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <input class="form-control" type="file" name="dob_proof_spouse"
                                                        id="dob_proof_spouse" onchange="validateForSize(this,30,250);"
                                                        value="{{ old('dob_proof_spouse') }}" />
                                                        <button id="customButton_dob_proof_sp" style="display: none"
                                                        class="btn btn-secondary"
                                                        style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                                </div>
                                             
                                               <!--  <p id="error_message_dob_proof_spouse" style="color:red;display:none;">
                                                    Please Select Dob spouse upload file </p> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Medical
                                                Record/Supporting Document</strong>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="other_docs"
                                                id="other_docs" onchange="validateForSize(this,30,250);"
                                                value="{{ old('other_docs') }}" />
                                                 <button id="customButton28" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                        </div>
                                       <!--  @error('other_docs')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>

                                 <div class="col-md-6" id="oci_applicant_hide">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of OCI card of Applicant</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="oci_applicant_file"
                                                id="oci_applicant_file" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('oci_applicant_file') }}" />
                                                 <button id="customButton29" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                        </div>
                                        <!-- <p id="error_message_oci_file_applicant" style="color:red;display:none;">
                                                    Please Upload OCI Card Attachment of the Applicant< </p> -->
                                      <!--   @error('copy_ssn')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="col-md-6" id="oci_spouse_hide_pdf">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature"><strong>Copy of OCI card of spouse</strong><span style="color:#ff0000">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="oci_spouse_file"
                                                id="oci_spouse_file" onchange="validateForSizepdf(this,30,250);"
                                                value="{{ old('oci_spouse_file') }}" />
                                                 <button id="customButton30" class="btn btn-secondary"
                                                style="color: white; border: none; padding: 10px 20px; cursor: pointer;">Remove</button>
                                        </div>
                                       <!--  <p id="error_message_oci_file_spouse" style="color:red;display:none;">
                                                    Please Upload OCI Card Attachment of the Spouse< </p> -->
                                      <!--   @error('copy_ssn')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                    </div>
                                </div>
                                <div class="col-md-6" id="signed_declaration_applicant1">
                                    <div class="mb-3">
                                        <label class="control-label" for="signature">
                                            {{-- <strong>Upload signed declaration of the Applicant</strong><span
                                                style="color:#ff0000">*</span> --}}
                                            <strong>Upload signed declaration of the applicant/ spouse (if
                                                applicable) *</strong><span
                                                style="color:#ff0000">*</span>
                                                
                                        </label>
                                        <div class="input-group">
                                            <!-- File Upload -->
                                            <input class="form-control" type="file" name="sign_applicant"
                                                id="sign_applicant" onchange="validateForSize(this,30,250);"
                                                value="{{ old('sign_applicant') }}" />
                                            <!-- Download Button -->
                                            {{-- <a href="pdf_format/declaration_applicant.pdf"
                                                download="declaration_applicant.pdf" style="margin-left: 10px;">
                                                <button class="download-btn btn btn-secondary" type="button"
                                                    style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                    Declaration <i class="fas fa-download" style="margin-right: 5px;"></i>
                                                </button>
                                            </a> --}}
                                            <a href="{{ route('download-pdf', ['filename' => 'declaration_applicant.pdf']) }}"
                                                download="c_applicant.pdf" style="margin-left: 10px;">
                                                <button class="download-btn btn btn-secondary" type="button"
                                                    style="color: white; border: none; padding: 10px 20px; cursor: pointer;">
                                                    Declaration <i class="fas fa-download"
                                                        style="margin-right: 5px;"></i>
                                                </button>
                                                <button id="customButton_declaration" style="display: none"
                                                    class="btn btn-secondary">Remove</button>
                                            </a>
                                        </div>
                                       <!--  @error('sign_applicant')
                                            <p style="color:red;display:none;">{{ $message }}</p>
                                        @enderror -->
                                        <p id="error_message_sign_applicant" style="color:red;display:none;">Please
                                            Select Sign Applicant upload file </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9 mb-4">
                                        <input type="checkbox" id="declaration" name="declaration"
                                            value="{{ old('declaration') }}">
                                        <b> I/ we hereby declare that these gametes (sperm/oocyte)/embryos are
                                            our own and are being transfered for personal use only.<span
                                                style="color:#ff0000">*</span> </b>
                                    </div>
                                    <!-- @error('declaration')
                                        <p style="color:red;display:none;">{{ $message }}</p>
                                    @enderror -->
                                    <p id="error_message_declaration" style="color:red;display:none;">Please Select
                                        checkbox sign declaration </p>
                                </div>

                            </div>
                            <button type="button" class="btn btn-secondary"
                                style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;"
                                id="prev-step">Back</button>
                            <button type="submit" class="btn btn-success" id="button_disabled"
                                style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;"
                                onclick="return validatesubmit(event)">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <style nonce="{{$cspNonce}}">
        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #e9ecef;
        }

        .indicator.active {
            background-color: #0d6efd;
        }

        .progress-bar {
            background-color: #0d6efd;
            ;
        }
    </style>


        </div>
 

    
<script nonce="{{ $cspNonce }}">
    $('#dob_spouse_info').hide();
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const progressBar = document.getElementById('progress-bar');

    document.getElementById('next-step').addEventListener('click', () => {
        step1.classList.add('d-none');
        step2.classList.remove('d-none');
        progressBar.style.width = '100%';
        progressBar.setAttribute('aria-valuenow', '100');
        progressBar.innerText = 'Step 2 of 2';
    });

    document.getElementById('prev-step').addEventListener('click', () => {

        step2.classList.add('d-none');
        step1.classList.remove('d-none');
        progressBar.style.width = '50%';
        progressBar.setAttribute('aria-valuenow', '50');
        progressBar.innerText = 'Step 1 of 2';
    });

function goToStep1() {
    step2.classList.add('d-none');
    step1.classList.remove('d-none');
    progressBar.style.width = '50%';
    progressBar.setAttribute('aria-valuenow', '50');
    progressBar.innerText = 'Step 1 of 2';
}
</script>
<script nonce="{{ $cspNonce }}" type="text/javascript">
    function validateAadhar(input) {
        // Allow only numeric input
        input.value = input.value.replace(/\D/g, '');

        // Ensure the input is not more than 4 digits
        if (input.value.length > 4) {
            input.value = input.value.slice(0, 4);
        }
    }
</script>

<script nonce="{{ $cspNonce }}">
    // Set the max attribute for both date inputs to prevent future dates
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

        // Set max for Applicant's DOB
        const dobApplicantInput = document.getElementById('dob_applicant');

        dobApplicantInput.setAttribute('max', today);

        // Set max for Spouse's DOB
        const dobSpouseInput = document.getElementById('dob_spouse');
        dobSpouseInput.setAttribute('max', today);
    });
</script>

<script nonce="{{ $cspNonce }}">
    // Listen for changes on the checkboxes and dropdown
    document.getElementById('embryosCheckBox').addEventListener('change',
        function() {
            checkConditions();
        });

    document.getElementById('spermsCheckBox').addEventListener('change',
        function() {
            checkConditions();
        });

    document.getElementById('oocytesCheckBox').addEventListener('change',
        function() {
            checkConditions();
        });

    document.getElementById('transfer').addEventListener('change', function() {
        checkConditions();
    });

    function checkConditions() {
        var embryosChecked = document.getElementById('embryosCheckBox').checked;
        var spermsChecked = document.getElementById('spermsCheckBox').checked;
        var oocytesChecked = document.getElementById('oocytesCheckBox').checked;
        var transferSelected = document.getElementById('transfer').value;
        var instructionList = document.getElementById('instructionList');

        instructionList.innerHTML = ''; // Clear any previous instructions

        // Condition 1: If embryos is checked and transfer is "Outside India"
        if (embryosChecked && transferSelected === "Outside India") {
            instructionList.innerHTML = `
                                                           <li>Form: 17 (Affidavit for transfer of embryos outside India)</li>
                                                           <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>
                                                           <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li>
                                                        `;
            $('#exampleModalCenter').modal('show'); // Show the modal
        }
        // Condition 2: If embryos is checked and transfer is "Within India"
        if (embryosChecked && transferSelected === "Within India") {
            instructionList.innerHTML = `
                                                           <li>Form: 19 (Affidavit for transfer of embryos within India)</li>
                                                           <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>
                                                           <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li>
                                                        `;
            $('#exampleModalCenter').modal('show'); // Show the modal
        }

        // Condition 3: If sperms or oocytes is checked and transfer is "Outside India"
        if ((spermsChecked || oocytesChecked) && transferSelected ===
            "Outside India") {
            instructionList.innerHTML = `
                                                           <li>Form: 18 (Affidavit for transfer of gametes (sperm/oocyte) outside India)</li>
                                                           <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                            <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                        `;
            $('#exampleModalCenter').modal('show'); // Show the modal
        }
        // Condition 4: If sperms or oocytes is checked and transfer is "Within India"
        if ((spermsChecked || oocytesChecked) && transferSelected ===
            "Within India") {
            instructionList.innerHTML = `
                                                           <li>Form: 20 (Affidavit for transfer of gametes (sperms/oocytes) within India)</li>
                                                           <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                            <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                        `;
            $('#exampleModalCenter').modal('show'); // Show the modal
        }
        // Condition 5: If both embryos and sperms are checked
        if ((embryosChecked && spermsChecked) && transferSelected ===
            "Within India") {
            instructionList.innerHTML = `
                                                     <li>Form: 19 (Affidavit for transfer of embryos within India)</li>
                                                     <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>
                                                     <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li>
                                                     <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                     <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                  `;
            $('#instructionsModal').modal('show'); // Show the modal
        }
        // Condition 6: If both embryos and sperms are checked
        if ((embryosChecked && oocytesChecked) && transferSelected ===
            "Within India") {
            instructionList.innerHTML = `
                                                     <li>Form: 19 (Affidavit for transfer of embryos within India)</li>
                                                     <li>Form: 20 (Affidavit for transfer of gametes (sperms/oocytes) within India)</li>
                                                     <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>                                                        
                                                     <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                     <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li>
                                                     <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                  `;
            $('#instructionsModal').modal('show'); // Show the modal
        }
        if ((embryosChecked && oocytesChecked) && transferSelected ===
            "Outside India") {
            instructionList.innerHTML = `
                                                     <li>Form: 17 (Affidavit for transfer of embryos outside India)</li>
                                                     <li>Form: 18 (Affidavit for transfer of gametes (sperm/oocyte) outside India)</li>
                                                     <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>
                                                     <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                     <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li> 
                                                     <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                  `;
            $('#instructionsModal').modal('show'); // Show the modal
        }
        if ((embryosChecked && oocytesChecked && spermsChecked) &&
            transferSelected ===
            "Outside India") {
            instructionList.innerHTML = `
                                                     <li>Form: 17 (Affidavit for transfer of embryos outside India)</li>
                                                     <li>Form: 18 (Affidavit for transfer of gametes (sperm/oocyte) outside India)</li>
                                                     <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>
                                                     <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                     <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li> 
                                                     <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                  `;
            $('#instructionsModal').modal('show'); // Show the modal
        }
        if ((embryosChecked && oocytesChecked && spermsChecked) &&
            transferSelected ===
            "Within India") {
            instructionList.innerHTML = `
                                                     <li>Form: 19 (Affidavit for transfer of embryos within India)</li>
                                                     <li>Form: 20 (Affidavit for transfer of gametes (sperms/oocytes) within India)</li>
                                                     <li>Form: 21 (Affidavit from the clinic holding the frozen embryos)</li>                                                        
                                                     <li>Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes))</li>
                                                     <li>Form: 23 (Affidavit from clinic receiving the frozen embryos)</li>
                                                     <li>Form: 24 (Affidavit from clinic receiving the frozen gametes)</li>
                                                  `;
            $('#instructionsModal').modal('show'); // Show the modal
        }



    }
</script>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        const transferSelect = document.getElementById('transfer');
        const embryosCheckBox = document.getElementById('embryosCheckBox');
        const form17Div = document.getElementById('form_17');

        // Function to toggle Form 17 visibility
        function toggleForm17() {
            if (transferSelect.value === 'Outside India' && embryosCheckBox.checked) {
                form17Div.style.display = 'block'; // Show Form 17
            } else {
                form17Div.style.display = 'none'; // Hide Form 17
            }
        }

        // Event listeners for changes in the transfer select and embryos checkbox
        transferSelect.addEventListener('change', toggleForm17);
        embryosCheckBox.addEventListener('change', toggleForm17);

        // Initially hide the Form 17 div
        form17Div.style.display = 'none';
    });
</script>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        const transferSelect = document.getElementById('transfer');
        const spermsCheckBox = document.getElementById('spermsCheckBox');
        const oocytesCheckBox = document.getElementById('oocytesCheckBox');
        const form18Div = document.getElementById('form_18');

        // Function to toggle Form 18 visibility
        function toggleForm18() {
            if (transferSelect.value === 'Outside India' && (spermsCheckBox.checked || oocytesCheckBox
                    .checked)) {
                form18Div.style.display = 'block'; // Show Form 18
            } else {
                form18Div.style.display = 'none'; // Hide Form 18
            }
        }

        // Event listeners for changes in the transfer select and checkboxes
        transferSelect.addEventListener('change', toggleForm18);
        spermsCheckBox.addEventListener('change', toggleForm18);
        oocytesCheckBox.addEventListener('change', toggleForm18);

        // Initially hide the Form 18 div
        form18Div.style.display = 'none';
    });
</script>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        const transferSelect = document.getElementById('transfer');
        const embryosCheckBox = document.getElementById('embryosCheckBox');
        const form19Div = document.getElementById('form_19');

        // Function to toggle Form 19 visibility
        function toggleForm19() {
            if (transferSelect.value === 'Within India' && embryosCheckBox.checked) {
                form19Div.style.display = 'block'; // Show Form 19
            } else {
                form19Div.style.display = 'none'; // Hide Form 19
            }
        }

        // Event listeners for changes in the transfer select and embryo checkbox
        transferSelect.addEventListener('change', toggleForm19);
        embryosCheckBox.addEventListener('change', toggleForm19);

        // Initially hide the Form 19 div
        form19Div.style.display = 'none';
    });
</script>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        const transferSelect = document.getElementById('transfer');
        const spermsCheckBox = document.getElementById('spermsCheckBox');
        const oocytesCheckBox = document.getElementById('oocytesCheckBox');
        const form20Div = document.getElementById('form_20');

        // Function to toggle Form 18 visibility
        function toggleForm20() {
            if (transferSelect.value === 'Within India' && (spermsCheckBox.checked || oocytesCheckBox
                    .checked)) {
                form20Div.style.display = 'block'; // Show Form 18
            } else {
                form20Div.style.display = 'none'; // Hide Form 18
            }
        }

        // Event listeners for changes in the transfer select and checkboxes
        transferSelect.addEventListener('change', toggleForm20);
        spermsCheckBox.addEventListener('change', toggleForm20);
        oocytesCheckBox.addEventListener('change', toggleForm20);

        // Initially hide the Form 18 div
        form20Div.style.display = 'none';
    });
</script>

<script nonce="{{ $cspNonce }}">
    // Get references to elements
    const embryosCheckBox = document.getElementById('embryosCheckBox');
    const form21 = document.getElementById('form_21');
    const form23 = document.getElementById('form_23');

    // Add event listener to the checkbox
    embryosCheckBox.addEventListener('change', function() {
        if (this.checked) {
            // Show form divs if the checkbox is checked
            form21.style.display = 'block';
            form23.style.display = 'block';
        } else {
            // Hide form divs if the checkbox is unchecked
            form21.style.display = 'none';
            form23.style.display = 'none';
        }
    });
</script>
<script nonce="{{ $cspNonce }}">
    // Get references to elements
    const spermsCheckBox = document.getElementById('spermsCheckBox');
    const oocytesCheckBox = document.getElementById('oocytesCheckBox');
    const form22 = document.getElementById('form_22');
    const form24 = document.getElementById('form_24');

    // Add event listeners to the checkboxes
    spermsCheckBox.addEventListener('change', toggleForms);
    oocytesCheckBox.addEventListener('change', toggleForms);

    function toggleForms() {
        if (spermsCheckBox.checked || oocytesCheckBox.checked) {
            // Show the form divs if either checkbox is checked
            form22.style.display = 'block';
            form24.style.display = 'block';
        } else {
            // Hide the form divs if neither checkbox is checked
            form22.style.display = 'none';
            form24.style.display = 'none';
        }
    }
</script>

<script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to both dropdowns
        const statusClinic = document.getElementById('status_clinic');
        const statusFromClinic = document.getElementById('status_from_clinic');

        // Debugging: Ensure the elements are correctly referenced
       // console.log('Clinic Dropdown:', statusClinic);
       // console.log('Status Dropdown:', statusFromClinic);

        // Add an event listener to monitor changes on the status_clinic dropdown
        statusClinic.addEventListener('change', function() {

           // console.log('Clinic selected:', statusClinic.value); // Debugging

            if (statusClinic.value !== '') {
                // Enable the status_from_clinic dropdown if a clinic is selected
                statusFromClinic.disabled = false;
             //   console.log('Status dropdown enabled'); // Debugging
            } else {
                // Disable the status_from_clinic dropdown if no clinic is selected
                statusFromClinic.disabled = true;
               // console.log('Status dropdown disabled'); // Debugging
            }
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    // When checkbox is checked, show the select field, otherwise hide it
    $('#embryosCheckBox').change(function() {
       
        if ($(this).is(':checked')) {
            $('#embryos_hidden').show();
        } else {
            $('#embryos_hidden').hide();
            $('#embryos_number').val('');
        }
    });

    $('#spermsCheckBox').change(function() {
        if ($(this).is(':checked')) {
            $('#sperm_hidden').show();
        } else {
            $('#sperm_hidden').hide();
            $('#sperm_vials').val('');
        }
    });

    $('#oocytesCheckBox').change(function() {
        if ($(this).is(':checked')) {
            $('#oocytes_hidden').show();
        } else {
            $('#oocytes_hidden').hide();
            $('#oocytes_number').val('');
        }
    });
</script>
<script nonce="{{ $cspNonce }}">
    // Regular expressions for ID validation
    const voterIDPattern = /^[A-Z]{2,3}[0-9]{7}$/;
    const panIDPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    const aadhaarIDPattern = /^[0-9]{12}$/;
    const passportIDPattern = /^[A-Z]{1}[0-9]{7}$/;

    // Get input fields and validation message element
    const voterIDInput = document.getElementById('voterID');
    const panIDInput = document.getElementById('panID');
    // const aadhaarIDInput = document.getElementById('aadhaarID');
    const passportIDInput = document.getElementById('passportID');
    const validationMessage = document.getElementById('validationMessage');

    // document.getElementById('multi-step-form').addEventListener('submit', function(event) {
    //     // Get values of the input fields
    //     const voterIDValue = voterIDInput.value.trim();
    //     const panIDValue = panIDInput.value.trim();
    //     //  const aadhaarIDValue = aadhaarIDInput.value.trim();
    //     const passportIDValue = passportIDInput.value.trim();

    //     // Validate Voter ID, PAN, Aadhaar, or Passport
    //     const isVoterIDValid = voterIDPattern.test(voterIDValue);
    //     const isPanIDValid = panIDPattern.test(panIDValue);
    //     //   const isAadhaarIDValid = aadhaarIDPattern.test(aadhaarIDValue);
    //     const isPassportIDValid = passportIDPattern.test(passportIDValue);

    //     // Check if at least one ID is valid
    //     if (isVoterIDValid || isPanIDValid || isPassportIDValid) {
    //         validationMessage.textContent = "At least one valid ID is provided!";
    //         validationMessage.className = "success";
    //     } else {
    //         validationMessage.textContent =
    //             "Please provide a valid Voter ID, PAN Card, Aadhaar Card, or Passport.";
    //         validationMessage.className = "error";
    //         event.preventDefault(); // Prevent form submission if no valid ID is found
    //     }
    // });
</script>
<script nonce="{{ $cspNonce }}">
    $('#m_status').on('change', function() {
       
        $("#name_spouse").val('');
        $("#nationality_spouse").val('');
        $("#email_spouse").val('');
        $("#mobile_spouse").val('');
        $("#aadhar_spouse").val('');
        $("#pan_spouse").val('');
        $("#dob_spouse").val('');
        $("#voterid_spouse").val('');
        $("#country_spouse_display").hide();
        $('#country_applicant_spouse').val();

        var purpose_of_transfer = document.getElementById('purpose_of_transfer');
        purpose_of_transfer.value = '';

        var transfer = document.getElementById('transfer');
        transfer.value = '';


        var embryosCheckBox = document.getElementById('embryosCheckBox');
        embryosCheckBox.checked = false;
        $('.hiddenembryos').show();
        $('#embryos_number').val('');
        $('#embryos_hidden').hide();
       

        var spermsCheckBox = document.getElementById('spermsCheckBox');
        spermsCheckBox.checked = false;
        $('.hiddensperms').show();
        $('#sperm_vials').val('');
        $('#sperm_hidden').hide();

        var oocytesCheckBox = document.getElementById('oocytesCheckBox');
        oocytesCheckBox.checked = false;
        $('.hiddenococytes').show();
        $('#oocytes_number').val('');
        $('#oocytes_hidden').hide();
        
        


        if (this.value == 'Married') {
            $('#dob_spouse_info').show();
            $("#name_spouse_display").show();
            $("#email_spouse_display").show();
            $("#mobile_spouse_display").show();
            $("#nationality_spouse_display").show();
            $("#nationality_spouse_display222").show();
           // $('#country_applicant_display').show();
            $("#country_spouse_display").show();
            $("#spouse_info").show();
            $("#copy_aadhar_card_spouse1").show();
            //$("#copy_passport_spouse1").show();
            $("#copy_passport_spouse1").css("display", "block");
            $("#sign_spouse1").show();
            $("#dob_proof_s").show();
        } else {
            $('#dob_spouse_info').hide();
            $("#nationality_spouse_display222").hide();
            $("#name_spouse_display").hide();
            $("#email_spouse_display").hide();
            $("#mobile_spouse_display").hide();
            $("#nationality_spouse_display").hide();
            $("#country_spouse_display").hide(); 
            $('#country_applicant_display').hide();
            $("#spouse_info").hide();
            $("#copy_aadhar_card_spouse1").hide();
            $("#copy_passport_spouse1").hide();
            $("#sign_spouse1").hide();
            $("#dob_proof_s").hide();
        }
        if (this.value === 'Unmarried' || this.value === 'Divorced' || this.value === 'Widow') {
                let gen = document.getElementById("gender").value;
                if (gen === 'Man') {
                    $(".hiddenval").hide();
                } else {
                    $(".hiddenval").show();
                }

                if (this.value === 'Unmarried') {
                    if (gen === 'Woman') {
                        $(".hiddensur").hide();
                    } else {
                        $(".hiddensur").show();
                    }
                } else {
                    $(".hiddensur").show();
                }

                if (this.value === 'Divorced' && document.getElementById('nationality_applicant').value == 'Foreigner') {
                    if (gen === 'Woman') {
                       // alert('sfsdf');
                        $(".hiddensur").hide();
                    } else {
                        $(".hiddensur").show();
                    }
                } else if(this.value === 'Widow' && document.getElementById('nationality_applicant').value == 'Foreigner') {
                    if (gen === 'Woman') {
                       // alert('sfsdf');
                        $(".hiddensur").hide();
                    } else {
                        $(".hiddensur").show();
                    }
                   
                }
            } else {
                $(".hiddenval").show();
                $(".hiddensur").show();
            }



    });
</script>

<script nonce="{{ $cspNonce }}">
    $('#nationality_spouse').on('change', function() {
        // console.log('hello');
        //alert('helooo');
        //$("#country_spouse").val('');
        if (this.value == 'Foreigner') {
            $("#country_spouse_display").hide();
            $("#error_message_nationality_spouse").hide();

        } else if (this.value == 'Indian') {
            $("#country_spouse_display").hide();
            $("#error_message_nationality_spouse").hide();
        } else {
            $("#country_spouse_display").show();
        }
    });


  
</script>
<script nonce="{{ $cspNonce }}">
    $('#oci_card_holder_app').hide();
    $('#oci_card_holder_sp').hide();
    $('#oci_applicant_hide').hide();
    $('#oci_spouse_hide_pdf').hide();

    $('#transfer').on('change', function() {
        if (this.value == 'Outside India') {
            $('#to_address').val('');
            $('#t_pincode').val('');
            $('#t_state').val('');
            $('#t_district').val('');
            $('#t_email').val('');
            $('#t_contact').val('');
            $('#to_regno').val('');
            $('#to_applicationno').val('');
            $('#to_name_clinic11').val('');
            $("#to_status_hide").val();

            $("#to_status_hide").hide();
            $("#country_hide").show();
            $("#to_applicationno_hide").hide();
            $("#change_from_name_clinic1").hide();
            $("#change_from_name_clinic").hide();
            $("#to_address").removeAttr("readonly");
            $("#to_applicationno").removeAttr("readonly");
            $("#t_pincode").removeAttr("readonly");
            $("#t_contact").removeAttr("readonly");
            $("#t_address").removeAttr("readonly");
            $("#t_email").removeAttr("readonly");
            $("#to_regno_hide11").show();
            $("#to_regno_hide").hide();
            $("#to_change_from_name_clinic1").hide();
            $("#to_change_from_name_clinic").hide();
            $("#to_hide_not_registerd_mem").show();
            $("#pincode_hide").hide();

            $("#copy_passport1").show();
        } else {

            $("#country_hide").hide();
            //$("#to_name_clinic11").hide();
            $("#to_status_hide").show();

            $("#copy_passport1").hide();
        }
    });
</script>
<script nonce="{{ $cspNonce }}">
    $('#transfer').on('change', function() {
        if (this.value == 'Outside India') {
            // $("#passport_spouse1").show();

            passport_spouse
        } else {
            //  $("#passport_spouse1").hide();
        }
    });
</script>
<script nonce="{{ $cspNonce }}">
    $('#transfer').on('change', function() {
        if (this.value == 'Outside India') {
            //  $("#passport_applicant1").show();
        } else {
            //  $("#passport_applicant1").hide();
        }
    });
</script>

<script nonce="{{ $cspNonce }}">
    function nationality_applicant_hideError() {
        var errorMessage = document.getElementById("error_message_nationality_applicant");
        var nationality_applicant = document.getElementById("nationality_applicant");

        if (nationality_applicant.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    }


    $('#name_spouse').on('input', function() {
        var errorMessage = document.getElementById("error_message_name_spouse");
        var name_spouse = document.getElementById("name_spouse");

        // Check if the input is not empty after trimming
        if (name_spouse.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });






    $('#email_spouse').on('input', function() {
        var errorMessage = document.getElementById("error_message_email_spouse");
        var email_spouse = document.getElementById("email_spouse");

        // Check if the input is not empty after trimming
        if (email_spouse.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });

    $('#mobile_spouse').on('input', function() {
        var errorMessage = document.getElementById("error_message_mobile_spouse");
        var mobile_spouse = document.getElementById("mobile_spouse");

        // Check if the input is not empty after trimming
        if (mobile_spouse.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });

    $('#oci_applicant').on('input', function() {
        var errorMessage = document.getElementById("error_message_oci_number");
        var oci_applicant = document.getElementById("oci_applicant");

        // Check if the input is not empty after trimming
        if (oci_applicant.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });

     $('#oci_spouse').on('input', function(){
        var errorMessage = document.getElementById("error_message_oci_number_spouse");
        var oci_applicant = document.getElementById("oci_spouse");

        // Check if the input is not empty after trimming
        if (oci_spouse.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });


     $('#oci_applicant_file').on('input', function(){
        var errorMessage = document.getElementById("error_message_oci_file_applicant");
        var oci_applicant_file = document.getElementById("oci_applicant_file");

        // Check if the input is not empty after trimming
        if (oci_applicant_file.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });

     $('#oci_spouse_file').on('input', function(){
        var errorMessage = document.getElementById("error_message_oci_file_spouse");
        var oci_spouse_file = document.getElementById("oci_spouse_file");

        // Check if the input is not empty after trimming
        if (oci_spouse_file.value.trim().length > 0) {
            errorMessage.style.display = "none"; // Hide the error message
        } else {
            errorMessage.style.display = "block"; // Show the error message
        }
    });


    function transfer_spouse_hideError2() {

     
        var errorMessage = document.getElementById("error_message_transfer");
        var transfer = document.getElementById("transfer");
        var purpose_of_transfer = document.getElementById("purpose_of_transfer");
        var nationality_oci     = document.getElementById("nationality_applicant");
        var nationality_spouse     = document.getElementById("nationality_spouse");
        var m_status     = document.getElementById("m_status");

        const country = document.getElementById("country"); //outside india case country dropdown value null
        country.value = '';
    //all attachement change case null value set// 
        const affidavit_embryos_outside_empty_17 = document.getElementById("affidavit_embryos_outside");
        affidavit_embryos_outside_empty_17.value = '';

        const affidavit_gametes_outside_empty_18 = document.getElementById("affidavit_gametes_outside");
        affidavit_gametes_outside_empty_18.value = '';

        const affidavit_embryos_within_empty_19 = document.getElementById("affidavit_embryos_within"); 
        affidavit_embryos_within_empty_19.value = '';

        const affidavit_gametes_within_20 = document.getElementById("affidavit_gametes_within");
        affidavit_gametes_within_20.value = '';

        const affidavit_clinic_holding_embryos_21 = document.getElementById("affidavit_clinic_holding_embryos");
        affidavit_clinic_holding_embryos_21.value = '';

        const affidavit_clinic_holding_gametes_empty_22 = document.getElementById("affidavit_clinic_holding_gametes");
        affidavit_clinic_holding_gametes_empty_22.value = '';

        const affidavit_clinic_receiving_embryos_empty_23 = document.getElementById("affidavit_clinic_receiving_embryos");
        affidavit_clinic_receiving_embryos_empty_23.value = '';

        const affidavit_clinic_receiving_gametes_empty_24 = document.getElementById("affidavit_clinic_receiving_gametes");
        affidavit_clinic_receiving_gametes_empty_24.value = '';

    //all attachement change case null value set end code // 

       

       if (transfer.value !== "") {
       
           //errorMessage.style.display = "none";
             if (transfer.value == "Outside India" && nationality_oci.value == 'Foreigner' && nationality_spouse.value == 'Foreigner' && m_status.value == 'Married'){
              // alert('sdfsdf');
                $('#oci_card_holder_app').show();
                $('#oci_card_holder_sp').show();
                
             }else if(transfer.value == "Outside India"  && nationality_oci.value == 'Foreigner' && nationality_spouse.value == 'Indian' && m_status.value == 'Married'){
                $('#oci_card_holder_app').show();
                //  $('#oci_applicant_hide').show();
             }else{
                $('#oci_card_holder_app').hide();
                $('#oci_card_holder_sp').hide();
             }
        }
// comment code
        // if (transfer.value !== "") {
        //     errorMessage.style.display = "none";
        //      if (transfer.value == "Within India" && purpose_of_transfer.value == 'Surrogacy' && nationality_oci.value == 'Foreigner' && m_status.value != 'Married'){
               
        //         $('#oci_card_holder_app').show();
        //         $('#oci_applicant_hide').show();
                

        //      }else if (transfer.value == "Within India" && purpose_of_transfer.value == 'Surrogacy' && nationality_oci.value == 'Foreigner' && m_status.value == 'Married'){
        //         $('#oci_card_holder_app').show();
        //          $('#oci_applicant_hide').show();
        //           // $('#oci_spouse_hide').show();
        //         // $('#oci_card_holder_sp').show();
        //      }else{
        //         //alert('sdfsd');
        //         $('#oci_applicant').val('');
        //         const oci_applicant_file = document.getElementById("oci_applicant_file");
        //         oci_applicant_file.value = '';
        //         $('#oci_card_holder_app').hide();
        //         $('#oci_applicant_hide').hide();
                
        //      }


        // } else {
        //      $('#oci_applicant').val('');
        //      const oci_applicant_file = document.getElementById("oci_applicant_file");
        //      oci_applicant_file.value = '';
        //      $('#oci_card_holder_app').hide();
        //      $('#oci_applicant_hide').hide();
             
        //     errorMessage.style.display = "block";
        // }

        hideshow_oci_spouse_field();
        hideshow_oci_spouse_hide_pdf();
    }

    document.getElementById('dob_applicant').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_dob_applicant");
        var dob_applicant = document.getElementById("dob_applicant");

        if (dob_applicant.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('dob_spouse').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_dob_spouse");
        var dob_spouse = document.getElementById("dob_spouse");

        if (dob_spouse.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('status_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_status_clinic");
        var status_clinic = document.getElementById("status_clinic");

        // if (status_clinic.value !== "") {
        //     errorMessage.style.display = "none";
        // } else {
        //     errorMessage.style.display = "block";
        // }
    });

    document.getElementById('status_from_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_status_from_clinic");
        var status_from_clinic = document.getElementById("status_from_clinic");

     

            // if (status_from_clinic.value !== "") {

            //     errorMessage.style.display = "none";
            // } else {
            //     errorMessage.style.display = "block";
            // }
        
    });

    document.getElementById('from_name_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_from_name_clinic");
        var from_name_clinic = document.getElementById("from_name_clinic");

        if (from_name_clinic.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('from_name_clinic11').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_from_name_clinic11");
        var from_name_clinic11 = document.getElementById("from_name_clinic11");

        if (from_name_clinic11.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('from_name_clinic1').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_from_name_clinic1");
        var from_name_clinic1 = document.getElementById("from_name_clinic1");

        if (from_name_clinic1.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });


    document.getElementById('from_address').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_from_address");
        var from_address = document.getElementById("from_address");

        if (from_address.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('f_pincode').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_f_pincode");
        var f_pincode = document.getElementById("f_pincode");

        if (f_pincode.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('f_state').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_f_state");
        var f_state = document.getElementById("f_state");

        if (f_state.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('f_district').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_f_district");
        var f_district = document.getElementById("f_district");

        if (f_district.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('f_contact').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_f_contact");
        var f_contact = document.getElementById("f_contact");

        if (f_contact.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('f_email').addEventListener('input', function() {
        var errorMessage = document.getElementById("error_message_f_email");
        var f_email = document.getElementById("f_email");

        if (f_email.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });




   $('#embryosCheckBox').change(function() {
       

        var errorMessage = document.getElementById("error_message_embryosCheckBox");
        var embryosCheckbox = document.getElementById("embryosCheckBox");
        var spermsCheckbox = document.getElementById("spermsCheckBox");
        var oocytesCheckbox = document.getElementById("oocytesCheckBox");

        // Check if all checkboxes are unchecked
        if (!embryosCheckbox.checked && !spermsCheckbox.checked && !oocytesCheckbox.checked) {
            errorMessage.style.display = "block"; // Show error message if all checkboxes are unchecked
            $('#embryos_number').val('');
        } else {
           
            errorMessage.style.display = "none"; // Hide error message if at least one checkbox is checked
        }
  });

    $('#spermsCheckBox').change(function() {
        var errorMessage = document.getElementById("error_message_embryosCheckBox");
        var embryosCheckbox = document.getElementById("embryosCheckBox");
        var spermsCheckbox = document.getElementById("spermsCheckBox");
        var oocytesCheckbox = document.getElementById("oocytesCheckBox");

        // Check if all checkboxes are unchecked
        if (!embryosCheckbox.checked && !spermsCheckbox.checked && !oocytesCheckbox.checked) {
            errorMessage.style.display = "block"; // Show error message if all checkboxes are unchecked
            $('#sperm_vials').val('');
        } else {
            errorMessage.style.display = "none"; // Hide error message if at least one checkbox is checked
        }
    });

    $('#oocytesCheckBox').change(function() {
        var errorMessage = document.getElementById("error_message_embryosCheckBox");
        var embryosCheckbox = document.getElementById("embryosCheckBox");
        var spermsCheckbox = document.getElementById("spermsCheckBox");
        var oocytesCheckbox = document.getElementById("oocytesCheckBox");

        // Check if all checkboxes are unchecked
        if (!embryosCheckbox.checked && !spermsCheckbox.checked && !oocytesCheckbox.checked) {
            errorMessage.style.display = "block"; // Show error message if all checkboxes are unchecked
            $('#oocytes_number').val('');
        } else {
            errorMessage.style.display = "none"; // Hide error message if at least one checkbox is checked
        }
    });


   
    $('#embryos_number').change(function(){
        var errorMessage = document.getElementById("error_message_embryos_number");
        var embryos_number = document.getElementById("embryos_number");

        if (embryos_number.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    
      $('#sperm_vials').change(function(){
        var errorMessage = document.getElementById("error_message_sperms_number");
        var sperm_vials = document.getElementById("sperm_vials");

        if (sperm_vials.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    
     $('#oocytes_number').change(function(){
        var errorMessage = document.getElementById("error_message_oocytes_number");
        var oocytes_number = document.getElementById("oocytes_number");

        if (oocytes_number.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    }


    function error_message_purpose_of_transfer() {

        
        var purpose_of_transfer = document.getElementById("purpose_of_transfer").value;
        var nationality_applicant = document.getElementById("nationality_applicant").value;
        var gender = document.getElementById("gender").value;
        var m_status = document.getElementById("m_status").value;
        document.getElementById('to_status_clinic').selectedIndex = 0;
        let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
            if (surrogacyOption) {
                surrogacyOption.hidden = false;
            }

            artOption = document.querySelector('#to_status_clinic option[value="ART"]');
            if (artOption) {
                artOption.hidden = false;
            }

     if (purpose_of_transfer == 'Future Cryopreservation' && m_status == 'Married' && (gender == 'Man' || gender == 'Woman')){
          let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
          if (surrogacyOption) {
            surrogacyOption.hidden = false;
          }

          artOption = document.querySelector('#to_status_clinic option[value="ART"]');
          if (artOption) {
              artOption.hidden = false;
          }
  

      }else if(purpose_of_transfer == 'Surrogacy' && m_status == 'Married' && (gender == 'Man' || gender == 'Woman')){
          let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
          if (surrogacyOption) {
            surrogacyOption.hidden = false;
          }

          artOption = document.querySelector('#to_status_clinic option[value="ART"]');
          if (artOption) {
              artOption.hidden = false;
          }
  

      }else if(purpose_of_transfer == 'Invitro Fertilization' && m_status == 'Married' && (gender == 'Man' || gender == 'Woman')){
          let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
          if (surrogacyOption) {
            surrogacyOption.hidden = false;
          }

          artOption = document.querySelector('#to_status_clinic option[value="ART"]');
          if (artOption) {
              artOption.hidden = false;
          }
  

      }else if (purpose_of_transfer == 'Invitro Fertilization' && gender == 'Woman' && m_status == 'Unmarried'){
       
          let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
          if (surrogacyOption) {
            surrogacyOption.hidden = false;
          }

          artOption = document.querySelector('#to_status_clinic option[value="ART"]');
          if (artOption) {
            artOption.hidden = false;
          }

          var spermsCheckBox = document.getElementById('spermsCheckBox');
          spermsCheckBox.checked = false;
          $('#sperm_vials').val();
          $('.hiddensperms').hide();

       }else if (purpose_of_transfer == 'Future Cryopreservation' && gender == 'Woman' && m_status == 'Unmarried'){
         // alert('sdfsdf');
          let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
          if (surrogacyOption) {
            surrogacyOption.hidden = false;
          }

          artOption = document.querySelector('#to_status_clinic option[value="ART"]');
          if (artOption) {
              artOption.hidden = false;
          }

          $('.hiddensperms').hide();

       }else if (purpose_of_transfer == 'Future Cryopreservation' && gender == 'Man' && m_status == 'Married'){
          let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
          if (surrogacyOption) {
            surrogacyOption.hidden = false;
          }

          artOption = document.querySelector('#to_status_clinic option[value="ART"]');
          if (artOption) {
              artOption.hidden = false;
          }
  

      }else if ((purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Surrogacy'  || purpose_of_transfer == 'Future Cryopreservation')  && gender == 'Man'){
         
            let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
            if (surrogacyOption) {
                surrogacyOption.hidden = false;
            }

            artOption = document.querySelector('#to_status_clinic option[value="ART"]');
            if (artOption) {
                artOption.hidden = false;
            }
            

            $('.hiddenembryos').hide();
            $('.hiddenococytes').hide();
     }else if ((purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Surrogacy'  || purpose_of_transfer == 'Future Cryopreservation')  && gender == 'Woman' && m_status == 'Unmarried'){
         
         let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
         if (surrogacyOption) {
             surrogacyOption.hidden = false;
         }

         artOption = document.querySelector('#to_status_clinic option[value="ART"]');
         if (artOption) {
             artOption.hidden = false;
         }
         $('.hiddenembryos').show();
         $('.hiddenococytes').show();

         $('.hiddensperms').hide();
      }else if (purpose_of_transfer == 'Surrogacy') {
            //alert('ss');
            const artOption = document.querySelector('#to_status_clinic option[value="ART"]');
            if (artOption) {
                artOption.hidden = false;
            }
    }else if (purpose_of_transfer == 'Invitro Fertilization'){
           
           const surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
           if (surrogacyOption) {
               surrogacyOption.hidden = false;
           }
           
    }else{
            
            const artOption = document.querySelector('#to_status_clinic option[value="ART"]');
            if (artOption) {
                artOption.hidden = false;
            }

            const surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
            if (surrogacyOption) {
                surrogacyOption.hidden = false;
            }

            var to_status_clinic = document.getElementById('to_status_clinic');
             to_status_clinic.value = '';

            $('.hiddenembryos').show();
            $('.hiddenococytes').show();
            $('.hiddensperms').show();

            var spermsCheckBox = document.getElementById('spermsCheckBox');
            spermsCheckBox.checked = false;
            $('#sperm_vials').val('');
            $('#sperm_hidden').hide();

            var oocytesCheckBox = document.getElementById('oocytesCheckBox');
            oocytesCheckBox.checked = false;
            $('#oocytes_number').val('');
            $('#oocytes_hidden').hide();

            var embryosCheckBox = document.getElementById('embryosCheckBox');
            embryosCheckBox.checked = false;
            $('#embryos_number').val('');
            $('#embryos_hidden').hide();
        }


        hideshow_oci_spouse_field();
        hideshow_oci_spouse_hide_pdf();
        var errorMessage = document.getElementById("error_message_purpose_of_transfer");
        var purpose_of_transfer = document.getElementById("purpose_of_transfer");
        var transwithin_oci     = document.getElementById("transfer");
        var nationality_oci     = document.getElementById("nationality_applicant");
        var m_status_oci        = document.getElementById("m_status");
        var genderval            = document.getElementById("gender").value;
         
        var m_status_oci        = document.getElementById("m_status");
        var purpose_of_transfer = document.getElementById("purpose_of_transfer");

        // if(genderval == 'Man' && purpose_of_transfer.value == 'Future Cryopreservation' && m_status_oci == 'Unmarried'){
        //     $(".hiddenembryos").hide();
        //     $(".hiddenococytes").hide();
        // }else{
        //     $(".hiddenembryos").show();
        //     $(".hiddenococytes").show();
        // }

        // if(genderval == 'Man' && document.getElementById('nationality_applicant').value == 'Indian' && m_status_oci == 'Unmarried'){
        //     $(".hiddenembryos").hide();
        //     $(".hiddenococytes").hide();
        // }else{
        //     $(".hiddenembryos").show();
        //     $(".hiddenococytes").show();
        // }

        // if(genderval == 'Woman' && m_status_oci == 'Unmarried'){
        //     $(".hiddensperms").hide();
        // }else{
        //     $(".hiddensperms").show();
        // }

        // if(genderval == 'Woman' && m_status_oci == 'Unmarried' && document.getElementById('nationality_applicant').value == 'Indian'){
        //     $(".hiddensperms").hide();
        // }else{
        //     $(".hiddensperms").show();
        // }

        // if(genderval == 'Woman' && m_status_oci == 'Unmarried' && document.getElementById('nationality_applicant').value == 'Foreigner'){
        //     $(".hiddensperms").hide();
        // }else{
        //     $(".hiddensperms").show();
        // }

        // if(genderval == 'Woman' && (m_status_oci == 'Widow' || m_status_oci == 'Divorced')){
        //     $(".hiddensperms").hide();
        // }else{
        //     $(".hiddensperms").show();
        // }

        

        ///comment code//

        // if (purpose_of_transfer.value !== "") {

        //       errorMessage.style.display = "none";
        //      if(purpose_of_transfer.value == "Surrogacy")
        //          {

        //             if(transwithin_oci.value == ''){
        //                 alert('Please select transfer within/outside India');
        //                 $('#oci_applicant').val('');
        //                 const oci_applicant_file = document.getElementById("oci_applicant_file");
        //                 oci_applicant_file.value = '';
        //                  $('#oci_card_holder_app').hide();
        //                   $('#oci_applicant_hide').hide();
        //                   // $('#oci_spouse_hide').hide();

        //                    // $('#oci_card_holder_sp').hide();
                        
        //              }else if(transwithin_oci.value == 'Within India' && nationality_oci.value == 'Foreigner' && m_status_oci.value == 'Married'){
        //                 // $('#oci_card_holder_sp').show();
        //                 $('#oci_card_holder_app').show();
        //                 $('#oci_applicant_hide').show();
        //                   // $('#oci_spouse_hide').show();

        //              }else if(transwithin_oci.value == 'Within India' && nationality_oci.value == 'Foreigner'){
        //                 $('#oci_card_holder_app').show();
        //                 $('#oci_applicant_hide').show();
                                                       

        //              }else{
        //                 $('#oci_applicant').val('');
        //                 const oci_applicant_file = document.getElementById("oci_applicant_file");
        //                  oci_applicant_file.value = '';
        //                 $('#oci_card_holder_app').hide();
        //                 // $('#oci_card_holder_sp').hide();
        //                 $('#oci_applicant_hide').hide();
        //                 // $('#oci_spouse_hide').hide();
        //              }

        //        }else{
        //         $('#oci_applicant').val('');
        //         const oci_applicant_file = document.getElementById("oci_applicant_file");
        //         oci_applicant_file.value = '';
        //          $('#oci_card_holder_app').hide();
        //          // $('#oci_card_holder_sp').hide();
        //          $('#oci_applicant_hide').hide();
        //          // $('#oci_spouse_hide').hide();
        //        }  
         
        // } 
        // else {
        //     $('#oci_card_holder_app').hide();
        //       // $('#oci_card_holder_sp').hide();
        //       $('#oci_applicant_hide').hide();
        //       // $('#oci_spouse_hide').hide();
        //     errorMessage.style.display = "block";
        // }
    }

    //to clinic validation//
    document.getElementById('to_status_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_to_status_clinic");
        var to_status_clinic = document.getElementById("to_status_clinic");
        var purpose_of_transfer = document.getElementById("purpose_of_transfer").value;


        // if (to_status_clinic.value !== "") {
        //     errorMessage.style.display = "none";
        // } else {
        //     errorMessage.style.display = "block";
        // }
    });


    document.getElementById('to_status_from_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_to_status_from_clinic");
        var to_status_from_clinic = document.getElementById("to_status_from_clinic");

        if (to_status_from_clinic.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('to_name_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_to_name_clinic");
        var to_name_clinic = document.getElementById("to_name_clinic");

        if (to_name_clinic.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('to_name_clinic1').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_to_name_clinic11");
        var to_name_clinic1 = document.getElementById("to_name_clinic1");

        if (to_name_clinic1.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });


    document.getElementById('affidavit_embryos_outside').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_outside_embroys_1");
        var affidavit_embryos_outside = document.getElementById("affidavit_embryos_outside");

        if (affidavit_embryos_outside.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('affidavit_clinic_holding_embryos').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_outside_embroys_2");
        var affidavit_clinic_holding_embryos = document.getElementById("affidavit_clinic_holding_embryos");

        if (affidavit_clinic_holding_embryos.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('affidavit_clinic_receiving_embryos').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_outside_embroys_3");
        var affidavit_clinic_receiving_embryos = document.getElementById("affidavit_clinic_receiving_embryos");

        if (affidavit_clinic_receiving_embryos.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });


    //second//

    document.getElementById('affidavit_gametes_outside').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_affidavit_gametes_outside");
        var affidavit_gametes_outside = document.getElementById("affidavit_gametes_outside");

        if (affidavit_gametes_outside.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('affidavit_clinic_holding_gametes').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_affidavit_clinic_holding_gametes");
        var affidavit_clinic_holding_gametes = document.getElementById("affidavit_clinic_holding_gametes");

        if (affidavit_clinic_holding_gametes.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('affidavit_clinic_receiving_gametes').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_affidavit_clinic_receiving_gametes");
        var affidavit_clinic_receiving_gametes = document.getElementById("affidavit_clinic_receiving_gametes");

        if (affidavit_clinic_receiving_gametes.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });


    document.getElementById('to_name_clinic').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_to_name_clinic11");
        var to_name_clinic = document.getElementById("to_name_clinic");

        if (to_name_clinic.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });


    document.getElementById('dob_proof_ap').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_dob_proof_ap");
        var dob_proof_ap = document.getElementById("dob_proof_ap");

        if (dob_proof_ap.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

    document.getElementById('dob_proof_applicant').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_dob_proof_applicant");
        var dob_proof_applicant = document.getElementById("dob_proof_applicant");

        if (dob_proof_applicant.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });


    document.getElementById('dob_proof_ap').addEventListener('change', function() {
        var errorMessage = document.getElementById("error_message_dob_proof_ap");
        var dob_proof_ap = document.getElementById("dob_proof_ap");

        if (dob_proof_applicant.value !== "") {
            errorMessage.style.display = "none";
        } else {
            errorMessage.style.display = "block";
        }
    });

</script>

<script nonce="{{ $cspNonce }}">
    $('#m_status').on('change', function() {
        $("#name_spouse").val('');
        $("#email_spouse").val('');
        $("#mobile_spouse").val('');
        $("#nationality_spouse").val('');
        $("#aadhar_spouse").val('');
        $("#pan_spouse").val('');
        $("#dob_spouse").val('');
        $("#voterid_spouse").val('');
        $('#passport_spouse').val('');
        const identity_proof_applicant_spouse_empty = document.getElementById("identity_proof_applicant_spouse");
        identity_proof_applicant_spouse_empty.value='';

        const identity_proof_spouse_file_empty = document.getElementById("identity_proof_spouse_file");
        identity_proof_spouse_file_empty.value = '';


        const dob_proof_sp_empty = document.getElementById("dob_proof_sp");
        dob_proof_sp_empty.value='';

        const dob_proof_spouse_empty = document.getElementById("dob_proof_spouse");
        dob_proof_spouse_empty.value = '';

        if (this.value == 'Married') {
            $("#name_spouse_display").show();
            $("#email_spouse_display").show();
            $("#mobile_spouse_display").show();
            $("#nationality_spouse_display").show();
            // $("#country_spouse_display").show();
            $("#spouse_info").show();
            $("#copy_aadhar_card_spouse1").show();
           // $("#copy_passport_spouse1").show();
            $("#copy_passport_spouse1").css("display", "block");
            
            $("#sign_spouse1").show();
            $("#dob_proof_s").show();
        } else {
            $("#name_spouse_display").hide();
            $("#email_spouse_display").hide();
            $("#mobile_spouse_display").hide();
            $("#nationality_spouse_display").hide();
            // $("#country_spouse_display").hide();
            $("#spouse_info").hide();
            $("#copy_aadhar_card_spouse1").hide();
            $("#copy_passport_spouse1").hide();
            $("#sign_spouse1").hide();
            $("#dob_proof_s").hide();
        }

        
    });
</script>
<script nonce="{{ $cspNonce }}">
    $('#transfer').on('change', function() {
        $('#to_status_clinic').val('');
        $('#to_status_from_clinic').val('');
        if (this.value == 'Outside India') {
            $('#to_address').val('');
            $('#t_pincode').val('');
            $('#t_state').val('');
            $('#t_district').val('');
            $('#t_email').val('');
            $('#t_contact').val('');
            $('#to_regno').val('');
            $('#to_applicationno').val('');

            $("#to_status_hide").hide();
            $("#country_hide").show();
            $("#to_applicationno_hide").hide();
            $("#change_from_name_clinic1").hide();
            $("#change_from_name_clinic").hide();
            $("#to_address").removeAttr("readonly");
            $("#to_applicationno").removeAttr("readonly");
            $("#t_pincode").removeAttr("readonly");
            $("#t_contact").removeAttr("readonly");
            $("#t_address").removeAttr("readonly");
            $("#t_email").removeAttr("readonly");
            $("#to_regno_hide11").show();
            $("#to_regno_hide").hide();
            $("#to_change_from_name_clinic1").hide();
            $("#to_change_from_name_clinic").hide();
            $("#to_hide_not_registerd_mem").show();
            $("#pincode_hide").hide();
            $("#copy_passport1").show();
        } else {

            $("#copy_passport1").hide();
        }
    });
</script>
<script nonce="{{ $cspNonce }}">
    $('#transfer').on('change', function() {
        if (this.value == 'Outside India') {
            // $("#passport_spouse1").show();
        } else {
            //  $("#passport_spouse1").hide();
        }
    });
</script>
<script nonce="{{ $cspNonce }}">
    $('#transfer').on('change', function() {
        if (this.value == 'Outside India') {
            $("#passport_applicant1").show();
        } else {
            $("#passport_applicant1").hide();
        }
    });
</script>


<script nonce="{{ $cspNonce }}">
    //var _validFilepdf = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif", ".png"];
    var _validFilepdf = [".pdf"];

    function validateForSizepdf(oInput, minSize, maxSizepdf) {
        //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFilepdf.length; j++) {
                    var sCurExtension = _validFilepdf[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                        .toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    alert("Sorry, this file is invalid, allowed extension is: " + _validFilepdf.join(", "));
                    oInput.value = "";
                    return false;
                }
            }
        }

        fileSizeValidatepdf(oInput, minSize, maxSizepdf);
    }

    function fileSizeValidatepdf(fdata, minSize, maxSizepdf) {
        if (fdata.files && fdata.files[0]) {
            var fsize = fdata.files[0].size /
                1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
            //alert(fsize)
            if (fsize > maxSizepdf || fsize < minSize) {
                alert('This file size is: ' + fsize.toFixed(2) +
                    "KB. Files should be in " + (minSize) + " to " + (maxSizepdf) + " KB ");
                fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
                return false;
            } 
        }
    }
</script>
<script nonce="{{ $cspNonce }}">
    var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif", ".png"];

    function validateForSize(oInput, minSize, maxSizejpeg) {
        //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFilejpeg.length; j++) {
                    var sCurExtension = _validFilejpeg[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                        .toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    alert("Sorry, this file is invalid, allowed extension is: " + _validFilejpeg.join(", "));
                    oInput.value = "";
                    return false;
                }
            }
        }

        fileSizeValidatejpeg(oInput, minSize, maxSizejpeg);
    }

    function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
        if (fdata.files && fdata.files[0]) {
            var fsize = fdata.files[0].size /
                1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
            //alert(fsize)
            if (fsize > maxSizejpeg || fsize < minSize) {
                alert('This file size is: ' + fsize.toFixed(2) +
                    "KB. Files should be in " + (minSize) + " to " + (maxSizejpeg) + " KB ");
                fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
                return false;
            } 
        }
    }
</script>
<script nonce="{{ $cspNonce }}">
    $('#pincode').blur(function() {
        var pincode = $(this).val();
        if (pincode === "") {
            $('#state').val('');
            $('#district').val('');
            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
        } else {
            $.ajax({
                url: "{{ route('pincode.check') }}", // Laravel route
                method: "POST",
                data: {
                    pincode: pincode,
                    _token: "{{ csrf_token() }}" // CSRF token for security
                },
                success: function(data) {
                    if (data.success) {
                        $('#state').val(data.state);
                        $('#district').val(data.district);
                        $('#pincodeavailability').html('');
                    } else {
                        $('#pincodeavailability').html(
                            '<span class="text-danger">Invalid Pincode.</span>');
                        $('#state').val('');
                        $('#district').val('');
                    }
                }
            });
        }
    });
</script>



<!-- code starts for date of applicant and spouse -->
<script nonce="{{ $cspNonce }}">
    


    </script>

<!-- code ends -->

<script nonce="{{ $cspNonce }}" type="text/javascript">
    window.history.forward();

    function noBack() {
        window.history.forward();
    }

    $(document).ready(function() {
        $("#from_regno_hide11").hide();
        $("#to_clinic_hide_show").hide();
        $("#name_of_clinic_input").hide();
        $("#from_regno_hide").hide();
        $("#change_from_name_clinic1").hide();
        $("#hide_not_registerd_mem").hide();
        $("#to_hide_not_registerd_mem").hide();


        $("#to_status_from_clinic").change(function() {
            var slect_value = $(this).val();
            $('#to_doctor').val('');
            $('#to_address').val('');
            $('#t_pincode').val('');
            $('#t_state').val('');
            $('#t_district').val('');
            $('#t_email').val('');
            $('#t_contact').val('');
            $('#to_regno').val('');
            $('#to_applicationno').val('');
            //by naseer    $('#to_name_clinic').val('');
            $('#to_name_clinic1').val('');
            $('#to_name_clinic11').val('');
            if (slect_value == 'Registered') {
                $("#to_change_from_name_clinic").show();
                $("#to_applicationno").show();
                $("#to_hide_not_registerd_mem").show();
                $("#to_regno_hide").show();
                $("#to_of_clinic_input").hide();
                $("#to_applicationno_hide").hide();
                $("#to_change_from_name_clinic1").hide();
                $("#to_regno_hide11").hide();
                //$("#from_name_clinic11").hide();
                $("#to_address").attr("readonly", true);



            } else if (slect_value == 'Not Registered') {
                // $("#hide_not_registerd_mem").show();
                $("#to_applicationno_hide").hide();
                $("#change_from_name_clinic1").hide();
                $("#change_from_name_clinic").hide();
                $("#to_address").removeAttr("readonly");
                $("#to_applicationno").removeAttr("readonly");
                $("#t_pincode").removeAttr("readonly");
                $("#t_contact").removeAttr("readonly");
                $("#t_address").removeAttr("readonly");
                $("#t_email").removeAttr("readonly");
                $("#to_regno_hide11").show();
                $("#to_regno_hide").hide();
                $("#to_change_from_name_clinic1").hide();
                $("#to_change_from_name_clinic").hide();
                $("#to_hide_not_registerd_mem").show();


            } else if (slect_value == 'Applied for') {
                $("#to_change_from_name_clinic").show();
                $("#to_hide_not_registerd_mem").show();
                $("#to_regno_hide").hide();
                $("#to_applicationno_hide").show();
                $("#to_name_of_clinic_input").show();
                $("#to_change_from_name_clinic1").show();
                $("#to_change_from_name_clinic").hide();
                //  $("#to_regno_hide11").hide();
                $("#to_address").attr("readonly", true);
                $("#to_regno_hide11").hide();

            } else {
                //add on 06-09-2024
                $("#to_hide_not_registerd_mem").hide();

            }
        });

        $("#status_clinic").change(function() {
            var slect_value1 = $(this).val();
            $('#from_address').val('');
            $('#f_pincode').val('');
            $('#f_state').val('');
            $('#f_district').val('');
            $('#f_email').val('');
            $('#f_contact').val('');
            $('#from_regno').val('');
            $('#from_applicationno').val('');
            $('#from_name_clinic').val('');
            $('#from_name_clinic1').val('');
            $('#from_name_clinic11').val('');
        });

        $("#status_from_clinic").change(function() {
            var slect_value = $(this).val();
            $('#from_doctor').val('');
            $('#from_address').val('');
            $('#f_pincode').val('');
            $('#f_state').val('');
            $('#f_district').val('');
            $('#f_email').val('');
            $('#f_contact').val('');
            $('#from_regno').val('');
            $('#from_applicationno').val('');
            $('#from_name_clinic').val('');
            $('#from_name_clinic1').val('');
            $('#from_name_clinic11').val('');

            //alert(slect_value);
            if (slect_value == 'Registered') {
                $("#change_from_name_clinic").show();
                $("#from_applicationno").show();
                $("#hide_not_registerd_mem").show();
                $("#from_regno_hide").show();
                $("#name_of_clinic_input").hide();
                $("#from_applicationno_hide").hide();
                $("#change_from_name_clinic1").hide();
                $("#from_regno_hide11").hide();
                //$("#from_name_clinic11").hide();
                $("#from_address").attr("readonly", true);

            } else if (slect_value == 'Not Registered') {
                $("#hide_not_registerd_mem").show();
                $("#from_applicationno_hide").hide();
                $("#change_from_name_clinic1").hide();
                $("#change_from_name_clinic").hide();
                $("#from_address").removeAttr("readonly");
                $("#from_applicationno").removeAttr("readonly");
                $("#f_pincode").removeAttr("readonly");
                $("#f_contact").removeAttr("readonly");
                $("#from_address").removeAttr("readonly");
                $("#f_email").removeAttr("readonly");
                $("#from_regno_hide11").show();
                $("#from_regno_hide").hide();

            } else if (slect_value == 'Applied for') {
                $("#change_from_name_clinic").show();
                $("#hide_not_registerd_mem").show();
                $("#from_regno_hide").hide();
                $("#from_applicationno_hide").show();
                $("#name_of_clinic_input").show();
                $("#change_from_name_clinic1").show();
                $("#change_from_name_clinic").hide();
                $("#from_regno_hide11").hide();
                $("#from_address").attr("readonly", true);

            } else {
               
                $("#hide_not_registerd_mem").hide();
                


            }
        });

    });
</script>



<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#to_status_clinic, #to_status_from_clinic').on('change', function() {
            var clinicType = $('#to_status_clinic').val();
            var statusType = $('#to_status_from_clinic').val();

            if (clinicType && statusType) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('noc.fetchClinicData') }}',
                    data: {
                        clinic_type: clinicType,
                        status_type: statusType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('.abc').empty().append(data).select2();
                        $('.xyz').empty().append(data).select2();
                    },
                    error: function(xhr, status, error) {
                       // console.log("AJAX Error: ", error);
                    }
                });
            } else {
                $('.abc, .xyz').html('<option value="">Select</option>');
            }
        });

        $('#status_clinic, #status_from_clinic').on('change', function() {
             
            var clinicType = $('#status_clinic').val();
            var statusType = $('#status_from_clinic').val();

            if (clinicType && statusType) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('noc.fetchClinicDataFrom') }}',
                    data: {
                        clinic_type: clinicType,
                        status_type: statusType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('.def').empty().append(data).select2();
                        $('.ghi').empty().append(data).select2();
                    },
                    error: function(xhr, status, error) {
                       // console.log("AJAX Error: ", error);
                    }
                });
            } else {
                $('.def, .ghi').html('<option value="">Select</option>');
            }
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {

        $('#to_name_clinic').change(function() {

            //  console.log('hello');
            //alert('check 1');
            var clinicType = $('#to_status_clinic').val();
            var statusType = $('#to_status_from_clinic').val();
            var to_name_clinic_fetch_reg = $('#to_name_clinic').val();

            //console.log(to_name_clinic_fetch_reg);
            if (to_name_clinic_fetch_reg === '') {
                $('#to_clinic_hide_show').hide();
                $('#to_address, #t_pincode, #t_state, #t_district, #t_email, #t_contact, #to_regno, #to_applicationno')
                    .val('');
            } else {
                $('#to_clinic_hide_show').show();

                $.ajax({
                    url: '{{ route('noc.fetchClinicDetails') }}',
                    method: 'POST',
                    data: {
                        to_name_clinic_fetch_reg: to_name_clinic_fetch_reg,
                        clinicType: clinicType,
                        statusType: statusType,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#to_address').val(data.address || '');
                        $('#t_pincode').val(data.pincode || '');
                        $('#t_state').val(data.state || '');
                        $('#t_district').val(data.district || '');
                        $('#t_email').val(data.email || '');
                        $('#t_contact').val(data.contactno || '');
                        $('#to_regno').val(data.registration_no || '');
                        $('#to_applicationno').val(data.application_no || '');
                        //console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });

        $('#to_name_clinic1').change(function() {
            var clinicType = $('#to_status_clinic').val();
            var statusType = $('#to_status_from_clinic').val();
            var to_name_clinic_fetch_app = $('#to_name_clinic1').val();

            if (to_name_clinic_fetch_app === '') {
                $('#to_clinic_hide_show').hide();
                $('#to_address, #t_pincode, #t_state, #t_district, #t_email, #t_contact, #to_regno, #to_applicationno')
                    .val('');
            } else {
                $('#to_clinic_hide_show').show();

                $.ajax({
                    url: '{{ route('noc.fetchClinicApplicationDetails') }}',
                    method: 'POST',
                    data: 
                    {
                        to_name_clinic_fetch_app: to_name_clinic_fetch_app,
                        clinicType: clinicType,
                        statusType: statusType,
                       _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        //console.log(data);
                        $('#to_address').val(data.address || '');
                        $('#t_pincode').val(data.pincode || '');
                        $('#t_state').val(data.state || '');
                        $('#t_district').val(data.district || '');
                        $('#t_email').val(data.email || '');
                        $('#t_contact').val(data.mobile || '');
                        $('#to_regno').val(data.registration_no || '');
                        $('#to_applicationno').val(data.applicationno || '');
                       // console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#from_name_clinic').change(function() {

           
            var clinicType = $('#status_clinic').val();
            var statusType = $('#status_from_clinic').val();
            var from_name_clinic_fetch_reg = $('#from_name_clinic').val();

           // console.log(statusType);
          //  console.log(from_name_clinic_fetch_reg);
            if (from_name_clinic_fetch_reg === '') {
                $('#from_address').val('');
                $('#f_pincode').val('');
                $('#f_state').val('');
                $('#f_district').val('');
                $('#f_email').val('');
                $('#f_contact').val('');
                $('#from_regno').val('');
                $('#from_applicationno').val('');
            } else {
                $.ajax({
                    url: '{{ route('noc.fetchClinicDataFromm') }}',
                    method: 'POST',
                    data: {
                        from_name_clinic_fetch_reg: from_name_clinic_fetch_reg,
                        clinicType: clinicType,
                        statusType: statusType,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#from_address').val(data.address || '');
                        $('#f_pincode').val(data.pincode || '');
                        $('#f_state').val(data.state || '');
                        $('#f_district').val(data.district || '');
                        $('#f_email').val(data.email || '');
                        $('#f_contact').val(data.contactno || '');
                        $('#from_regno').val(data.registration_no || '');
                        $('#from_applicationno').val(data.application_no || '');
                    },
                    error: function(xhr, status, error) {
                      //  console.error('AJAX Error:', error);
                    }
                });
            }
        });

        $('#from_name_clinic1').change(function() {
            var clinicType = $('#status_clinic').val();
            var statusType = $('#status_from_clinic').val();
            var from_name_clinic_fetch_app = $('#from_name_clinic1').val();


            if (from_name_clinic_fetch_app === '') {
                $('#from_address').val('');
                $('#f_pincode').val('');
                $('#f_state').val('');
                $('#f_district').val('');
                $('#f_email').val('');
                $('#f_contact').val('');
                $('#from_regno').val('');
                $('#from_applicationno').val('');
            } else {
                $.ajax({
                    url: '{{ route('noc.nocClinicFetchAppFrom') }}',
                    method: 'POST',
                    data: {
                        from_name_clinic_fetch_app: from_name_clinic_fetch_app,
                        clinicType: clinicType,
                        statusType: statusType,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#from_address').val(data.address || '');
                        $('#f_pincode').val(data.pincode || '');
                        $('#f_state').val(data.state || '');
                        $('#f_district').val(data.district || '');
                        $('#f_email').val(data.email || '');
                        $('#f_contact').val(data.contactno || '');
                        $('#from_regno').val(data.registration_no || '');
                        $('#from_applicationno').val(data.applicationno || '');
                    },
                    error: function(xhr, status, error) {
                       // console.error('AJAX Error:', error);
                    }
                });
            }
        });
    });
</script>


<!---08-01-2024 Start---------->
<script nonce="{{ $cspNonce }}">
    $('#customButton17').click(function(event) {
        event.preventDefault();
        $('#affidavit_embryos_outside').val('');
        $('#customButton17').hide();
        $('.17pdf').show();

    });

    $('#customButton18').click(function(event) {
        event.preventDefault();
        $('#affidavit_gametes_outside').val('');
        $('#customButton18').hide();
        $('.18pdf').show();

    });

    $('#customButton19').click(function(event) {
        event.preventDefault();
        $('#affidavit_embryos_within').val('');
        $('#customButton19').hide();
        $('.19pdf').show();

    });

    $('#customButton20').click(function(event) {
        event.preventDefault();
        $('#affidavit_gametes_within').val('');
        $('#customButton20').hide();
        $('.20pdf').show();

    });

    $('#customButton21').click(function(event) {
        event.preventDefault();
        $('#affidavit_clinic_holding_embryos').val('');
        $('#customButton21').hide();
        $('.21pdf').show();

    });

    $('#customButton22').click(function(event) {
        event.preventDefault();
        $('#affidavit_clinic_holding_gametes').val('');
        $('#customButton22').hide();
        $('.22pdf').show();

    });

    $('#customButton23').click(function(event) {
        event.preventDefault();
        $('#affidavit_clinic_receiving_embryos').val('');
        $('#customButton23').hide();
        $('.23pdf').show();

    });

    // $('#customButton23').click(function(event) {
    //     event.preventDefault();
    //     $('#affidavit_clinic_receiving_embryos').val('');
    //     $('#customButton23').hide();
    //     $('#23pdf').show();

    // });

    $('#customButton24').click(function(event) {
        event.preventDefault();
        $('#affidavit_clinic_receiving_gametes').val('');
        $('#customButton24').hide();
        $('.24pdf').show();

    });

    $('#customButton25').click(function(event) {
        event.preventDefault();
        $('#copy_aadhar_card').val('');
        $('#customButton25').hide();
        
    });

    $('#customButton26').click(function(event) {
        event.preventDefault();
        $('#copy_aadhar_card_spouse').val('');
        $('#customButton26').hide();
        
    });

     $('#customButton27').click(function(event) {
        event.preventDefault();
        $('#copy_ssn').val('');
        $('#customButton27').hide();
        
    });

    $('#customButton28').click(function(event) {
        event.preventDefault();
        $('#other_docs').val('');
        $('#customButton28').hide();
        
    });

   

     $('#customButton29').click(function(event) {
        event.preventDefault();
        $('#oci_applicant_file').val('');
        $('#customButton29').hide();
        
    });

      $('#customButton30').click(function(event) {
        event.preventDefault();
        $('#oci_spouse_file').val('');
        $('#customButton30').hide();
        
    });

    $('#customButton_dob_proof_ap').click(function(event) {
        event.preventDefault();
        $('#dob_proof_applicant').val('');
        $('#customButton_dob_proof_ap').hide();

    });

     $('#customButton_dob_proof_sp').click(function(event) {
        event.preventDefault();
        $('#dob_proof_spouse').val('');
        $('#customButton_dob_proof_sp').hide();

    });



    $('#customButton_declaration').click(function(event) {
        event.preventDefault();
        $('#sign_applicant').val('');
        $('#customButton_declaration').hide();

    });


    $('#declaration').click(function(event) {
        var declaration = $('#declaration').val();

        if ($(this).is(':checked')) {
            $('#error_message_declaration').hide();
        } else {
            $('#error_message_declaration').show();
        }
    });

    $('#dob_proof_sp').change(function(event) {
       $('#error_message_dob_proof_sp').hide();
    });

    $('#dob_proof_spouse').click(function(event) {
       $('#error_message_dob_proof_spouse').hide();
    });

     $('#sign_applicant').click(function(event) {
       $('#error_message_sign_applicant').hide();
    });




    $(document).ready(function() {
        $('#customButton17').hide();
        $('#customButton18').hide();
        $('#customButton19').hide();
        $('#customButton20').hide();
        $('#customButton21').hide();
        $('#customButton22').hide();
        $('#customButton23').hide();
        $('#customButton24').hide();
        $('#customButton25').hide();
        $('#customButton26').hide();
        $('#customButton27').hide();
        $('#customButton28').hide();
        $('#customButton29').hide();
        $('#customButton30').hide();




        $('#affidavit_embryos_outside').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_embryos_outside').text(fileName); // Display the file name
            $('.17pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton17').show(); // Show the remove button
        });

        $('#affidavit_gametes_outside').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_gametes_outside').text(fileName); // Display the file name
            $('.18pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton18').show(); // Show the remove button
        });

        $('#affidavit_embryos_within').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_embryos_within').text(fileName); // Display the file name
            $('.19pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton19').show(); // Show the remove button
        });

        $('#affidavit_gametes_within').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_gametes_within').text(fileName); // Display the file name
            $('.20pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton20').show(); // Show the remove button
        });

        $('#affidavit_clinic_holding_embryos').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_clinic_holding_embryos').text(fileName); // Display the file name
            $('.21pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton21').show(); // Show the remove button
        });

        $('#affidavit_clinic_holding_gametes').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_clinic_holding_gametes').text(fileName); // Display the file name
            $('.22pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton22').show(); // Show the remove button
        });

        $('#affidavit_clinic_receiving_embryos').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_clinic_receiving_embryos').text(fileName); // Display the file name
            $('.23pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton23').show(); // Show the remove button
        });

        $('#affidavit_clinic_receiving_gametes').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#affidavit_clinic_receiving_gametes').text(fileName); // Display the file name
            $('.24pdf').hide(); // Hide an element (possibly for a PDF preview)
            $('#customButton24').show(); // Show the remove button
        });


        $('#dob_proof_applicant').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#dob_proof_applicant').text(fileName); // Display the file name
            $('#customButton_dob_proof_ap').show();
        });

          $('#copy_aadhar_card').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#copy_aadhar_card').text(fileName); // Display the file name
            $('#customButton25').show(); 
        });

        $('#copy_aadhar_card_spouse').change(function() {
            //alert('sdfsdfs');
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#copy_aadhar_card_spouse').text(fileName); // Display the file name
            $('#customButton26').show(); 
        });

        $('#copy_ssn').change(function() {
            //alert('sdfsdfs');
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#copy_ssn').text(fileName); // Display the file name
            $('#customButton27').show(); 
        });

        $('#other_docs').change(function() {
            //alert('sdfsdfs');
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#other_docs').text(fileName); // Display the file name
            $('#customButton28').show(); 
        });


        $('#oci_applicant_file').change(function() {
           // alert('sdfsdfs');
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#oci_applicant_file').text(fileName); // Display the file name
            $('#customButton29').show(); 
        });

        $('#oci_spouse_file').change(function() {
            //alert('sdfsdfs');
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#oci_spouse_file').text(fileName); // Display the file name
            $('#customButton30').show(); 
        });
          
          
          
          
        $('#dob_proof_spouse').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#dob_proof_spouse').text(fileName); // Display the file name
            $('#customButton_dob_proof_sp').show();
        });


        $('#sign_applicant').change(function() {
            var fileName = $(this).val().split('\\').pop(); // Get the file name
            $('#sign_applicant').text(fileName); // Display the file name
            $('#customButton_declaration').show();
        });



    });
</script>

<script nonce="{{ $cspNonce }}" type="text/javascript">
    function nationality_spouse_hideError() {
     
    
        var errorMessage = document.getElementById("error_message_nationality_spouse");
        var nationality_spouse = document.getElementById("nationality_spouse");
        var m_status = document.getElementById("m_status");
        var nationality_applicant = document.getElementById("nationality_applicant");
       
        if (nationality_spouse.value == "Foreigner" && m_status.value == 'Married') {
      
             
            //$('#address_class').removeClass('col-md-8').addClass('col-md-12');
            if(nationality_applicant.value == 'Indian'){

                $('#pincode_hide_val').css('display', 'block');
                $('#state_hide_val').css('display', 'block');
                $('#district_hide_val').css('display', 'block');
               // $('#zipcode_hide_val').hide();


            }
            else{

                $('#mobile_hide_val').css('display', 'block');
                $('#email_hide_val').css('display', 'block');
                $('#pincode_hide_val').css('display', 'none');
                $('#state_hide_val').css('display', 'none');
                $('#district_hide_val').css('display', 'none');
                $('#zipcode_hide_val').show();
                

            }
            
            $('.hide_adhaar_pan_voter').hide();
            $('.hide_dobproff_adhaar_pan_birth_other').hide();

            $('#country_applicant_display').css('display', 'block');
            $('#aadhar_spouse_info').hide();
            $('#pan_spouse_info').hide();
            $('#voter_spouse_info').hide();
            
            $('#passport_spouse1').show();
            $('#passport_spouse_star').css('display', 'block');




            //errorMessage.style.display = "none";
        } else if (nationality_spouse.value == "Indian" && m_status.value == 'Married' && nationality_applicant.value == 'Indian') {

           // $('#address_class').removeClass('col-md-12').addClass('col-md-12');
            $('.hide_adhaar_pan_voter').show();
            $('.hide_dobproff_adhaar_pan_birth_other').show();
            $('#zipcode_hide_val').css('display', 'none');
            $('#pincode_hide_val').css('display', 'block');
            $('#state_hide_val').css('display', 'block');
            $('#district_hide_val').css('display', 'block');
            $('#mobile_hide_val').css('display', 'block');
            $('#email_hide_val').css('display', 'block');
            $('#country_applicant_display').css('display', 'none');
            $('#spouse_info').show();
            $('#aadhar_spouse_info').show();
            $('#pan_spouse_info').show();
            $('#voter_spouse_info').show();
            $('#passport_spouse1').show();
            $('#passport_spouse_star').css('display', 'none');



        }else if (nationality_spouse.value == "Indian" && m_status.value == 'Married' && nationality_applicant.value == 'Foreigner') {
            //alert('sdfsdf');
            $('#address_class').removeClass('col-md-12').addClass('col-md-12');
            $('.hide_adhaar_pan_voter').show();
            $('.hide_dobproff_adhaar_pan_birth_other').show();
           // $('#zipcode_hide_val').css('display', 'none');
            $('#pincode_hide_val').css('display', 'none');
            $('#state_hide_val').css('display', 'none');
            $('#district_hide_val').css('display', 'none');
            $('#mobile_hide_val').css('display', 'block');
            $('#email_hide_val').css('display', 'block');
            $('#email_hide_val').css('display', 'block');
            $('#passport_spouse_star').css('display', 'none');
            
            
            $('#country_applicant_display').css('display', 'none');
            $('#spouse_info').show();
            $('#aadhar_spouse_info').show();
            $('#pan_spouse_info').show();
            $('#voter_spouse_info').show();
            $('#passport_spouse1').show();



        } else if (nationality_spouse.value == " ") {
            $('#country_spouse_display').css('display', 'none');
            $('#country_applicant_display').css('display', 'none');
            $('#spouse_info').show();
            $('#aadhar_spouse_info').show();
            $('#pan_spouse_info').show();
            $('#voter_spouse_info').show();
        }
      //   alert('sdfsdf');
        $('#country_applicant_spouse').val('');
        $('#passport_spouse').val('');
        hideshow_oci_spouse_field();
        hideshow_oci_spouse_hide_pdf();
    }
</script>

<script nonce="{{ $cspNonce }}">
    var nationality_applicant = document.getElementById("nationality_applicant").value;
    var m_status = document.getElementById("m_status").value;



    $('#name_spouse_display').hide();
    $('#nationality_spouse_display222').hide();
    $('#email_spouse_display').hide();
    $('#mobile_spouse_display').hide();
    $('#country_applicant_display').hide();
    $('#zipcode_hide_val').hide();
    $('#country_hide_val').hide();
    $('#state_hide_val').hide();
    $('#district_hide_val').hide();
    $('#pincode_hide_val').hide();
    if (nationality_applicant == 'Indian') {
        
        $('#state_hide_val').show();
        $('#district_hide_val').show();
        $('#pincode_hide_val').show();

        if (m_status == 'Married') {

            $('#name_spouse_display').show();
            $('#nationality_spouse_display222').show();
            $('#email_spouse_display').show();
            $('#mobile_spouse_display').show();
            if (document.getElementById("nationality_spouse").value == 'Foreigner') {
                $('#country_applicant_display').show(); //// it is actually for spouce country not for applicant
                $('#zipcode_hide_val').show();

                // $('#state_hide_val').hide();
                // $('#district_hide_val').hide();
                // $('#pincode_hide_val').hide();
            } else {
                $('#state_hide_val').show();
                $('#district_hide_val').show();
                $('#pincode_hide_val').show();
                $('#aadhar_spouse_info').hide();
                $('#pan_spouse_info').hide();
                $('#voter_spouse_info').hide();
                $('#passport_spouse1').hide();
                // $('#country_applicant_display').hide();
                // $('#zipcode_hide_val').hide();

            }

        } else {
            // $('#name_spouse_display').hide();
            // $('#nationality_spouse_display222').hide();
            // $('#email_spouse_display').hide();
            // $('#mobile_spouse_display').hide();
            // $('#country_applicant_display').hide();
            // $('#zipcode_hide_val').hide();

            // $('#state_hide_val').hide();
            // $('#district_hide_val').hide();
            // $('#pincode_hide_val').hide();
        }

    } else {
        $('#passport_number_star').css('display', 'block');

        if (m_status == 'Married') {
           
            $('#name_spouse_display').show();
            $('#nationality_spouse_display222').show();
            $('#email_spouse_display').show();
            $('#mobile_spouse_display').show();
            if (document.getElementById("nationality_spouse").value == 'Foreigner') {
                $('#country_applicant_display').show(); //// it is actually for spouce country not for applicant
                $('#zipcode_hide_val').show();

                // $('#state_hide_val').hide();
                // $('#district_hide_val').hide();
                // $('#pincode_hide_val').hide();


            } else {

                $('#dob_spouse_info').hide();
                // add spouse address here
                // $('#state_hide_val').show();
                // $('#district_hide_val').show();
                // $('#pincode_hide_val').show();
                // $('#country_applicant_display').hide();
                // $('#zipcode_hide_val').hide();

            }



        } else {
            $('#zipcode_hide_val').show();
            $('#country_hide_val').show();
            // $('#name_spouse_display').hide();
            // $('#nationality_spouse_display222').hide();
            // $('#email_spouse_display').hide();
            // $('#mobile_spouse_display').hide();
            // $('#country_applicant_display').hide();
            // $('#zipcode_hide_val').hide();
            // $('#country_hide_val').hide();
            // $('#state_hide_val').hide();
            // $('#district_hide_val').hide();
            // $('#pincode_hide_val').hide();

        }





    }

    // If nationality is 'Indian' and marital status is not 'Married' or is empty
    if (nationality_applicant == 'Indian' && (m_status == '' || m_status != 'Married')) {
        //$('#nationality_spouse_display222').hide();
        //$('#country_hide_val').hide();
       // $('#zipcode_hide_val').hide();
        // $('#aadhar_spouse_info').hide();
        // $('#pan_spouse_info').hide();
        // $('#voter_spouse_info').hide();
        // $('#passport_spouse1').hide();
    }
    // If nationality is 'Foreign', hide certain elements
    else if (nationality_applicant == 'Foreigner') {
        $('#pincode_hide_val').hide();
        $('#district_hide_val').hide();
        $('#state_hide_val').hide();
        $('#aadhar_applicant_info').hide();
        $('#voter_applicant_info').hide();
        $('#pan_applicant_info').hide();
        $('#aadhar_spouse_info').hide();
        $('#pan_spouse_info').hide();
        $('#voter_spouse_info').hide();
        $('#passport_spouse1').hide();



    }
    // Else for all other cases (Indian with 'Married' or any other case)
    else {

        $('#country_hide_val').show();
        $('#zipcode_hide_val').show();
    }
</script>

<script nonce="{{ $cspNonce }}">
    function m_status_hideError(){
    
        var errorMessage = document.getElementById("error_message_m_status");
        var m_status = document.getElementById("m_status");
        var nationality_spouse = document.getElementById("nationality_spouse").value; // Get the value of the input
        var nationality_applicant = document.getElementById("nationality_applicant")
            .value; // Get the value of the input
        var transfer = document.getElementById("transfer").value;
        //alert(transfer);
        var purpose_of_transfer = document.getElementById("purpose_of_transfer").value;
        var genderval            = document.getElementById("gender").value;
     
        if(m_status.value == 'Married'){
            $('#gender_sp_hide').css('display', 'block');
        }


        // Check if marital status is "Married" and applicant nationality is "Foreign"
        if (m_status.value !== "" && m_status.value == 'Married' && nationality_applicant == 'Foreigner') {
            $('#dob_spouse_info').show();
            $('#spouse_info').show();
            $('#nationality_spouse_display222').show();
            $('#state_hide_val').hide();
            //$('#address_class').hide();

            $('#address_class').removeClass('col-md-12').addClass('col-md-8');
            $('#country_hide_val').removeClass('col-md-2').addClass('col-md-4');
            $('#zipcode_hide_val').removeClass('col-md-2').addClass('col-md-4');
            errorMessage.style.display = "none";

        } else if (m_status.value !== "" && m_status.value != 'Married' && nationality_applicant == 'Foreigner') {
            errorMessage.style.display = "none";
            $('#country_applicant_display').hide();
            $('#nationality_spouse_display222').hide();
            $('#dob_spouse_info').hide();
            $('#spouse_info').hide();
            $('#address_class').removeClass('col-md-8').addClass('col-md-12');

        } else if (m_status.value !== "" && m_status.value == 'Married' && nationality_applicant == 'Indian') {
            $('#dob_spouse_info').show();
            $('#spouse_info').show();
            $('#nationality_spouse_display222').show();
            $('#state_hide_val').show();
            $('#address_class').show();
            $('#address_class').removeClass('col-md-12').addClass('col-md-8');
            $('#country_hide_val').removeClass('col-md-2').addClass('col-md-4');
            $('#zipcode_hide_val').removeClass('col-md-2').addClass('col-md-4');
            errorMessage.style.display = "none";

        } else if (m_status.value !== "" && m_status.value != 'Married' && nationality_applicant == 'Indian') {
            errorMessage.style.display = "none";
            $('#country_applicant_display').hide();
            $('#nationality_spouse_display222').hide();
            $('#dob_spouse_info').hide();
            $('#spouse_info').hide();
            $('#zipcode_hide_val').hide();
            $('#address_class').removeClass('col-md-8').addClass('col-md-12');

        }else{
            $('#nationality_spouse_display222').val() === null;
            $('#nationality_spouse_display222').hide();
            $('#dob_spouse_info').val() === null;
            $('#dob_spouse_info').hide();
            $('#spouse_info').val() === null;
            $('#spouse_info').hide();
            $('#country_hide_val').removeClass('col-md-4').addClass('col-md-2');
            $('#zipcode_hide_val').removeClass('col-md-4').addClass('col-md-2');
            $('#address_class').removeClass('col-md-12').addClass('col-md-8');
            $('#state_hide_val').val() === null;
            $('#state_hide_val').hide();
            errorMessage.style.display = "block";
        }
      
        if(genderval == 'Woman' && nationality_applicant.value == 'Foreigner' && (m_status.value == 'Unmarried' || m_status.value == 'Widow' || m_status.value == 'Divorced')){
          
            $(".hiddensperms").hide();
            const option = document.querySelector('#purpose_of_transfer option[value="Surrogacy"]');
            if (option) {
                option.hidden = true;
            }
        }else{
            $(".hiddensperms").show();
            const option = document.querySelector('#purpose_of_transfer option[value="Surrogacy"]');
            if (option) {
                option.hidden = false;
            }
        }

     // Hide options based on gender and marital status
        if (genderval == 'Man' && (m_status.value == 'Unmarried' || m_status.value == 'Widow' || m_status.value == 'Divorced')) {
            // Hide both options
           
            const surrogacyOption = document.querySelector('#purpose_of_transfer option[value="Surrogacy"]');
            const ivfOption = document.querySelector('#purpose_of_transfer option[value="Invitro Fertilization"]');
            if (surrogacyOption) {
                surrogacyOption.hidden = false;
            }
            if (ivfOption){
                ivfOption.hidden = false;
            }
        }else if (genderval == 'Woman' && (m_status.value == 'Unmarried' || m_status.value == 'Widow' || m_status.value == 'Divorced')) {
            //alert('sdfsdfsdf');
            const surrogacyOption = document.querySelector('#purpose_of_transfer option[value="Surrogacy"]');
            const ivfOption = document.querySelector('#purpose_of_transfer option[value="Invitro Fertilization"]');
            if(surrogacyOption) {
                surrogacyOption.hidden = false;
            }
            if(ivfOption){
                ivfOption.hidden = false;
            }
        }

        hideshow_oci_spouse_field();
        hideshow_oci_spouse_hide_pdf();
        
    }
</script>

<script nonce="{{ $cspNonce }}">

   function validateNumericInput(event) {
       const inputField = event.target;
         inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
   }

   function validateNumericInput_contect(event) {
       const inputField = event.target;
         inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
   }

   function validateNumericInput_mobile_spouse(event) {
       const inputField = event.target;
         inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
   }


//    function validateEmail(emailField){
//    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
//    if (reg.test(emailField.value) == false) 
//    {
//     alert('Invalid Email Address');
//     return false;
//    }
//     return true;
//    }

//    function validate_F_Email(emailField){
//    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
//    if (reg.test(emailField.value) == false) 
//    {
//     alert('Invalid Email Address');
//     return false;
//    }
//     return true;
//    }



   function validateNumericInput_mask_aadhar(event) {
       const inputField = event.target;
         inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
   }

    function validateNumericInput_applicant_aadhar(event) {
       const inputField = event.target;
         inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
   }


   

</script> 


  <script nonce="{{ $cspNonce }}">
    function hideshow_oci_spouse_field() {
    // Get values of the four input elements
    const m_status = document.getElementById("m_status").value;
    const nationality_spouse = document.getElementById("nationality_spouse").value;
    const transfer = document.getElementById("transfer").value;
    const purpose_of_transfer = document.getElementById("purpose_of_transfer").value;

    // Check if all values match
    if (m_status == "Married" && nationality_spouse == "Foreigner" && transfer == "Within India" && purpose_of_transfer =="Surrogacy") {
        // If values match, show the new input tab
        document.getElementById("oci_card_holder_sp").style.display = "block";
    } //comment code
    // else {
    //     // If values don't match, hide the new input tab
    //     $('#oci_spouse').val('');
    //     document.getElementById("oci_card_holder_sp").style.display = "none";
    // }
}


   function hideshow_oci_spouse_hide_pdf() {
    // Get values of the four input elements
    const m_status = document.getElementById("m_status").value;
    const nationality_spouse = document.getElementById("nationality_spouse").value;
    const transfer = document.getElementById("transfer").value;
    const purpose_of_transfer = document.getElementById("purpose_of_transfer").value;

    // Check if all values match
    if (m_status == "Married" && nationality_spouse == "Foreigner" && transfer == "Within India" && purpose_of_transfer =="Surrogacy") {
        // If values match, show the new input tab
        document.getElementById("oci_spouse_hide_pdf").style.display = "block";
    } else {
        // If values don't match, hide the new input tab
        // const oci_spoue_file = document.getElementById("oci_spoue_file");
        // oci_spoue_file.value = '';

        document.getElementById("oci_spouse_hide_pdf").style.display = "none";
    }
}


 function showAlert() {
    var inputValue = document.getElementById('dob_applicant').value;
    var purpose_of_transfer = document.getElementById('purpose_of_transfer').value;
      if(inputValue !="" && purpose_of_transfer ==""){
      alert("Please Select Purpose of Transfer at least choose Surrogacy");
      $('#dob_applicant').val('');
      return false;
    }
}


 function showAlert_sp() {
    var inputValue_sp = document.getElementById('dob_spouse').value;
    var purpose_of_transfer = document.getElementById('purpose_of_transfer').value;
      if(inputValue_sp !="" && purpose_of_transfer ==""){
      alert("Please Select Purpose of Transfer at least choose Surrogacy");
      $('#dob_spouse').val('');
      return false;
    }
}


$('#f_pincode').blur(function() {
var pincode = $(this).val();
if (pincode === "") {
    $('#f_state').val('');
    $('#f_district').val('');
    $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
} else {
    $.ajax({
        url: "{{ route('pincode.check') }}", // Laravel route
        method: "POST",
        data: {
            pincode: pincode,
            _token: "{{ csrf_token() }}" // CSRF token for security
        },
        success: function(data) {
            if (data.success) {
                $('#f_state').val(data.state);
                $('#f_district').val(data.district);
                //$('#pincodeavailability').html('');
            }else{
                
                    showAlert('Please Insert valid pincode.');
                 
                    $('#f_state').val('');
                    $('#f_district').val('');
                $('#error_message_f_pincode').css('display', 'block');
                document.getElementById("f_pincode").focus();
                return false;
            }
        }
    });
}
});
</script>
<script nonce="{{ $cspNonce }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script nonce="{{ $cspNonce }}">
    function validatesubmit(event) 
    {
        event.preventDefault();
    
   

        if (document.getElementById("name_applicant").value == ""){
                   alert("Name of the Applicant cannot be blank");
                   setTimeout(function() {
                      document.getElementById("name_applicant").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
           
  
               if (document.getElementById("nationality_applicant").value == "") {
  
                   alert("Nationality of the Applicant cannot be blank");
                   let error_mess = document.getElementById("error_message_nationality_applicant");
                   error_mess.style.display = "block";
                    setTimeout(function() {
                      document.getElementById("nationality_applicant").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
         
  
               if (document.getElementById("m_status").value == "") {
                   alert("Marital Status cannot be blank");
                //    let error_mess = document.getElementById("error_message_m_status"); 
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("m_status").focus();
                    }, 100);
                  
                   goToStep1();
                   return false;
               }

                if (document.getElementById("gender_sp").value == ""){
                   alert("Gender of the Spouse cannot be blank");
                   setTimeout(function(){
                      document.getElementById("gender_sp").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
             
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("name_spouse") == null)) {
                   alert("Name of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_name_spouse"); 
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("name_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("name_spouse").value =="")) {
                   alert("Name of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_name_spouse"); 
                //    error_mess.style.display = "block";
                    setTimeout(function() {
                      document.getElementById("name_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("nationality_spouse") == null)) {
                   alert("Nationality of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_nationality_spouse"); 
                //    error_mess.style.display = "block";
                    setTimeout(function() {
                      document.getElementById("nationality_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("nationality_spouse").value == "")) {
                   alert("Nationality of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_nationality_spouse"); 
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("nationality_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }

       
         
           
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("email_spouse") == null)) {
                   alert("Email ID of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_email_spouse");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("email_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("email_spouse").value == "")) {
                   alert("Email ID of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_email_spouse");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("email_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
              
  
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("mobile_spouse").value == "")) {
                   alert("Mobile Number of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_mobile_spouse");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("mobile_spouse").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
               if (document.getElementById("address").value == "") {
                   alert("Address cannot be blank");
                //    let error_mess = document.getElementById("error_message_address");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("address").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
              
               if (document.getElementById("email").value == "") {
                   alert("Email Address cannot be blank");
                //    let error_mess = document.getElementById("error_message_email");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("email").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
               if (document.getElementById("transfer").value == "") {
                   alert("Please select Within Indian or Outside India");
                //    let error_mess = document.getElementById("error_message_transfer");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("transfer").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }

               if (document.getElementById("purpose_of_transfer").value == "") {
                   alert("Purpose of the Transfer cannot be blank");
                //    let error_mess = document.getElementById("error_message_transfer");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("purpose_of_transfer").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }

              
           
               const embryosChecked = document.getElementById('embryosCheckBox').checked;       
               const spermsChecked = document.getElementById('spermsCheckBox').checked;     
               const oocytesChecked = document.getElementById('oocytesCheckBox').checked;

               const embryosNumber = document.getElementById('embryos_number').value;
               const spermVials = document.getElementById('sperm_vials').value;
               const oocytesNumber = document.getElementById('oocytes_number').value;
               const checkboxes = document.querySelectorAll('input[name="transfer_of[]"]');
              
               const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
              
               if (!isChecked) {
                   alert('Please select atleast one option transfer of embryos/sperm/oocytes');
                   let error_mess = document.getElementById("error_message_embryosCheckBox");
                   error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("embryosCheckBox").focus();
                      document.getElementById("spermsCheckBox").focus();
                      document.getElementById("oocytesCheckBox").focus();
                    }, 100);
                     goToStep1();
                   return false;
               }
               
           
              
  
               if (embryosChecked && embryosNumber === "") {
                   alert("Please select the number of embryos.");
                //    let error_mess = document.getElementById("error_message_embryos_number");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("embryos_number").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }

            
  
               if (spermsChecked && spermVials === "") {
                   alert("Please select the number of sperm vials");
                //    let error_mess = document.getElementById("error_message_sperms_number");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("sperm_vials").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
               if (oocytesChecked && oocytesNumber === "") {
                   alert("Please select the number of oocytes.");
                //    let error_mess = document.getElementById("error_message_oocytes_number");
                //    error_mess.style.display = "block";
                   setTimeout(function() {
                      document.getElementById("oocytes_number").focus();
                    }, 100);
                   goToStep1();
                   return false;
               }
  
            //    if (document.getElementById("purpose_of_transfer").value == "") {
            //        alert("Purpose of the Transfer cannot be blank");
            //        let error_mess = document.getElementById("error_message_purpose_of_transfer");
            //        error_mess.style.display = "block";
            //        setTimeout(function() {
            //           document.getElementById("purpose_of_transfer").focus();
            //         }, 100);
            //        goToStep1();
            //        return false;
            //    }
  
               const aadhar = document.getElementById('aadhar_applicant').value;
               const voterid = document.getElementById('voterid_applicant').value;
               //console.log(voterid);
               const passport = document.getElementById('passport_applicant').value;
               const pan = document.getElementById('pan_applicant').value;
  
               const aadhar_sp = document.getElementById('aadhar_spouse').value;
               const voterid_sp = document.getElementById('voterid_spouse').value;
               //console.log(voterid);
               const passport_sp = document.getElementById('passport_spouse').value;
               const pan_sp = document.getElementById('pan_spouse').value;
  
               let purpose_of_transfer = document.getElementById("purpose_of_transfer").value;
  
           if (document.getElementById("dob_applicant").value == "") {
  
                       alert("Age of the Applicant cannot be blank");
                    // let error_mess = document.getElementById("error_message_dob_applicant");
                    // error_mess.style.display = "block";
                       setTimeout(function() {
                          document.getElementById("dob_applicant").focus();
                       }, 100);
                       goToStep1();
                       return false;
  
                   } else {
  
                       let select_date_ap = document.getElementById("dob_applicant").value; 
                       let nationality_spouse = document.getElementById("nationality_spouse").value;
                       let nationality_applicant_val = document.getElementById("nationality_applicant").value
                       let gender = document.getElementById("gender").value;
                       let m_status = document.getElementById("m_status").value;
                       let transfer_val = document.getElementById("transfer").value;
                       let spermsCheckBox_val = document.getElementById("spermsCheckBox").value;
                       let embryosCheckBox_val = document.getElementById("embryosCheckBox").value;
                       let oocytesCheckBox_val = document.getElementById("oocytesCheckBox").value;

                       let dob = new Date(select_date_ap);
                       let current_date = new Date();
                       let yearDifference = current_date.getFullYear() - dob.getFullYear();
                       let monthDifference = current_date.getMonth() - dob.getMonth();
                       if (monthDifference < 0 || (monthDifference === 0 && current_date.getDate() < dob.getDate()))
                       {
                           yearDifference--;
                       }

                     //  -------Outside india case--------//

                     
                     if(gender == 'Man' && (m_status == 'Divorced' || m_status == 'Unmarried' || m_status == 'Widow') && nationality_applicant_val == 'Foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Future Cryopreservation' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Surrogacy') && spermsCheckBox_val == 'Sperms'){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                               //====
                           }
                     }else if(gender == 'Man' && m_status == 'Married'  && nationality_applicant_val == 'Indian' && nationality_spouse == 'foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Man' && m_status == 'Married'  && nationality_applicant_val == 'Foreigner' && nationality_spouse == 'Indian' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Man' && m_status == 'Married'  && nationality_applicant_val == 'Foreigner' && nationality_spouse == 'Foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Woman' && m_status == 'Unmarried'  && nationality_applicant_val == 'Foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Woman' && (m_status == 'Widow' || m_status == 'Divorced' )  && nationality_applicant_val == 'Foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Woman' && m_status == 'Married'  && nationality_applicant_val == 'Indian' && nationality_spouse == 'Foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Woman' && m_status == 'Married'  && nationality_applicant_val == 'Foreigner' && nationality_spouse == 'Indian' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else if(gender == 'Woman' && m_status == 'Married'  && nationality_applicant_val == 'Foreigner' && nationality_spouse == 'Foreigner' && transfer_val == 'Outside India' && (purpose_of_transfer == 'Surrogacy' || purpose_of_transfer == 'Invitro Fertilization' || purpose_of_transfer == 'Future Cryopreservation') && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')){
                        if (yearDifference < 11 || yearDifference > 99) {
                               alert("Age of applicant should be Valid");
                               let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                           }
                     }else{
                        alert("Please choose other Form It is a outside india form");
                        let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                               setTimeout(function() {
                               document.getElementById("dob_applicant").focus();
                               }, 100);
                               goToStep1();
                               return false;
                     }

                     
             }
                    
         
  
               if (document.getElementById("m_status").value == "Married") {
  
                       if(document.getElementById("dob_spouse").value == ""){
  
                            alert("Age of the Spouse cannot be blank");
                               
                            //    let error_mess = document.getElementById("error_message_dob_spouse");
                            //    error_mess.style.display = "block";
                            setTimeout(function() {
                               document.getElementById("dob_spouse").focus();
                            }, 100);
                               goToStep1();
                               return false;
  
                        }else {
                            let select_date_sp = document.getElementById("dob_spouse").value;
                                let nationality_applicant_val = document.getElementById("nationality_applicant").value;
                                let nationality_spouse = document.getElementById("nationality_spouse").value;
                                let transfer_val = document.getElementById("transfer").value;
                                let purpose_of_transfer = document.getElementById("purpose_of_transfer").value;
                                let spermsCheckBox_val = document.getElementById("spermsCheckBox").value;
                                let embryosCheckBox_val = document.getElementById("embryosCheckBox").value;
                                let oocytesCheckBox_val = document.getElementById("oocytesCheckBox").value;
                                let gender = document.getElementById("gender").value;
                                let m_status = document.getElementById("m_status").value;

                                // Convert the date string to a Date object
                                let dob = new Date(select_date_sp);

                                // Get the current date
                                let current_date = new Date();

                                // Calculate the year difference
                                let yearDifference = current_date.getFullYear() - dob.getFullYear();

                                // Adjust for month and day differences
                                let monthDifference = current_date.getMonth() - dob.getMonth();
                                if (monthDifference < 0 || (monthDifference === 0 && current_date.getDate() < dob.getDate())) {
                                    yearDifference--;
                                }

                               

                                if (gender == 'Man' && m_status == 'Married' && transfer_val == 'Outside India' && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')) {
                                 
                                    if (yearDifference < 11 || yearDifference > 99) {
                                            alert("Age of spouse should be Valid");
                                            let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                                            setTimeout(function() {
                                            document.getElementById("dob_spouse").focus();
                                            }, 100);
                                            goToStep1();
                                            return false;
                                            //====
                                        }
            

                                    }else if(gender == 'Woman' && m_status == 'Married' && transfer_val == 'Outside India' && (spermsCheckBox_val == 'Sperms' || embryosCheckBox_val == 'Embryos' || oocytesCheckBox_val == 'Oocytes')) {
                                        
                                        if (yearDifference < 11 || yearDifference > 99) {
                                            alert("Age of spouse should be Valid");
                                            let error_mess = document.getElementById("error_message_dob_applicant_valid_man");
                                            setTimeout(function() {
                                            document.getElementById("dob_spouse").focus();
                                            }, 100);
                                            goToStep1();
                                            return false;
                                            //====
                                        }
                                       
                                }
                            }
                                
                        
                     }
     
  
  
               if ((document.getElementById("purpose_of_transfer").value == "Surrogacy") && (document.getElementById("transfer").value == "Within India") && (document.getElementById("oci_applicant").value == "") && (document.getElementById("nationality_applicant").value == "Foreigner")) {
                   alert("OCI Card Number of the applicant cannot be blank");
                   let error_mess = document.getElementById("error_message_oci_number");
                   error_mess.style.display = "block";
                   setTimeout(function() {
                   document.getElementById("oci_applicant").focus();
                   }, 100);
                   goToStep1();
                   return false;
               }
  
  
                if ((document.getElementById("purpose_of_transfer").value == "Surrogacy") && (document.getElementById("transfer").value == "Within India") && document.getElementById("m_status").value == "Married" && document.getElementById("nationality_spouse").value == 'Foreigner' && (document.getElementById("oci_spouse").value=="")) {
                   alert("OCI Card Number of the Spouse cannot be blank");
                   let error_mess = document.getElementById("error_message_oci_number_spouse");
                   error_mess.style.display = "block";
                   setTimeout(function() {
                   document.getElementById("oci_spouse").focus();
                   }, 100);
                   goToStep1();
                   return false;
               }
  
          
  
               if (document.getElementById("nationality_applicant").value == "Indian") {
                   if (voterid === "" && passport === "" && pan === "" && aadhar === "") {
                       alert("Please fill at least one field of Applicant’s ID Proof: Voter ID, Passport, PAN or Aadhar Card.");
                       goToStep1();
                       return false;
                   }
  
               } else if (document.getElementById("nationality_applicant").value == "Foreigner") {
                   if (passport === "") {
                       alert("Please fill Passport Number of applicant");
                       setTimeout(function() {
                          document.getElementById("passport_applicant").focus();
                       }, 100);
                       goToStep1();
                       return false;
                   }
               }
               if (document.getElementById("m_status").value == "Married") {
                   if (document.getElementById("nationality_spouse").value == "Indian") {
                       if (voterid_sp === "" && passport_sp === "" && pan_sp === "" && aadhar_sp === "") {
                           alert("Please fill at least one ID Proof of the Spouse: Voter ID, Passport, PAN or Aadhar Card.");
                           // let error_mess = document.getElementById("error_message_proof");
                           // error_mess.style.display = "block";
                           goToStep1();
                           return false;
                       }
                   } else if (document.getElementById("nationality_spouse").value == "Foreigner") {
                       if (passport_sp === "") {
                           alert("Please fill Passport Number of the Spouse.");
                           setTimeout(function() {
                            document.getElementById("passport_spouse").focus();
                           }, 100);
                           goToStep1();
                           return false;
                       }
  
                   }
  
               }
  
  
  
           
               if (document.getElementById("status_clinic").value == "") {
                   alert("Please select the Type of Transferring Clinic");
                //    let error_mess = document.getElementById("error_message_status_clinic");
                //    error_mess.style.display = "block";
                   document.getElementById("status_clinic").focus();
                   return false;
               }
  
               if (document.getElementById("status_from_clinic").value == "") {
                   alert("Status of Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_status_from_clinic");
                //    error_mess.style.display = "block";
                   document.getElementById("status_from_clinic").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Registered") && (document.getElementById(
                           "from_name_clinic")
                       .value ==
                       "")) {
                   alert("Name of the Transferring Clinic cannot be blank111");
                //    let error_mess = document.getElementById("error_message_from_name_clinic");
                //    error_mess.style.display = "block";
                   document.getElementById("from_name_clinic").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                       "from_name_clinic11").value == "")) {
                   alert("Name of the Transferring Clinic cannot be blank222");
                   //alert('Hello');
                //    let error_mess = document.getElementById("error_message_from_name_clinic11");
                //    error_mess.style.display = "block";
                   document.getElementById("from_name_clinic11").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "from_address")
                       .value ==
                       "")) {
                   alert("Address of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_from_address");
                //    error_mess.style.display = "block";
                   document.getElementById("from_address").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "from_address")
                       .value ==
                       "")) {
                   alert("Address of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_from_address");
                //    error_mess.style.display = "block";
                   document.getElementById("from_address").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "f_pincode")
                       .value ==
                       "")) {
                   alert("Pincode of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_f_pincode");
                //    error_mess.style.display = "block";
                   document.getElementById("f_pincode").focus();
                   return false;
               }
  
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "f_state")
                       .value ==
                       "")) {
                   alert("State of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_f_state");
                //    error_mess.style.display = "block";
                   document.getElementById("f_state").focus();
                   return false;
               }
  
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "f_district")
                       .value ==
                       "")) {
                   alert("District of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_f_district");
                //    error_mess.style.display = "block";
                   document.getElementById("f_district").focus();
                   return false;
               }
  
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "f_contact")
                       .value ==
                       "")) {
                   alert("Contact Number of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_f_contact");
                //    error_mess.style.display = "block";
                   document.getElementById("f_contact").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Not Registered") && (document.getElementById(
                           "f_email")
                       .value ==
                       "")) {
                   alert("Email of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_f_email");
                //    error_mess.style.display = "block";
                   document.getElementById("f_email").focus();
                   return false;
               }
               if ((document.getElementById("status_from_clinic").value == "Applied for") && (document.getElementById(
                           "from_name_clinic1")
                       .value ==
                       "")) {
                   alert("Name of the Transferring Clinic cannot be blank");
                //    let error_mess = document.getElementById("error_message_from_name_clinic1");
                //    error_mess.style.display = "block";
                   document.getElementById("from_name_clinic1").focus();
                   return false;
               }

               if (document.getElementById("from_doctor").value == ""){
                   alert("Name of the Doctor cannot be blank");
                  // setTimeout(function() {
                      document.getElementById("from_doctor").focus();
                   // }, 100);
                   //goToStep1();
                   return false;
                   }
              
               if (document.getElementById("transfer").value == "Outside India") {
  
                   const toClinicSelect = document.getElementById('to_status_clinic').value;
                   const toStatusSelect = document.getElementById('to_status_from_clinic').value;
                   const toNameClinic = document.getElementById('to_name_clinic').value;
  
                   if (document.getElementById("to_status_clinic").value == "") {
                       alert("Please select the type of Receiving Clinic");
                    //    let error_mess = document.getElementById("error_message_to_status_clinic");
                    //    error_mess.style.display = "block";
                    
                       document.getElementById("to_status_clinic").focus();
                       return false;
                   }
  
  
                   if (document.getElementById("country").value == "") {
                       alert("Please select country Name");
                    //    let error_mess = document.getElementById("error_message_to_status_from_clinic");
                    //    error_mess.style.display = "block";
                       document.getElementById("country").focus();
                       return false;
                   }

                   if ((document.getElementById("to_name_clinic11").value == "")) {
                       //alert('sfsdf');
                       alert("Name of the Clinic cannot be blank");
                    //    let error_mess = document.getElementById("error_message_to_name_clinic11");
                    //    error_mess.style.display = "block";
                       document.getElementById("to_name_clinic11").focus();
                       return false;
                   }

                if (document.getElementById("to_doctor").value == ""){
                        alert("Name of the Doctor cannot be blank");
                        // setTimeout(function() {
                            document.getElementById("to_doctor").focus();
                        // }, 100);
                        //goToStep1();
                        return false;
                   }

                   if ((document.getElementById("to_address").value == "")) {
                       //alert('sfsdf');
                       alert("Address cannot be blank");
                    //    let error_mess = document.getElementById("error_message_to_name_clinic11");
                    //    error_mess.style.display = "block";
                       document.getElementById("to_address").focus();
                       return false;
                   }

                   if ((document.getElementById("t_contact").value == "")) {
                       //alert('sfsdf');
                       alert("Contact number cannot be blank");
                    //    let error_mess = document.getElementById("error_message_to_name_clinic11");
                    //    error_mess.style.display = "block";
                       document.getElementById("t_contact").focus();
                       return false;
                   }

                   if ((document.getElementById("t_email").value == "")) {
                       //alert('sfsdf');
                       alert("Email cannot be blank");
                    //    let error_mess = document.getElementById("error_message_to_name_clinic11");
                    //    error_mess.style.display = "block";
                       document.getElementById("t_email").focus();
                       return false;
                   }
                 
  
               }
  
               var embryosChecked1 = document.getElementById('embryosCheckBox').checked;
  
               if ((document.getElementById("transfer").value == "Outside India") && embryosChecked1) {
                   var affidavitUpload = document.getElementById('affidavit_embryos_outside').value;
                   var affidavit_clinic_holding_embryos = document.getElementById('affidavit_clinic_holding_embryos').value;
                   var affidavit_clinic_receiving_embryos = document.getElementById('affidavit_clinic_receiving_embryos')
                       .value;
  
                   if (affidavitUpload === "") {
                       alert("Please upload Form 17 (Affidavit for transfer of embryos outside India).");
                    //    let error_mess = document.getElementById("error_message_outside_embroys_1");
                    //    error_mess.style.display = "block";
                       document.getElementById("affidavit_embryos_outside").focus();
                       return false;
                   }
  
                   if (affidavit_clinic_holding_embryos === "") {
                       alert("Please upload Form 21 (Affidavit from the clinic holding the frozen embryos).");
                    //    let error_mess = document.getElementById("error_message_outside_embroys_2");
                    //    error_mess.style.display = "block";
                       document.getElementById("affidavit_clinic_holding_embryos").focus();
                       return false;
                   }
  
                   if (affidavit_clinic_receiving_embryos === "") {
                       alert("Please upload Form 23 (Affidavit from clinic receiving the frozen embryos).");
                    //    let error_mess = document.getElementById("error_message_outside_embroys_3");
                    //    error_mess.style.display = "block";
                       document.getElementById("affidavit_clinic_receiving_embryos").focus();
                       return false;
                   }
  
               }
  
               if ((document.getElementById("transfer").value == "Outside India") && (spermsChecked || oocytesChecked)) {
  
                   var affidavit_gametes_outside = document.getElementById('affidavit_gametes_outside').value;
                   var affidavit_clinic_holding_gametes = document.getElementById('affidavit_clinic_holding_gametes').value;
                   var affidavit_clinic_receiving_gametes = document.getElementById('affidavit_clinic_receiving_gametes')
                       .value;
  
  
                   if (affidavit_gametes_outside === "") {
                       alert("Please upload Form 18 [Affidavit for transfer of gametes (sperm/oocytes) outside India].");
                    //    let error_mess = document.getElementById("error_message_affidavit_gametes_outside");
                    //    error_mess.style.display = "block";
                       document.getElementById("affidavit_gametes_outside").focus();
                       return false;
                   }
  
                   if (affidavit_clinic_holding_gametes === "") {
                       alert("Please upload Form 22 Affidavit from the clinic holding  gametes.");
                    //    let error_mess = document.getElementById("error_message_affidavit_clinic_holding_gametes");
                    //    error_mess.style.display = "block";
                       document.getElementById("affidavit_clinic_holding_gametes").focus();
                       return false;
                   }
  
                   if (affidavit_clinic_receiving_gametes === "") {
                       alert("Please upload Form 24 (Affidavit from clinic receiving the frozen gametes).");
                    //    let error_mess = document.getElementById("error_message_affidavit_clinic_receiving_gametes");
                    //    error_mess.style.display = "block";
                       document.getElementById("affidavit_clinic_receiving_gametes").focus();
                       return false;
                   }
  
  
               }
  
  
  
               // Get the affidavit file input
               var affidavitGametesWithside = document.getElementById("affidavit_gametes_within");
  
               // Check if the transfer is outside India and either Sperms or Oocytes is selected
               if ((document.getElementById("transfer").value == "Within India") && (spermsChecked || oocytesChecked)) {
                   // If the affidavit file is not selected, show an alert and return false to prevent form submission
                   if (affidavitGametesWithside.value === "") {
                       alert("Form 19: Affidavit for the transfer of gametes Within India is mandatory");
                       document.getElementById("affidavit_gametes_within").focus();
                       return false;
                   }
               }
  
               // Get the file input element
               const affidavitInput = document.getElementById("affidavit_clinic_holding_embryos");
  
               // Check if "Embryos" is checked
               if (embryosCheckBox.checked) {
                   // Check if the file input is empty
                   if (affidavitInput.files.length === 0) {
                       alert("Form: 21 (Affidavit from the clinic holding the frozen embryos) is mandatory for transfer of embryos");
                         document.getElementById("affidavit_clinic_holding_embryos").focus();
                       return false; // Prevent form submission
                   }
               }
               // Get the file input
               const affidavitFile1 = document.getElementById("affidavit_clinic_holding_gametes").value;
  
               // Check if either Sperms or Oocytes is selected and if the affidavit file is provided
               if ((spermsChecked || oocytesChecked) && !affidavitFile1) {
                   alert("Form: 22 (Affidavit from clinic holding gametes (Sperms /oocytes) is mandatory for transfer of sperms/oocytes");
                   document.getElementById("affidavit_clinic_holding_gametes").focus();
                   return false; // Prevent form submission
               }
               // Get the affidavit file input
               const affidavitInput1 = document.getElementById('affidavit_clinic_receiving_embryos');
               const affidavitInput19 = document.getElementById('affidavit_embryos_within');
  
  
                if (embryosCheckBox.checked && document.getElementById("transfer").value != "Outside India") {
                   // Check if a file has been uploaded
                   if (!affidavitInput19.value) {
                       alert('Please Upload Form: 19 (Affidavit for transfer of embryos within India)');
                       document.getElementById("affidavit_embryos_within").focus();
                       return false; // Prevent form submission
                   }
               }
  
               // Check if the Embryos checkbox is checked
               if (embryosCheckBox.checked) {
                   // Check if a file has been uploaded
                   if (!affidavitInput1.value) {
                       alert('Please upload the Affidavit from the clinic receiving the frozen embryos');
                       document.getElementById("affidavit_clinic_receiving_embryos").focus();
                       return false; // Prevent form submission
                   }
               }
               // Get file input value
               const affidavitInput2 = document.getElementById("affidavit_clinic_receiving_gametes").value;
  
               // Check if either sperms or oocytes is checked and the affidavit file is not uploaded
               if ((spermsChecked || oocytesChecked) && !affidavitInput2) {
                   alert(" Form: 24 (Affidavit from clinic receiving the frozen gametes) is mandatory for transfer of sperms/oocytes)");
                   document.getElementById("affidavit_clinic_receiving_gametes").focus();
                   return false; // Prevent form submission
               }
  
  
  
  
               if (document.getElementById("identity_proof_applicant").value == "") {
                   alert("Please Select Copy of Identity Proof of the Applicant");
                //    let error_mess = document.getElementById("error_message_identity_proof_applicant_dropdown");
                   document.getElementById("identity_proof_applicant").focus();
                   return false;
               }
  
                  if (document.getElementById("identity_proof_applicant_file").value == "") {
                   alert("Please upload Copy of Identity Proof of the Applicant");
                   //error_mess.style.display = "block";
                   document.getElementById("identity_proof_applicant_file").focus();
                   return false;
               }
  
  
  
               if (document.getElementById("identity_proof_applicant_spouse").value == "" && document.getElementById("m_status").value == "Married") {
                   alert("Please upload Copy of Identity Proof of the Spouse");
                //    let error_mess = document.getElementById("error_message_identity_proof_applicant_dropdown");
                  // error_mess.style.display = "block";
                   document.getElementById("identity_proof_applicant_spouse").focus();
                   return false;
               }
  
                  if (document.getElementById("identity_proof_spouse_file").value == "" && document.getElementById("m_status").value == "Married" ) {
                   alert("Please upload Copy of Identity Proof of the Spouse");
                //    let error_mess = document.getElementById("error_message_identity_proof_applicant_file");
                   //error_mess.style.display = "block";
                   document.getElementById("identity_proof_spouse_file").focus();
                   return false;
               }
               
            if(document.getElementById("transfer").value == "Outside India"){
  
                   if (document.getElementById("copy_passport").value == "") {
                       alert("Copy of Passport of Applicant cannot be blank");
                       document.getElementById("copy_passport").focus();
                       return false;
                   }

                   if (document.getElementById("copy_passport_spouse").value == "" && document.getElementById("m_status").value == 'Married') {
                       alert("Copy of Passport of Spouse cannot be blank");
                       document.getElementById("copy_passport_spouse").focus();
                       return false;
                   }
                   
               }
  
                 if (document.getElementById("dob_proof_ap").value == "") {
                   alert("Please Select Date of Birth proof of the Applicant");
                //    let error_mess = document.getElementById("error_message_dob_proof_ap");
                  // error_mess.style.display = "block";
                   document.getElementById("dob_proof_ap").focus();
                   return false;
               }

            
  
               if (document.getElementById("dob_proof_applicant").value == "") {
                   alert("Please upload Date of Birth proof for the Applicant");
                   let error_mess = document.getElementById("  ");
                 //  error_mess.style.display = "block";
                   document.getElementById("dob_proof_applicant").focus();
                   return false;
               }
  
  
               if (document.getElementById("dob_proof_sp").value == "" && document.getElementById("m_status").value == "Married") {
                   alert("Please upload Date of Birth proof of the Spouse");
                //    let error_mess = document.getElementById("error_message_dob_proof_sp");
                  // error_mess.style.display = "block";
                   document.getElementById("dob_proof_sp").focus();
                   return false;
               }
  
  
  
               if (document.getElementById("dob_proof_spouse").value == "" && document.getElementById("m_status").value == "Married") {
                   alert("Please upload Date of Birth proof of the Spouse");
                //    let error_mess = document.getElementById("error_message_dob_proof_spouse");
                  // error_mess.style.display = "block";
                   document.getElementById("dob_proof_spouse").focus();
                   return false;
               }
  
        
  
               if ((document.getElementById("purpose_of_transfer").value == "Surrogacy") && (document.getElementById("transfer").value == "Within India") && (document.getElementById("oci_applicant_file").value=="") && (document.getElementById("nationality_applicant").value == 'Foreigner')) {
                   alert("OCI Card Number of the Applicant cannot be blank");
                //    let error_mess = document.getElementById("error_message_oci_file_applicant");
                   //error_mess.style.display = "block";
                   document.getElementById("oci_applicant_file").focus();
                   return false;
               }
  
  
                if ((document.getElementById("purpose_of_transfer").value == "Surrogacy") && (document.getElementById("transfer").value == "Within India") && document.getElementById("m_status").value == "Married" && document.getElementById("nationality_spouse").value == 'Foreigner' && (document.getElementById("oci_spouse_file").value=="")) {
                   alert("OCI Card Number of the spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_oci_file_spouse");
                   error_mess.style.display = "block";
                   document.getElementById("oci_spouse_file").focus();
                   return false;
               }
  
  
  
       
               
               const dobProofType = document.getElementById('dob_proof_sp').value;
               const dobProofFile = document.getElementById('dob_proof_spouse').value;
  
               // Check if the user has selected a proof type and uploaded a file
               if (document.getElementById("m_status").value == "Married"){
                       if (dobProofType === "") {
                           alert("Please upload Date of Birth Proof of the spouse");
                        //    let error_mess = document.getElementById("error_message_dob_proof_sp");
                           error_mess.style.display = "block";
                           document.getElementById("dob_proof_sp").focus();
                           return false;
                       }
  
                       if (dobProofFile === "") {
                           alert("Please upload Date of Birth Proof of the spouse");
                        //    let error_mess = document.getElementById("error_message_dob_proof_spouse");
                           error_mess.style.display = "block";
                           document.getElementById("dob_proof_spouse").focus();
                           return false;
                       }
                }
  
  
               if ((document.getElementById("m_status").value == "Married") && (document.getElementById("dob_proof_ap")
                       .value == "")) {
                   alert("Date of birth proof of the Spouse cannot be blank");
                //    let error_mess = document.getElementById("error_message_dob_proof_ap");
                  // error_mess.style.display = "block";
                   document.getElementById("dob_proof_ap").focus();
                   return false;
               }
  
              
  
  
               if (document.getElementById("sign_applicant").value == "") {
                   //alert('hello');
                   alert("Upload signed declaration of the Applicant and the Spouse (if applicable)");
                //    let error_mess = document.getElementById("error_message_sign_applicant");
                //   error_mess.style.display = "block";
                   document.getElementById("sign_applicant").focus();
                   return false;
               }
  
                if (!document.getElementById("declaration").checked) {
                   alert("Declaration cannot be blank");
                //    let error_mess = document.getElementById("error_message_declaration");
                   //error_mess.style.display = "block";
                   document.getElementById("declaration").focus();
                   return false;
               }

               //function submitFormWithConfirmation() {

               if(document.getElementById("declaration").checked){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Kindly check and confirm all details before final submission.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, submit it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-wizard').submit();
                        }
                    });
                }                
       
    }
    
</script>
@endsection

  