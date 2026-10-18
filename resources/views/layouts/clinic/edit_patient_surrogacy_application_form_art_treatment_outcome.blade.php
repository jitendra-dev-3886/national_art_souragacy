<div class="col-md-12">
    <div class="mb-3">
        <label class="text-label form-label" for="validationCustomUsername"><strong>
                Case of
                :</strong></label>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="art_case_of" id="art_flexRadioDefault1" value="one" {{ old('art_case_of', $uhidDetails->art_case_of ?? '') === 'one' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="art_flexRadioDefault1">
                    Couple
                </label>
            </div>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="art_case_of" id="art_flexRadioDefault2" value="two" {{ old('art_case_of', $uhidDetails->art_case_of ?? '') === 'two' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="art_flexRadioDefault2"> Single Woman </label>
            </div>
        </div>
        @error('art_flexRadioDefault')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-2 displyay-none-fifty" id="art_nationality_husband">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Nationality of the Husband</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_nationality" id="art_nationality" class="form-control" aria-label="form-select-lg example" disabled>
                    <option value="" class="text-muted"><strong><b>Select</b></strong></option>
                    <option value="Indian" class="p-1" {{ old('art_nationality', $uhidDetails->art_nationality ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                    <option value="Foreigner" {{ old('art_nationality', $uhidDetails->art_nationality ?? '') == 'Foreigner' ? 'selected' : '' }}>Foreigner</option>
                </select>

            </div>
            @error('art_nationality')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 art-displyay-none-fifty " id="art_other_nationality1">
        <div class="mb-3">
            <label class="control-label"><strong>Country</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_other_nationality" id="art_other_nationality" class="form-control" disabled>
                    <option value="">-- Select Country --</option>

                    @if (!empty($countries) && $countries->count() > 0)
                    @foreach ($countries as $country)
                    <option value="{{ $country->id }}"
                    {{ old('art_other_nationality', optional($uhidDetails)->art_other_nationality) == $country->id ? 'selected' : '' }}>
                    {{ $country->country_name }}
                    </option>
                    @endforeach
                    @else
                    <option value="">No Countries Available</option>
                    @endif

            </div>
        </div>
    </div>

    <div class="col-md-2 art-displyay-none-fifty" id="art_nationality_wife1">
        <div class="mb-3">
            <label class="text-label form-label" id="art_nationality_woman_lable"
                for="nationality_wife"><strong>Nationality</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_nationality_wife" id="art_nationality_wife" class="form-control"
                    aria-label="form-select-lg example">
                    <option value="" class="text-muted">
                        <strong><b>Select</b></strong>
                    </option>
                    <option value="Indian" class="p-1" {{ old('art_nationality_wife', $uhidDetails->art_nationality_wife ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                    <option value="Foreigner" {{ old('art_nationality_wife', $uhidDetails->art_nationality_wife ?? '') == 'Foreigner' ? 'selected' : '' }}>Foreigner</option>

                </select>

            </div>
            @error('art_nationality_wife')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 art-displyay-none-fifty" id="art_other_nationality1_wife">
        <div class="mb-3">
            <label class="control-label"><strong>Country</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_other_nationality_wife" id="art_other_nationality_wife" class="form-control" disabled>
                    <option value="">-- Select Country --</option>
                  @if (!empty($countries) && $countries->count() > 0)
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ old('art_other_nationality_wife', $uhidDetails->art_other_nationality_wife ?? '') == $country->id ? 'selected' : '' }}>
                                {{ $country->country_name }}
                            </option>
                        @endforeach
                    @else
                        <option value="">No Countries Available</option>
                    @endif
                </select>

            </div>
        </div>
    </div>


    <div class="col-md-3 one art-selectt art-displyay-none-fifty" id="art_one_couple">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Husband Age</strong><span
                    class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_age_hus_wife" id="art_age_hus_wife" class="form-control"
                    aria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted"><strong><b>Select Age</b></strong> </option>
                    <?php for ($i = 26; $i <= 55; $i++) {
                        $selected = ($i == old('art_age_hus_wife', $uhidDetails->art_age_hus_wife ?? '')) ? 'selected' : '';
                        echo '<option value="' . $i . '" '.$selected.'>' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>
            @error('art_age_hus_wife')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-3 one art-selectt art-displyay-none-fifty" id="art_one_couple">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Wife Age
                </strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_wife_age" id="art_wife_age" class="form-control"
                    aria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted"><strong><b>Select Age</b></strong> </option>
                    <?php for ($i = 21; $i <= 50; $i++) {
                         $selected = ($i == old('art_wife_age', $uhidDetails->art_wife_age ?? '')) ? 'selected' : '';
                        echo '<option value="' . $i . '" '.$selected.'>' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>
            @error('art_wife_age')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-3 two art-selectt art-displyay-none-fifty" id="art_single">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Age of
                    Woman</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_age_of_women" id="art_age_of_women" class="form-control"
                    aria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted"><strong><b>Select
                                Age</b></strong>
                    </option>
                    <?php for ($i = 21; $i <= 50; $i++) {
                         $selected = ($i == old('art_age_of_women', $uhidDetails->art_age_of_women ?? '')) ? 'selected' : '';
                        echo '<option value="' . $i . '" '.$selected.'>' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>
            @error('art_age_of_women')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="border p-3 rounded">
    <label class="form-label mb-3 d-block">
        <strong>Cause of Infertility</strong> <span class="color-red-fourty-three">*</span>
    </label>

    <div class="row">
        <!-- Male Factor -->
        <div class="col-md-2" id="art_male_factor_div">
            <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                <input class="form-check-input me-2" type="checkbox" id="art_male_factor" name="art_male_factor"
                    value="Y" {{ old('art_male_factor', $uhidDetails->art_male_factor ?? '') == 'Y' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="male_factor">
                    <strong>Male Factor</strong>
                </label>
            </div>
        </div>

        <!-- Female Factor -->
        <div class="col-md-2">
            <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                <input class="form-check-input me-2" type="checkbox" id="art_female_factor" name="art_female_factor"
                    value="Y" {{ old('art_female_factor', $uhidDetails->art_female_factor ?? '') == 'Y' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="female_factor">
                    <strong>Female Factor</strong>
                </label>
            </div>
        </div>

        <!-- Unexplained -->
        <div class="col-md-2">
            <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                <input class="form-check-input me-2" type="checkbox" id="art_unexplained" name="art_unexplained"
                    value="Y" {{ old('art_unexplained', $uhidDetails->art_unexplained ?? '') == 'Y' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="unexplained">
                    <strong>Unexplained</strong>
                </label>
            </div>
        </div>

        <!-- Description of Cause -->
        <div class="col-md-12 mt-3">
            <div class="input-group mt-2">
                <input type="text" class="form-control" name="art_cause_of_infretily" id="art_cause_of_infretily"
                    aria-describedby="cause_of_infretily" placeholder="Please describe the cause of infertility..." value="{{ old('art_cause_of_infretily', $uhidDetails->art_cause_of_infretily ?? '') }}" disabled>
            </div>
            @error('art_cause_of_infretily')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-4" id="art_other">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>ART
                    Procedure Undertaken</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_proc_undertaken" id="art_proc_undertaken" class="form-control" saria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted"><strong>Select</strong> </option>
                    <option value="artificial insemination" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'artificial insemination' ? 'selected' :'' }} >Artificial insemination </option>
                    <option value="intra-uterine insemination(IUI)" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'intra-uterine insemination(IUI)' ? 'selected' :'' }}> Intra-uterine insemination(IUI)</option>
                    <option value="in vitro fertilization-embryo transfer" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'in vitro fertilization-embryo transfer' ? 'selected' :'' }}> In vitro fertilization-embryo transfer(IVF-ET) </option>
                    <option value="gamete intrafallopian tube transfer" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'gamete intrafallopian tube transfer' ? 'selected' :'' }}> Gamete intrafallopian tube transfer(GIFT) </option>
                    <option value="intra-cytoplasmic sperm injection(ICSI)" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'intra-cytoplasmic sperm injection(ICSI)' ? 'selected' :'' }}> Intra-cytoplasmic sperm injection(ICSI) </option>
                    <option value="physiological Intra-cytoplasmic sperm injection" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'physiological Intra-cytoplasmic sperm injection' ? 'selected' :'' }}>Physiological Intra-cytoplasmic sperm injection(PICSI)</option>
                    <option value="intra-cytoplasmic morphologically selected sperm injection" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'intra-cytoplasmic morphologically selected sperm injection' ? 'selected' :'' }}> Intra-cytoplasmic morphologically selected sperm injection(IMSI)</option>
                    <option value="round spermatid nucleus injection" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'round spermatid nucleus injection' ? 'selected' :'' }}> Round spermatid nucleus injection(ROSNI) </option>
                    <option value="Elongated spermatid injection" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'aElongated spermatid injection' ? 'selected' :'' }}> Elongated spermatid injection(ELSI)</option>
                    <option value="Others" class="p-1" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'Others' ? 'selected' :'' }}>others</option>
                </select>

            </div>
            @error('art_proc_undertaken')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="col-md-4 art-displyay-none-fifty art_treatment" id="art_others_id">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Others</strong></label>
            <div class="input-group">
                <input type="text" class="form-control" name="art_undertaken_other_2" id="art_undertaken_other_2"
                    aria-describedby="undertaken_other" value="{{ old('art_undertaken_other_2', $uhidDetails->art_undertaken_other_2 ?? '') }}" disabled>
            </div>
            @error('art_undertaken_other_2')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-md-4">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Type of Treatment</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_types_of_treat" id="art_types_of_treat" class="form-control" aria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted" id="art_typeOfTreat1"> <strong><b>Select</b></strong> </option>
                    <option value="ART Treatment using self gametes" class="p-1" id="art_own_gametes" {{ old('art_types_of_treat', $uhidDetails->art_types_of_treat ?? '') == 'ART Treatment using self gametes' ? 'selected' :'' }}>ART Treatment using self gametes</option>
                    <option value="ART Treatment using donor gametes" class="p-1" id="art_d_gametes" {{ old('art_types_of_treat', $uhidDetails->art_types_of_treat ?? '') == 'ART Treatment using donor gametes' ? 'selected' :'' }}> ART Treatment using donor gametes</option>
                </select>
            </div>
            @error('art_types_of_treat')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="col-md-4 art-displyay-none-fifty art_treatment" id="art_ivf_donor">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Type of Donation</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_types_of_treat1" id="art_types_of_treat1" class="form-control" aria-label=".form-select-lg example" disabled>
                    <option value="" id="art_tot1" class="text-muted"> <strong><b>Select</b></strong> </option>
                    <option value="Oocyte Donation" id="art_o_d" class="p-1" {{ old('art_types_of_treat1', $uhidDetails->art_types_of_treat1 ?? '') == 'Oocyte Donation' ? 'selected' :'' }}>Oocyte Donation </option>
                    <option value="Sperm Donation" id="art_s_d" class="p-1" {{ old('art_types_of_treat1', $uhidDetails->art_types_of_treat1 ?? '') == 'Sperm Donation' ? 'selected' :'' }}> Sperm Donation</option>
                    <option value="Both Oocyte Donation & Sperm Donation" id="art_od" class="p-1" {{ old('art_types_of_treat1', $uhidDetails->art_types_of_treat1 ?? '') == 'Both Oocyte Donation & Sperm Donation' ? 'selected' :'' }}> Both Oocyte Donation & Sperm Donation</option>
                </select>
            </div>
            @error('art_types_of_treat1')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="col-md-4" id="art_total_cycle">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Total No. of Treatment Cycle(s) Undertaken</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_total_num_of_cyc" id="art_total_num_of_cyc" class="form-control"
                    aria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted">
                        <strong><b>Select</b></strong>
                    </option>
                    <?php for ($i = 1; $i <= 20; $i++) {
                        $selected = ($i == old('art_total_num_of_cyc', $uhidDetails->art_total_num_of_cyc ?? '')) ? 'selected' : '';
                        echo '<option value="' . $i . '" '.$selected.'>' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>
            @error('art_total_num_of_cyc')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4" id="art_no_cycles1">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>No. of Cycles Cancelled (if any) </strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_no_cycles" id="art_no_cycles" class="form-control" aria-label=".form-select-lg example" data-sval="{{ old('art_no_cycles', $uhidDetails->art_no_cycles ?? '')}}" disabled>
                    <option value="" class="text-muted"> <strong><b>Select</b></strong></option>
                </select>
            </div>
            
            @error('art_no_cycles')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-7 art-displyay-none-fifty art_treatment" id="art_fail_reason">
        <div class="mb-3">
            <label class="text-label form-label" for="validationCustomUsername"><strong>Cycle
                    Cancellation reason</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control" id="art_cyc_canc_failure_reason"
                    name="art_cyc_canc_failure_reason" aria-describedby="cyc_canc_failure_reason"  value="{{ old('art_cyc_canc_failure_reason', $uhidDetails->art_cyc_canc_failure_reason ?? '') }}" disabled>
            </div>
            @error('art_cyc_canc_failure_reason')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4" id="art_">
        <div class="mb-3">
            <label class="text-label form-label" for=""><strong>Treatment
                    Outcome</strong><span class="color-red-fourty-three">*</span></label>
            <div class="input-group">
                <select name="art_treat_outcomes" id="art_treat_outcomes" class="form-control"
                    aria-label=".form-select-lg example" disabled>
                    <option value="" class="text-muted">
                        <strong><b>Select</b></strong>
                    </option>
                    <option value="Pregnant" class="p-1" {{ old('art_treat_outcomes', $uhidDetails->art_treat_outcomes ?? '') == 'Pregnant' ? 'selected' :'' }} >Pregnant</option>
                    <option value="Not Pregnant" class="p-1" {{ old('art_treat_outcomes', $uhidDetails->art_treat_outcomes ?? '') == 'Not Pregnant' ? 'selected' :'' }}>Not Pregnant
                    </option>
                </select>
            </div>
            @error('art_treat_outcomes')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="mb-3">
        <label class="text-label form-label" for="validationCustomUsername"><strong>Complications, if any</strong></label>
        <div class="input-group">
            <textarea class="form-control" name="art_complicatoins_if_any" id="art_complicatoins_if_any" aria-describedby="complicatoins_if_any" disabled>{{old('art_complicatoins_if_any',$uhidDetails->art_complicatoins_if_any ?? '')}}</textarea>
        </div>
        <span id="art_comp_if_any_id" class="color-red-fourty-three"></span>
    </div>
</div>
<div class="col-md-12">
    <div class="mb-3">
        <label class="text-label form-label" for="validationCustomUsername"><strong>Remarks/ Any other relevant information</strong></label>
        <div class="input-group">
            <textarea class="form-control" col="5" rows="3" type="text" class="form-control" name="art_remark" id="art_remark" aria-describedby="remark" disabled>{{old('art_remark',$uhidDetails->art_remark ?? '')}}</textarea>
        </div>
        <span id="art_" class="color-red-fourty-three"></span>
    </div>
</div>


<div class="col-md-12" id="declaration_both">
    <div class="mb-3">
        <label class="text-label form-label" for="validationCustomUsername"><strong>
                Required affidavit/undertaking** regarding following to be taken on record for the patient</strong></label>
        <div class="col-12" id="art_declaration_hide">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="art_declaration" name="art_declaration" {{ old('art_declaration', $uhidDetails->art_declaration ?? '') == 'on' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="gridCheck"> From Oocyte Donor that she has
                    not donated oocytes more than once in her life time.</label>
            </div>
            @error('art_declaration')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="art_declaration1" name="art_declaration1" {{ old('art_declaration1', $uhidDetails->art_declaration1 ?? '') == 'on' ? 'checked' : '' }} disabled>
                <label class="form-check-label" for="gridCheck"> From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning
                    couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more
                    than one commissioning couple. </label>
            </div>
            @error('art_declaration1')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <label class="text-label form-label" for="validationCustomUsername"><strong>
                **Note: Undertaking will be taken in retrospective cases where affidavit is not available and the case
                is prior to the operationalization of the portal. 25.03.2026</strong>
        </label>
    </div>
</div>
