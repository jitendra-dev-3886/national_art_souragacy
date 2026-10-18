
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

function validateAadhar(input) {
    // Allow only numeric input
    input.value = input.value.replace(/\D/g, '');

    // Ensure the input is not more than 4 digits
    if (input.value.length > 4) {
        input.value = input.value.slice(0, 4);
    }
}

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

document.addEventListener("DOMContentLoaded", function() {
    // Get references to both dropdowns
    const statusClinic = document.getElementById('status_clinic');
    const statusFromClinic = document.getElementById('status_from_clinic');

    // Debugging: Ensure the elements are correctly referenced
    console.log('Clinic Dropdown:', statusClinic);
    console.log('Status Dropdown:', statusFromClinic);

    // Add an event listener to monitor changes on the status_clinic dropdown
    statusClinic.addEventListener('change', function() {

        console.log('Clinic selected:', statusClinic.value); // Debugging

        if (statusClinic.value !== '') {
            // Enable the status_from_clinic dropdown if a clinic is selected
            statusFromClinic.disabled = false;
            console.log('Status dropdown enabled'); // Debugging
        } else {
            // Disable the status_from_clinic dropdown if no clinic is selected
            statusFromClinic.disabled = true;
            console.log('Status dropdown disabled'); // Debugging
        }
    });
});

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

document.getElementById('multi-step-form').addEventListener('submit', function(event) {
    // Get values of the input fields
    const voterIDValue = voterIDInput.value.trim();
    const panIDValue = panIDInput.value.trim();
    //  const aadhaarIDValue = aadhaarIDInput.value.trim();
    const passportIDValue = passportIDInput.value.trim();

    // Validate Voter ID, PAN, Aadhaar, or Passport
    const isVoterIDValid = voterIDPattern.test(voterIDValue);
    const isPanIDValid = panIDPattern.test(panIDValue);
    //   const isAadhaarIDValid = aadhaarIDPattern.test(aadhaarIDValue);
    const isPassportIDValid = passportIDPattern.test(passportIDValue);

    // Check if at least one ID is valid
    if (isVoterIDValid || isPanIDValid || isPassportIDValid) {
        validationMessage.textContent = "At least one valid ID is provided!";
        validationMessage.className = "success";
    } else {
        validationMessage.textContent =
            "Please provide a valid Voter ID, PAN Card, Aadhaar Card, or Passport.";
        validationMessage.className = "error";
        event.preventDefault(); // Prevent form submission if no valid ID is found
    }
});

$('#m_status').on('change', function() {

    var errorMessage = document.getElementById("error_message_m_status");
    var m_status = document.getElementById("m_status");
    var nationality_applicant = document.getElementById("nationality_applicant").value;
    var transfer = document.getElementById("transfer").value;
    var purpose_of_transfer = document.getElementById("purpose_of_transfer").value;
    var genderval = document.getElementById("gender").value;

    if (m_status.value == 'Married') {
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

    } else {
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

    if (genderval == 'Woman' && nationality_applicant.value == 'Foreigner' && (m_status.value == 'Unmarried' || m_status.value == 'Widow' || m_status.value == 'Divorced')) {

        $(".hiddensperms").hide();
        const option = document.querySelector('#purpose_of_transfer option[value="Surrogacy"]');
        if (option) {
            option.hidden = true;
        }
    } else {
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
            surrogacyOption.hidden = true;
        }
        if (ivfOption) {
            ivfOption.hidden = true;
        }
    } else {
        // Show both options for other conditions
        const surrogacyOption = document.querySelector('#purpose_of_transfer option[value="Surrogacy"]');
        const ivfOption = document.querySelector('#purpose_of_transfer option[value="Invitro Fertilization"]');

        if (surrogacyOption) {
            surrogacyOption.hidden = false;
        }
        if (ivfOption) {
            ivfOption.hidden = false;
        }
    }

    hideshow_oci_spouse_field();
    hideshow_oci_spouse_hide_pdf();


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
    $('#purpose_of_transfer').val('');
    $('#transfer').val('');


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
        $("#copy_passport_spouse1").show();
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
                $(".hiddensur").hide();
            } else {
                $(".hiddensur").show();
            }
        } else if (this.value === 'Widow' && document.getElementById('nationality_applicant').value == 'Foreigner') {
            if (gen === 'Woman') {
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

$('#nationality_spouse').on('change', function() {
    alert('sdfsdfsfffffffffffffffffffffffff');
    var errorMessage = document.getElementById("error_message_nationality_spouse");
    var nationality_spouse = document.getElementById("nationality_spouse");
    var m_status = document.getElementById("m_status");
    var nationality_applicant = document.getElementById("nationality_applicant");

    if (nationality_spouse.value == "Foreigner" && m_status.value == 'Married') {


        //$('#address_class').removeClass('col-md-8').addClass('col-md-12');
        if (nationality_applicant.value == 'Indian') {

            $('#pincode_hide_val').css('display', 'block');
            $('#state_hide_val').css('display', 'block');
            $('#district_hide_val').css('display', 'block');
            // $('#zipcode_hide_val').hide();


        } else {

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



    } else if (nationality_spouse.value == "Indian" && m_status.value == 'Married' && nationality_applicant.value == 'Foreigner') {
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

$('#transfer').on('change', function() {
    if (this.value == 'Outside India') {
        // $("#passport_spouse1").show();

        passport_spouse
    } else {
        //  $("#passport_spouse1").hide();
    }
});

$('#transfer').on('change', function() {
    if (this.value == 'Outside India') {
        //  $("#passport_applicant1").show();
    } else {
        //  $("#passport_applicant1").hide();
    }
});

$('#transfer').on('change', function() {
    if (this.value == 'outside_india') {
        $("#copy_passport_spouse1").show();
    } else {
        $("#copy_passport_spouse1").hide();
    }
});

var refreshButton = document.querySelector(".refresh-captcha");
refreshButton.onclick = function() {
    document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
}

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

$('#oci_spouse').on('input', function() {
    var errorMessage = document.getElementById("error_message_oci_number_spouse");
    var oci_applicant = document.getElementById("oci_spouse");

    // Check if the input is not empty after trimming
    if (oci_spouse.value.trim().length > 0) {
        errorMessage.style.display = "none"; // Hide the error message
    } else {
        errorMessage.style.display = "block"; // Show the error message
    }
});


$('#oci_applicant_file').on('input', function() {
    var errorMessage = document.getElementById("error_message_oci_file_applicant");
    var oci_applicant_file = document.getElementById("oci_applicant_file");

    // Check if the input is not empty after trimming
    if (oci_applicant_file.value.trim().length > 0) {
        errorMessage.style.display = "none"; // Hide the error message
    } else {
        errorMessage.style.display = "block"; // Show the error message
    }
});

$('#oci_spouse_file').on('input', function() {
    var errorMessage = document.getElementById("error_message_oci_file_spouse");
    var oci_spouse_file = document.getElementById("oci_spouse_file");

    // Check if the input is not empty after trimming
    if (oci_spouse_file.value.trim().length > 0) {
        errorMessage.style.display = "none"; // Hide the error message
    } else {
        errorMessage.style.display = "block"; // Show the error message
    }
});

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

    if (status_clinic.value !== "") {
        errorMessage.style.display = "none";
    } else {
        errorMessage.style.display = "block";
    }
});

document.getElementById('status_from_clinic').addEventListener('change', function() {
    var errorMessage = document.getElementById("error_message_status_from_clinic");
    var status_from_clinic = document.getElementById("status_from_clinic");



    if (status_from_clinic.value !== "") {

        errorMessage.style.display = "none";
    } else {
        errorMessage.style.display = "block";
    }

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


$('#embryos_number').on('change', function() {
    var errorMessage = document.getElementById("error_message_embryos_number");
    var embryos_number = document.getElementById("embryos_number");

    if (embryos_number.value !== "") {
        errorMessage.style.display = "none";
    } else {
        errorMessage.style.display = "block";
    }
});

$('#sperm_vials').on('change', function() {
    alert('ssss');
    var errorMessage = document.getElementById("error_message_sperms_number");
    var sperm_vials = document.getElementById("sperm_vials");

    if (sperm_vials.value !== "") {
        errorMessage.style.display = "none";
    } else {
        errorMessage.style.display = "block";
    }
});

$('#oocytes_number').on('change', function() {
    var errorMessage = document.getElementById("error_message_oocytes_number");
    var oocytes_number = document.getElementById("oocytes_number");

    if (oocytes_number.value !== "") {
        errorMessage.style.display = "none";
    } else {
        errorMessage.style.display = "block";
    }

});

//to clinic validation//
document.getElementById('to_status_clinic').addEventListener('change', function() {
    var errorMessage = document.getElementById("error_message_to_status_clinic");
    var to_status_clinic = document.getElementById("to_status_clinic");
    var purpose_of_transfer = document.getElementById("purpose_of_transfer").value;


    if (to_status_clinic.value !== "") {
        errorMessage.style.display = "none";
    } else {
        errorMessage.style.display = "block";
    }
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
    identity_proof_applicant_spouse_empty.value = '';

    const identity_proof_spouse_file_empty = document.getElementById("identity_proof_spouse_file");
    identity_proof_spouse_file_empty.value = '';


    const dob_proof_sp_empty = document.getElementById("dob_proof_sp");
    dob_proof_sp_empty.value = '';

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
        $("#copy_passport_spouse1").show();
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

$('#transfer').on('change', function() {

    var errorMessage = document.getElementById("error_message_transfer");
    var transfer = document.getElementById("transfer");
    var purpose_of_transfer = document.getElementById("purpose_of_transfer");
    var nationality_oci = document.getElementById("nationality_applicant");
    var m_status = document.getElementById("m_status");
    const country = document.getElementById("country");
    country.value = '';
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

    if (transfer.value !== "") {
        if (transfer.value == "Within India" && purpose_of_transfer.value == 'Surrogacy' && nationality_oci.value == 'Foreigner' && nationality_spouse.value == 'Foreigner' && m_status.value == 'Married') {
            $('#oci_card_holder_app').show();
            $('#oci_card_holder_sp').show();

        } else if (transfer.value == "Within India" && purpose_of_transfer.value == 'Surrogacy' && nationality_oci.value == 'Foreigner' && nationality_spouse.value == 'Indian' && m_status.value == 'Married') {
            $('#oci_card_holder_app').show();
        } else {
            $('#oci_card_holder_app').hide();
            $('#oci_card_holder_sp').hide();
        }
    }

    hideshow_oci_spouse_field();
    hideshow_oci_spouse_hide_pdf();

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

    if (this.value == 'Outside India') {
        $("#passport_applicant1").show();
    } else {
        $("#passport_applicant1").hide();
    }
});


var _validFilepdf = [".pdf"];
const minSize = 10 * 1024;
const maxSizepdf = 250 * 1024;
const fileInputs = document.querySelectorAll('input[type="file"]');

fileInputs.forEach(fileInput => {
    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const fileName = file.name.toLowerCase();
        const isValidExtension = _validFilepdf.some(ext => fileName.endsWith(ext));

        if (!isValidExtension) {
            alert("Sorry, this file is invalid. Allowed extension:" + _validFilepdf.join(", "));
            event.target.value = "";
            return false;
        }

        fileSizeValidatepdf(file, minSize, maxSizepdf, event.target);
    });
});

function fileSizeValidatepdf(file, minSize, maxSize, fileInput) {
    const fileSize = file.size;
    if (fileSize < minSize) {
        alert("File is too small. Minimum size is " + (minSize / 1024) + " KB.");
        fileInput.value = "";
        return false;
    }

    if (fileSize > maxSize) {
        alert("File is too large. Maximum size is " + (maxSize / 1024) + " KB.");
        fileInput.value = "";
        return false;
    }

    alert("File is valid!");
    return true;
}


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

$(document).ready(function() {
    $('#to_status_clinic, #to_status_from_clinic').on('change', function() {
        var clinicType = $('#to_status_clinic').val();
        var statusType = $('#to_status_from_clinic').val();

        if (clinicType && statusType) {
            $.ajax({
                type: 'POST',
                url: "{{ route('noc.fetchClinicData ') }}",
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
                    console.log("AJAX Error: ", error);
                }
            });
        } else {
            $('.abc, .xyz').html('<option value="">Select</option>');
        }
    });

    $('#status_clinic, #status_from_clinic').on('change', function() {

        var clinicType = $('#status_clinic').val();
        var statusType = $('#status_from_clinic').val();
alert('dfsdf');
                    $('.select2-selection--single').hide();
        if (clinicType && statusType) {
            $.ajax({
                type: 'POST',
                url: "{{ route('noc.fetchClinicDataFrom ') }}",
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
                    console.log("AJAX Error: ", error);
                }
            });
        } else {
            $('.def, .ghi').html('<option value="">Select</option>');
        }
    });
});

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
                url: '{{ route('
                noc.fetchClinicDetails ') }}',
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
                url: '{{ route('
                noc.fetchClinicApplicationDetails ') }}',
                method: 'POST',
                data: {
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

$(document).ready(function() {
    $('#from_name_clinic').change(function() {


        var clinicType = $('#status_clinic').val();
        var statusType = $('#status_from_clinic').val();
        var from_name_clinic_fetch_reg = $('#from_name_clinic').val();

        //   console.log(statusType);
        //   console.log(from_name_clinic_fetch_reg);
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
                url: '{{ route('
                noc.fetchClinicDataFromm ') }}',
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
                    console.error('AJAX Error:', error);
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
                url: '{{ route('
                noc.nocClinicFetchAppFrom ') }}',
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
                    console.error('AJAX Error:', error);
                }
            });
        }
    });
});

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
            $('#dob_spouse_info').show();
            $('#passport_spouse1').show();
            $('#aadhar_spouse_info').show();
            $('#state_hide_val').show();
            $('#district_hide_val').show();
            $('#pincode_hide_val').show();
            $('#pan_spouse_info').show();
            $('#voter_spouse_info').show();
            // $('#country_applicant_display').hide();
            // $('#zipcode_hide_val').hide();

        }

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

        }



    } else {
        $('#zipcode_hide_val').show();
        $('#country_hide_val').show();

    }




}

if (nationality_applicant == 'Foreigner') {
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



} else {

    $('#country_hide_val').show();
    $('#zipcode_hide_val').show();
} 

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



function validateNumericInput_mask_aadhar(event) {
    const inputField = event.target;
    inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
}

function validateNumericInput_applicant_aadhar(event) {
    const inputField = event.target;
    inputField.value = inputField.value.replace(/[^0-9]/g, ''); // This will remove any non-numeric characters
}



function hideshow_oci_spouse_field() {
    // Get values of the four input elements
    const m_status = document.getElementById("m_status").value;
    const nationality_spouse = document.getElementById("nationality_spouse").value;
    const transfer = document.getElementById("transfer").value;
    const purpose_of_transfer = document.getElementById("purpose_of_transfer").value;

    // Check if all values match
    if (m_status == "Married" && nationality_spouse == "Foreigner" && transfer == "Within India" && purpose_of_transfer == "Surrogacy") {
        // If values match, show the new input tab
        document.getElementById("oci_card_holder_sp").style.display = "block";
    } else {
        // If values don't match, hide the new input tab
        $('#oci_spouse').val('');
        document.getElementById("oci_card_holder_sp").style.display = "none";
    }
}


function hideshow_oci_spouse_hide_pdf() {
    // Get values of the four input elements
    const m_status = document.getElementById("m_status").value;
    const nationality_spouse = document.getElementById("nationality_spouse").value;
    const transfer = document.getElementById("transfer").value;
    const purpose_of_transfer = document.getElementById("purpose_of_transfer").value;

    // Check if all values match
    if (m_status == "Married" && nationality_spouse == "Foreigner" && transfer == "Within India" && purpose_of_transfer == "Surrogacy") {
        // If values match, show the new input tab
        document.getElementById("oci_spouse_hide_pdf").style.display = "block";
    } else {
        // If values don't match, hide the new input tab
        const oci_spoue_file = document.getElementById("oci_spoue_file");
        oci_spoue_file.value = '';

        document.getElementById("oci_spouse_hide_pdf").style.display = "none";
    }
}


function showAlert() {
    var inputValue = document.getElementById('dob_applicant').value;
    var purpose_of_transfer = document.getElementById('purpose_of_transfer').value;
    if (inputValue != "" && purpose_of_transfer == "") {
        alert("Please Select Purpose of Transfer at least choose Surrogacy");
        $('#dob_applicant').val('');
        return false;
    }
}


function showAlert_sp() {
    var inputValue_sp = document.getElementById('dob_spouse').value;
    var purpose_of_transfer = document.getElementById('purpose_of_transfer').value;
    if (inputValue_sp != "" && purpose_of_transfer == "") {
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
                } else {
                    alert('Please Insert valid pincode');
                    $('#f_state').val('');
                    $('#f_district').val('');
                    document.getElementById("f_pincode").focus();
                }
            }
        });
    }
});

$('#purpose_of_transfer').on('change', function() {
    var purpose_of_transfer = document.getElementById("purpose_of_transfer").value;
    var transfer = document.getElementById("transfer").value;
    var nationality_applicant = document.getElementById("nationality_applicant").value;
    var gender = document.getElementById("gender").value;
    var m_status = document.getElementById("m_status").value;
    document.getElementById('to_status_clinic').selectedIndex = 0;

    var errorMessage = document.getElementById("error_message_purpose_of_transfer");
    let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
    if (surrogacyOption) {
        surrogacyOption.hidden = false;
    }

    artOption = document.querySelector('#to_status_clinic option[value="ART"]');
    if (artOption) {
        artOption.hidden = false;
    }

    if (transfer == 'Outside India') {

        artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = false;
        }

    } else if (purpose_of_transfer == 'Future Cryopreservation' && m_status == 'Married' && (gender == 'Man' || gender == 'Woman')) {
        let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
        if (surrogacyOption) {
            surrogacyOption.hidden = false;
        }

        artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = false;
        }


    } else if (purpose_of_transfer == 'Surrogacy' && m_status == 'Married' && (gender == 'Man' || gender == 'Woman')) {
        let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
        if (surrogacyOption) {
            surrogacyOption.hidden = false;
        }

        artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = true;
        }


    } else if (purpose_of_transfer == 'Invitro Fertilization' && m_status == 'Married' && (gender == 'Man' || gender == 'Woman')) {
        let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
        if (surrogacyOption) {
            surrogacyOption.hidden = false;
        }

        artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = false;
        }


    } else if (purpose_of_transfer == 'Invitro Fertilization' && gender == 'Woman' && m_status == 'Unmarried') {

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

    } else if (purpose_of_transfer == 'Future Cryopreservation' && gender == 'Woman' && m_status == 'Unmarried') {
        let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
        if (surrogacyOption) {
            surrogacyOption.hidden = false;
        }

        artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = false;
        }

        $('.hiddensperms').hide();

    } else if (purpose_of_transfer == 'Future Cryopreservation' && nationality_applicant == 'Foreigner' && gender == 'Woman' && m_status == 'Widow') {
        $('.hiddensperms').hide();

    } else if (purpose_of_transfer == 'Invitro Fertilization' && nationality_applicant == 'Foreigner' && gender == 'Woman' && m_status == 'Widow') {
        $('.hiddensperms').hide();

    } else if (purpose_of_transfer == 'Future Cryopreservation' && gender == 'Man' && m_status == 'Married') {
        let surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
        if (surrogacyOption) {
            surrogacyOption.hidden = false;
        }

        artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = false;
        }


    } else if (purpose_of_transfer == 'Future Cryopreservation' && gender == 'Man') {

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
    } else if (purpose_of_transfer == 'Surrogacy') {
        const artOption = document.querySelector('#to_status_clinic option[value="ART"]');
        if (artOption) {
            artOption.hidden = true;
        }
    } else if (purpose_of_transfer == 'Invitro Fertilization') {

        const surrogacyOption = document.querySelector('#to_status_clinic option[value="Surrogacy"]');
        if (surrogacyOption) {
            surrogacyOption.hidden = true;
        }

    } else {

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

    if (purpose_of_transfer !== "") {

        errorMessage.style.display = "none";
        if (purpose_of_transfer == "Surrogacy") {

            if (transfer == '') {
                alert('Please select transfer within/outside India');
                $('#oci_applicant').val('');
                const oci_applicant_file = document.getElementById("oci_applicant_file");
                oci_applicant_file.value = '';
                $('#oci_card_holder_app').hide();
                $('#oci_applicant_hide').hide();

            } else if (transfer == 'Within India' && nationality_applicant == 'Foreigner' && m_status == 'Married') {
                $('#oci_card_holder_app').show();
                $('#oci_applicant_hide').show();

            } else if (transfer == 'Within India' && nationality_applicant == 'Foreigner') {
                $('#oci_card_holder_app').show();
                $('#oci_applicant_hide').show();


            } else {
                $('#oci_applicant').val('');
                const oci_applicant_file = document.getElementById("oci_applicant_file");
                oci_applicant_file.value = '';
                $('#oci_card_holder_app').hide();
                $('#oci_applicant_hide').hide();

            }

        } else {
            $('#oci_applicant').val('');
            const oci_applicant_file = document.getElementById("oci_applicant_file");
            oci_applicant_file.value = '';
            $('#oci_card_holder_app').hide();
            $('#oci_applicant_hide').hide();

        }

    } else {
        $('#oci_card_holder_app').hide();
        $('#oci_applicant_hide').hide();
        errorMessage.style.display = "block";
    }

}); 