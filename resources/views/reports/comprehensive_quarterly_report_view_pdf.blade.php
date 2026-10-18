<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="css/app1.css"> -->
    <title>Format for Quarterly report to be submitted by the State /UT </title>
    <style>
        .main-tables tbody{
            border-bottom: 4px solid #ccc;
        } 
       .lines tr th{
             border-bottom: 1px solid #007BFF;
             border-right: 1px solid #007BFF;
             border-top: 1px solid #007BFF;
             background: #007BFF;
             color: #fff; 
             padding: 5px 4px;
            text-align: left;
        }  
		.lines tr td{
			 border-right: 1px solid #007BFF;
			 border-bottom: 1px solid #007BFF;
              padding: 5px 4px;
		}	

		.lines tr:first-child{
			 border-left: 1px solid #007BFF;
		}	
        .lines tr .zeroborder{
           border-left: 1px solid #007bff;
            padding: 5px 4px; 
        }
         
       
         .lines tr td:nth-child(3){
            text-align: center!important;
           
        } 
         .lines tr td:nth-child(4){
           text-align: center;
        } 
         .lines tr td:nth-child(5){
           text-align: center;
        } 
         .lines tr td:nth-child(6){
           text-align: center;
        } 
         

        .txtaligncenter{
        vertical-align: middle !important;
        text-align: center !important;
        }
        .no-capitalize {
        text-transform: none !important;
        }
     
    
</style>
</head>
<body>
<div class="container">
<div class="row">
    <div class="col-md-12">
        <div>
            <h2 style="text-align: center">View Quarterly report to be submitted by the <br> State / UT Appropriate Authority</h2>
            <p>Report For Quarter ended on: <b>{{isset($reportResult->description)? $reportResult->description:'' }} {{isset($reportResult->year)? $reportResult->year:'' }}</b></p>
            <p>Name Of State / Union Territory: <b>{{isset($reportResult->state_name)? $reportResult->state_name:'' }}</b></p>
        </div>
        <?php //print_r($reportResult);?>
 
    <div class="col-md-12">
        <table width="100%" class="lines">
            <thead class="table-light">
                <tr>
                    <th colspan="2">Items</th>
                    <th colspan="2">During the Quarter</th>
                    <th colspan="2">Upto this Quarter end</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b> 1.</b> Number of applications received in the National Registry Portal in the State / UT :
                </td>
                <td >ART Clinic</td>
                 <td>{{isset($reportResult->art_clinic_q1)? $reportResult->art_clinic_q1:'0' }}</td>
                <td class="txtaligncenter" rowspan="3" >
                    {{ ($reportResult->art_clinic_q1 ?? 0)+ ($reportResult->art_banks_q1 ?? 0) + ($reportResult->surrogacy_clinic_q1 ?? 0) }}
                </td>     
                <td> {{isset($reportResult->art_clinic_qtr_end_q1)? $reportResult->art_clinic_qtr_end_q1:'0' }} </td>
                <td class="txtaligncenter" rowspan="3">
                      {{ ($reportResult->art_clinic_qtr_end_q1 ?? 0)+ ($reportResult->art_banks_qtr_end_q1 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q1 ?? 0) }}
                </td>
            </tr>
             <tr>
                <td>ART Banks</td>
                <td id="art_banks_q1" class="txtaligncenter">{{isset($reportResult->art_banks_q1)? $reportResult->art_banks_q1:'0' }}</td>
                <td id="art_banks_qtr_end_q1" >{{isset($reportResult->art_banks_qtr_end_q1)? $reportResult->art_banks_qtr_end_q1:'0' }}</td>
            </tr>
            <tr>
                <td >Surrogacy Clinic</td>
                <td id="surrogacy_clinic_q1" class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q1)? $reportResult->surrogacy_clinic_q1:'0' }}</td>
            <td id="surrogacy_clinic_qtr_end_q1">{{isset($reportResult->surrogacy_clinic_qtr_end_q1)? $reportResult->surrogacy_clinic_qtr_end_q1:'0' }}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b>2.</b> Number of applications received (Complete in all respects along with Registration fees) by the State / UT :
                </td>
                <td class="text-start">ART Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q2)? $reportResult->art_clinic_q2:'0' }}</td>
                <td rowspan="3" class="txtaligncenter"> {{ ($reportResult->art_clinic_q2 ?? 0)+ ($reportResult->art_banks_q2 ?? 0) + ($reportResult->surrogacy_clinic_q2 ?? 0) }}</td>
                <td  class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q2)? $reportResult->art_clinic_qtr_end_q2:'0' }}</td>
                <td rowspan="3" class="txtaligncenter"> {{ ($reportResult->art_clinic_qtr_end_q2 ?? 0)+ ($reportResult->art_banks_qtr_end_q2 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q2 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                 <td id="art_banks_q2" class="txtaligncenter">{{isset($reportResult->art_banks_q2)? $reportResult->art_banks_q2:'0' }}</td>
                 <td id="art_banks_qtr_end_q2" class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q2)? $reportResult->art_banks_qtr_end_q2:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td id="surrogacy_clinic_q2" class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q2)? $reportResult->surrogacy_clinic_q2:'0' }}</td>
                <td id="surrogacy_clinic_qtr_end_q2" class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q2)? $reportResult->surrogacy_clinic_qtr_end_q2:'0' }}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b>3.</b> Number of Clinic or Banks Registered in the State / UT
                </td>
                <td class="text-start">ART Clinic</td>
                 <td class="txtaligncenter" >{{isset($reportResult->art_clinic_q3)? $reportResult->art_clinic_q3:'0' }}</td>
            <td rowspan="3"  class="txtaligncenter"> {{ ($reportResult->art_clinic_q3 ?? 0)+ ($reportResult->art_banks_q3 ?? 0) + ($reportResult->surrogacy_clinic_q3 ?? 0) }}</td>
            <td  id="art_clinic_qtr_end_q3">{{isset($reportResult->art_clinic_qtr_end_q3)? $reportResult->art_clinic_qtr_end_q3:'0' }}</td>
            <td rowspan="3"  id="tno_qtr_end_q3">{{ ($reportResult->art_clinic_qtr_end_q3 ?? 0)+ ($reportResult->art_banks_qtr_end_q3 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q3 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                <td  class="txtaligncenter" >{{isset($reportResult->art_banks_q3)? $reportResult->art_banks_q3:'0' }}</td>
                <td id="art_banks_qtr_end_q3">{{isset($reportResult->art_banks_qtr_end_q3)? $reportResult->art_banks_qtr_end_q3:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q3)? $reportResult->surrogacy_clinic_q3:'0' }}</td>
                <td  id="surrogacy_clinic_qtr_end_q3">{{isset($reportResult->surrogacy_clinic_qtr_end_q3)? $reportResult->surrogacy_clinic_qtr_end_q3:'0' }}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b>4.</b> Of the Number shown in item (3) above, number of establishments in the Government run institutes in the State / UT
                </td>
                <td class="text-start">ART Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q4)? $reportResult->art_clinic_q4:'0' }}</td>
                <td rowspan="3" id="tno_q4">{{ ($reportResult->art_clinic_q4 ?? 0)+ ($reportResult->art_banks_q4 ?? 0) + ($reportResult->surrogacy_clinic_q4 ?? 0) }}</td>
                <td  id="art_clinic_qtr_end_q4" >{{isset($reportResult->art_clinic_qtr_end_q4)? $reportResult->art_clinic_qtr_end_q4:'0' }}</td>
                <td rowspan="3" id="tno_qtr_end_q4">{{ ($reportResult->art_clinic_qtr_end_q4 ?? 0)+ ($reportResult->art_banks_qtr_end_q4 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q4 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_q4)? $reportResult->art_banks_q4:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q4)? $reportResult->art_banks_qtr_end_q4:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q4)? $reportResult->surrogacy_clinic_q4:'0' }}</td>
               <td id="surrogacy_clinic_qtr_end_q4" >{{isset($reportResult->surrogacy_clinic_qtr_end_q4)? $reportResult->surrogacy_clinic_qtr_end_q4:'0' }}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b>5.</b> Of the number shown in item (3) above, number of Private clinics or banks in the State/UT:
                </td>
                <td class="text-start">ART Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q5)? $reportResult->art_clinic_q5:'0' }}</td>
                <td rowspan="3" class="txtaligncenter" >{{ ($reportResult->art_clinic_q5 ?? 0)+ ($reportResult->art_banks_q5 ?? 0) + ($reportResult->surrogacy_clinic_q5 ?? 0) }}</td>
                <td class="txtaligncenter" >{{isset($reportResult->art_clinic_qtr_end_q5)? $reportResult->art_clinic_qtr_end_q5:'0' }}</td>
                <td rowspan="3" class="txtaligncenter" >{{ ($reportResult->art_clinic_qtr_end_q5 ?? 0)+ ($reportResult->art_banks_qtr_end_q5 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q5 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                <td class="txtaligncenter" >{{isset($reportResult->art_banks_q5)? $reportResult->art_banks_q5:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q5)? $reportResult->art_banks_qtr_end_q5:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q5)? $reportResult->surrogacy_clinic_q5:'0' }}</td>
                <td  class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q5)? $reportResult->surrogacy_clinic_qtr_end_q5:'0' }}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b> 6.</b>  Number of Applications rejected for registration of clinics or banks:
                </td>
                <td class="text-start">ART Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q6)? $reportResult->art_clinic_q6:'0' }}</td>
                <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q6 ?? 0)+ ($reportResult->art_banks_q6 ?? 0) + ($reportResult->surrogacy_clinic_q6 ?? 0) }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q6)? $reportResult->art_clinic_qtr_end_q6:'0' }}</td>
                <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q6 ?? 0)+ ($reportResult->art_banks_qtr_end_q6 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q6 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                <td class="txtaligncenter" >{{isset($reportResult->art_banks_q6)? $reportResult->art_banks_q6:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q6)? $reportResult->art_banks_qtr_end_q6:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td  class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q6)? $reportResult->surrogacy_clinic_q6:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q6)? $reportResult->surrogacy_clinic_qtr_end_q6:'0' }}</td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b>7.</b> Number of Applications received on the portal but later cancelled or withdrawn in respect of:
                </td>
                <td class="text-start">ART Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q7)? $reportResult->art_clinic_q7:'0' }}</td>
                <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q7 ?? 0)+ ($reportResult->art_banks_q7 ?? 0) + ($reportResult->surrogacy_clinic_q7 ?? 0) }}</td>
                <td  class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q7)? $reportResult->art_clinic_qtr_end_q7:'0' }}</td>
                <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q7 ?? 0)+ ($reportResult->art_banks_qtr_end_q7 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q7 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_q7)? $reportResult->art_banks_q7:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q7)? $reportResult->art_banks_qtr_end_q7:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q7)? $reportResult->surrogacy_clinic_q7:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q7)? $reportResult->surrogacy_clinic_qtr_end_q7:'0' }}</td>
            </tr>
         </tbody>        
        
         <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b> 8.</b> Number of applications pending beyond the prescribed period: [2-(3+6+7)]
                </td>
                <td class="text-start">ART Clinic | Pending beyond 30 days</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q8)? $reportResult->art_clinic_q8:'0' }}</td>
                <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q8 ?? 0)+ ($reportResult->art_banks_q8 ?? 0) + ($reportResult->surrogacy_clinic_q8 ?? 0) }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q8)? $reportResult->art_clinic_qtr_end_q8:'0' }}</td>
                <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q8 ?? 0)+ ($reportResult->art_banks_qtr_end_q8 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q8 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks | Pending beyond 30 days</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_q8)? $reportResult->art_banks_q8:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q8)? $reportResult->art_banks_qtr_end_q8:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic | Pending beyond 90 days</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q8)? $reportResult->surrogacy_clinic_q8:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q8)? $reportResult->surrogacy_clinic_qtr_end_q8:'0' }}</td>
            </tr>
         </tbody>
         <tbody>
            <tr>
                <td rowspan="3" class="zeroborder">
                    <b> 9.</b> A Number of clinics which are not Registered:
                    <p class="pt-2"> B. Action taken in respect of A:</p>
                     <p class="fst-italic small">(Please provide the details on a separate sheet, as per Annexure-I.)<p>
                 
                </td>
                <td class="text-start">ART Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_q9)? $reportResult->art_clinic_q9:'0' }}</td>
                <td rowspan="3"class="txtaligncenter">{{ ($reportResult->art_clinic_q9 ?? 0)+ ($reportResult->art_banks_q9 ?? 0) + ($reportResult->surrogacy_clinic_q9 ?? 0) }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q9)? $reportResult->art_clinic_qtr_end_q9:'0' }}</td>
                <td rowspan="3"class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q9 ?? 0)+ ($reportResult->art_banks_qtr_end_q9 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q9 ?? 0) }}</td>
            </tr>
            <tr>
                <td class="text-start">ART Banks</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_q9)? $reportResult->art_banks_q9:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q9)? $reportResult->art_banks_qtr_end_q9:'0' }}</td>
            </tr>
            <tr>
                <td class="text-start">Surrogacy Clinic</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q9)? $reportResult->surrogacy_clinic_q9:'0' }}</td>
                <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q9)? $reportResult->surrogacy_clinic_qtr_end_q9:'0' }}</td>
            </tr>
          </tbody>

           <tbody>
                <tr>
                    <td rowspan="3" class="zeroborder">
                        <b>10.</b>Number Of applications received for renewals of registration certificate:
                    </td>
                    <td class="text-start">ART Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_q10)? $reportResult->art_clinic_q10:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q10 ?? 0)+ ($reportResult->art_banks_q10 ?? 0) + ($reportResult->surrogacy_clinic_q10 ?? 0) }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q10)? $reportResult->art_clinic_qtr_end_q10:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q10 ?? 0)+ ($reportResult->art_banks_qtr_end_q10 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q10 ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-start">ART Banks</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_q10)? $reportResult->art_banks_q10:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q10)? $reportResult->art_banks_qtr_end_q10:'0' }}</td>
                </tr>
                <tr>
                    <td class="text-start">Surrogacy Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q10)? $reportResult->surrogacy_clinic_q10:'0' }}</td>
                    <td  class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q10)? $reportResult->surrogacy_clinic_qtr_end_q10:'0' }}</td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td rowspan="3" class="zeroborder">
                        <b> 11.</b> Out of (10) above, applications of delayed renewal received:
                    </td>
                    <td class="text-start">ART Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_q11)? $reportResult->art_clinic_q11:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q11 ?? 0)+ ($reportResult->art_banks_q11 ?? 0) + ($reportResult->surrogacy_clinic_q11 ?? 0) }}</td>
                    <td  class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q11)? $reportResult->art_clinic_qtr_end_q11:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q11 ?? 0)+ ($reportResult->art_banks_qtr_end_q11 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q11 ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-start">ART Banks</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_q11)? $reportResult->art_banks_q11:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q11)? $reportResult->art_banks_qtr_end_q11:'0' }}</td>
                </tr>
                <tr>
                    <td class="text-start">Surrogacy Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q11)? $reportResult->surrogacy_clinic_q11:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q11)? $reportResult->surrogacy_clinic_qtr_end_q11:'0' }}</td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td rowspan="3" class="zeroborder">
                        <b>12.</b> Number of renewals granted:
                    </td>

                    <td class="text-start">ART Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_q12)? $reportResult->art_clinic_q12:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q12 ?? 0)+ ($reportResult->art_banks_q12 ?? 0) + ($reportResult->surrogacy_clinic_q12 ?? 0) }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q12)? $reportResult->art_clinic_qtr_end_q12:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q12 ?? 0)+ ($reportResult->art_banks_qtr_end_q12 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q12 ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-start">ART Banks</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_q12)? $reportResult->art_banks_q12:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q12)? $reportResult->art_banks_qtr_end_q12:'0' }}</td>
                </tr>
                <tr>
                    <td class="text-start">Surrogacy Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q12)? $reportResult->surrogacy_clinic_q12:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q12)? $reportResult->surrogacy_clinic_qtr_end_q12:'0' }}</td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td rowspan="3" class="zeroborder">
                        <b>13.</b> Number of renewal applications rejected:
                    </td>                    
                    <td class="text-start">ART Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_q13)? $reportResult->art_clinic_q13:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_q13 ?? 0)+ ($reportResult->art_banks_q13 ?? 0) + ($reportResult->surrogacy_clinic_q13 ?? 0) }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_clinic_qtr_end_q13)? $reportResult->art_clinic_qtr_end_q13:'0' }}</td>
                    <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinic_qtr_end_q13 ?? 0)+ ($reportResult->art_banks_qtr_end_q13 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q13 ?? 0) }}</td>
                </tr>
                <tr>
                    <td class="text-start">ART Banks</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_q13)? $reportResult->art_banks_q13:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_q13)? $reportResult->art_banks_qtr_end_q13:'0' }}</td>
                </tr>

                <tr>
                    <td class="text-start">Surrogacy Clinic</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_q13)? $reportResult->surrogacy_clinic_q13:'0' }}</td>
                    <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinic_qtr_end_q13)? $reportResult->surrogacy_clinic_qtr_end_q13:'0' }}</td>
                </tr>
            </tbody>
         <tbody>
    
        <tr>
            <td rowspan="1" class="zeroborder">
                <b>14. A.</b>  Number of appeals received against the rejection of applications (Fresh registration/Renewal)
            </td>

            <td></td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_rej_app_a_q14)? $reportResult->appeal_rej_app_a_q14:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_rej_app_a_q14)? $reportResult->appeal_rej_app_a_q14:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_rej_app_qtr_end_a_q14)? $reportResult->appeal_rej_app_qtr_end_a_q14:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_rej_app_qtr_end_a_q14)? $reportResult->appeal_rej_app_qtr_end_a_q14:'0' }}</td>
        </tr>
        <tr>
            <td rowspan="1" class="zeroborder">
            <b>14. B.</b> Out of the above, number of appeals disposed off.
            
            </td>

            <td></td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_b_q14)? $reportResult->appeals_disposed_b_q14:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_b_q14)? $reportResult->appeals_disposed_b_q14:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_qtr_end_b_q14)? $reportResult->appeals_disposed_qtr_end_b_q14:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_qtr_end_b_q14)? $reportResult->appeals_disposed_qtr_end_b_q14:'0' }}</td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="zeroborder">
                <b>15.</b> Number of complaints received by the Appropriate Authorities under the Act:
                  <p class="fst-italic small">(Please provide the details on a separate sheet, as per Annexure-II.)<p>
            </td>

            <td class="text-start"><b>i:</b> Forwarded by Department of Health Research</td>
            <td class="txtaligncenter"> {{isset($reportResult->forwarded_dhr_i_q15)? $reportResult->forwarded_dhr_i_q15:'0' }}</td>
            <td rowspan="3" class="txtaligncenter">{{ ($reportResult->forwarded_dhr_i_q15 ?? 0)+ ($reportResult->received_stakeholders_ii_q15 ?? 0) + ($reportResult->suo_moto_cognizancеr_iii_q15 ?? 0) }}</td>
            <td class="txtaligncenter">{{isset($reportResult->forwarded_dhr_qtr_end_i_q15)? $reportResult->forwarded_dhr_qtr_end_i_q15:'0' }}</td>
            <td rowspan="3" class="txtaligncenter">{{ ($reportResult->forwarded_dhr_qtr_end_i_q15 ?? 0)+ ($reportResult->received_stakeholders_qtr_end_ii_q15 ?? 0) +($reportResult->suo_moto_cognizancеr_qtr_end_iii_q15 ?? 0)}}</td>
        </tr>

        <tr>
            <td class="text-start"><b>ii.</b> Received from other Stakeholders</td>
            <td class="txtaligncenter">{{isset($reportResult->received_stakeholders_ii_q15)? $reportResult->received_stakeholders_ii_q15:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->received_stakeholders_qtr_end_ii_q15)? $reportResult->received_stakeholders_qtr_end_ii_q15:'0' }}</td>
        </tr>

        <tr>
            <td class="text-start"><b>iii.</b> Suo-moto Cognizancе</td>
            <td class="txtaligncenter">{{isset($reportResult->suo_moto_cognizancеr_iii_q15)? $reportResult->suo_moto_cognizancеr_iii_q15:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->suo_moto_cognizancеr_qtr_end_iii_q15)? $reportResult->suo_moto_cognizancеr_qtr_end_iii_q15:'0' }}</td>
        </tr>
    </tbody>  
    <tbody>
        <tr>
            <td colspan="6" class="zeroborder"><b>16.</b> Action taken w.r.t. complaints at point (15) above:</td>
        </tr>
        <tr>
            <td rowspan="1" class="zeroborder">
                <b>A.</b> Inspection of premises, search and seizure of documents or records, summoning of associated persons etc.
            </td>

            <td>
                [Powers drawn from Sec. 14(1) & 40(1) of ART (Regulation) Act, 2021<br>
                and Sec. 37(1) & 47(1) of Surrogacy (Regulation) Act, 2021]
            </td>
            
            <td class="txtaligncenter">{{isset($reportResult->action_taken_a_q16)? $reportResult->action_taken_a_q16:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->action_taken_a_q16)? $reportResult->action_taken_a_q16:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->action_taken_qtr_end_a_q16)? $reportResult->action_taken_qtr_end_a_q16:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->action_taken_qtr_end_a_q16)? $reportResult->action_taken_qtr_end_a_q16:'0' }}</td>
        </tr>
        <tr>
            <td rowspan="3" class="zeroborder">
            <b> B.</b> Number of suspensions or cancellations of registration in the State/UT under Section 18 of ART (Regulation) Act and Section 13 of Surrogacy (Regulation) Act, 2021 in respect of:
            <p class="fst-italic small">(Please provide the details on a separate sheet against each complaint or suo-moto cognizance, as per Annexure-II.)<p>
            </td>
            
            <td>ART Clinics</td>
            <td class="txtaligncenter">{{isset($reportResult->art_clinics_b_q16)? $reportResult->art_clinics_b_q16:'0' }}</td>
            <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinics_b_q16 ?? 0)+ ($reportResult->art_banks_b_q16 ?? 0) + ($reportResult->surrogacy_clinics_b_q16 ?? 0) }}</td>
            <td class="txtaligncenter">{{isset($reportResult->art_clinics_qtr_end_b_q16)? $reportResult->art_clinics_qtr_end_b_q16:'0' }}</td>
            <td rowspan="3" class="txtaligncenter">{{ ($reportResult->art_clinics_qtr_end_b_q16 ?? 0)+ ($reportResult->art_banks_qtr_end_b_q16 ?? 0) + ($reportResult->surrogacy_clinics_qtr_end_b_q16 ?? 0) }}</td>
        </tr>

        <tr>
            <td>ART Banks</td>
            <td class="txtaligncenter">{{isset($reportResult->art_banks_b_q16)? $reportResult->art_banks_b_q16:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->art_banks_qtr_end_b_q16)? $reportResult->art_banks_qtr_end_b_q16:'0' }}</td>
        </tr>

        <tr>
            <td>Surrogacy Clinics</td>
            <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinics_b_q16)? $reportResult->surrogacy_clinics_b_q16:'0' }}</td>
           
            <td class="txtaligncenter">{{isset($reportResult->surrogacy_clinics_qtr_end_b_q16)? $reportResult->surrogacy_clinics_qtr_end_b_q16:'0' }}</td>
            
        </tr>

    </tbody>  
    <tbody>
    
        <tr>
            <td rowspan="1" class="zeroborder">
                <b>17. A.</b>  Number of appeals received against
                suspension or cancellation of registration of clinics or banks
            </td>

            <td></td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_received_a_q17)? $reportResult->appeal_received_a_q17:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_received_a_q17)? $reportResult->appeal_received_a_q17:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_received_qtr_end_a_q17)? $reportResult->appeal_received_qtr_end_a_q17:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeal_received_qtr_end_a_q17)? $reportResult->appeal_received_qtr_end_a_q17:'0' }}</td>
        </tr>
        <tr>
            <td rowspan="1" class="zeroborder">
            <b>17. B.</b> Out of the above, number of appeals disposed off
            
            </td>

            <td></td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_b_q17)? $reportResult->appeals_disposed_b_q17:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_b_q17)? $reportResult->appeals_disposed_b_q17:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_qtr_end_b_q17)? $reportResult->appeals_disposed_qtr_end_b_q17:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_qtr_end_b_q17)? $reportResult->appeals_disposed_qtr_end_b_q17:'0' }}</td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="1" class="zeroborder">
                <b>18.</b> Number of complaints filed in courts in the
                State/UT:
               <p class="fst-italic small">(Please provide the details on a separate sheet as per Annexure-III.)<p>   
            </td>
            
            <td class="text-start"> as per Sec. 35 of ART(Regulation) Act
                and Sec. 44 of the Surrogacy(Regulation) Act 2021:</td>
            <td  class="txtaligncenter">{{isset($reportResult->complaints_filed_q18)? $reportResult->complaints_filed_q18:'0' }}</td>
            <td rowspan="1" class="txtaligncenter">{{isset($reportResult->complaints_filed_q18)? $reportResult->complaints_filed_q18:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->complaints_filed_qtr_end_q18)? $reportResult->complaints_filed_qtr_end_q18:'0' }}</td>
            <td rowspan="1" class="txtaligncenter">{{isset($reportResult->complaints_filed_qtr_end_q18)? $reportResult->complaints_filed_qtr_end_q18:'0' }}</td>
        </tr>    
    </tbody> 
     <tbody>
        <tr>
            <td colspan="6" class="zeroborder"><b>19.</b> Details of certificates issued in connection with Surrogacy (Regulation) Act, 2021 [Sec.4]:-<br /></td>
        </tr>
        <tr>
            <td rowspan="4" class="zeroborder">
                
                <b>A.</b> Number of applications received for:-
            </td>

            <td><b>i.</b> Certificate of Essentiality to Intending Couple/Intending woman</td>

            <td class="txtaligncenter">{{isset($reportResult->applications_received_i_a_q19)? $reportResult->applications_received_i_a_q19:'0' }}</td>
            <td rowspan="4" class="txtaligncenter">{{ ($reportResult->applications_received_i_a_q19 ?? 0)+($reportResult->applications_received_ii_a_q19 ?? 0) + ($reportResult->applications_received_iii_a_q19 ?? 0) + ($reportResult->applications_received_iv_a_q19 ?? 0)}}</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_received_qtr_end_i_a_q19)? $reportResult->applications_received_qtr_end_i_a_q19:'0' }}</td>
            <td rowspan="4" class="txtaligncenter">{{ ($reportResult->applications_received_qtr_end_i_a_q19 ?? 0)+($reportResult->applications_received_qtr_end_ii_a_q19 ?? 0) + ($reportResult->applications_received_qtr_end_iii_a_q19 ?? 0) + ($reportResult->applications_received_qtr_end_iv_a_q19 ?? 0)}}</td>
        </tr>
        <tr>
            <td><b>ii.</b> Eligibility Certificate to Surrogate Mother</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_received_ii_a_q19)? $reportResult->applications_received_ii_a_q19:'0' }}</td> 
            <td class="txtaligncenter">{{isset($reportResult->applications_received_qtr_end_ii_a_q19)? $reportResult->applications_received_qtr_end_ii_a_q19:'0' }}</td>
        </tr>
        <tr>
            <td><b>iii.</b> Eligibility Certificate to Intending Couple/Intending woman</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_received_iii_a_q19)? $reportResult->applications_received_iii_a_q19:'0' }}</td>         
            <td class="txtaligncenter">{{isset($reportResult->applications_received_qtr_end_iii_a_q19)? $reportResult->applications_received_qtr_end_iii_a_q19:'0' }}</td>
        </tr>
        <tr>
            <td><b>iv.</b> Authorisation of Medical Termination of
            Pregnancy having written consent of the Surrogate Mother</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_received_iv_a_q19)? $reportResult->applications_received_iv_a_q19:'0' }}</td>     
            <td class="txtaligncenter">{{isset($reportResult->applications_received_qtr_end_iv_a_q19)? $reportResult->applications_received_qtr_end_iv_a_q19:'0' }}</td>
        </tr>
             
        <tr>
            <td rowspan="4" class="zeroborder">
            <b> B.</b> Out of the applications received as per A above, number of certificates granted:-
            </td>

            <td><b>i.</b> Certificate of Essentiality to Intending Couple/Intending woman</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_i_b_q19)? $reportResult->applications_granted_i_b_q19:'0' }}</td>
            <td rowspan="4" class="txtaligncenter">{{ ($reportResult->applications_granted_i_b_q19 ?? 0)+($reportResult->applications_granted_ii_b_q19 ?? 0) + ($reportResult->applications_granted_iii_b_q19 ?? 0) + ($reportResult->applications_granted_iv_b_q19 ?? 0)}}</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_received_qtr_end_i_a_q19)? $reportResult->applications_received_qtr_end_i_a_q19:'0' }}</td>
            <td rowspan="4" class="txtaligncenter">{{ ($reportResult->applications_received_qtr_end_i_a_q19 ?? 0)+($reportResult->applications_granted_qtr_end_ii_b_q19 ?? 0) + ($reportResult->applications_granted_qtr_end_iii_b_q19 ?? 0) + ($reportResult->applications_granted_qtr_end_iv_b_q19 ?? 0)}}</td>
        </tr>
        <tr>
            <td><b>ii.</b> Eligibility Certificate to Surrogate Mother</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_ii_b_q19)? $reportResult->applications_granted_ii_b_q19:'0' }}</td>           
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_qtr_end_ii_b_q19)? $reportResult->applications_granted_qtr_end_ii_b_q19:'0' }}</td>
       </tr>

        <tr>
            <td><b>iii.</b> Eligibility Certificate to Intending Couple/Intending woman</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_iii_b_q19)? $reportResult->applications_granted_iii_b_q19:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_qtr_end_iii_b_q19)? $reportResult->applications_granted_qtr_end_iii_b_q19:'0' }}</td>
        </tr>
        <tr>
            <td><b>iv.</b> Authorisation of Medical Termination of
                Pregnancy having written consent of the Surrogate Mother</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_iv_b_q19)? $reportResult->applications_granted_iv_b_q19:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_granted_qtr_end_iv_b_q19)? $reportResult->applications_granted_qtr_end_iv_b_q19:'0' }}</td>
          
        </tr>

        <tr>
            <td rowspan="4" class="zeroborder">
            <b> C.</b> Out of the applications received as per A above, number of applications rejected:-
            </td>
            <td><b>i.</b> Certificate of Essentiality to Intending Couple/Intending woman</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_i_c_q19)? $reportResult->applications_rejected_i_c_q19:'0' }}</td>
            <td rowspan="4" class="txtaligncenter">{{ ($reportResult->applications_rejected_i_c_q19 ?? 0)+($reportResult->applications_rejected_ii_c_q19 ?? 0) + ($reportResult->applications_rejected_iii_c_q19 ?? 0) + ($reportResult->applications_rejected_iv_c_q19 ?? 0)}}</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_qtr_end_i_c_q19)? $reportResult->applications_rejected_qtr_end_i_c_q19:'0' }}</td>
            <td rowspan="4" class="txtaligncenter">{{ ($reportResult->applications_rejected_qtr_end_i_c_q19 ?? 0)+($reportResult->applications_rejected_qtr_end_ii_c_q19 ?? 0) + ($reportResult->applications_rejected_qtr_end_iii_c_q19 ?? 0) + ($reportResult->applications_rejected_qtr_end_iv_c_q19 ?? 0)}}</td>
        </tr>

        <tr>
            <td><b>ii.</b> Eligibility Certificate to Surrogate Mother</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_ii_c_q19)? $reportResult->applications_rejected_ii_c_q19:'0' }}</td> 
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_qtr_end_ii_c_q19)? $reportResult->applications_rejected_qtr_end_ii_c_q19:'0' }}</td>
 
        </tr>

        <tr>
            <td><b>iii.</b> Eligibility Certificate to Intending Couple/Intending woman</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_iii_c_q19)? $reportResult->applications_rejected_iii_c_q19:'0' }}</td>           
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_qtr_end_iii_c_q19)? $reportResult->applications_rejected_qtr_end_iii_c_q19:'0' }}</td>
 
        </tr>
        <tr>
            <td><b>iv.</b> Authorisation of Medical Termination of
                Pregnancy having written consent of the Surrogate Mother</td>
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_iv_c_q19)? $reportResult->applications_rejected_iv_c_q19:'0' }}</td>      
            <td class="txtaligncenter">{{isset($reportResult->applications_rejected_qtr_end_iv_c_q19)? $reportResult->applications_rejected_qtr_end_iv_c_q19:'0' }}</td>
       
        </tr> 
    </tbody>    
    <tbody>    
        <tr>
            <td rowspan="1" class="zeroborder">
                <b>20. A.</b>  Number of Appeals received against rejection of certificate at point 19(C) above.
            </td>

            <td></td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_against_rejection_a_q20)? $reportResult->appeals_against_rejection_a_q20:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_against_rejection_a_q20)? $reportResult->appeals_against_rejection_a_q20:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_against_rejection_qtr_end_a_q20)? $reportResult->appeals_against_rejection_qtr_end_a_q20:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_against_rejection_qtr_end_a_q20)? $reportResult->appeals_against_rejection_qtr_end_a_q20:'0' }}</td>
        </tr>
        <tr>
            <td rowspan="1" class="zeroborder">
            <b>20. B.</b> Number of Such Appeals disposed off.            
            </td>
            <td></td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_b_q20)? $reportResult->appeals_disposed_b_q20:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_b_q20)? $reportResult->appeals_disposed_b_q20:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_qtr_end_b_q20)? $reportResult->appeals_disposed_qtr_end_b_q20:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->appeals_disposed_qtr_end_b_q20)? $reportResult->appeals_disposed_qtr_end_b_q20:'0' }}</td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="1" class="zeroborder">
                <b>21.</b> Date(s) of the meetings of the State Board constituted under section 27 of the Act [Sec 29(1) - meeting at least once in 4 months].
            

            <td class="text-start"></td>
            <td colspan="2">{{isset($reportResult->meeting_date_q21)? $reportResult->meeting_date_q21:'0' }}</textarea>
        
            </td>
           
            <td colspan="2">
                {{isset($reportResult->meeting_date_qtr_end_q21)? $reportResult->meeting_date_qtr_end_q21:'0' }}</textarea>
           
            </td>
             
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="2" class="zeroborder">
                <b>22.</b> Action taken in respect of Penal provisions under:
                  <p class="fst-italic small">(Please provide the details on a separate sheet as per Annexure-III.)<p>                
            </td>

            <td class="text-start"><b>1.</b> Chapter V of ART</td>
            <td class="txtaligncenter">{{isset($reportResult->chapter_v_art_q22)? $reportResult->chapter_v_art_q22:'0' }}</td>
            <td rowspan="2" class="txtaligncenter">{{ ($reportResult->chapter_v_art_q22 ?? 0)+ ($reportResult->surrogacy_chapter_vii_q22 ?? 0)}}</td>
            <td class="txtaligncenter">{{isset($reportResult->chapter_v_art_qtr_end_q22)? $reportResult->chapter_v_art_qtr_end_q22:'0' }}</td>
            <td rowspan="2" class="txtaligncenter">{{ ($reportResult->chapter_v_art_qtr_end_q22 ?? 0)+ ($reportResult->surrogacy_chapter_qtr_end_vii_q22 ?? 0)}}</td>
        </tr>

        <tr>
            <td class="text-start"><b>2.</b>Chapter VII of surrogacy</td>
            <td class="txtaligncenter">{{isset($reportResult->surrogacy_chapter_vii_q22)? $reportResult->surrogacy_chapter_vii_q22:'0' }}</td>
            <td class="txtaligncenter">{{isset($reportResult->surrogacy_chapter_qtr_end_vii_q22)? $reportResult->surrogacy_chapter_qtr_end_vii_q22:'0' }}</td>
        </tr>

    </tbody>
</table>
     <div class="step step-4">
      <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
            <h5 class="mb-4 text-primary">
               Annexure-I (For  Point 9 of the Format)
            </h5>

            <table width="100%" class="lines">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>Name of the Clinic/Bank</th>
                        <th>Operating since</th>
                        <th>Action taken</th>
                    </tr>
                </thead>
                <tbody>                    
                    @php $i=1;  @endphp
                    @if(isset($annexureResult['firstAnnexureResultQ9'])) 
                        @foreach ($annexureResult['firstAnnexureResultQ9'] as $rowQ9 )     
                        <tr>
                            <td  class="zeroborder">{{$i}}</td>
                            <td>{{isset($rowQ9['clinic_name'])? $rowQ9['clinic_name']:'' }}</td>
                            <td>{{isset($rowQ9['operating_since'])? date("d-m-Y",strtotime($rowQ9['operating_since'])):'' }}</td>
                            <td>{{isset($rowQ9['action_taken'])? $rowQ9['action_taken']:'' }}</td>
                        </tr>      
                        @php $i++; @endphp 
                        @endforeach
                    @endif  
                </tbody>
            </table>
       </div>
        {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
            <h5 class="mb-4 text-primary">
                Q15  (Please give details on separate sheet as per Annexure-II)
            </h5>

            <table width="100%" class="lines">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">S.No</th>
                        <th>Complaint forwarded by</th>
                        <th>Complaint filed by</th>
                        <th>Complaint filed against</th>
                        <th>Details of issues</th>
                        <th>Action taken</th>
                        <th>Final outcome</th>
                    </tr>
                </thead>
                <tbody>
                    @php $j=1;  @endphp
                    @if(isset($annexureResult['secondAnnexureResultQ15'])) 
                        @foreach ($annexureResult['secondAnnexureResultQ15'] as $rowQ15 ) 
                            <tr class="row-template @if($j==1) q15-row @endif">
                            <td class="zeroborder">{{$j}}</td>
                            <td>{{isset($rowQ15['complaint_source'])? $rowQ15['complaint_source']:'' }}</td>
                            <td>{{isset($rowQ15['filed_by'])? $rowQ15['filed_by']:'' }}</td>
                            <td>{{isset($rowQ15['filed_against'])? $rowQ15['filed_against']:'' }}</td>
                            <td>{{isset($rowQ15['issue_details'])? $rowQ15['issue_details']:'' }}</td>
                            <td>{{isset($rowQ15['action_taken'])? $rowQ15['action_taken']:'' }}</td>
                            <td>{{isset($rowQ15['outcome'])? $rowQ15['outcome']:'' }}</td>         
                            </tr>
                            @php $j++; @endphp 
                        @endforeach
                    @endif  
                </tbody>
            </table>
        </div> --}}
        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
            <h5 class="mb-4 text-primary">
              Annexure-II (For  Point 15 & 16 of the Format)
            </h5>

            <table width="100%" class="lines">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">S.No</th>
                        <th>Complaint forwarded by</th>
                        <th>Complaint filed by</th>
                        <th>Complaint filed against</th>
                        <th>Details of issues</th>
                        <th>Action taken</th>
                        <th>Final outcome</th>
                    </tr>
                </thead>
                <tbody>
                      @php $k=1;  @endphp
                        @if(isset($annexureResult['secondAnnexureResultQ16'])) 
                            @foreach ($annexureResult['secondAnnexureResultQ16'] as $rowQ16 )   
                        <tr class="row-template  @if($k==1) q16-row @endif">
                            <td class="zeroborder">{{$k}}</td>
                            <td>{{isset($rowQ16['complaint_source'])? $rowQ16['complaint_source']:'' }}</td>
                            <td>{{isset($rowQ16['filed_by'])? $rowQ16['filed_by']:'' }}</td>
                            <td>{{isset($rowQ16['filed_against'])? $rowQ16['filed_against']:'' }}</td>
                            <td>{{isset($rowQ16['issue_details'])? $rowQ16['issue_details']:'' }}</td>
                            <td>{{isset($rowQ16['action_taken'])? $rowQ16['action_taken']:'' }}</td>
                            <td>{{isset($rowQ16['outcome'])? $rowQ16['outcome']:'' }}</td>
                        </tr>
                    @php $k++; @endphp 
                            @endforeach
                        @endif
                </tbody>
            </table>
        </div>
        {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
            <h5 class="mb-4 text-primary">
                Q18. (Please give details on separate sheet as per Annexure-III)
            </h5>

            <table width="100%" class="lines">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">S.No</th>
                        <th>Case filed by</th>
                        <th>Case filed against</th>
                        <th>Section & Act</th>
                        <th>Details of issues</th>
                        <th>No. of persons arrested</th>
                        <th>Final outcome</th>
                    </tr>
                </thead>
                <tbody>
                     @php $l=1;  @endphp
                    @if(isset($annexureResult['thirdAnnexureResultQ18'])) 
                        @foreach ($annexureResult['thirdAnnexureResultQ18'] as $rowQ18 ) 
                            <tr class="row-template @if($l==1) q18-row @endif">
                                <td class="zeroborder">{{$l}}</td>
                                <td>{{isset($rowQ18['case_filed_by'])? $rowQ18['case_filed_by']:'' }}</td>
                                <td>{{isset($rowQ18['case_filed_against'])? $rowQ18['case_filed_against']:'' }}</td>
                                <td>{{isset($rowQ18['section_act_for_violation'])? $rowQ18['section_act_for_violation']:'' }}</td>
                                <td>{{isset($rowQ18['issue_details'])? $rowQ18['issue_details']:'' }}</td>
                                <td>{{isset($rowQ18['persons_arrested'])? $rowQ18['persons_arrested']:''   }}</td>
                                <td>{{isset($rowQ18['case_outcome'])? $rowQ18['case_outcome']:''   }}</td>
                            </tr>
                        @php $l++; @endphp 
                        @endforeach
                    @endif  
                </tbody>
            </table>
        </div> --}}
        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
            <h5 class="mb-4 text-primary">
              Annexure-III (For  Point 18 & 22 of the Format)
            </h5>

            <table width="100%" class="lines">
                <thead class="table-light">
                    <tr>
                        <th style="width:5%">S.No</th>
                        <th>Case filed by</th>
                        <th>Case filed against</th>
                        <th>Section & Act</th>
                        <th>Details of issues</th>
                        <th>No. of persons arrested</th>
                        <th>Final outcome</th>
                    </tr>
                </thead>
                <tbody>
                    @php $m=1;                    
                    @endphp
                    @if(isset($annexureResult['thirdAnnexureResultQ22'])) 
                        @foreach ($annexureResult['thirdAnnexureResultQ22'] as $rowQ22 ) 
                        <tr class="row-template @if($m==1) q22-row @endif">
                            <td class="zeroborder">{{$m}}</td>
                            <td>{{isset($rowQ22['case_filed_by'])? $rowQ22['case_filed_by']:'' }}</td>
                            <td>{{isset($rowQ22['case_filed_against'])? $rowQ22['case_filed_against']:'' }}</td>
                            <td>{{isset($rowQ22['section_act_for_violation'])? $rowQ22['section_act_for_violation']:'' }}</td>
                            <td>{{isset($rowQ22['issue_details'])? $rowQ22['issue_details']:'' }}</td>
                            <td>{{isset($rowQ22['persons_arrested'])? $rowQ22['persons_arrested']:'' }}</td>
                            <td>{{isset($rowQ22['case_outcome'])? $rowQ22['case_outcome']:'' }}</td>
                        </tr>
                        @php $m++; @endphp 
                        @endforeach
                    @endif          
                </tbody>
            </table>
        </div>
    </div>
    </div>
<br/>
    <div clsss="pt-4">
      <div style="float: left">
          <p>Date: {{ isset($reportResult->final_date)? date("d-m-Y",strtotime($reportResult->final_date)):'' }}</p>
          <p>Place: {{ $reportResult->place ?? "" }} </p>
      </div>
       <div style="float: right">            
            <p>Name: {{ $reportResult->applicant_name ?? "" }}</p>
            <p> Designation: {{ $reportResult->designation ?? "" }}</p>
       </div>
        
    </div>
 </div>
</div>
</body>
</html>