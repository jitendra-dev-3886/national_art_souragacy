@extends('layouts.clinic.clinic_master')
@section('content')

<div class="container-fluid">

<style nonce="{{ $cspNonce }}">
    .table tbody tr td:last-child {
        text-align: start !important;
        padding-right: 1.563rem;
    }
    .csp-clinic-text-left { text-align: left; }
    .csp-clinic-text-black { color: black; }
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
            {{-- <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title csp-clinic-text-black">
                    View Surrogacy Patient Information - {{ $decryptedUhid }}
                </h3>
            </div> --}}

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-striped verticle-middle">
                     {{-- <h3 class="text-center">Surrogacy Details</h3> --}}
                        <thead>
                            <tr>
                                <th colspan="2"> <b> Year - Quarter </b></th>
                                <td colspan="6"><b>{{ $patient->year }} , {{ $aq ?? '' }}</b></td>
                            </tr>
                        </thead>

                        <tbody>

                            @php
                            $finalRows1 = ["Name of the Clinic" => $patient->name_of_clinic ?? '-',
                                    "Clinic Registration Number" => $patient->cli_reg_name ?? '-',
                                    "Patient UHID" => $patient->pati_uhid ?? null,
                                    'Had received treatment from us previously' => $patient->previous_treatment ?? '-',
                            ];
                            @endphp
                        @if($patient->treatment_type === 'surrogacy')
                                @php
                                $checkwomanwife = ($patient->case_of == 'one') ? '(Wife)' : '' ;
                                $finalRows2 = [
                                    'Type of Case' => ($patient->case_of == 'one') ? 'Couple' : 'Single Women' ?? '-',
                                    "Nationality (Husband)" => $patient->nationality ?? null,
                                    "Country (Husband)" => $patient->husband_country_name ?? null,
                                    "Nationality $checkwomanwife" => $patient->nationality_wife ?? null,
                                    "Country (Wife)" => $patient->wife_country_name ?? null,
                                    'Husband Age' => $patient->age ?? null,
                                    'Wife Age' => $patient->wife_age ?? null,
                                    'Age of Women' => $patient->age_of_women ?? null,
                                    'Having Surviving Child' => $patient->num_pre_child ?? '-',
                                    'Details of Child' => $patient->child_give_details ?? null,
                                    'Medical Indication Necessitating Surrogacy' => 
                                                                collect([
                                                                $patient->uterus_ab === 'Y' ? 'Uterus Abnormalities' : null,
                                                                $patient->ivf_failure === 'Y' ? 'Repeated IVF failure or Recurrent implantation failure' : null,
                                                                $patient->preg_loss === 'Y' ? 'Multiple Pregnancy Loss' : null,
                                                                 $patient->life_threat === 'Y' ? 'Life threatening illness' : null,
                                                                  $patient->male_factor === 'Y' ? 'Male Factor' : null
                                                                ])
                                                                ->filter()
                                                                ->implode(', ') ?: '-',
                                        "Medical Indication Necessitating Surrogacy Description" => $patient->medical_surrogacy ?? '-',
                                        "Type of Treatment" => $patient->types_of_treat ?? '-',
                                        "Gamete Source" => $patient->types_of_treat1 ?? null,
                                        "Surrogate Mother Age" => $patient->surrogate_mother_age ?? null,
                                        "ART Procedure Undertaken" => $patient->art_undertaken ?? null,
                                        "Others" => $patient->art_undertaken_other ?? null,
                                        " Total No. of Treatment Cycle(s) Undertaken" => $patient->total_nun_cycles ?? null,
                                        "No. of Cycles Cancelled" => $patient->no_cycles,
                                        "Cycle Cancellation reason" => $patient->Cycle_fail_reason,
                                        "Treatment Outcome" => $patient->tratment_Outcome ?? '-',
                                        "Pregnancy Outcome" => $patient->preganancy_outcome ?? null, 
                                        'Live Birth Pregnancy' => $patient->l_birth ?? null,
                                        'Male' => $patient->male_number ?? null,
                                        'Female' => $patient->female_number ?? null,
                                        "Complications (if any)" => $patient->comp_if_any ?? '-',
                                        "Remarks" => $patient->remark ?? '-',
                                    ];  
                                    $finalRows = array_merge($finalRows1, $finalRows2)
                                    @endphp

                                @foreach ($finalRows as $label => $value)
                                    @if(!empty($value))
                                        <tr>
                                            <th colspan="2">{{ $label }}</th>
                                            <td colspan="6">{{ $value }}</td>
                                        </tr>
                                    @endif
                                @endforeach
    


                                @forelse($existingDocs as $key=>$val)
                                @php
                                        if ($val->doc_type == 'target_file_surrogacypatient_medicalcertificate_docs') {
                                            $documents = 'Uploaded Medical Certificate';
                                        } else {
                                            $documents = 'Medical Certificate of Child issued by District Medical Board';
                                        }

                                        $file = folderpath('surrogacy_patient_medical_docs_blade') 
                                                . $patient->clinic_id . '/' 
                                                . $val->doc_upload_ref;
                                    @endphp
                                    <tr>
                                        <th colspan="2">{{ $documents }}</th>
                                        @php 
                                            $file = folderpath('surrogacy_patient_medical_docs_blade') 
                                                    . $patient->clinic_id . '/' 
                                                    . $val->doc_upload_ref; 
                                        @endphp
                                        <td colspan="6">
                                            <a href="{{ asset($file) }}" 
                                                target="_blank" 
                                                class="btn btn-primary btn-sm">
                                                View / Download PDF
                                            </a>
                                        </td>
                                    </tr>        
                                @empty
                                @endforelse

                            {{-- ========================= --}}
                            {{-- DECLARATION SECTION --}}
                            {{-- ========================= --}}   
                      
                            <tr><th colspan="8" class="csp-clinic-table-header">Declarations</th></tr>
                            @if($patient->declaration==='on')
                                <tr>
                                    <th colspan="2"> From Surrogate mother that she has not acted as a
                                        surrogate mother more than once in her lifetime.</th>
                                    <td colspan="6">{{ $patient->declaration == 'on' ? 'Submitted' : 'Not Submitted' }}</td>
                                    
                                </tr>
                            @endif
                            @if($patient->declaration1==='on')
                                <tr>
                                    <th colspan="2">From intending
                                                    couple or single woman (widow or divorcee) that they/she
                                                    do/does not have any surviving child biologically or through
                                                    adoption or through surrogacy earlier .</th>
                                    <td colspan="6">{{ $patient->declaration1 == 'on' ? 'Submitted' : 'Not Submitted' }}</td>
                                </tr>
                            @endif
                            @if($patient->declaration3==='on')
                                <tr>
                                <th colspan="2">From Oocyte Donor that she has not donated oocytes more than once in her life time.</th>
                                <td colspan="6">{{ $patient->declaration3 == 'on' ? 'Submitted' : 'Not Submitted' }}</td>
                                </tr>
                            @endif
                            @if($patient->declaration4==='on')
                                <tr>
                                    <th colspan="2"> From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.</th>
                                    <td colspan="6">{{ $patient->declaration4 == 'on' ? 'Submitted' : 'Not Submitted' }}</td>
                                </tr>
                            @endif
                            
                           
                           
                        @elseif ($patient->treatment_type === 'art_treatment')
                                @php
                                    $checkwomanwife = ($patient->art_case_of == 'one') ? '(Wife)' : '' ;

                                   $finalRows2 = [ 'Type of Case' => ($patient->art_case_of == 'one') ? 'Couple' : 'Single Women' ?? '-',
                                                "Nationality (Husband)" => $patient->art_nationality ?? null,
                                                "Country (Husband)" => $patient->art_husband_country_name ?? null,
                                                "Nationality $checkwomanwife" => $patient->art_nationality_wife ?? null,
                                                "Country (Wife)" => $patient->art_wife_country_name ?? null,
                                                'Husband Age' => $patient->art_age_hus_wife ?? null,
                                                'Wife Age' => $patient->art_wife_age ?? null,
                                                'Age of Woman' => $patient->art_age_of_women ?? null,
                                                'Details of Child' => $patient->art_child_give_details ?? null,
                                                'Cause of Infertility' => 
                                                                            collect([
                                                                            $patient->art_male_factor === 'Y' ? 'Male Factor' : null,
                                                                            $patient->art_female_factor === 'Y' ? 'Female Factor' : null,
                                                                            $patient->art_unexplained === 'Y' ? 'Unexplained' : null
                                                                            ])
                                                                            ->filter()
                                                                            ->implode(', ') ?: '-',
                                                    "Cause of Infertility Description" =>  $patient->art_cause_of_infretily ?? '-',    
                                                    "ART Procedure Undertaken" => $patient->art_proc_undertaken ?? '-',
                                                    "Other" => $patient->art_undertaken_other_2 ?? null,
                                                    "Type of Treatment" => $patient->art_types_of_treat ?? null,
                                                    "Type of Donation" => $patient->art_types_of_treat1 ?? null,
                                                    "ART Undertaken" => $patient->art_undertaken ?? null,
                                                    "Others" => $patient->art_undertaken_other ?? null,
                                                    "Total No. of Treatment Cycle(s) Undertaken" => $patient->art_total_num_of_cyc ?? null,
                                                    "No. of Cycles Cancelled, if any" => $patient->art_no_cycles,
                                                    "Cycle Cancellation reason" => $patient->art_cyc_canc_failure_reason,
                                                    "Treatment Outcome" => $patient->art_treat_outcomes ?? '-',
                                                    "Complications, if any" => $patient->art_complicatoins_if_any ?? null, 
                                                    "Remarks/ Any other relevant information" => $patient->art_remark ?? '-',
                                        ];
                                $finalRows = array_merge($finalRows1, $finalRows2)
                                @endphp

                                @foreach ($finalRows as $label => $value)
                                @if(!empty($value))
                                    <tr>
                                        <th colspan="2">{{ $label }}</th>
                                        <td colspan="6">{{ $value }}</td>
                                    </tr>
                                @endif
                            @endforeach
                             
                                   

                            <tr><th colspan="8" class="csp-clinic-table-header">Declarations</th></tr>
                            @if($patient->art_declaration==='on')
                                <tr>
                                    
                                    <th colspan="2"> From Oocyte Donor that she has not donated oocytes more than once in her life time.</th>
                                    <td colspan="6">{{ $patient->art_declaration == 'on' ? 'Submitted' : 'Not Submitted' }}</td>
                                
                                </tr>
                            @endif
                            @if($patient->art_declaration1==='on')
                                <tr>
                                    <th colspan="2">From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.</th>
                                    <td colspan="6">{{ $patient->art_declaration1 == 'on' ? 'Submitted' : 'Not Submitted' }}</td>
                                </tr>
                            @endif
                        @endif
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
