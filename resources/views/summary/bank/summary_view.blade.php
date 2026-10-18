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

                  <h3 class="csp-clinic-heading">Reporting Format for ART Bank</h3>

                    @php
                        $quarterMap = [2 => 'April - June', 3 => 'July - September', 4 => 'October - December', 1 => 'January - March'];
                    @endphp

                    <table>
        <tr>
            <th>Quarter and Year</th>
            <td class="text-center-answer">{{ $quarterMap[$summary->quarter] ?? 'N/A' }} , {{ $summary->year }}</td>
        </tr>
        <tr>
            <th>Name of the Bank</th>
            <td class="text-center-answer">{{ $summary->name_of_bank }}</td>
        </tr>
        <tr>
            <th>Bank Registration Number</th>
            <td class="text-center-answer">{{ $summary->bank_reg_num }}</td>
        </tr>
 <tr>
            <th colspan="2">d. Total number of oocyte donors screened and registered</th>
        </tr>

        <tr>
            <td>(i) Oocytes cryopreserved/stored</td>
            <td class="text-center-answer">{{ $summary->no_oocyte_cryo }}</td>
        </tr>

        <tr>
            <td>(ii) Donor oocytes supplied to ART clinic</td>
            <td class="text-center-answer">{{ $summary->no_donor_oocyte }}</td>
        </tr>

        <tr>
            <td>(iii) Donor oocytes supplied to surrogacy clinic</td>
            <td class="text-center-answer">{{ $summary->no_donor_surro }}</td>
        </tr>

        <tr>
            <th>Total (i + ii + iii)</th>
            <td class="text-center-answer">{{ $summary->no_oocyte_donors_screened }}</td>
        </tr>

        <tr>
            <th colspan="2">e. Total Number of semen donors screened & registered</th>
        </tr>

        <tr>
            <td>(i) Donor semen samples cryopreserved (vials)</td>
            <td class="text-center-answer">{{ $summary->no_donor_semen_cryo }}</td>
        </tr>

        <tr>
            <td>(ii) Patient's own semen samples cryopreserved (vials)</td>
            <td class="text-center-answer">{{ $summary->no_patient_semen_cryo }}</td>
        </tr>

        <tr>
            <td>(iii) Donor semen to ART clinic (vials)</td>
            <td class="text-center-answer">{{ $summary->no_donor_semen_art }}</td>
        </tr>

        <tr>
            <td>(iv) Donor semen to Surrogacy clinic (vials)</td>
            <td class="text-center-answer">{{ $summary->no_donor_semen_surrogacy }}</td>
        </tr>

        <tr>
            <td>(v) Patient's own semen to ART clinic (vials)</td>
            <td class="text-center-answer">{{ $summary->no_patient_semen_artclinic }}</td>
        </tr>

        <tr>
            <td>(vi) Patient's own semen to Surrogacy clinic (vials)</td>
            <td class="text-center-answer">{{ $summary->no_patient_own_semen_sclinic }}</td>
        </tr>

        <tr>
            <th>Total (i + ii + iii + iv + v + vi)</th>
            <td class="text-center-answer">{{ $summary->no_semen_donors_screened }}</td>
        </tr>
    </table>
                </div>
            </div>  
        </div>
    </div>

@endsection