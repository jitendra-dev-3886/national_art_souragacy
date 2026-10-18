@extends('layouts.clinic.clinic_master')
@section('content')
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
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                        {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="csp-clinic-heading">Reporting Format for ART Clinic (Level-I)</h3>

                    @php
                        $quarterMap = [2 => 'April - June', 3 => 'July - September', 4 => 'October - December', 1 => 'January - March'];
                    @endphp

                    <table>
                        <tr>
                            <th>Quarter and Year</th>
                            <td class="text-center-answer">{{ $quarterMap[$summary->quarter] ?? 'N/A' }} , {{ $summary->year }}</td>
                        </tr>
                        <tr>
                            <th>Name of the Clinic</th>
                            <td class="text-center-answer">{{ $summary->name_of_clinic }}</td>
                        </tr>
                        <tr>
                            <th>Clinic Registration Number</th>
                            <td class="text-center-answer">{{ $summary->clinic_level1_reg_num }}</td>
                        </tr>
                        <tr>
                            <th colspan="2">d. Total Number of Patients undergoing IUI procedure (ongoing cases)</th>
                        </tr>
                        <tr>
                            <th colspan="2">d.1 Number of Married couples</th>
                        </tr>

                        <tr>
                            <td>d.1.a Using self-gametes</td>
                            <td class="text-center-answer">{{ $summary->no_ongoing_self_gametes }}</td>
                        </tr>
                        <tr>
                            <td>d.1.b Using donor semen</td>
                            <td class="text-center-answer">{{ $summary->no_ongoing_donor_semen }}</td>
                        </tr>
                        <tr>
                            <td>(d.1.a+d.1.b) Total Married Couples</td>
                            <td class="text-center-answer">{{ $summary->no_married_couples }}</td>
                        </tr>
                        <tr>
                            <td>d.2 Single women (unmarried/widow/divorcee)</td>
                            <td class="text-center-answer">{{ $summary->no_ongoing_single_woman }}</td>
                        </tr>
                        <tr>
                            <td>Total Patients Undergoing IUI d (d.1+d.2)</td>
                            <td class="text-center-answer">{{ $summary->no_patient_IUI_onoing }}</td>
                        </tr>
                        <tr>
                            <th colspan="2">e. Total Number of Patients where IUI procedure has been completed</th>
                        </tr>
                        <tr>
                            <th colspan="2">e.1 Married couples</th>
                        </tr>
                        <tr>
                            <td>e.1.a Using self-gametes</td>
                            <td class="text-center-answer">{{ $summary->no_completed_self_gametes }}</td>
                        </tr>
                        <tr>
                            <td>e.1.b Using donor semen</td>
                            <td class="text-center-answer">{{ $summary->no_completed_donor_semen }}</td>
                        </tr>
                        <tr>
                            <td>(e.1.a+e.1.b) Total Married Couples</td>
                            <td class="text-center-answer">{{ $summary->no_married_couple }}</td>
                        </tr>
                        <tr>
                            <td>e.2 Single women (unmarried/widow/divorcee)</td>
                            <td class="text-center-answer">{{ $summary->no_completed_single_woman }}</td>
                        </tr>
                        <tr>
                            <td>Total Patients completed IUI e (e.1+e.2)</td>
                            <td class="text-center-answer">{{ $summary->no_patient_IUI_completed }}</td>
                        </tr>
                    </table>
                </div>
            </div>  
        </div>
    </div>

@endsection