var updateProgressBar;
let currentStep = 1;

function displayStep(stepNumber) {
  if (stepNumber >= 1 && stepNumber <= 4) {
    $(".step-" + currentStep).hide();
    $(".step-" + stepNumber).show();
    currentStep = stepNumber;
    updateProgressBar();
  }
}

// click event without inline onclick
$(".step-circle").on("click", function () {
  const stepNumber = $(this).data("step");
  displayStep(stepNumber);
});

  $(document).ready(function() {
    $('#multi-step-form').find('.step').slice(1).hide();
  
    $(".next-step").click(function() {
      if (currentStep < 4) {
        $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
        currentStep++;
        setTimeout(function() {
          $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
          $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInRight");
          updateProgressBar();
        }, 500);
      }
    });

    $(".prev-step").click(function() {
      if (currentStep > 1) {
        $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
        currentStep--;
        setTimeout(function() {
          $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
          $(".step-" + currentStep).show().addClass("animate__animated animate__fadeInLeft");
          updateProgressBar();
        }, 500);
      }
    });

    updateProgressBar = function() {
      var progressPercentage = ((currentStep - 1) / 3) * 100;
      $(".progress-bar").css("width", progressPercentage + "%");
    }
  });


  // add field 1st form
  document.addEventListener("DOMContentLoaded", function () {

    // ADD ROW
    document.querySelectorAll(".addRowBtn").forEach(btn => {
        btn.addEventListener("click", function (e) {
             e.preventDefault();
            const tableId = this.dataset.table;
            const table = document.getElementById(tableId);
            const tbody = table.querySelector("tbody");
            const templateRow = tbody.querySelector(".row-template");

            const newRow = templateRow.cloneNode(true);

            // clear all inputs except S.No
            newRow.querySelectorAll("input").forEach(input => {
                if (!input.classList.contains("sno")) {
                    input.value = "";
                }
            });

            tbody.appendChild(newRow);
            updateSerialNumbers(tbody);
        });
    });

    // REMOVE ROW
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("removeRow")) {
            const row = e.target.closest("tr");
            const tbody = row.closest("tbody");

            if (tbody.rows.length === 1) return; // keep minimum one row

            row.remove();
            updateSerialNumbers(tbody);
        }
    });

    // UPDATE S.NO
    function updateSerialNumbers(tbody) {
        Array.from(tbody.rows).forEach((row, index) => {
            row.querySelector(".sno").value = index + 1;
        });
    }

});

$(".step-circle").on("click", function () {
  currentStep = $(this).data("step");

  // $(".step-circle").removeClass("active");
  // $(this).addClass("active");
});

// procces bar





//Code calculation for question 1 to 14   
for (let i = 1; i <= 14; i++) {
       //Code for question 14
        $("#appeal_rej_app_a_q" + i + ", #appeal_rej_app_qtr_end_a_q" + i+ ", #appeals_disposed_b_q" + i+ ", #appeals_disposed_qtr_end_b_q" + i)
        .on("keyup", function () {
             if(i==14){                   
                    let totalAppeal_rej = Number($("#appeal_rej_app_a_q" + i).val()) || 0;                    
                    $("#tno_a_q" + i).val(totalAppeal_rej);

                     let totalAppeal_rej_qtr_end = Number($("#appeal_rej_app_qtr_end_a_q" + i).val()) || 0;  
                     $("#tno_qtr_end_a_q" + i).val(totalAppeal_rej_qtr_end);

                     let totalAppeals_disposed = Number($("#appeals_disposed_b_q" + i).val()) || 0;                    
                    $("#tno_b_q" + i).val(totalAppeals_disposed);
                     let totalAppeal_rej_qtr_end_b_q = Number($("#appeals_disposed_qtr_end_b_q" + i).val()) || 0;  
                     $("#tno_qtr_end_b_q" + i).val(totalAppeal_rej_qtr_end_b_q);
             }

        });

     

      //Code for question 1 to 13

    $("#art_clinic_q" + i + ", #art_banks_q" + i + ", #surrogacy_clinic_q" + i)
        .on("keyup", function () {
             if(i<=13){                 
                let art_clinic_q = Number($("#art_clinic_q" + i).val()) || 0;
                let art_banks_q = Number($("#art_banks_q" + i).val()) || 0;
                let surrogacy_clinic_q = Number($("#surrogacy_clinic_q" + i).val()) || 0;
                let totalRec = art_clinic_q + art_banks_q + surrogacy_clinic_q;
                $("#tno_q" + i).val(totalRec);        
             } 

        });
        $(function () {
          if(i<=13){                 
                let art_clinic_q = Number($("#art_clinic_q" + i).val()) || 0;
                let art_banks_q = Number($("#art_banks_q" + i).val()) || 0;
                let surrogacy_clinic_q = Number($("#surrogacy_clinic_q" + i).val()) || 0;
                let totalRec = art_clinic_q + art_banks_q + surrogacy_clinic_q;
                $("#tno_q" + i).val(totalRec);        
             } 
          if(i==14){                   
                  let totalAppeal_rej = Number($("#appeal_rej_app_a_q" + i).val()) || 0;                    
                  $("#tno_a_q" + i).val(totalAppeal_rej);

                    let totalAppeal_rej_qtr_end = Number($("#appeal_rej_app_qtr_end_a_q" + i).val()) || 0;  
                    $("#tno_qtr_end_a_q" + i).val(totalAppeal_rej_qtr_end);

                    let totalAppeals_disposed = Number($("#appeals_disposed_b_q" + i).val()) || 0;                    
                  $("#tno_b_q" + i).val(totalAppeals_disposed);
                    let totalAppeal_rej_qtr_end_b_q = Number($("#appeals_disposed_qtr_end_b_q" + i).val()) || 0;  
                    $("#tno_qtr_end_b_q" + i).val(totalAppeal_rej_qtr_end_b_q);
            }
        });


}
  
for (let a = 1; a <= 13; a++) {
    $("#art_clinic_qtr_end_q" + a +
      ", #art_banks_qtr_end_q" + a +
      ", #surrogacy_clinic_qtr_end_q" + a)
    .off("keyup")
    .on("keyup", function () {
        let art = Number($("#art_clinic_qtr_end_q" + a).val()) || 0;
        let bank = Number($("#art_banks_qtr_end_q" + a).val()) || 0;
        let sur = Number($("#surrogacy_clinic_qtr_end_q" + a).val()) || 0;

        $("#tno_qtr_end_q" + a).val(art + bank + sur);
    });
       $(function () {
          let art = Number($("#art_clinic_qtr_end_q" + a).val()) || 0;
        let bank = Number($("#art_banks_qtr_end_q" + a).val()) || 0;
        let sur = Number($("#surrogacy_clinic_qtr_end_q" + a).val()) || 0;

        $("#tno_qtr_end_q" + a).val(art + bank + sur);

       })
}


//Code calculation for question 15 

 $("#forwarded_dhr_i_q15, #received_stakeholders_ii_q15, #suo_moto_cognizancеr_iii_q15")
.on("keyup", function () {

    let forwarded_dhr_i_q15 = Number($("#forwarded_dhr_i_q15").val()) || 0;
    let received_stakeholders_ii_q15 = Number($("#received_stakeholders_ii_q15").val()) || 0;
    let suo_moto_cognizancеr_iii_q15 = Number($("#suo_moto_cognizancеr_iii_q15").val()) || 0;
    let totalq15 = forwarded_dhr_i_q15 + received_stakeholders_ii_q15 + suo_moto_cognizancеr_iii_q15;
    $("#tno_i_q15").val(totalq15);
});
//papulate total

 $(function () {
 let forwarded_dhr_i_q15 = Number($("#forwarded_dhr_i_q15").val()) || 0;
    let received_stakeholders_ii_q15 = Number($("#received_stakeholders_ii_q15").val()) || 0;
    let suo_moto_cognizancеr_iii_q15 = Number($("#suo_moto_cognizancеr_iii_q15").val()) || 0;
    let totalq15 = forwarded_dhr_i_q15 + received_stakeholders_ii_q15 + suo_moto_cognizancеr_iii_q15;
    $("#tno_i_q15").val(totalq15);
 })

$("#forwarded_dhr_qtr_end_i_q15, #received_stakeholders_qtr_end_ii_q15, #suo_moto_cognizancеr_qtr_end_iii_q15")
.on("keyup", function () {    
                    
    let forwarded_dhr_qtr_end_i_q15= Number($("#forwarded_dhr_qtr_end_i_q15").val()) || 0;  
    let received_stakeholders_qtr_end_ii_q15= Number($("#received_stakeholders_qtr_end_ii_q15").val()) || 0;  
    let suo_moto_cognizancеr_qtr_end_iii_q15 = Number($("#suo_moto_cognizancеr_qtr_end_iii_q15").val()) || 0; 
    let totalqtrend15 =forwarded_dhr_qtr_end_i_q15 + received_stakeholders_qtr_end_ii_q15 +  suo_moto_cognizancеr_qtr_end_iii_q15;          
    $("#tno_qtr_end_i_q15").val(totalqtrend15);
});
//papulate total

 $(function () {
  let forwarded_dhr_qtr_end_i_q15= Number($("#forwarded_dhr_qtr_end_i_q15").val()) || 0;  
    let received_stakeholders_qtr_end_ii_q15= Number($("#received_stakeholders_qtr_end_ii_q15").val()) || 0;  
    let suo_moto_cognizancеr_qtr_end_iii_q15 = Number($("#suo_moto_cognizancеr_qtr_end_iii_q15").val()) || 0; 
    let totalqtrend15 =forwarded_dhr_qtr_end_i_q15 + received_stakeholders_qtr_end_ii_q15 +  suo_moto_cognizancеr_qtr_end_iii_q15;          
    $("#tno_qtr_end_i_q15").val(totalqtrend15);
 })

//Code calculation for question 16 A
$("#action_taken_a_q16, #action_taken_qtr_end_a_q16")
.on("keyup", function () {                      
    let action_taken_a_q16= Number($("#action_taken_a_q16").val()) || 0;  
    $("#tno_a_q16").val(action_taken_a_q16);
    let action_taken_qtr_end_a_q16= Number($("#action_taken_qtr_end_a_q16").val()) || 0;  
    $("#tnb_qtr_end_a_q16").val(action_taken_qtr_end_a_q16);
});
//papulate total
  $(function () {
     let action_taken_a_q16= Number($("#action_taken_a_q16").val()) || 0;  
    $("#tno_a_q16").val(action_taken_a_q16);
    let action_taken_qtr_end_a_q16= Number($("#action_taken_qtr_end_a_q16").val()) || 0;  
    $("#tnb_qtr_end_a_q16").val(action_taken_qtr_end_a_q16);
 }) 
//Code calculation for question 16 A
$("#art_clinics_b_q16, #art_banks_b_q16, #surrogacy_clinics_b_q16")
.on("keyup", function () {  
    let art_clinics_b_q16 = Number($("#art_clinics_b_q16").val()) || 0;
    let art_banks_b_q16 = Number($("#art_banks_b_q16").val()) || 0;
    let surrogacy_clinics_b_q16 = Number($("#surrogacy_clinics_b_q16").val()) || 0;
    let totalRecQ16 = art_clinics_b_q16 + art_banks_b_q16 + surrogacy_clinics_b_q16;
    $("#tno_b_q16").val(totalRecQ16);        

});
//papulate total
  $(function () {
     let art_clinics_b_q16 = Number($("#art_clinics_b_q16").val()) || 0;
    let art_banks_b_q16 = Number($("#art_banks_b_q16").val()) || 0;
    let surrogacy_clinics_b_q16 = Number($("#surrogacy_clinics_b_q16").val()) || 0;
    let totalRecQ16 = art_clinics_b_q16 + art_banks_b_q16 + surrogacy_clinics_b_q16;
    $("#tno_b_q16").val(totalRecQ16);    
 }) 
$("#art_clinics_qtr_end_b_q16, #art_banks_qtr_end_b_q16, #surrogacy_clinics_qtr_end_b_q16")
.on("keyup", function () {  
    let art_clinics_qtr_end_b_q16 = Number($("#art_clinics_qtr_end_b_q16").val()) || 0;
    let art_banks_qtr_end_b_q16 = Number($("#art_banks_qtr_end_b_q16").val()) || 0;
    let surrogacy_clinics_qtr_end_b_q16 = Number($("#surrogacy_clinics_qtr_end_b_q16").val()) || 0;
    let totalRecQtrQ16 = art_clinics_qtr_end_b_q16 + art_banks_qtr_end_b_q16 + surrogacy_clinics_qtr_end_b_q16;
    $("#tno_art_clinics_qtr_end_b_q16").val(totalRecQtrQ16);
});
//papulate total
  $(function () {
    let art_clinics_qtr_end_b_q16 = Number($("#art_clinics_qtr_end_b_q16").val()) || 0;
    let art_banks_qtr_end_b_q16 = Number($("#art_banks_qtr_end_b_q16").val()) || 0;
    let surrogacy_clinics_qtr_end_b_q16 = Number($("#surrogacy_clinics_qtr_end_b_q16").val()) || 0;
    let totalRecQtrQ16 = art_clinics_qtr_end_b_q16 + art_banks_qtr_end_b_q16 + surrogacy_clinics_qtr_end_b_q16;
    $("#tno_art_clinics_qtr_end_b_q16").val(totalRecQtrQ16);

  })


//Code calculation for question 17 A
$("#appeal_received_a_q17, #appeal_received_qtr_end_a_q17")
.on("keyup", function () {                      
    let appeal_received_a_q17= Number($("#appeal_received_a_q17").val()) || 0;  
    $("#tno_a_q17").val(appeal_received_a_q17);
    let appeal_received_qtr_end_a_q17= Number($("#appeal_received_qtr_end_a_q17").val()) || 0;  
    $("#tno_qtr_end_a_q17").val(appeal_received_qtr_end_a_q17);
});
  //papulate total
  $(function () {
    let appeal_received_a_q17= Number($("#appeal_received_a_q17").val()) || 0;  
    $("#tno_a_q17").val(appeal_received_a_q17);
    let appeal_received_qtr_end_a_q17= Number($("#appeal_received_qtr_end_a_q17").val()) || 0;  
    $("#tno_qtr_end_a_q17").val(appeal_received_qtr_end_a_q17);
    
  })
//Code calculation for question 17 B
$("#appeals_disposed_b_q17, #appeals_disposed_qtr_end_b_q17")
.on("keyup", function () {                      
    let appeals_disposed_b_q17= Number($("#appeals_disposed_b_q17").val()) || 0;  
    $("#tno_b_q17").val(appeals_disposed_b_q17);
    let appeals_disposed_qtr_end_b_q17= Number($("#appeals_disposed_qtr_end_b_q17").val()) || 0;  
    $("#tno_qtr_end_b_q17").val(appeals_disposed_qtr_end_b_q17);
}); 
  //papulate total
  $(function () {
    let appeals_disposed_b_q17= Number($("#appeals_disposed_b_q17").val()) || 0;  
    $("#tno_b_q17").val(appeals_disposed_b_q17);
    let appeals_disposed_qtr_end_b_q17= Number($("#appeals_disposed_qtr_end_b_q17").val()) || 0;  
    $("#tno_qtr_end_b_q17").val(appeals_disposed_qtr_end_b_q17);
    
  })
//Code calculation for question 18
$("#complaints_filed_q18, #complaints_filed_qtr_end_q18")
.on("keyup", function () {                      
    let complaints_filed_q18= Number($("#complaints_filed_q18").val()) || 0;  
    $("#tno_q18").val(complaints_filed_q18);
    let complaints_filed_qtr_end_q18= Number($("#complaints_filed_qtr_end_q18").val()) || 0;  
    $("#tno_qtr_end_q18").val(complaints_filed_qtr_end_q18);
}); 
  //papulate total
  $(function () {
    let complaints_filed_q18= Number($("#complaints_filed_q18").val()) || 0;  
    $("#tno_q18").val(complaints_filed_q18);
    let complaints_filed_qtr_end_q18= Number($("#complaints_filed_qtr_end_q18").val()) || 0;  
    $("#tno_qtr_end_q18").val(complaints_filed_qtr_end_q18);
    
  })
//Code calculation for question 19 a
$("#applications_received_i_a_q19, #applications_received_ii_a_q19, #applications_received_iii_a_q19 , #applications_received_iv_a_q19")
.on("keyup", function () {  
     let total_a_q19  = 0;
     total_a_q19 += Number($("#applications_received_i_a_q19").val()) || 0;
    total_a_q19 += Number($("#applications_received_ii_a_q19").val()) || 0;
    total_a_q19 += Number($("#applications_received_iii_a_q19").val()) || 0;
    total_a_q19 += Number($("#applications_received_iv_a_q19").val()) || 0;   
    $("#tno_i_a_q19").val(total_a_q19);
}); 
  //papulate total
  $(function () {
     let total_a_q19  = 0;
     total_a_q19 += Number($("#applications_received_i_a_q19").val()) || 0;
    total_a_q19 += Number($("#applications_received_ii_a_q19").val()) || 0;
    total_a_q19 += Number($("#applications_received_iii_a_q19").val()) || 0;
    total_a_q19 += Number($("#applications_received_iv_a_q19").val()) || 0;   
    $("#tno_i_a_q19").val(total_a_q19);
    
  })
$("#applications_received_qtr_end_i_a_q19, #applications_received_qtr_end_ii_a_q19, #applications_received_qtr_end_iii_a_q19 , #applications_received_qtr_end_iv_a_q19")
.on("keyup", function () {  
     let total_qtr_a_q19  = 0;
     total_qtr_a_q19 += Number($("#applications_received_qtr_end_i_a_q19").val()) || 0;
    total_qtr_a_q19 += Number($("#applications_received_qtr_end_ii_a_q19").val()) || 0;
    total_qtr_a_q19 += Number($("#applications_received_qtr_end_iii_a_q19").val()) || 0;
    total_qtr_a_q19 += Number($("#applications_received_qtr_end_iv_a_q19").val()) || 0;   
    $("#tno_qtr_end_i_a_q19").val(total_qtr_a_q19);
}); 
 //papulate total
  $(function () {
    let total_qtr_a_q19  = 0;
     total_qtr_a_q19 += Number($("#applications_received_qtr_end_i_a_q19").val()) || 0;
    total_qtr_a_q19 += Number($("#applications_received_qtr_end_ii_a_q19").val()) || 0;
    total_qtr_a_q19 += Number($("#applications_received_qtr_end_iii_a_q19").val()) || 0;
    total_qtr_a_q19 += Number($("#applications_received_qtr_end_iv_a_q19").val()) || 0;   
    $("#tno_qtr_end_i_a_q19").val(total_qtr_a_q19);

  })

 //Code calculation for question 19 b
$("#applications_granted_i_b_q19, #applications_granted_ii_b_q19, #applications_granted_iii_b_q19 , #applications_granted_iv_b_q19")
.on("keyup", function () {  
     let total_b_q19  = 0;
     total_b_q19 += Number($("#applications_granted_i_b_q19").val()) || 0;
    total_b_q19 += Number($("#applications_granted_ii_b_q19").val()) || 0;
    total_b_q19 += Number($("#applications_granted_iii_b_q19").val()) || 0;
    total_b_q19 += Number($("#applications_granted_iv_b_q19").val()) || 0;   
    $("#tno_i_b_q19").val(total_b_q19);
}); 
 //papulate total
  $(function () {
     let total_b_q19  = 0;
     total_b_q19 += Number($("#applications_granted_i_b_q19").val()) || 0;
    total_b_q19 += Number($("#applications_granted_ii_b_q19").val()) || 0;
    total_b_q19 += Number($("#applications_granted_iii_b_q19").val()) || 0;
    total_b_q19 += Number($("#applications_granted_iv_b_q19").val()) || 0;   
    $("#tno_i_b_q19").val(total_b_q19);

  }) 

$("#applications_granted_qtr_end_i_b_q19, #applications_granted_qtr_end_ii_b_q19, #applications_granted_qtr_end_iii_b_q19 , #applications_granted_qtr_end_iv_b_q19")
.on("keyup", function () {  
     let total_qtr_b_q19  = 0;
     total_qtr_b_q19 += Number($("#applications_granted_qtr_end_i_b_q19").val()) || 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_ii_b_q19").val()) || 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_iii_b_q19").val()) || 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_iv_b_q19").val()) || 0;   
    $("#tno_qtr_end_i_b_q19").val(total_qtr_b_q19);
});
   //papulate total
  $(function () {
    let total_qtr_b_q19  = 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_i_b_q19").val()) || 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_ii_b_q19").val()) || 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_iii_b_q19").val()) || 0;
    total_qtr_b_q19 += Number($("#applications_granted_qtr_end_iv_b_q19").val()) || 0;   
    $("#tno_qtr_end_i_b_q19").val(total_qtr_b_q19);
  })  
 //Code calculation for question 19 c
$("#applications_rejected_i_c_q19, #applications_rejected_ii_c_q19, #applications_rejected_iii_c_q19 , #applications_rejected_iv_c_q19")
.on("keyup", function () {  
     let total_c_q19  = 0;
     total_c_q19 += Number($("#applications_rejected_i_c_q19").val()) || 0;
    total_c_q19 += Number($("#applications_rejected_ii_c_q19").val()) || 0;
    total_c_q19 += Number($("#applications_rejected_iii_c_q19").val()) || 0;
    total_c_q19 += Number($("#applications_rejected_iv_c_q19").val()) || 0;   
    $("#tnc_i_c_q19").val(total_c_q19);
}); 
   //papulate total
  $(function () {
    let total_c_q19  = 0;
    total_c_q19 += Number($("#applications_rejected_i_c_q19").val()) || 0;
    total_c_q19 += Number($("#applications_rejected_ii_c_q19").val()) || 0;
    total_c_q19 += Number($("#applications_rejected_iii_c_q19").val()) || 0;
    total_c_q19 += Number($("#applications_rejected_iv_c_q19").val()) || 0;   
    $("#tnc_i_c_q19").val(total_c_q19);
  }) 

$("#applications_rejected_qtr_end_i_c_q19, #applications_rejected_qtr_end_ii_c_q19, #applications_rejected_qtr_end_iii_c_q19 , #applications_rejected_qtr_end_iv_c_q19")
.on("keyup", function () {  
     let total_qtr_c_q19  = 0;
     total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_i_c_q19").val()) || 0;
    total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_ii_c_q19").val()) || 0;
    total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_iii_c_q19").val()) || 0;
    total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_iv_c_q19").val()) || 0;   
    $("#tno_qtr_end_i_c_q19").val(total_qtr_c_q19);
});
//papulate total
  $(function () {
 let total_qtr_c_q19  = 0;
     total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_i_c_q19").val()) || 0;
    total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_ii_c_q19").val()) || 0;
    total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_iii_c_q19").val()) || 0;
    total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_iv_c_q19").val()) || 0;   
    $("#tno_qtr_end_i_c_q19").val(total_qtr_c_q19);
  })
//Code calculation for question 20 a, b
$("#appeals_against_rejection_a_q20, #appeals_against_rejection_qtr_end_a_q20")
.on("keyup", function () {                      
    let appeals_against_rejection_a_q20= Number($("#appeals_against_rejection_a_q20").val()) || 0;  
    $("#tno_a_q20").val(appeals_against_rejection_a_q20);
    let appeals_against_rejection_qtr_end_a_q20= Number($("#appeals_against_rejection_qtr_end_a_q20").val()) || 0;  
    $("#tno_qtr_end_a_q20").val(appeals_against_rejection_qtr_end_a_q20);
});
//papulate total
  $(function () {
     let appeals_against_rejection_a_q20= Number($("#appeals_against_rejection_a_q20").val()) || 0;  
    $("#tno_a_q20").val(appeals_against_rejection_a_q20);
    let appeals_against_rejection_qtr_end_a_q20= Number($("#appeals_against_rejection_qtr_end_a_q20").val()) || 0;  
    $("#tno_qtr_end_a_q20").val(appeals_against_rejection_qtr_end_a_q20);
  })
$("#appeals_disposed_b_q20, #appeals_disposed_qtr_end_b_q20")
.on("keyup", function () {                      
    let appeals_disposed_b_q20= Number($("#appeals_disposed_b_q20").val()) || 0;  
    $("#tno_b_q20").val(appeals_disposed_b_q20);
    let appeals_disposed_qtr_end_b_q20= Number($("#appeals_disposed_qtr_end_b_q20").val()) || 0;  
    $("#tno_qtr_end_b_q20").val(appeals_disposed_qtr_end_b_q20);
});
//papulate total
  $(function () {
     let appeals_disposed_b_q20= Number($("#appeals_disposed_b_q20").val()) || 0;  
    $("#tno_b_q20").val(appeals_disposed_b_q20);
    let appeals_disposed_qtr_end_b_q20= Number($("#appeals_disposed_qtr_end_b_q20").val()) || 0;  
    $("#tno_qtr_end_b_q20").val(appeals_disposed_qtr_end_b_q20);
  })
$("#chapter_v_art_q22, #surrogacy_chapter_vii_q22")
.on("keyup", function () {                      
    let chapter_v_art_q22= Number($("#chapter_v_art_q22").val()) || 0;  
    let surrogacy_chapter_vii_q22= Number($("#surrogacy_chapter_vii_q22").val()) || 0;  
      $("#tno_q22").val(chapter_v_art_q22+surrogacy_chapter_vii_q22);
});
//papulate total
  $(function () {
    let chapter_v_art_q22= Number($("#chapter_v_art_q22").val()) || 0;  
    let surrogacy_chapter_vii_q22= Number($("#surrogacy_chapter_vii_q22").val()) || 0;  
      $("#tno_q22").val(chapter_v_art_q22+surrogacy_chapter_vii_q22);
  })
$("#chapter_v_art_qtr_end_q22, #surrogacy_chapter_qtr_end_vii_q22")
.on("keyup", function () {
                               
    let chapter_v_art_qtr_end_q22= Number($("#chapter_v_art_qtr_end_q22").val()) || 0;  
    let surrogacy_chapter_qtr_end_vii_q22= Number($("#surrogacy_chapter_qtr_end_vii_q22").val()) || 0;  
      $("#tno_qtr_end_q22").val(chapter_v_art_qtr_end_q22+surrogacy_chapter_qtr_end_vii_q22);
});
//papulate total
  $(function () {
     let chapter_v_art_qtr_end_q22= Number($("#chapter_v_art_qtr_end_q22").val()) || 0;  
    let surrogacy_chapter_qtr_end_vii_q22= Number($("#surrogacy_chapter_qtr_end_vii_q22").val()) || 0;  
      $("#tno_qtr_end_q22").val(chapter_v_art_qtr_end_q22+surrogacy_chapter_qtr_end_vii_q22);
  })

$(document).on("input", ".number-only", function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});




