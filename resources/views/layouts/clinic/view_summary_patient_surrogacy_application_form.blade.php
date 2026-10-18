
<!DOCTYPE html>
<html>
<head>
    <title>Summary (Reporting Format for Surrogacy Clinic)</title>
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
   
    <h3 class="csp-clinic-heading">Reporting Format for Surrogacy Clinic</h3>

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
            <td class="text-center-answer">{{ $report->cli_reg_name }}</td>
        </tr>
        <tr>
            <th colspan="2">d. Total number patients undergoing/undergone surrogacy procedure</th>
        </tr>
        <tr>
            <td>(i) Number of Indian Nationals</td>
            <td class="text-center-answer">{{ $report->no_indian_nationals }}</td>
        </tr>
        <tr>
            <td>(ii) Number of Foreign Nationals (OCI cardholders)</td>
            <td class="text-center-answer">{{ $report->no_foreign_nationals }}</td>
        </tr>
        <tr>
            <td>Total number patients undergoing/undergone surrogacy procedure (i+ii)</td>
            <td class="text-center-answer">{{ $report->no_patient_undergoing_procedure }}</td>
        </tr>
        <tr>
            <th colspan="2">e. Number of Patients where Surrogacy procedure is ongoing</th>
        </tr>
        <tr>
            <th colspan="2">e.1 Number of Married couples</th>
        </tr>
        <tr>
            <td>e.1.a Using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_ongoing_self_gametes }}</td>
        </tr>
        <tr>
            <td>e.1.b Using self-oocytes and donor semen</td>
            <td class="text-center-answer">{{ $report->no_ongoing_oocytes_donor_semen }}</td>
        </tr>
        <tr>
            <td>e.1.c Using self-semen and donor oocytes</td>
            <td class="text-center-answer">{{ $report->no_ongoing_semen_donor_oocytes }}</td>
        </tr>
        <tr>
            <td>e.1 (a+b+c) Total Married Couples</td>
            <td class="text-center-answer">{{ $report->no_married_couples }}</td>
        </tr>
         <tr>
            <td>e.2 Number of Single woman (widow/divorcee)</td>
            <td class="text-center-answer">{{ $report->no_ongoing_single_woman }}</td>
        </tr>
         <tr>
            <td>Total number of Patients where Surrogacy procedure is ongoing (e.1+e.2)</td>
            <td class="text-center-answer">{{ $report->no_patient_surrogacy_ongoing }}</td>
        </tr>
        <tr>
            <th colspan="2">f. Number of Patients where Surrogacy procedure has been completed</th>
        </tr>
        <tr>
            <th colspan="2">f.1 Number of Married couples</th>
        </tr>
        <tr>
            <td>f.1.a Using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_completed_self_gametes }}</td>
        </tr>
         <tr>
            <td>f.1.b Using self-oocytes and donor semen</td>
            <td class="text-center-answer">{{ $report->no_completed_oocytes_donor_semen }}</td>
        </tr>
         <tr>
            <td>f.1.c Using self-semen and donor oocytes</td>
            <td class="text-center-answer">{{ $report->no_completed_semen_donor_oocytes }}</td>
        </tr>
         <tr>
            <td>f.1 (a+b+c) Number of Married couples</td>
            <td class="text-center-answer">{{ $report->no_married_couple }}</td>
        </tr>
         <tr>
            <td>f.2 Number of Single woman (widow/divorcee)</td>
            <td class="text-center-answer">{{ $report->no_completed_single_woman }}</td>
        </tr>
         <tr>
            <td>Total number of Patients where Surrogacy procedure has been completed (f.1+f2)</td>
            <td class="text-center-answer">{{ $report->no_patient_surrogacy_completed }}</td>
        </tr>
        <tr>
            <th colspan="2">g. Total number of surrogate Mothers</th>
        </tr>
         <tr>
            <td>(i) Number of surrogate mothers (ongoing cases)</td>
            <td class="text-center-answer">{{ $report->no_surrogate_mother_ongoing }}</td>
        </tr>
         <tr>
            <td>(ii) Number of surrogate mothers (completed cases)</td>
            <td class="text-center-answer">{{ $report->no_surrogate_mother_completed }}</td>
        </tr>
         <tr>
            <td>Total number of surrogate Mothers (i+ii)</td>
            <td class="text-center-answer">{{ $report->no_surrogate_mothers }}</td>
        </tr>
         <tr>
            <td>h. Number of surgical retrivals of semen done</td>
            <td class="text-center-answer">{{ $report->no_surgical_retrival_done }}</td>
        </tr>
         <tr>
            <th colspan="2">i. Number of oocyte retrievals done</th>
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
            <td>Number of oocyte retrievals (i+ii)</td>
            <td class="text-center-answer">{{ $report->no_oocyte_retrievals }}</td>
        </tr>
         <tr>
            <td>j. Number of patient semen cryopreserved (in vials)</td>
            <td class="text-center-answer">{{ $report->no_patient_semen_cryopreserved }}</td>
        </tr>
         <tr>
            <td>k. Number of patient oocytes cryopreserved</td>
            <td class="text-center-answer">{{ $report->no_patient_oocyte_cryopreserved }}</td>
        </tr>
        <tr>
            <td>l. Number of donor sperm cryopreserved (in vials)</td>
            <td class="text-center-answer">{{ $report->no_donor_sperm_cryopreserved }}</td>
        </tr>
        <tr>
            <td>m. Number of donor oocyte cryopreserved</td>
            <td class="text-center-answer">{{ $report->no_donor_oocyte_cryopreserved }}</td>
        </tr>
         <tr>
            <th colspan="2">n. Number of embryos cryopreserved</th>
        </tr>
         <tr>
            <td>n.1 created using self-gametes</td>
            <td class="text-center-answer">{{ $report->no_created_using_self_gametes }}</td>
        </tr>
         <tr>
            <th colspan="2">n.2 created using one donor gamete</th>
        </tr>


         <tr>
            <td>n.2.a Donor Sperm</td>
            <td class="text-center-answer">{{ $report->no_donor_sperm }}</td>
        </tr>
         <tr>
            <td>n.2.b Donor oocyte</td>
            <td class="text-center-answer">{{ $report->no_donor_oocyte }}</td>
        </tr>
        <tr>
            <td>n.2 (a+b)Total created using one donor gamete</td>
            <td class="text-center-answer">{{ $report->no_created_using_one_donor_gamete }}</td>
        </tr>
        <tr>
            <td>n.3 created using both donor gametes</td>
            <td class="text-center-answer">{{ $report->no_created_using_both_donor_gamete }}</td>
        </tr>
         <tr>
            <td>Total Number of embryos cryopreserved. n (1+2+3)</td>
            <td class="text-center-answer">{{ $report->no_embryos_cryopreserved }}</td>
        </tr>
    </table>
</body>
</html>