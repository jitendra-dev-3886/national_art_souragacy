<div class="row">
    <div class="col-12">

        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">

                <tr class="table-light fw-bold">
                    <th colspan="10" class="text-center">Clinic Information</th>
                </tr>
                {{-- artclinic --}}
                @if ($clinic_type == 'ARTCLINIC')
                    @if (!empty($patient->clinic_level1_reg_num))
                        <tr>
                            <th colspan="2">Clinic Registration No.</th>
                            <td colspan="8">{{ $patient->clinic_level1_reg_num ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->name_of_clinic))
                        <tr>
                            <th colspan="2">Name of Clinic</th>
                            <td colspan="8">{{ $patient->name_of_clinic ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->patient_uhid))
                        <tr>
                            <th colspan="2">Patient UHID</th>
                            <td colspan="8">{{ $patient->patient_uhid ?? '-' }}</td>
                        </tr>
                    @endif
                @endif
                {{-- ARTBANK --}}
                @if ($clinic_type == 'ARTBANK')
                    @if (!empty($patient->name_of_bank))
                        <tr>
                            <th colspan="2">Name of Bank</th>
                            <td colspan="8">{{ $patient->name_of_bank ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->bank_reg_num))
                        <tr>
                            <th colspan="2">Bank Registration No.</th>
                            <td colspan="8">{{ $patient->bank_reg_num ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->donor_id))
                        <tr>
                            <th colspan="2">Donor UHID</th>
                            <td colspan="8">{{ $patient->donor_id ?? '-' }}</td>
                        </tr>
                    @endif
                @endif
                {{-- ARTSURROGACY --}}
                @if ($clinic_type == 'ARTSURROGACY')
                    @if (!empty($patient->cli_reg_name))
                        <tr>
                            <th colspan="2">Clinic Registration No.</th>
                            <td colspan="8">{{ $patient->cli_reg_name ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->name_of_clinic))
                        <tr>
                            <th colspan="2">Name of Clinic</th>
                            <td colspan="8">{{ $patient->name_of_clinic ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->pati_uhid))
                        <tr>
                            <th colspan="2">Patient UHID</th>
                            <td colspan="8">{{ $patient->pati_uhid ?? '-' }}</td>
                        </tr>
                    @endif

                @endif




                <tr class="table-light fw-bold">
                    <th colspan="10" class="text-center">Basic Details</th>
                </tr>

                @if ($clinic_type == 'ARTCLINIC' || $clinic_type == 'ARTBANK' || $clinic_type == 'ARTSURROGACY')
          
                    <tr>
                        <th colspan="3">Quarter</th>
                        <td colspan="1">{{ $quarter ?? '-' }}</td>

                        <th>Year</th>
                        <td>{{ $patient->year ?? '-' }}</td>
                        @if (!empty($patient->case_of))
                            <th colspan="1">Case Of</th>
                            <td colspan="3">
                                {{ $patient->case_of == 'one' ? 'Couple' : 'Single Woman' }}
                            </td>
                        @endif
                        @if (!empty($patient->art_case_of))
                            <th colspan="1">Case Of</th>
                            <td colspan="3">
                                {{ $patient->art_case_of == 'one' ? 'Couple' : 'Single Woman' }}
                            </td>
                        @endif

                        @if (!empty($patient->gender_donor))
                            <th colspan="1">Gender</th>
                            <td colspan="3">
                                {{ $patient->gender_donor == 'Male' ? 'Male' : 'Female' }}
                            </td>
                        @endif
                    </tr>

                    <tr>
                        @if ($clinic_type == 'ARTBANK')
                            <th colspan="3">Already Enrolled Donor</th>
                        @else
                            <th colspan="3">Previous Treatment</th>
                        @endif
                        <td colspan="8">{{ $patient->previous_treatment ?? '-' }}</td>
                    </tr>
                @endif
                <tr class="table-light fw-bold">
                    <th colspan="10" class="text-center">Nationality & Age</th>
                </tr>

                @if ($clinic_type == 'ARTCLINIC')
                    @if (!empty($patient->nationality) || !empty($patient->nationality_wife))
                        <tr>

                            @if (!empty($patient->nationality))
                                <th colspan="2">Nationality (Husband)</th>
                                <td colspan="{{ $patient->nationality == 'Foreigner' ? 2 : 8 }}">{{ $patient->nationality }}</td>
                                @if($patient->nationality == 'Foreigner')
                                    <th colspan="2">Country</th>
                                    <td colspan="4">{{ $patient->husband_country }}</td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            @if (!empty($patient->nationality_wife))
                                @if ($patient->case_of == 'one')
                                    <th colspan="2">Nationality (Wife)</th>
                                @else
                                    <th colspan="2">Nationality</th>
                                @endif
                                <td colspan="{{ $patient->nationality == 'Foreigner' ? 2 : 8 }}">{{ $patient->nationality_wife }}</td>
                                @if(!empty($patient->nationality_wife) && $patient->nationality_wife == 'Foreigner')
                                        <th colspan="2">Country</th>
                                        <td colspan="4">{{ $patient->wife_country }}</td>
                                    @endif
                                 
                            @endif
                            
                                
                        </tr>
                    @endif
                    <tr>
                         @if (!empty($patient->age_hus_wife))
                                <th colspan="2">Husband Age</th>
                                <td colspan="2">{{ $patient->age_hus_wife ?? '-' }}</td>
                            @endif
                        @if (!empty($patient->age_of_women))
                            <th colspan="2">Age of Woman</th>
                            <td colspan="8">{{ $patient->age_of_women ?? '-' }}</td>
                        @elseif (!empty($patient->wife_age))
                            <th colspan="2">Wife Age</th>
                            <td colspan="4">{{ $patient->wife_age ?? '-' }}</td>
                        @endif
                    </tr>
                @endif

                @if ($clinic_type == 'ARTBANK')
                    <tr>
                        @if (!empty($patient->nationality))
                            <th colspan="2">Nationality</th>
                            <td colspan="{{ $patient->nationality == 'Foreigner' ? 3 : 8 }}">{{ $patient->nationality ?? '-' }}</td>
                        @endif
                        @if (!empty($patient->other_nationality))
                            <th colspan="2">Nationality</th>
                            <td colspan="3">{{ $patient->husband_country ?? '-' }}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (!empty($patient->marital_status))
                        <th colspan="2">Marital Status</th>
                        <td colspan="1">{{ $patient->marital_status ?? '-' }}</td>
                        @endif
                        @if (!empty($patient->donor_age))
                            <th colspan="2">Age</th>
                            <td colspan="1">{{ $patient->donor_age ?? '-' }}</td>
                        @endif
                        @if (!empty($patient->oocyte_age))
                            <th colspan="2">Age</th>
                            <td colspan="1">{{ $patient->oocyte_age ?? '-' }}</td> 
                        @endif
                        
                        @if (!empty($patient->gamete_details))
                            
                            @if ($patient->gender_donor == 'Female')
                                <th colspan="3">Oocyte details ( No. of Oocyte(s) stored )</th>
                            @else
                                <th colspan="3">Semen Detail (in vials)</th>
                            @endif
                            <td colspan="1">{{ $patient->gamete_details ?? '-'  }}</td>
                        @endif
                    </tr>
                @endif

                @if ($clinic_type == 'ARTSURROGACY')
                    @if (!empty($patient->art_nationality) || !empty($patient->art_nationality_wife))
                        <tr>
                            

                            @if (!empty($patient->art_nationality))
                                <th colspan="3">Nationality (Husband)</th>
                                <td colspan="{{ $patient->art_nationality == 'Foreigner' ? 2 : 7 }}">{{ $patient->art_nationality }}</td>
                                @if($patient->art_nationality == 'Foreigner')
                                    <th colspan="3">Country</th>
                                    <td colspan="2">{{ $patient->husband_country ?? '' }}</td>
                                @endif
                            @endif
                        </tr>
                            <tr>
                            @if (!empty($patient->art_nationality_wife))
                                @if ($patient->art_case_of == 'one')
                                    <th colspan="3">Nationality (Wife)</th>
                                @else
                                    <th colspan="3">Nationality</th>
                                @endif
                                <td colspan="{{ $patient->art_nationality_wife == 'Foreigner' ?  2 : 7 }}">{{ $patient->art_nationality_wife }}</td>

                                @if($patient->art_nationality_wife == 'Foreigner')
                                    <th colspan="3">Country</th>
                                    <td colspan="2">{{ $patient->wife_country }}</td>
                                @endif
                            @endif

                        </tr>
                        <tr>
                        @if($patient->art_nationality == 'Foreigner')
                            <th colspan="3">Country</th>
                            <td colspan="2">{{ $patient->husband_country ?? '' }}</td>
                            @else
                            <th colspan="3">-</th>
                            <td colspan="2">-</td>
                        @endif
                        @if($patient->art_nationality_wife == 'Foreigner')
                            <th colspan="3">Country</th>
                            <td colspan="2">{{ $patient->wife_country }}</td>
                            @else
                            <th colspan="3">-</th>
                            <td colspan="2">-</td>
                        @endif
                        </tr>
                    @endif



                    {{-- @if (!empty($patient->art_husband_country_name) || !empty($patient->art_wife_country_name))
                        <tr>

                            @if (!empty($patient->art_husband_country_name))
                                <th colspan="2">Country (Husband)</th>
                                <td>{{ $patient->art_husband_country_name }}</td>
                            @endif

                            @if (!empty($patient->art_wife_country_name))
                                <th colspan="2">Country (Wife)</th>
                                <td>{{ $patient->art_wife_country_name }}</td>
                            @endif

                        </tr>
                    @endif --}}



                    @if (!empty($patient->art_age_hus_wife) || !empty($patient->art_wife_age))
                        <tr>

                            @if (!empty($patient->art_age_hus_wife))
                                <th colspan="3">Husband Age</th>
                                <td colspan="2">{{ $patient->art_age_hus_wife }}</td>
                            @endif

                            @if (!empty($patient->art_wife_age))
                                <th colspan="3">Wife Age</th>
                                <td colspan="2">{{ $patient->art_wife_age }}</td>
                            @endif

                        </tr>
                    @endif



                    @if (!empty($patient->art_age_of_women))
                        <tr>
                            @if (!empty($patient->art_age_of_women))
                                <th colspan="2">Age of Woman</th>
                                <td>{{ $patient->art_age_of_women }}</td>
                            @endif

                        </tr>
                    @endif


                    @if (!empty($patient->nationality) || !empty($patient->nationality_wife))
                        <tr>

                            @if (!empty($patient->nationality))
                                <th colspan="2">Nationality (Husband)</th>
                                <td colspan="{{ $patient->nationality == 'OCI Card Holders' ? 2 : 8 }}">{{ $patient->nationality }}</td>
                                @if($patient->nationality == 'OCI Card Holders')
                                    <th colspan="2">Country</th>
                                    <td colspan="4">{{ $patient->husband_country }}</td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            @if (!empty($patient->nationality_wife))
                                @if ($patient->case_of == 'one')
                                    <th colspan="2">Nationality (Wife)</th>
                                @else
                                    <th colspan="2">Nationality</th>
                                @endif
                                <td colspan="{{ $patient->nationality == 'OCI Card Holders' ? 2 : 8 }}">{{ $patient->nationality_wife }}</td>
                                @if(!empty($patient->nationality_wife) && $patient->nationality_wife == 'OCI Card Holders')
                                        <th colspan="2">Country</th>
                                        <td colspan="4">{{ $patient->wife_country }}</td>
                                @endif
                                 
                            @endif
                            
                                
                        </tr>
                    @endif



                    {{-- @if (!empty($patient->husband_country_name) || !empty($patient->wife_country_name))
                        <tr>

                            @if (!empty($patient->husband_country_name))
                                <th colspan="2">Country (Husband)</th>
                                <td>{{ $patient->husband_country_name }}</td>
                            @endif

                            @if (!empty($patient->wife_country_name))
                                <th colspan="2">Country (Wife)</th>
                                <td>{{ $patient->wife_country_name }}</td>
                            @endif

                        </tr>
                    @endif --}}



                    @if (!empty($patient->age) || !empty($patient->wife_age))
                        <tr>

                            @if (!empty($patient->age))
                                <th colspan="2">Husband Age</th>
                                <td colspan="3">{{ $patient->age }}</td>
                            @endif

                            @if (!empty($patient->wife_age))
                                <th colspan="2">Wife Age</th>
                                <td colspan="3">{{ $patient->wife_age }}</td>
                            @endif

                        </tr>
                    @endif
                    @if (!empty($patient->age_of_women) || !empty($patient->num_pre_child))
                        <tr>

                            @if (!empty($patient->age_of_women))
                                <th colspan="2">Age of Women</th>
                                <td>{{ $patient->age_of_women }}</td>
                            @endif

                            @if (!empty($patient->num_pre_child))
                                <th colspan="2">Having Surviving Child</th>
                                <td>{{ $patient->num_pre_child }}</td>
                            @endif

                        </tr>
                    @endif


                    @if (!empty($patient->child_give_details))
                        <tr>
                            <th colspan="2">Details of Child</th>
                            <td colspan="4">{{ $patient->child_give_details }}</td>
                        </tr>
                    @endif
                @endif
                @if ($clinic_type == 'ARTCLINIC' || $clinic_type == 'ARTSURROGACY')
                    <tr class="table-light fw-bold">
                        <th colspan="10" class="text-center">Infertility Details</th>
                    </tr>
                @endif
                @if ($clinic_type == 'ARTCLINIC')
                    @if (!empty($patient->cause_of_infretily))
                        <tr>
                            <th colspan="2">Cause of Infertility</th>
                            <td colspan="8">{{ $patient->cause_of_infretily ?? '-' }}</td>
                        </tr>


                        <tr>
                            <th colspan="2">Male Factor</th>
                            <td>
                                @if ($patient->male_factor == 'Y')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>

                            <th>Female Factor</th>
                            <td>
                                @if ($patient->female_factor == 'Y')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>

                            <th>Unexplained</th>
                            <td>
                                @if ($patient->unexplained == 'Y')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                    @endif
                @endif
                @if ($clinic_type == 'ARTSURROGACY')
                    @if (!empty($patient->art_cause_of_infretily))

                        <tr>
                            <th colspan="2">Male Factor</th>
                            <td olspan="2">
                                @if ($patient->male_factor == 'Y')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>

                            <th colspan="2">Female Factor</th>
                            <td olspan="1">
                                @if ($patient->female_factor == 'Y')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>

                            <th colspan="2">Unexplained</th>
                            <td colspan="1">
                                @if ($patient->unexplained == 'Y')
                                    Yes
                                @else
                                    No
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">Cause of Infertility</th>
                            <td colspan="8">{{ $patient->art_cause_of_infretily ?? '-' }}</td>
                        </tr>
                    @endif


                    @if (
                        $patient->uterus_ab == 'Y' ||
                            $patient->ivf_failure == 'Y' ||
                            $patient->preg_loss == 'Y' ||
                            $patient->life_threat == 'Y' ||
                            $patient->male_factor == 'Y')
                        

                        <tr>
                            <th colspan="2">Uterus Abnormalities</th>
                            <td>
                                {{ $patient->uterus_ab == 'Y' ? 'Yes' : 'No' }}
                            </td>

                            <th colspan="2">Repeated IVF Failure</th>
                            <td>
                                {{ $patient->ivf_failure == 'Y' ? 'Yes' : 'No' }}
                            </td>

                            <th colspan="2">Multiple Pregnancy Loss</th>
                            <td>
                                {{ $patient->preg_loss == 'Y' ? 'Yes' : 'No' }}
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Life Threatening Illness</th>
                            <td>
                                {{ $patient->life_threat == 'Y' ? 'Yes' : 'No' }}
                            </td>

                            <th colspan="2">Male Factor</th>
                            <td>
                                {{ $patient->male_factor == 'Y' ? 'Yes' : 'No' }}
                            </td>

                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <th colspan="2">Medical Indication Necessitating Surrogacy</th>
                            <td colspan="8">
                                {{ $patient->medical_surrogacy ?? '-' }}
                            </td>
                        </tr>
                    @endif

                @endif

                @if ($clinic_type == 'ARTCLINIC' || $clinic_type == 'ARTSURROGACY')
                    <tr class="table-light fw-bold">
                        <th colspan="10" class="text-center">Treatment Details</th>
                    </tr>
                @endif

                @if ($clinic_type == 'ARTCLINIC')
                    @if (!empty($patient->art_proc_undertaken))
                        <tr>
                            <th colspan="2">ART Procedure Undertaken</th>
                            <td colspan="8">{{ $patient->art_undertaken ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->art_undertaken_other))
                        <tr>
                            <th colspan="2">Other Procedure</th>
                            <td colspan="8">{{ $patient->art_undertaken_other ?? '-' }}</td>
                        </tr>
                    @endif

                    @if (!empty($patient->types_of_treat))
                        <tr>
                            <th colspan="2">Type of Treatment</th>
                            <td colspan="8">{{ $patient->types_of_treat ?? '-' }}</td>
                        </tr>
                    @endif



                    @if (!empty($patient->types_of_treat1))
                        <tr>
                            <th colspan="2">Type of Treatment 1</th>
                            <td colspan="8">{{ $patient->types_of_treat1 ?? '-' }}</td>
                        </tr>
                    @endif

                    @if (!empty($patient->total_num_of_cyc))
                        <tr>
                            <th colspan="2">Total Number of Cycles</th>
                            <td colspan="8">{{ $patient->total_num_of_cyc ?? '-' }}</td>
                        </tr>
                    @endif

                    @if (!empty($patient->cyc_canc_failure_reason))
                        <tr>
                            <th colspan="2">Cycle Cancel Reason</th>
                            <td colspan="8">{{ $patient->cyc_canc_failure_reason ?? '-' }}</td>
                        </tr>
                    @endif
                @endif

                @if ($clinic_type == 'ARTSURROGACY')
                       
                    @if (!empty($patient->art_proc_undertaken))
                        <tr>
                            <th colspan="2">ART Procedure Undertaken</th>
                            <td colspan="8">{{ ucwords($patient->art_proc_undertaken) }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->art_types_of_treat))
                        <tr>
                            <th colspan="2">Type of Treatment</th>
                            <td colspan="8">{{ $patient->art_types_of_treat ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->art_types_of_treat1))
                        <tr>
                            <th colspan="2">Type of Treatment 1</th>
                            <td colspan="8">{{ $patient->art_types_of_treat1 ?? '-' }}</td>
                        </tr>
                    @endif
                    

                    @if (!empty($patient->art_total_num_of_cyc))
                        <tr>
                            <th colspan="2">Total Number of Cycles</th>
                            <td colspan="{{ !empty($patient->art_no_cycles) ? 3 : 8 }}">{{ $patient->art_total_num_of_cyc ?? '-' }}</td>
                             @if (!empty($patient->art_no_cycles))
                                <th colspan="2"> No. of Cycles Cancelled , if any</th>
                                <td colspan="3">{{ $patient->art_no_cycles ?? '-' }}</td>
                            @endif
                        </tr>
                    @endif
                   
                   
                    @if (!empty($patient->art_cyc_canc_failure_reason))
                        <tr>
                            <th colspan="2">Cycle Cancellation Reason</th>
                            <td colspan="8">{{ $patient->art_cyc_canc_failure_reason ?? '-' }}</td>
                        </tr>
                    @endif
                
                    {{-- surrogacy  start   --}}
                    @if (!empty($patient->types_of_treat))
                        <tr>
                            <th colspan="2">Type of Treatment</th>
                            <td colspan="8">{{ $patient->types_of_treat ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->types_of_treat1))
                        <tr>
                            <th colspan="2">Gamete Source</th>
                            <td colspan="8">{{ $patient->types_of_treat1 ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->surrogate_mother_age))
                        <tr>
                            <th colspan="2">Surrogate Mother Age</th>
                            <td colspan="8">{{ $patient->surrogate_mother_age ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->art_undertaken))
                        <tr>
                            <th colspan="2">ART Procedure Undertaken</th>
                            <td colspan="{{ $patient->art_undertaken == 'Others' ? 2 : 8 }}">{{ $patient->art_undertaken ?? '-' }}</td>
                            @if($patient->art_undertaken == 'Others')
                            <th colspan="2">ART Procedure Undertaken</th>
                            <td colspan="4">{{ $patient->art_undertaken_other ?? '-' }}</td>
                            @endif
                        </tr>
                    @endif


                    @if (!empty($patient->total_nun_cycles))
                        <tr>
                            <th colspan="2"> Total No. of Treatment Cycle(s) Undertaken</th>
                            <td colspan="3">{{ $patient->total_nun_cycles ?? '-' }}</td>
                             @if (!empty($patient->no_cycles))
                                <th colspan="2"> No. of Cycles Cancelled, if any </th>
                                <td colspan="3">{{ $patient->no_cycles ?? '-' }}</td>
                            @endif
                        </tr>
                    @endif
                    @if (!empty($patient->Cycle_fail_reason))
                        <tr>
                            <th colspan="2">Cycle Cancel Reason</th>
                            <td colspan="8">{{ $patient->Cycle_fail_reason ?? '-' }}</td>
                        </tr>
                    @endif
                    

            {{-- surrogacy  End   --}}
                @endif
                @if ($clinic_type == 'ARTCLINIC' || $clinic_type == 'ARTSURROGACY')
                    <tr class="table-light fw-bold">
                        <th colspan="10" class="text-center">Outcome Details</th>
                    </tr>
                @endif

                @if ($clinic_type == 'ARTCLINIC')
                    @if (!empty($patient->treat_outcomes))
                        <tr>
                            <th colspan="2">Treatment Outcome</th>
                            <td colspan="8">{{ $patient->treat_outcomes ?? '-' }}</td>
                        </tr>
                    @endif
                @endif
                @if ($clinic_type == 'ARTSURROGACY')

                    @if (!empty($patient->tratment_Outcome))
                        <tr>
                            <th colspan="2">Treatment Outcome</th>
                            <td colspan="8">{{ $patient->tratment_Outcome ?? '-' }}</td>
                        </tr>
                    @elseif (!empty($patient->art_treat_outcomes))
                        <tr>
                            <th colspan="2">ART Treatment Outcome</th>
                            <td colspan="8">{{ $patient->art_treat_outcomes ?? '-' }}</td>
                        </tr>
                    @endif

                    @if ($patient->treatment_type == 'surrogacy' && !empty($patient->doc_upload_ref))
                        <tr>
                            <th colspan="2">Uploaded Medical Certificate</th>
                            @php $file = folderpath('surrogacy_patient_medical_docs_blade') . $patient->clinic_id . '/' . $patient->doc_upload_ref; @endphp
                            <td colspan="6">

                                <button type="button" class="btn btn-primary btn-sm viewPdfBtn"
                                    data-file="{{ asset($file) }}">
                                    View / Download PDF
                                </button>

                            </td>
                        </tr>
                    @endif
                @endif





                <tr class="table-light fw-bold">
                    <th colspan="10" class="text-center">Additional Details</th>
                </tr>
                @if (!empty($patient->complicatoins_if_any))
                    <tr>
                        <th colspan="2">Complications (If Any)</th>
                        <td colspan="8">{{ $patient->complicatoins_if_any ?? '-' }}</td>
                    </tr>
                @endif

                @if (!empty($patient->comp_if_any))
                    <tr>
                        <th colspan="2">Complications (If Any)</th>
                        <td colspan="8">{{ $patient->comp_if_any ?? '-' }}</td>
                    </tr>
                @endif
                @if (!empty($patient->art_complicatoins_if_any))
                    <tr>
                        <th colspan="2">Complications (If Any)</th>
                        <td colspan="8">{{ $patient->art_complicatoins_if_any ?? '-' }}</td>
                    </tr>
                @endif
                @if(!empty($patient->remark))
                <tr>
                    <th colspan="2">Remarks</th>
                    <td colspan="8">{{ $patient->remark ?? '-' }}</td>
                </tr>
                @endif
                @if(!empty($patient->art_remark))
                <tr>
                    <th colspan="2">Remarks</th>
                    <td colspan="8">{{ $patient->art_remark ?? '-' }}</td>
                </tr>
                @endif

                @if(!empty($patient->declaration) || !empty($patient->declaration1) || !empty($patient->declaration3) || !empty($patient->declaration4) 
                || !empty($patient->art_declaration1) || !empty($patient->art_declaration2))
                <tr class="table-light fw-bold">
                    <th colspan="10" class="text-center">Required Affidavit regarding following to be taken on record:</th>
                </tr>
                @endif

                @if(!empty($patient->declaration))
                <tr>
                    @if ($clinic_type == 'ARTSURROGACY')
                        {{-- <th colspan="2">Remarks</th> --}}
                        <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From Surrogate mother that she has not acted as a surrogate mother more than once in her lifetime.</td>
                    @else
                        <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From Oocyte Donor that she has not donated oocytes more than once in her life time.</td>
                    @endif
                </tr>
                @endif
                @if(!empty($patient->declaration1))
                <tr>
                    @if ($clinic_type == 'ARTSURROGACY')
                        {{-- <th colspan="2">Remarks</th> --}}
                        <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From intending couple or single woman (widow or divorcee) that they/she do/does not 
                            have any surviving child biologically or through adoption or through surrogacy earlier .</td>
                    @else
                        {{-- <th colspan="2">Remarks</th> --}}
                        <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than 
                            one commissioning couple/single woman.</td>
                    @endif
                </tr>
                @endif
                @if(!empty($patient->art_declaration))
                <tr>
                    {{-- <th colspan="2">Remarks</th> --}}
                    <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From Oocyte Donor that she has not donated oocytes more than once in her life time.</td>
                </tr>
                @endif
                @if(!empty($patient->art_declaration1))
                <tr>
                    {{-- <th colspan="2">Remarks</th> --}}
                    <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than 
                    one commissioning couple/single woman.</td>
                </tr>
                @endif
                @if(!empty($patient->declaration3))
                <tr>
                    {{-- <th colspan="2">Remarks</th> --}}
                    <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> From Oocyte Donor that she has not donated oocytes more than once in her life time.</td>
                </tr>
                @endif
                @if(!empty($patient->declaration4))
                <tr>
                    {{-- <th colspan="2">Remarks</th> --}}
                    <td colspan="10"><i class="fa-solid fa-check" aria-hidden="true"></i> 
                        From the ART Bank that the bank has not supplied sperm/oocyte of the same 
                    donor to more than one commissioning couple/single woman or clinic and clinic has 
                    not used the sperm/oocyte of the same donor for more than one commissioning couple.</td>
                </tr>
                @endif
            </table>


        </div>
    </div>
</div>
