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
        <?php //if(@$row['role_id'] == 1) {?>
        <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
            <div class="header-info2 align-items-center">
                <!--img src="images/profile/pic1.jpg" alt=""-->
                <div class="align-items-center sidebar-info text-center">

                    <small class="text-end font-w500 text-dark mt-2">Welcome:</small>
                  
                    <span class="font-w400 d-block csp-clinic-session-text">{{ session('clinicname') }}</span>



                </div>

            </div>
        </a>
        <?php //} ?>

        
        {{-- <li><a href="{{ route('noc.myapplication') }}" class="" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">My Application</span>
                </a>
        </li> --}}
        <ul class="metismenu" id="menu">
            <li><a href="{{ route('clinic.clinicForm_list') }}" class="" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <?php// if(@$row['role_id']!=5) {?>
            <li><a href="{{ route('clinic.signupprofile') }}" class="" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            {{-- <li> --}}

            
          
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                  <i class="fa fa-address-card"></i>
                  <span class="nav-text">Application Form</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <a href="{{ $isFormFilled ? route('clinic.clinic_form_view', ['id' => $clinicId]) : route('clinic.add_clinic_application_form') }}">
                        ART Clinic
                    </a> --}}
                  
                  {{-- @endphp --}}
                  <li><a href="{{ route('clinic.add_clinic_application_form') }}">ART Clinic</a></li>
                  <li><a href="{{ route('clinic.add_surrogacy_application_form') }}">Surrogacy Clinic</a></li>
                  <li><a href="{{ route('clinic.add_bank_application_form') }}">ART Bank</a></li>                  
                </ul>
               
            </li>

                        @if(
                        (session()->has('patient_artclinic_registration_no') && session()->has('id')) ||
                        (session()->has('patient_artbank_registration_no') && session()->has('id')) ||
                        (session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                        )

                        <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                              
                                <span class="nav-text csp-clinic-nav-text">Patient Reporting from Clinics</span>
                            </a>
                            <ul aria-expanded="false">
                                <!-- Summary Section -->
                                <li>
                                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Summary</a>
                                    <ul aria-expanded="false">
                                        <!-- Entry Submenu -->
                                        <li>
                                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Entry Form</a>
                                            <ul aria-expanded="false">
                                                @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                                                    @if(session('patient_artclinic_cliniclevel') == 'Level-1')                           
                                                    <li><a href="{{ route('clinic.summary_add_patient_art_application_form') }}">ART Clinic</a></li>
                                                    @elseif(session('patient_artclinic_cliniclevel') == 'Level-2')                           
                                                    <li><a href="{{ route('clinic.summary_add_patient_art_two_application_form') }}">ART Clinic</a></li>
                                                    @endif
                                                @endif
                                                @if(session()->has('patient_artbank_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.summary_add_patient_bank_application_form') }}">ART Bank</a></li>
                                                @endif
                                                @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.summary_add_patient_surrogacy_application_form') }}">Surrogacy Clinic</a></li>
                                                @endif
                                            </ul>
                                        </li>

                                        <!-- View/Update Submenu -->
                                        <li>
                                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">View/Update</a>
                                            <ul aria-expanded="false">
                                                @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                                                    @if(session('patient_artclinic_cliniclevel') == 'Level-1')                           
                                                    <li><a href="{{ route('clinic.list_artclinicone_patient_quarter_view') }}">ART Clinic</a></li>
                                                    @elseif(session('patient_artclinic_cliniclevel') == 'Level-2')                            
                                                    <li><a href="{{ route('clinic.list_artclinic_patient_quarter_view') }}">ART Clinic</a></li>
                                                    @endif
                                                @endif
                                                @if(session()->has('patient_artbank_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_artbank_patient_quarter_view') }}">ART Bank</a></li>
                                                @endif
                                                @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_surrogacyclinic_patient_quarter_view') }}">Surrogacy Clinic</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Details Section -->
                                <li>
                                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Details</a>
                                    <ul aria-expanded="false">
                                        <!-- Entry Submenu -->
                                        <li>
                                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">Entry Form</a>
                                            <ul aria-expanded="false">
                                                @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_artclinic_patient') }}">ART Clinic</a></li>
                                                @endif
                                                @if(session()->has('patient_artbank_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_artbank_patient') }}">ART Bank</a></li>
                                                @endif
                                                @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_surrogacyclinic_patient') }}">Surrogacy Clinic</a></li>
                                                @endif
                                            </ul>
                                        </li>

                                        <!-- View/Update Submenu -->
                                        <li>
                                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">View/Update</a>
                                            <ul aria-expanded="false">
                                                @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_artclinic_patient_quarter_view_patient') }}">ART Clinic</a></li>
                                                @endif
                                                @if(session()->has('patient_artbank_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_artbank_patient_quarter_view_patient') }}">ART Bank</a></li>
                                                @endif
                                                @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                                                    <li><a href="{{ route('clinic.list_surrogacy_patient_quarter_view_patient') }}">Surrogacy Clinic</a></li>
                                                @endif 
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

















                    {{-- <li>
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text" style="font-size: 15px;">Patient Reporting from Clinics</span>
                        </a>                   
                        <ul aria-expanded="false">
                            @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                            <li><a href="{{ route('clinic.list_artclinic_patient') }}">ART Clinic</a></li>
                            @endif
                            @if(session()->has('patient_artbank_registration_no') && session()->has('id'))                           
                            <li><a href="{{ route('clinic.list_artbank_patient') }}">ART Bank</a></li>
                            @endif
                            @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))                           
                            <li><a href="{{ route('clinic.list_surrogacyclinic_patient') }}">Surrogacy Clinic</a></li>
                            @endif
                        </ul>
                    </li> --}}
                    @endif




























            {{-- @if(
                (session()->has('patient_artclinic_registration_no') && session()->has('id')) ||
                (session()->has('patient_artbank_registration_no') && session()->has('id')) ||
                (session()->has('patient_surrogacy_registration_no') && session()->has('id'))
            )
                    <li>
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text" style="font-size: 15px;">Patient/Donor Form</span>
                        </a>                   
                        <ul aria-expanded="false">
                            @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                            <li><a href="{{ route('clinic.list_artclinic_patient') }}">ART Clinic</a></li>
                            @endif
                            @if(session()->has('patient_artbank_registration_no') && session()->has('id'))                           
                            <li><a href="{{ route('clinic.list_artbank_patient') }}">ART Bank</a></li>
                            @endif
                            @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))                           
                            <li><a href="{{ route('clinic.list_surrogacyclinic_patient') }}">Surrogacy Clinic</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    
                    @if(
                        (session()->has('patient_artclinic_registration_no') && session()->has('id')) ||
                        (session()->has('patient_artbank_registration_no') && session()->has('id')) ||
                        (session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                    )
                    <li>
                       
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text" style="font-size: 15px;">Summary (Patient)</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                            @if(session('patient_artclinic_cliniclevel') == 'Level-1')                           
                            <li><a href="{{ route('clinic.summary_add_patient_art_application_form') }}">ART Clinic</a></li>
                            @elseif(session('patient_artclinic_cliniclevel') == 'Level-2')                           
                            <li><a href="{{ route('clinic.summary_add_patient_art_two_application_form') }}">ART Clinic</a></li>
                            @endif
                            @endif
                            @if(session()->has('patient_artbank_registration_no') && session()->has('id'))                            
                            <li><a href="{{ route('clinic.summary_add_patient_bank_application_form') }}">ART Bank</a></li>
                            @endif
                            @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))                           
                            <li><a href="{{ route('clinic.summary_add_patient_surrogacy_application_form') }}">Surrogacy Clinic</a></li>
                            @endif
                        </ul>
                            
                           
                    </li>
                    @endif


                    @if(
                        (session()->has('patient_artclinic_registration_no') && session()->has('id')) ||
                        (session()->has('patient_artbank_registration_no') && session()->has('id')) ||
                        (session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                    )
                    <li>                       
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text" style="font-size: 15px;">View/update (summary patient forms)</span>
                        </a>
                        <ul aria-expanded="false">                         
                            @if(session()->has('patient_artclinic_registration_no') && session()->has('id'))
                            @if(session('patient_artclinic_cliniclevel') == 'Level-1')                           
                            <li><a href="{{ route('clinic.list_artclinicone_patient_quarter_view') }}">ART Clinic</a></li>
                            @elseif(session('patient_artclinic_cliniclevel') == 'Level-2')                            
                            <li><a href="{{ route('clinic.list_artclinic_patient_quarter_view') }}">ART Clinic</a></li>
                            @endif
                            @endif
                           @if(session()->has('patient_artbank_registration_no') && session()->has('id'))                           
                            <li><a href="{{ route('clinic.list_artbank_patient_quarter_view') }}">ART Bank</a></li>
                            @endif
                            @if(session()->has('patient_surrogacy_registration_no') && session()->has('id'))                            
                            <li><a href="{{ route('clinic.list_surrogacyclinic_patient_quarter_view') }}">Surrogacy Clinic</a></li>
                            @endif 
                        </ul>
                            
                           
                    </li>
                    @endif



                    @if(
                    (session()->has('patient_artclinic_registration_no') && session()->has('id')) ||
                    (session()->has('patient_artbank_registration_no') && session()->has('id')) ||
                    (session()->has('patient_surrogacy_registration_no') && session()->has('id'))
                    )
                    <li>
                       
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text" style="font-size: 15px;">View/update (Patient/Donor Form)</span>
                        </a>
                        <ul aria-expanded="false">
                            @if(session()->has('patient_artclinic_registration_no') && session()->has('id')) 
                            <li><a href="{{ route('clinic.list_artclinic_patient_quarter_view_patient') }}">ART Clinic</a></li>
                            @endif
                           
                        </ul>
                            
                           
                    </li>
                    @endif --}}








        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end