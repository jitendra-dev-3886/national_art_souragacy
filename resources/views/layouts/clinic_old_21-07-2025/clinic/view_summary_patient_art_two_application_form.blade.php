
<!DOCTYPE html>
<html>
<head>
    <title>Summary (Reporting Format for ART Clinic)</title>
    <style nonce="{{$cspNonce}}">
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
        }
        th {
            text-align: left;
        }
        .text-center-answer {
        text-align: center;
        vertical-align: middle;
        }
        /* td {
            text-align: center;
        } */
 .csp-clinic-heading {
        text-align: center;
    }

    </style>
</head>
<body>
   
    <h3 class="csp-clinic-heading">Reporting Format for ART Clinic (Level-II)</h3>


    @php
        $quarterMap = [1 => 'April - June', 2 => 'July - September', 3 => 'October - December', 4 => 'January - March'];
    @endphp

    <table>
        <tr>
            <th>Quarter and Year</th>
            <td class="text-center-answer">{{ $quarterMap[$report->quarter] ?? 'N/A' }} , {{ $report->year }}</td>
        </tr>
        <tr>
            <th>Name of the Clinic</th>
            <td class="text-center-answer">{{ $report->name_of_clinic }}</td>
        </tr>
        <tr>
            <th>Clinic Registration Number</th>
            <td class="text-center-answer">{{ $report->clinic_level1_reg_num }}</td>
        </tr>
        <tr>
            <th colspan="2">d. Total Number of Patients undergoing IVF/ICSI procedure (ongoing cases)</th>
        </tr>
        <tr>
            <th colspan="2">(i) Number of Married couples</th>
        </tr>
        <tr>
            <td>(a) Using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_ongoing_self_gametes }}</td>
        </tr>
        <tr>
            <td>(b) Using donor gametes</td>
            <td class="text-center-answer">{{ $report->no_donor_gametes }}</td>
        </tr>
        <tr>
            <td>i (a+b) Number of Married couples</td>
            <td class="text-center-answer">{{ $report->no_married_couples }}</td>
        </tr>
        <tr>
            <th colspan="2">(b.i) One donor gamete</th>
        </tr>
        <tr>
            <td>(a) Donor Sperm</td>
            <td class="text-center-answer">{{ $report->no_one_donor_sperm }}</td>
        </tr>
        <tr>
            <td>(b) Donor oocyte</td>
            <td class="text-center-answer">{{ $report->no_one_donor_gamete }}</td>
        </tr>
        <tr>
            <td>b.i (a+b) One donor gamete</td>
            <td class="text-center-answer">{{ $report->no_ongoing_donor_gamete }}</td>
        </tr>
        <tr>
            <td>(b.ii) Both donor gametes</td>
            <td class="text-center-answer">{{ $report->no_ongoing_donor_bothgamete }}</td>
        </tr>
       <tr>
            <th colspan="2">(ii) Single woman (unmarried/widow/divorcee)</th>
        </tr>
         <tr>
            <td>(a) Using Donor Sperm</td>
            <td class="text-center-answer">{{ $report->no_using_donor_sperm }}</td>
        </tr>
         <tr>
            <td>(b) Using both donor gametes</td>
            <td class="text-center-answer">{{ $report->no_using_donor_gamete }}</td>
        </tr>
         <tr>
            <td>ii (a+b) Single woman (unmarried/widow/divorcee)</td>
            <td class="text-center-answer">{{ $report->no_ongoing_single_woman }}</td>
        </tr>
         <tr>
            <td>Total Number of Patients undergoing IVF/ICSI procedure (ongoing cases) (i+ii)</td>
            <td class="text-center-answer">{{ $report->no_patient_undergoing_IVF_procedure }}</td>
        </tr>
        <tr>
            <th colspan="2">e. Total Number of Patients where IVF/ICSI procedure has been completed</th>
        </tr>
         <tr>
            <th colspan="2">(i) Married couples</th>
        </tr>
         <tr>
            <td>(a) Using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_completed_self_gametes }}</td>
        </tr>
         <tr>
            <td>(a) Using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_completed_self_gametes }}</td>
        </tr>
         <tr>
            <td>(b) Using donor gametes</td>
            <td class="text-center-answer">{{ $report->no_donor_gamete }}</td>
        </tr>
         <tr>
            <td>i (a+b) Married couples</td>
            <td class="text-center-answer">{{ $report->no_married_couple }}</td>
        </tr>
         <tr>
            <th colspan="2">(b.i) One donor gamete</th>
        </tr>
         <tr>
            <td>(a) Donor Sperm</td>
            <td class="text-center-answer">{{ $report->no_one_donor_sperms }}</td>
        </tr>
         <tr>
            <td>(b) Donor oocyte</td>
            <td class="text-center-answer">{{ $report->no_one_donor_gametes }}</td>
        </tr>
         <tr>
            <td>b.i (a+b) One donor gamete</td>
            <td class="text-center-answer">{{ $report->no_completed_donor_gamete }}</td>
        </tr>
         <tr>
            <td>(b.ii) Both donor gametes</td>
            <td class="text-center-answer">{{ $report->no_completed_donor_bothgamete }}</td>
        </tr>
        <tr>
            <th colspan="2">(ii) Single woman (unmarried/widow/divorcee)</th>
        </tr>
         <tr>
            <td>(a) Using Donor Sperm</td>
            <td class="text-center-answer">{{ $report->no_using_donor_sperms }}</td>
        </tr>
         <tr>
            <td>(b) Using both donor gametes</td>
            <td class="text-center-answer">{{ $report->no_using_donor_gametes }}</td>
        </tr>
         <tr>
            <td>ii (a+b) Single woman (unmarried/widow/divorcee)</td>
            <td class="text-center-answer">{{ $report->no_completed_single_woman }}</td>
        </tr>
         <tr>
            <td>Total Number of Patients where IVF/ICSI procedure has been completed (i+ii)</td>
            <td class="text-center-answer">{{ $report->no_patient_undergoing_IVF_procedure_completed }}</td>
        </tr>
         <tr>
            <td>f. Number of surgical retrievals of semen done</td>
            <td class="text-center-answer">{{ $report->no_surgical_semen_completed }}</td>
        </tr>
          <tr>
            <th colspan="2">g. Number of oocyte retrievals done</th>
        </tr>
         <tr>
            <td>(i) oocyte donor</td>
            <td class="text-center-answer">{{ $report->no_oocyte_donor }}</td>
        </tr>
         <tr>
            <td>(ii) Self oocytes of patient</td>
            <td class="text-center-answer">{{ $report->no_self_oocyte_patient }}</td>
        </tr>
         <tr>
            <td>Total number of oocyte retrievals done. g(i+ii)</td>
            <td class="text-center-answer">{{ $report->no_oocyte_retrievals_done }}</td>
        </tr>
         <tr>
            <th colspan="2">h. Number of embryos cryopreserved</th>
        </tr>
         <tr>
            <td>(i) created using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_created_self_gametes }}</td>
        </tr>
         <tr>
            <th colspan="2">(ii) created using one donor gamete</th>
        </tr>
         <tr>
            <td>(a) Donor Sperm</td>
            <td class="text-center-answer">{{ $report->no_donor_sperm }}</td>
        </tr>
         <tr>
            <td>(b) Donor Oocyte</td>
            <td class="text-center-answer">{{ $report->no_donor_oocyte }}</td>
        </tr>
        <tr>
            <td>ii (a+b) created using one donor gamete</td>
            <td class="text-center-answer">{{ $report->no_created_one_donor_gamete }}</td>
        </tr>
        <tr>
            <td>(iii) created using both donor gametes</td>
            <td class="text-center-answer">{{ $report->no_created_both_donor_gamete }}</td>
        </tr>
         <tr>
            <td>Total number of embryos cryopreserved. (i+ii+iii)</td>
            <td class="text-center-answer">{{ $report->no_embryos_cryopreserved }}</td>
        </tr>
         <tr>
            <td>i. Number of Patient sperm cryopreserved (in vials)</td>
            <td class="text-center-answer">{{ $report->no_patient_sperm_cryo }}</td>
        </tr>
         <tr>
            <td>j. Number of patient oocytes cryopreserved</td>
            <td class="text-center-answer">{{ $report->no_patient_oocyte_cryo }}</td>
        </tr>
         <tr>
            <td>k. Number of donor sperm cryopreserved (in vials)</td>
            <td class="text-center-answer">{{ $report->no_donor_sperm_cryo }}</td>
        </tr>
         <tr>
            <td>l. Number of donor oocytes cryopreserved</td>
            <td class="text-center-answer">{{ $report->no_donor_oocyte_cryo }}</td>
        </tr>
    </table>
</body>
</html>