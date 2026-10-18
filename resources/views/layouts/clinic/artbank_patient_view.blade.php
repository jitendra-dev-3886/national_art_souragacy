@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container-fluid">   
    <style nonce="{{$cspNonce}}">
    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
   
    .csp-clinic-text-left {
        text-align: left;
    }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-btn-blue {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-table-header {
        background-color: #d3d8fd;
        text-align: center;
    }
</style>


    <div class="row">
    <div class="col-12">

        <div class="card csp-clinic-text-left">

            <div class="col-lg-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title csp-clinic-text-black">
                        View ART Bank Information - {{ $decryptedUhid }}
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                    <h3 class="text-center">ART Bank Details</h3>
                        <table class="table table-bordered table-striped verticle-middle table-responsive-sm">

                            <thead>
                                <tr>
                                    <th colspan="2">Year - Quarter</th>
                                    <td colspan="6">{{ $patient->year }} , {{ $aq ?? '' }}</td>
                                </tr>
                            </thead>

                            <tbody>

                                @php
                                    $rows = [
                                        "Bank Registration Number" => $patient->bank_reg_num ?? '-',
                                        "Name of Bank"             => $patient->name_of_bank ?? '-',
                                         'Already enrolled Donor' => $patient->previous_treatment ?? '-',
                                        "Donor UHID"               => $patient->donor_id ?? '-',
                                        "Gender"                   => $patient->gender_donor ?? '-',
                                        "Donor Age"                => $patient->donor_age ?? '-',
                                        "Oocyte Donor Age"         => $patient->oocyte_age ?? '-',
                                        "Marital Status"           => $patient->marital_status ?? '-',
                                        "Nationality"              => $patient->nationality ?? '-',
                                        "Other Nationality"        => $patient->other_nationality ? ($countries->find($patient->other_nationality)->country_name ?? '-') : "-",
                                        (($patient->gender_donor ?? '') == 'Male'
                                        ? 'No Semen (in vials) Stored'
                                        : 'No Oocyte(s) Stored')
                                        => $patient->no_oocyte_semen_stored ? 'True' : 'False',

                                        (($patient->gender_donor ?? '') == 'Male'
                                        ? 'Gamete Details (No. of Semen Vials Stored)'
                                        : 'Gamete Details (No. of Oocytes Stored)')
                                        => $patient->gamete_details ?? '-',
                                       
                                    ];
                                @endphp

                                @foreach ($rows as $label => $value)
                                    <tr>
                                        <th colspan="2">{{ $label }}</th>
                                        <td colspan="8">{{ $value }}</td>
                                    </tr>
                                @endforeach

                                @php
                                    $textRows = [
                                        "Complications (if any)" => $patient->complicatoins_if_any ?? '-',
                                        "Remarks"                => $patient->remark ?? '-',
                                    ];
                                @endphp

                                @foreach ($textRows as $label => $value)
                                    @if(!empty($value))
                                        <tr>
                                            <th colspan="2">{{ $label }}</th>
                                            <td colspan="8">{{ $value }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Declarations</th>
                                </tr>

                                <tr>
                                    <th colspan="2">Please click that affidavit/undertaking** has been taken on record from oocyte donor that she has not donated oocytes more than once in her lifetime.</th>
                                    <td colspan="6">
                                        {{ $patient->declaration == 'on' ? 'Submitted' : 'Not Submitted' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Please click on the undertaking that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic.</th>
                                    <td colspan="6">
                                        {{ $patient->declaration1 == 'on' ? 'Submitted' : 'Not Submitted' }}
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

</div>
@endsection