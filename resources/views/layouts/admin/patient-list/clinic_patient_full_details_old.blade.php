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
                            <th colspan="2">Patient UHID</th>
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
                        <td>{{ $quarter ?? '-' }}</td>

                        <th>Year</th>
                        <td>{{ $patient->year ?? '-' }}</td>
                        @if (!empty($patient->case_of))
                            <th>Case Of</th>
                            <td>
                                {{ $patient->case_of == 'one' ? 'Couple' : 'Single Woman' }}
                            </td>
                        @endif

                        @if (!empty($patient->gender_donor))
                            <th>Gender</th>
                            <td>
                                {{ $patient->gender_donor == 'male' ? 'Male' : 'Female' }}
                            </td>
                        @endif
                    </tr>

                    <tr>
                        <th colspan="3">Previous Treatment</th>
                        <td colspan="8">{{ $patient->previous_treatment ?? '-' }}</td>
                    </tr>
                @endif
                <tr class="table-light fw-bold">
                    <th colspan="10" class="text-center">Nationality & Age</th>
                </tr>

                @if ($clinic_type == 'ARTCLINIC')
                    <tr>
                        @if (!empty($patient->nationality))
                            <th colspan="3">Nationality (Husband)</th>
                            <td>{{ $patient->nationality ?? '-' }}</td>

                            @if (!empty($patient->age_hus_wife))
                                <th colspan="2">Husband of age</th>
                                <td>{{ $patient->age_hus_wife ?? '-' }}</td>
                            @else
                                <th></th>
                                <td></td>
                            @endif
                        @endif
                    </tr>


                    <tr>
                        @if (!empty($patient->age_of_women))
                            <th colspan="3">Nationality</th>
                            <td>{{ $patient->nationality_wife ?? '-' }}</td>

                            <th colspan="2">Age of Woman</th>
                            <td>{{ $patient->age_of_women ?? '-' }}</td>
                        @elseif (!empty($patient->wife_age))
                            <th colspan="3">Nationality (Wife)</th>
                            <td>{{ $patient->nationality_wife ?? '-' }}</td>

                            <th colspan="2">Wife of age</th>
                            <td>{{ $patient->wife_age ?? '-' }}</td>
                        @endif
                    </tr>
                @endif

                @if ($clinic_type == 'ARTBANK')
                    <tr>
                        @if (!empty($patient->nationality))
                            <th colspan="2">Nationality</th>
                            <td>{{ $patient->nationality ?? '-' }}</td>

                            <th colspan="2">Marital Status</th>
                            <td>{{ $patient->marital_status ?? '-' }}</td>

                            @if (!empty($patient->donor_age))
                                <th colspan="2">Age</th>
                                <td>{{ $patient->donor_age ?? '-' }}</td>
                            @endif
                        @endif
                    </tr>

                    @if (!empty($patient->oocyte_age))
                        <tr>
                            <th colspan="2">Oocyte Details</th>
                            <td colspan="6">{{ $patient->oocyte_age ?? '-' }}</td>
                        </tr>
                    @endif
                @endif

                @if ($clinic_type == 'ARTSURROGACY')


                    @if (!empty($patient->art_nationality) || !empty($patient->art_nationality_wife))
                        <tr>


                            @if (!empty($patient->art_nationality))
                                <th colspan="2">Nationality (Husband)</th>
                                <td>{{ $patient->art_nationality }}</td>
                            @endif
                            @if (!empty($patient->art_nationality_wife))
                                @if ($patient->case_of == 'one')
                                    <th colspan="2">Nationality (Wife)</th>
                                @else
                                    <th colspan="2">Nationality</th>
                                @endif

                                <td>{{ $patient->art_nationality_wife }}</td>
                            @endif

                        </tr>
                    @endif



                    @if (!empty($patient->art_husband_country_name) || !empty($patient->art_wife_country_name))
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
                    @endif



                    @if (!empty($patient->art_age_hus_wife) || !empty($patient->art_wife_age))
                        <tr>

                            @if (!empty($patient->art_age_hus_wife))
                                <th colspan="2">Husband Age</th>
                                <td>{{ $patient->art_age_hus_wife }}</td>
                            @endif

                            @if (!empty($patient->art_wife_age))
                                <th colspan="2">Wife Age</th>
                                <td>{{ $patient->art_wife_age }}</td>
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
                                <td>{{ $patient->nationality }}</td>
                            @endif


                            @if (!empty($patient->nationality_wife))
                                @if ($patient->case_of == 'one')
                                    <th colspan="2">Nationality (Wife)</th>
                                @else
                                    <th colspan="2">Nationality</th>
                                @endif

                                <td>{{ $patient->nationality_wife }}</td>
                            @endif

                        </tr>
                    @endif



                    @if (!empty($patient->husband_country_name) || !empty($patient->wife_country_name))
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
                    @endif



                    @if (!empty($patient->age) || !empty($patient->wife_age))
                        <tr>

                            @if (!empty($patient->age))
                                <th colspan="2">Husband Age</th>
                                <td>{{ $patient->age }}</td>
                            @endif

                            @if (!empty($patient->wife_age))
                                <th colspan="2">Wife Age</th>
                                <td>{{ $patient->wife_age }}</td>
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
                            <th colspan="2">Cause of Infertility</th>
                            <td colspan="8">{{ $patient->art_cause_of_infretily ?? '-' }}</td>
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


                    @if (
                        $patient->uterus_ab == 'Y' ||
                            $patient->ivf_failure == 'Y' ||
                            $patient->preg_loss == 'Y' ||
                            $patient->life_threat == 'Y' ||
                            $patient->male_factor == 'Y')
                        <tr>
                            <th colspan="2">Medical Indication Necessitating Surrogacy</th>
                            <td colspan="8">
                                {{ $patient->medical_surrogacy ?? '-' }}
                            </td>
                        </tr>

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
                            <td colspan="8">{{ $patient->art_proc_undertaken ?? '-' }}</td>
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

                    @if (!empty($patient->art_undertaken))
                        <tr>
                            <th colspan="2">ART Procedure Undertaken</th>
                            <td colspan="8">{{ $patient->art_undertaken ?? '-' }}</td>
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
                            <td colspan="8">{{ $patient->art_total_num_of_cyc ?? '-' }}</td>
                        </tr>
                    @endif
                    @if (!empty($patient->art_cyc_canc_failure_reason))
                        <tr>
                            <th colspan="2">Cycle Cancel Reason</th>
                            <td colspan="8">{{ $patient->art_cyc_canc_failure_reason ?? '-' }}</td>
                        </tr>
                    @endif
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
                <tr>
                    <th colspan="2">Remarks</th>
                    <td colspan="8">{{ $patient->remark ?? '-' }}</td>
                </tr>

                <tr>
                    <th colspan="2">Created At</th>
                    <td colspan="8">{{ $patient->created_at ?? '-' }}</td>
                </tr>

            </table>


        </div>
    </div>
</div>
