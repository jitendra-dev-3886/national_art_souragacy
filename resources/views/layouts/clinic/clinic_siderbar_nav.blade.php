<!--**********************************
    Sidebar start
***********************************-->

<style nonce="{{$cspNonce}}">
    .csp-clinic-session-text {
        border-color: #0b5ed7;
        color: #0b5ed7;
    }

    .csp-clinic-nav-text {
        font-size: 15px;
    }
</style>


<div class="dlabnav">
    <div class="dlabnav-scroll">

        <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
            <div class="header-info2 align-items-center">
                <div class="align-items-center sidebar-info text-center">
                    <small class="text-end font-w500 text-dark mt-2">Welcome:</small>
                    <span class="font-w400 d-block csp-clinic-session-text">{{ session('clinicname') }}</span>
                </div>
            </div>
        </a>
        
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('clinic.clinicForm_list') }}" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('clinic.signupprofile') }}" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="nav-text">Application Form</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('clinic.add_clinic_application_form') }}">ART Clinic</a></li>
                    <li><a href="{{ route('clinic.add_surrogacy_application_form') }}">Surrogacy Clinic</a></li>
                    <li><a href="{{ route('clinic.add_bank_application_form') }}">ART Bank</a></li>                  
                </ul>
            </li>

            {{-- chang here  --}}



             
   @php
    $userId = Session::get('id');
    $clinics = \App\Models\clinic\ClinicRegistrationModel::where('userid_applicant', $userId)
                ->where('status', 1)
                ->whereIn('clinic_type', ['ARTSURROGACY', 'ARTBANK', 'ARTCLINIC'])
                ->orderByRaw("FIELD(clinic_type, 'ARTCLINIC', 'ARTSURROGACY', 'ARTBANK')")
                ->get();
    $clinicTypeLabels = [
        'ARTSURROGACY' => 'Surrogacy Clinic',
        'ARTBANK'      => 'ART Bank',
        'ARTCLINIC'    => 'ART Clinic',
    ];
     @endphp


        @if($clinics->count())
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="nav-text">Application for Renewal</span>
                </a>
                <ul aria-expanded="false">
                    @foreach($clinics as $clinic)
                        <li>
                        <li>
                            <a href="{{ route('renewal.surrogacy_renewal_applicationform', ['encryptedClinicId' => Crypt::encryptString($clinic->clinic_id)]) }}">
                                {{ $clinicTypeLabels[$clinic->clinic_type] ?? $clinic->clinic_type }}
                            </a>
                        </li>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="nav-text">Application for Change Manpower</span>
                </a>
                <ul aria-expanded="false">
                    @foreach($clinics as $clinic)
                        <li>
                        <li>
                            <a href="{{ route('manpower.change_manpower_form', ['encryptedClinicId' => Crypt::encryptString($clinic->clinic_id)]) }}">
                                {{ $clinicTypeLabels[$clinic->clinic_type] ?? $clinic->clinic_type }}
                            </a>
                        </li>
                        </li>
                    @endforeach
                </ul>
            </li>



        @endif  {{--in_array(session('id'), [2477,9117,279,3101,1586,15040,1662,653,1249,938,515,718,20057,2559,459,109,2149,997,19811,20067,8987,281])--}}


     
       

            @if(
                (session()->has('patient_artclinic_registration_no')) || //clinic_id=1034, 1103,3163,3248, 997 (for testing), 19811(for me)
                (session()->has('patient_artbank_registration_no')) ||   //clinic id=4167, 4334, 20065 (for ranvendra)
                (session()->has('patient_surrogacy_registration_no'))   //clinic_id = 5001, 5002
            )

                @php $clinic_reg = Session::get('clinic_bank_surrogacy'); @endphp 
                
                @if(!empty($clinic_reg))
                    @php 
                        $clinic = $bank = $surrogacy = $clinictwo = 0;
                        foreach($clinic_reg as $cr) {
                            if($cr == 'ARTCLINIC') $clinic = 1;
                            if($cr == 'ARTBANK') $bank = 1;
                            if($cr == 'ARTSURROGACY') $surrogacy = 1;
                        }
                    @endphp
                     <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fa fa-address-card"></i>
                            <span class="nav-text">Application Form Change of Name</span>
                        </a>
                        <ul aria-expanded="false">
                            @foreach($clinics as $clinic)
                            <li>
                                <li>
                                <a href="{{ route('clinic.change-name', ['encryptedClinicId' => Crypt::encryptString($clinic->clinic_id)]) }}">
                                {{ $clinicTypeLabels[$clinic->clinic_type] ?? $clinic->clinic_type }}
                                </a>
                                </li>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    @if($clinics->count())
                        <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card"></i>
                                <span class="nav-text">Change Address</span>
                            </a>
                            <ul aria-expanded="false">
                                @foreach($clinics as $clinic)
                                    <li>
                                    <li>
                                       <a href="{{ route('change_address.application_form', ['encryptedClinicId' => Crypt::encryptString($clinic->clinic_id)]) }}">
                                            {{ $clinicTypeLabels[$clinic->clinic_type] ?? $clinic->clinic_type }}
                                        </a>
                                    </li>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    @if($clinics->count())
                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fa fa-address-card"></i>
                            <span class="nav-text">Withdrawal Application</span>
                        </a>
                        <ul aria-expanded="false">
                            @foreach($clinics as $clinic)
                                <li>
                                <li>
                                    <a href="{{ route('withdrawal.application_form', ['encryptedClinicId' => Crypt::encryptString($clinic->clinic_id)]) }}">
                                        {{ $clinicTypeLabels[$clinic->clinic_type] ?? $clinic->clinic_type }}
                                    </a>
                                </li>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    <li>
                        <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text csp-clinic-nav-text">Reporting Clinics/Banks</span>
                        </a>
                        <ul aria-expanded="false">
                            <!-- Summary Section -->
                            {{-- <li>
                                <a class="has-arrow fw-semibold" href="javascript:void(0)" aria-expanded="false">
                                    Summary
                                </a>

                                <ul aria-expanded="false" class="list-unstyled ps-3">

                                    <!-- Entry Form -->
                                    <li>
                                        <a class="has-arrow small text-muted" href="javascript:void(0)" aria-expanded="false">
                                            Entry Form
                                        </a>

                                        <ul aria-expanded="false" class="list-unstyled ps-3">
                                            @if(session()->has('patient_artclinic_registration_no') && $clinic)
                                                @if(session('patient_artclinic_cliniclevel') == 'Level-1')                           
                                                    <li><a class="d-block py-1" href="{{ route('clinic.quarter_set_for_patient_summary',['artclinic']) }}">ART Clinic</a></li>
                                                @elseif(session('patient_artclinic_cliniclevel') == 'Level-2')                           
                                                    <li><a class="d-block py-1" href="{{ route('clinic.quarter_set_for_patient_summary',['artclinic']) }}">ART Clinic</a></li> 
                                                @endif 
                                            @endif

                                            @if(session()->has('patient_artbank_registration_no') && $bank)
                                                <li><a class="d-block py-1" href="{{ route('clinic.quarter_set_for_patient_summary',['artbank']) }}">ART Bank</a></li>
                                            @endif

                                            @if(session()->has('patient_surrogacy_registration_no') && $surrogacy)
                                                <li><a class="d-block py-1" href="{{ route('clinic.quarter_set_for_patient_summary',['artsurrogacy']) }}">Surrogacy Clinic</a></li>
                                            @endif
                                        </ul>
                                    </li>

                                    <!-- View / Update -->
                                    <li class="mt-1">
                                        <a class="has-arrow small text-muted" href="javascript:void(0)" aria-expanded="false">
                                            View / Update
                                        </a>

                                        <ul aria-expanded="false" class="list-unstyled ps-3">
                                            @if(session()->has('patient_artclinic_registration_no') && $clinic)
                                                @if(session('patient_artclinic_cliniclevel') == 'Level-1')                           
                                                    <li><a class="d-block py-1" href="{{ route('clinic.list_artclinicone_patient_quarter_view') }}">ART Clinic</a></li>
                                                @elseif(session('patient_artclinic_cliniclevel') == 'Level-2')                            
                                                    <li><a class="d-block py-1" href="{{ route('clinic.list_artclinic_patient_quarter_view') }}">ART Clinic</a></li>
                                                @endif
                                            @endif

                                            @if(session()->has('patient_artbank_registration_no') && $bank)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_artbank_patient_quarter_view') }}">ART Bank</a></li>
                                            @endif

                                            @if(session()->has('patient_surrogacy_registration_no') && $surrogacy)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_surrogacyclinic_patient_quarter_view') }}">Surrogacy Clinic</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </li> --}}

                                <!-- Detail Section -->
                            <li>
                                <a class="has-arrow fw-semibold" href="javascript:void(0)" aria-expanded="false">
                                    Patient / Donor Details
                                </a>

                                <ul aria-expanded="false" class="list-unstyled ps-3">
                                    

                                    <!-- Entry Form -->
                                    <li>
                                        <a class="has-arrow small text-muted" href="javascript:void(0)" aria-expanded="false">
                                            Entry Form
                                        </a>

                                        <ul aria-expanded="false" class="list-unstyled ps-3">
                                            @if(session()->has('patient_artclinic_registration_no') && $clinic)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_artclinic_patient') }}">ART Clinic</a></li>
                                            @endif

                                            @if(session()->has('patient_artbank_registration_no') && $bank)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_artbank_patient') }}">ART Bank</a></li>
                                            @endif

                                            @if(session()->has('patient_surrogacy_registration_no') && $surrogacy)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_surrogacyclinic_patient') }}">Surrogacy Clinic</a></li>
                                            @endif
                                        </ul>
                                    </li>

                                    <!-- View / Update -->
                                    <li class="mt-1">
                                        <a class="has-arrow small text-muted" href="javascript:void(0)" aria-expanded="false">
                                            View / Update Forms
                                        </a>

                                        <ul aria-expanded="false" class="list-unstyled ps-3">
                                            @if(session()->has('patient_artclinic_registration_no') && $clinic)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_artclinic_patient_quarter_view_patient') }}">ART Clinic</a></li>
                                            @endif

                                            @if(session()->has('patient_artbank_registration_no') && $bank)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_artbank_patient_quarter_view_patient') }}">ART Bank</a></li>
                                            @endif

                                            @if(session()->has('patient_surrogacy_registration_no') && $surrogacy)
                                                <li><a class="d-block py-1" href="{{ route('clinic.list_surrogacy_patient_quarter_view_patient') }}">Surrogacy Clinic</a></li>
                                            @endif 
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            @php
                            $userId = Session::get('id');

                            $artClinicIds = $clinics->where('clinic_type','ARTCLINIC')->pluck('clinic_id');
                            $surrogacyClinicIds = $clinics->where('clinic_type','ARTSURROGACY')->pluck('clinic_id');

                            $artClinicReport = \App\Models\patient\PatientPeriodReportingTable::where('userid',$userId)
                                                ->whereIn('clinic_id',$artClinicIds)
                                                ->where('status','Finished')
                                                ->exists();

                            $surrogacyReport = \App\Models\patient\PatientPeriodReportingTable::where('userid',$userId)
                                                ->whereIn('clinic_id',$surrogacyClinicIds)
                                                ->where('status','Finished')
                                                ->exists();
                            @endphp

                            @if($artClinicReport || $surrogacyReport)
                            <li>
                                <a class="has-arrow fw-semibold" href="javascript:void(0)">
                                    Patient Outcome Details (Part B)
                                </a>

                                <ul class="list-unstyled ps-3">

                                
                                    <li>
                                        <a class="has-arrow small text-muted" href="javascript:void(0)">
                                            Entry Form
                                        </a>

                                        <ul class="list-unstyled ps-3">

                                            @if($artClinicReport)
                                            <li>
                                                <a class="d-block py-1" href="{{ route('clinic.list_artclinic_patient_view_outcome') }}">
                                                    ART Clinic
                                                </a>
                                            </li>
                                            @endif

                                            @if($surrogacyReport)
                                            <li>
                                                <a class="d-block py-1" href="{{ route('clinic.list_surrogacy_patient_outcome_view') }}">
                                                    Surrogacy Clinic
                                                </a>
                                            </li>
                                            @endif

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            <li>
                                <a class="fw-semibold" href="{{ route('clinic.unlock.patient.report') }}" aria-expanded="false">
                                    Unlock Closed Quarter
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</div>

<!--**********************************
    Sidebar end
***********************************-->
