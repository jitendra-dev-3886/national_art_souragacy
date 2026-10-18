@extends('layouts.noc.noc_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .alert-success {
            width: 50%;
            position: absolute;
            z-index: 11;

            height: auto;
            box-shadow: 2px 3px 10px 0px rgba(0, 0, 0, 0.353);
        }
        .bc-border-color-thirtyfour{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white;
         }
         .bc-color-thirty-five{
            background-color:#1460c4;
         }
         .margin-top-thirty-six{
          margin-top:4px;  
         }
    </style>
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible text-white border-0 fade show bc-color-thirty-five" role="alert">
                <button type="button" class="btn-close btn-close-red" data-bs-dismiss="alert" aria-label="Close"></button>
                <p class="font-30 py-2"><strong>{{ session('success') }}</strong> </p>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h3>Update Your Profile</h3>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form class="form-valide-with-icon needs-validation" novalidate=""
                        action="{{ route('noc.profile.update.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Name of the
                                    Applicant</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                <input type="text" name="name_applicant"
                                    value="{{ old('name_applicant', $applicantProfile->name_applicant ?? '') }}"
                                    class="form-control @error('name_applicant') is-invalid @enderror"
                                    required {{ !empty($applicantProfile->name_applicant) ? 'readonly' : '' }}>

                            </div>
                            @error('name_applicant') <!-- Display error for name_applicant -->
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                         <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Gender</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-user"></i></span>&nbsp;&nbsp;&nbsp;
                                 <label for="disableInput"
                                    
                                 class="margin-top-thirty-six">&nbsp;Man</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="gender" name="gender" value="Man" 
                                    {{ old('gender', $applicantProfile->gender ?? '') === 'Man' ? "checked" : '' }}
                                    {{-- {{ !empty($applicantProfile->gender) ? 'disabled' : '' }} --}}
                                    >
                                    {{-- @if (!empty($applicantProfile->gender))
                                    <input type="hidden" name="gender" value="{{ $applicantProfile->gender }}">
                                    @endif --}}
                                    <label for="disableInput"
                                    
                                    class="margin-top-thirty-six">&nbsp;&nbsp;&nbsp;&nbsp;Woman</label>&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="gender" name="gender" value="Woman" 
                                    {{ old('gender', $applicantProfile->gender ?? '') === 'Woman' ? "checked" : '' }}  
                                    {{-- {{ !empty($applicantProfile->gender) ? 'disabled' : '' }}  --}}
                                    >

                            </div>
                            @error('gender') 
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomCountry"><strong>Nationality</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-address-card"></i></span>
                                <select name="nationality_type" id="nationality_type" class="form-control  @error('nationality_type') is-invalid @enderror">
                                    <option value="">Select Nationality</option>
                                    <option value="Indian"
                                        {{ old('nationality_type', $applicantProfile->nationality_type ?? '') == 'Indian' ? 'selected' : '' }}>
                                        Indian
                                    </option>
                                    <option value="Foreigner"
                                        {{ old('nationality_type', $applicantProfile->nationality_type ?? '') == 'Foreigner' ? 'selected' : '' }}>
                                        Foreigner
                                    </option>
                                </select>
                                
                            </div>
                            @error('nationality_type') <!-- Display error for name_applicant -->
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                          <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Address</strong></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                            <input type="text" name="address" id="address" class="form-control"
                                value="{{ old('address', $applicantProfile->address ?? '') }}">
                        </div>
                        @error('address') <!-- Display error for address -->
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row" id="hideval">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="text-label form-label" for="validationCustomUsername"><strong>Country</strong></label>
								<div class="input-group">
									<span class="input-group-text"> <i class="fa fa-marker"></i> </span>
									<select name="country" id="country" class="form-control">
                                    <option value="">Select a country</option>
                                    @foreach(App\Models\Noc\countrytable::all() as $country)
                                        <option value="{{ $country->country_name }}" {{ old('country', $applicantProfile->country ?? '') == $country->country_name ? 'selected' : '' }}>{{ $country->country_name }}</option>
                                    @endforeach
                                    </select>
                                    @error('country') <!-- Display error for pincode -->
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
								</div>
							</div>
						</div>
					
						<div class="col-md-6">
							<div class="mb-3">
								<label class="text-label form-label" for="validationCustomUsername"><strong>Zipcode</strong></label>
								<div class="input-group">
									<span class="input-group-text"> <i class="fa fa-map"></i> </span>
									<input type="text" pattern="^[A-Za-z0-9\s\-]{1,15}$" name="zipcode" id="zipcode" value="{{ old('zipcode', $applicantProfile->zipcode ?? '') }}" oninput="validzipcode(event)" placeholder="zipcode" class="form-control" title="Zipcode can contain only letters, numbers, spaces, or hyphens.">
								</div>
								@error('zipcode') <!-- Display error for pincode -->
								<div class="text-danger">{{ $message }}</div>
							@enderror
							</div>
						</div>
					</div>

                    <div class="row" id="hidevalue2">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-label form-label"
                                    for="validationCustomUsername"><strong>Pincode</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-marker"></i> </span>
                                    <input type="text" pattern="^[0-9]{6}$" name="pincode"
                                        value="{{ old('pincode', $applicantProfile->pincode ?? '') }}"
                                        placeholder="Pincode should be six numbers" maxlength="6" id="pincode"
                                        class="form-control">
                                </div>
								<span id="pincodeavailability"></span>
                                @error('pincode') <!-- Display error for pincode -->
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-label form-label"
                                    for="validationCustomUsername"><strong>State</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-map"></i> </span>
                                    <input type="text" name="state" id="state" placeholder="State"
                                        value="{{ old('state', $applicantProfile->state ?? '') }}"
                                        class="form-control" readonly>

                                </div>
                                @error('state') <!-- Display error for state -->
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-label form-label" for="email"><strong>District</strong></label>
                            <div class="input-group" id="district-container">
                                <input type="text" name="district" id="district" placeholder="District" value="{{ old('state', $applicantProfile->district ?? '') }}" class="form-control" readonly />
                            </div>                                                       
                               @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn me-2 bc-border-color-thirtyfour">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>



<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        var typecountry = document.getElementById("nationality_type").value;
		if(typecountry == 'Foreigner'){
			
			$('#hideval').show(); 
			$('#hidevalue2').hide();
		}else{
			
				$('#hideval').hide();
				$('#hidevalue2').show();
			
		}

        $('#nationality_type').change(function() {
            document.getElementById("pincode").value = "";
                document.getElementById("state").value = "";
                document.getElementById("district").value = "";

                document.getElementById("country").value = "";
                document.getElementById("zipcode").value = "";
                document.getElementById("address").value = "";
            let country = document.getElementById("nationality_type").value;
            if (country == 'Foreigner') {
				$('#hideval').show(); 
				$('#hidevalue2').hide();
				// document.getElementById("pincode").value = "";
				// document.getElementById("state").value = "";
				// document.getElementById("district").value = "";

				// document.getElementById("country").value = "";
				// document.getElementById("zipcode").value = "";
				// document.getElementById("address").value = "";
            }else{
				$('#hideval').hide();
				$('#hidevalue2').show();
			} 	
        });
    });
    $('#pincode').blur(function () {
                        var pincode = $(this).val();
                        if (pincode === "") {
                            $('#state').val('');
                            $('#district-container').html('<input type="text" name="district" value="" id="district" placeholder="Select District" class="form-control" readonly />');
                            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                        } else {
                            $.ajax({
    url: "{{ route('pincode.signup') }}",
    method: "POST",
    data: {
        pincode: pincode,
        _token: "{{ csrf_token() }}"
    },
    success: function (data) {
                        $('#pincodeavailability').html('');
                        $('#state').val('');

                        if (data.success) {
                            $('#state').val(data.state);

                            if (data.districts.length > 1) {
                                // Multiple districts - show dropdown
                                let districtDropdown = '<select name="district" id="district" class="form-control">';
                                // districtDropdown += '<option value="">Select District</option>';
                                data.districts.forEach(function (district) {
                                    districtDropdown += `<option value="${district}">${district}</option>`;
                                });
                                districtDropdown += '</select>';
                                $('#district-container').html(districtDropdown);

                                } else if (data.districts.length === 1) {
                                    // Only one district - show readonly input
                                    $('#district-container').html(`
                                        <input type="text" name="district" id="district" value="${data.districts[0]}" class="form-control" readonly />
                                    `);
                                } else {
                                    // No districts found
                                    $('#district-container').html(`
                                        <input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />
                                    `);
                                    $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                }

                            } else {
                                // Invalid pincode response from server
                                $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                $('#state').val('');
                                $('#district-container').html(`
                                    <input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />
                                `);
                            }
                        },
                            error: function (xhr, status, error) {
                                console.error('AJAX Error:', error);
                                console.log('Response Text:', xhr.responseText);
                                $('#pincodeavailability').html('<span class="text-danger">Something went wrong. Please try again.</span>');
                            }
                            });

                        }
                    });
                
    function validzipcode(event) {
    const inputField = event.target;
    inputField.value = inputField.value.replace(/[^A-Za-z0-9\s\-]/g, '');
    if (inputField.value.length > 15) {
        inputField.value = inputField.value.substring(0, 15);
    }
}

</script>
@endsection	
