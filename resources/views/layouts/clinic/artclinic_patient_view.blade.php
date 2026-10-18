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
                            <h3 class="card-title csp-clinic-text-black">View Patient information - {{ $decryptedUhid; }}</h3>
                            {{-- <a href="{{ route('clinic.clinicgeneratePdf', ['id' => Crypt::encrypt($application_num->id)]) }}"class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
                                    Download PDF
                            </a> --}}
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                               <h3 class="text-center">ART Clinic Details</h3>
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        
                                        <tr>
                                            <th colspan="2">Year - Quarter</th>
                                            <td colspan="2">{{ $patient->year }} , {{ $aq ?? '' }}</td>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $checkwomanwife = ($patient->case_of == 'one') ? 'of the Wife' : '' ;
                                            $rows = [
                                                // Applicant / Clinic Details
                                                'Name of the Clinic' => $clinic->name ?? '-',
                                                'Clinic Registration Number' => $patient->clinic_level1_reg_num ?? '-',
                                                'Had received treatment from us previously' => $patient->previous_treatment ?? '-',
                                                'Type of Case' => ($patient->case_of == 'one') ? 'Couple' : 'Single Women' ?? '-',
                                                'Nationality of the Husband' => $patient->nationality ?: null,
                                                'Country (Husband)' => $patient->husband_country_name ?? null,
                                                "Nationality $checkwomanwife" => $patient->nationality_wife ?: null,
                                                'Country (Wife)' => $patient->wife_country_name ?? null,
                                                'Age of Husband' => $patient->age_hus_wife ?? null,
                                                'Wife Age'    => $patient->wife_age ?? null,
                                                'Age of Woman' => $patient->age_of_women ?? null,
                                                'Cause of Infertility' => 
                                                                collect([
                                                                $patient->male_factor === 'Y' ? 'Male Factor' : null,
                                                                $patient->female_factor === 'Y' ? 'Female Factor' : null,
                                                                $patient->unexplained === 'Y' ? 'Unexplained' : null
                                                                ])
                                                                ->filter()
                                                                ->implode(', ') ?: '-',
                                               'Cause of Infertility Description' => $patient->cause_of_infretily ?? '-',
                                               'Date of establishment of your ART Clinic' => $clinic->date_of_establishment ?? '-',
                                            ];
                                        @endphp

                                        {{-- 🔥 SIMPLE LOOP FOR ALL NORMAL ROWS --}}
                                        @foreach ($rows as $label => $value)
                                            @if(!empty($value))
                                                <tr>
                                                    <th colspan="2">{{ $label }}</th>
                                                    <td colspan="8">{{ $value }}</td>
                                                </tr>
                                            @endif
                                        @endforeach


                                        {{-- 🔥 SECTION HEADER --}}
                                        <tr>
                                            <th colspan="8" class="csp-clinic-table-header">Detail of treatment</th>
                                        </tr>

                                        {{-- 🔥 CONTACT PERSON DETAILS LOOP --}}
                                        @php
                                            $contactRows = [
                                                'ART Procedure Undertaken' => $patient->art_proc_undertaken ?? '-',
                                                'Others' => $patient->art_undertaken_other ?? null,
                                                'Type of Treatment' => $patient->types_of_treat ?? '-',
                                                'Type of Donation' => $patient->types_of_treat1 ?? null,
                                                'Total No. of Treatment Cycle(s) Undertaken' => $patient->total_num_of_cyc ?? '-',
                                                'No. of Cycles Cancelled' => $patient->no_cycles ?? null,
                                                'Cycle Cancellation reason' => $patient->cyc_canc_failure_reason ?? null,
                                                'Treatment Outcome' => $patient->treat_outcomes ?? '-',
                                                'Pregnancy Outcome' => $patient->preganancy_outcome ?? null,
                                                'Live Birth Pregnancy' => $patient->l_birth ?? null,
                                                'Male' => $patient->male_number ?? null,
                                                'Female' => $patient->female_number ?? null,
                                                'Complication' => $patient->complicatoins_if_any ?? '-',
                                                'Remark' => $patient->remark ?? '-',
                                            ];
                                        @endphp

                                        @foreach ($contactRows as $label => $value)
                                            @if(!empty($value))
                                                <tr>
                                                    <th colspan="2">{{ $label }}</th>
                                                    <td colspan="8">{{ $value }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                @if($patient->declaration == 'on' || $patient->declaration1 == 'on')
                                  <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Declarations</th>
                                </tr>
                                @endif
                                @if($patient->declaration == 'on')
                                <tr>
                                    <th colspan="2">Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time.</th>
                                    <td colspan="6">
                                        {{ $patient->declaration == 'on' ? 'Submitted' : 'Not Submitted' }}
                                    </td>
                                </tr>
                                @endif
                                @if($patient->declaration1 == 'on')
                                <tr>
                                    <th colspan="2">Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.</th>
                                    <td colspan="6">
                                        {{ $patient->declaration1 == 'on' ? 'Submitted' : 'Not Submitted' }}
                                    </td>
                                </tr>
                                @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    
                    


                  

                </div>
            </form>
        </div>
    </div>
</div>
@endsection