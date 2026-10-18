//on load page validation 
$(document).ready(function () {
 let radioButton = $("input[name='art_case_of']:checked").val();
 let husbandCountry = $('#art_nationality').val();
 let wifeCountry = $('#art_nationality_wife').val();
 let singleWomanCountry = $('#art_nationality_wife1').val();
 let artProcUndertaken  = $('#art_proc_undertaken').val();
 let artTypesOfTreat =$('#art_types_of_treat').val();

    let art_total_num = $("#art_total_num_of_cyc").val();
    
    let no_cycles = $("#art_no_cycles").data('sval');


 if(radioButton === 'one'){
    $("#art_nationality_husband").show();
    $("#art_nationality_woman_lable strong").text("Nationality of Wife");
    $("#art_nationality_wife1").show();
    $(".art-selectt").show();
    $("#art_single").hide();
    $("#art_male_factor_div").show()

    if(husbandCountry === 'Foreigner'){
        $('#art_other_nationality1').show();
    }else{
        $('#art_other_nationality1').hide();
    }

    if(wifeCountry === 'Foreigner'){
        $('#art_other_nationality1_wife').show();
    }else{
        $('#art_other_nationality1_wife').hide();
    }

 }else if(radioButton === "two"){
    $("#art_nationality_husband").hide();
    $("#art_nationality_woman_lable strong").text("Nationality");
    $("#art_nationality_wife1").show();
    $(".art-selectt").hide();
    $("#art_single").show();
    $("#art_other_nationality1").hide();
    $("#art_other_nationality_wife").show();
    $("#art_male_factor_div").hide();

    if(singleWomanCountry === 'Foreigner'){
        $('#art_other_nationality1_wife').show();
    }else{
        $('#art_other_nationality1_wife').hide();
    }
 }

         if (artProcUndertaken === "Others") {
            $("#art_others_id").show();
        } else {
            $("#art_others_id").hide();
            
        }

        if (
            artProcUndertaken === "intra-uterine insemination(IUI)" ||
            artProcUndertaken === "artificial insemination"
        ) {
            if ($("#art_ivf_donor").is(":visible")) {
                $("#art_ivf_donor option").hide();
                $("#art_ivf_donor option[value='Sperm Donation']").show().prop("selected", true);
                $("#art_declaration_hide").hide();
                $("#art_declaration").prop("checked", false);
            }
        } else {
            // $("#art_ivf_donor option").show();
            // $("#art_ivf_donor option").prop("selected", false);
            $("#art_declaration_hide").show();
        }
       

        if (artTypesOfTreat === "ART Treatment using self gametes") {
            $("#art_ivf_donor").hide();
            $("#art_declaration_hide").show();
            $("#declaration_both").hide();
            $("#art_declaration").prop("checked", false);
            $("#art_declaration1").prop("checked", false);
        } else {
            $("#art_ivf_donor").show();
            $("#declaration_both").show();

            if ( artProcUndertaken === "intra-uterine insemination(IUI)" || artProcUndertaken === "artificial insemination" ) {
                $("#art_ivf_donor option").hide();
                $("#art_types_of_treat1 option[value='Sperm Donation']").show().prop("selected", true);

                $("#art_declaration_hide").hide();
                $("#art_declaration").prop("checked", false);
            }
        }




        let options = '<option value="">Select</option>';

        $("#art_fail_reason").hide();

        for (let i = 0; i <= art_total_num; i++) {
            options += `<option value="${i}" ${no_cycles == i ? 'selected' : ''}>${i}</option>`;
        }
        $("#art_no_cycles").html(options);
  


        
        
        if (no_cycles > 0) {
            $("#art_fail_reason").show();
        } else {
            $("#art_fail_reason").hide();
        }
        

        if (parseInt(no_cycles) === parseInt(art_total_num)) {
            $("#art_treat_outcomes option").hide();
            $("#art_treat_outcomes option[value='Not Pregnant']")
                .show()
                .prop("selected", true);
        } else {
            $("#art_treat_outcomes option").show();
            $("#art_treat_outcomes option[value='']")
                .show()
                .prop("selected", false);
        }



    });


// on changes / on Submit validation and 
$(document).ready(function () {
    $('input[name="art_case_of"]').click(function () {
        $(
            "#art_nationality_wife, #art_age_hus_wife, #art_nationality_husband, #art_age_of_women, #art_wife_age",
        )
            .val("")
            .trigger("change");
        $("#art_male_factor, #art_female_factor, #art_unexplained").prop(
            "checked",
            false,
        );

        $(
            "#art_other_nationality1, #art_other_nationality1_wife,#art_single",
        ).hide();
        $("#art_nationality_woman_lable strong").text("Nationality of Wife");

        let selectedValue = $(this).val();
        if (selectedValue === "one") {
            $("#art_nationality_husband").show();
            $("#art_nationality_woman_lable strong").text(
                "Nationality of Wife",
            );
            $("#art_nationality_wife1").show();
            $(".art-selectt").show();
            $("#art_single").hide();
            $("#art_male_factor_div").show();
        } else if (selectedValue === "two") {
            $("#art_nationality_husband").hide();
            $("#art_nationality_woman_lable strong").text("Nationality");
            $("#art_nationality_wife1").show();
            $(".art-selectt").hide();
            $("#art_single").show();
            $("#art_other_nationality1").hide();
            $("#art_other_nationality_wife").show();
            $("#art_male_factor_div").hide();
        }
    });

    $("#art_nationality").on("change", function () {
        let selectedValue_husband = $(this).val();

        if (selectedValue_husband === "Foreigner") {
            $("#art_other_nationality1").show();
        } else {
            $("#art_other_nationality1").hide();
        }
    });

    $("#art_nationality_wife").on("change", function () {
        let selectedValue_wife = $(this).val();

        if (selectedValue_wife === "Foreigner") {
            $("#art_other_nationality1_wife").show();
        } else {
            $("#art_other_nationality1_wife").hide();
        }
    });

    $("#art_proc_undertaken").on("change", function () {
        let proc_undertaken = $(this).val();

        if (proc_undertaken === "Others") {
            $("#art_others_id").show();
        } else {
            $("#art_others_id").hide();
            $("#art_undertaken_other_2").val("");
        }

        if (
            proc_undertaken === "intra-uterine insemination(IUI)" ||
            proc_undertaken === "artificial insemination"
        ) {
            if ($("#art_ivf_donor").is(":visible")) {
                $("#art_ivf_donor option").hide();
                $("#art_ivf_donor option[value='Sperm Donation']")
                    .show()
                    .prop("selected", true);
                $("#art_declaration_hide").hide();
                $("#art_declaration").prop("checked", false);
            }
        } else {
            $("#art_ivf_donor option").show();
            $("#art_ivf_donor option").prop("selected", false);
            $("#art_ivf_donor").val("");
            $("#art_declaration_hide").show();
        }
    });

    $("#art_types_of_treat").on("change", function () {
        let undertaken_1 = $("#art_proc_undertaken").val();

        if ($(this).val() === "ART Treatment using self gametes") {
            $("#art_ivf_donor").hide();
            $("#art_types_of_treat1").val("");
            $("#art_declaration_hide").show();
            $("#declaration_both").hide();
            $("#art_declaration").prop("checked", false);
            $("#art_declaration1").prop("checked", false);
        } else {
            $("#art_ivf_donor").show();
            $("#declaration_both").show();

            if (
                undertaken_1 === "intra-uterine insemination(IUI)" ||
                undertaken_1 === "artificial insemination"
            ) {
                $("#art_ivf_donor option").hide();
                $("#art_types_of_treat1 option[value='Sperm Donation']")
                    .show()
                    .prop("selected", true);

                $("#art_declaration_hide").hide();
                $("#art_declaration").prop("checked", false);
            }
        }
    });

    $("#art_types_of_treat1").on("change", function () {
        if ($(this).val() === "Sperm Donation") {
            $("#art_declaration_hide").hide();
            $("#art_declaration").prop("checked", false);
        } else {
            $("#art_declaration_hide").show();
        }
    });

    $("#art_total_num_of_cyc").on("change", function () {
        let max = $(this).val();
        let options = '<option value="">Select</option>';

        $("#art_fail_reason").hide();
        $("#art_cyc_canc_failure_reason").val("");
        $("#art_treat_outcomes").val("");

        for (let i = 0; i <= max; i++) {
            options += `<option value="${i}">${i}</option>`;
        }
        $("#art_no_cycles").html(options);
    });

    $("#art_no_cycles").on("change", function () {
        let no_cycles = $(this).val();
        if (no_cycles > 0) {
            $("#art_fail_reason").show();
        } else {
            $("#art_fail_reason").hide();
            $("#art_cyc_canc_failure_reason").val("");
        }
        let art_total_num = $("#art_total_num_of_cyc").val();

        if (parseInt(no_cycles) === parseInt(art_total_num)) {
            $("#art_treat_outcomes option").hide();
            $("#art_treat_outcomes option[value='Not Pregnant']")
                .show()
                .prop("selected", true);
        } else {
            $("#art_treat_outcomes").val("");
            $("#art_treat_outcomes option").show();
            $("#art_treat_outcomes option[value='']")
                .show()
                .prop("selected", false);
        }
    });
});


function checkField(condition, fieldId, message) {
    if (condition && $(fieldId).val() == "") {
        alert(message);
        $(fieldId).focus();
        return false;
    }
    return true;
}

function validationarttreat() {
    let isCouple = $('#art_flexRadioDefault1').is(':checked');
    let isSingle = $('#art_flexRadioDefault2').is(':checked');

 
    if(!checkField(true, '#pati_uhid', 'Patient UHID cannot be blank')) { return false };

    var couple = document.getElementsByName("art_case_of");
    var genValue = false;
    for (var i = 0; i < couple.length; i++) {
        if (couple[i].checked == true) {
            genValue = true;
        }
    }
    if (!genValue) {
        alert("Please select either the couple or single woman");
        $('#art_flexRadioDefault1').focus();
        return false;
    }

    if (!checkField(isCouple, '#art_nationality', "Nationality of the Husband cannot be blank")) {return false};

    if (isCouple && $('#art_nationality').val() == "Foreigner") {
        if (!checkField(true, '#art_other_nationality', "Please specify Country of the husband.")) {return false};
    }
    if (!checkField(isCouple, '#art_nationality_wife', "Nationality of the wife cannot be blank")) {return false};

    if (isCouple && $('#art_nationality_wife').val() == "Foreigner") {
        if (!checkField(true, '#art_other_nationality_wife', "Please specify Country of the wife")) {return false};
    }
    if (!checkField(isSingle, '#art_nationality_wife', "Nationality of the woman cannot be blank")) {return false};

    if (isSingle && $('#art_nationality_wife').val() == "Foreigner") {
        if (!checkField(true, '#art_other_nationality_wife', "Please specify Country of the woman")) {return false};
    }
    if (!checkField(isCouple, '#art_age_hus_wife', "Please Select Husband age")) {return false};
    if (!checkField(isCouple, '#art_wife_age', "Please Select Wife age")) {return false};
    if (!checkField(isSingle, '#art_age_of_women', "Please Select Age of woman (widow or divorcee)")) {return false};


    let art_male_factor = $('#art_male_factor').is(':checked');
    let art_female_factor = $('#art_female_factor').is(':checked');
    let art_unexplained = $('#art_unexplained').is(':checked');

    if (!art_male_factor && !art_female_factor && !art_unexplained) {
        alert("Please select at least one option for medical indication.");
        return false;
    }
    if(!checkField(true, '#art_cause_of_infretily', 'Art Cause of Infretily Cannot be blank')) {return false};
    if(!checkField(true, '#art_proc_undertaken', 'ART Procedure Undertaken cannot be blank')) {return false};
    
    if(!checkField(true, '#art_types_of_treat', 'Type of Treatment cannot be blank')) {return false};

    if($('#art_types_of_treat').val() === 'ART Treatment using donor gametes'){
        if(!checkField(true, '#art_types_of_treat1', 'Type of Donation cannot be blank')) {return false};
    }

    if(!checkField(true, '#art_total_num_of_cyc', 'Total No. of Treatment Cycle(s) Undertaken cannot be blank')) {return false};
    if(!checkField(true, '#art_no_cycles', 'No. of Cycles Cancelled / Failed, if any cannot be blank')) {return false};

    let cycles = parseInt($.trim($('#art_no_cycles').val())) || 0;
    if(cycles > 0){
        if(!checkField(true, '#art_cyc_canc_failure_reason', 'Cycle Cancellation / failure reason cannot be blank')) { return false };
    }

    if(!checkField(true, '#art_treat_outcomes', 'Treatment Outcome if any cannot be blank')) {return false};

    if($('#art_types_of_treat1').val() != 'Sperm Donation' && $('#art_types_of_treat').val() != 'ART Treatment using self gametes'){
        if(!$('#art_declaration').is(':checked')){
            alert('Please accept declaration');
            $('#art_declaration').focus();
            return false;
        }
    }

    if($('#art_types_of_treat').val() != 'ART Treatment using self gametes'){
        if (!$('#art_declaration1').is(':checked')) {
            alert('Please accept declaration');
            $('#art_declaration1').focus();
            return false;
        }
    }

    let patient_uhid = $('#pati_uhid').val();
    var agree = confirm("Kindly check & confirm all details for UHID-" + patient_uhid + " before continuing next patient details.After submission Patient details can be modified using view / edit option.");
    if (agree) {
    return true;
    }
}
