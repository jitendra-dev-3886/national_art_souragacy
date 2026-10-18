Sidebar start
***********************************-->

@php
    use App\Models\renewal\RenewalSCApplication;
    use App\Models\ChangeAddress\ChangeAddressApplication;

    use App\Models\clinic\ClinicWithdrawal;
    use App\Models\clinic\ClinicRevocation;
    use App\Models\clinic\ClinicRegistrationModel;



    use App\Models\ChangeManpower\ChangeManpowerApplication;

    $stateName = session('state_name');

    // Fetch clinic types from both tables (distinct to avoid duplicates)
    $renewalClinics = RenewalSCApplication::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $changeAddressClinics = ChangeAddressApplication::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $withdrawalClinics = ClinicWithdrawal::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $changeManpowserClinics = ChangeManpowerApplication::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $clinicForSuspension = ClinicRegistrationModel::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $clinicForRevocation = ClinicRevocation::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $clinicsWithData = array_unique(array_merge($renewalClinics, $changeAddressClinics,$changeManpowserClinics, $clinicForSuspension, $clinicForRevocation));

    // Static clinic map (define once)
    $clinics = [
        'ARTCLINIC' => 'ART Clinic',
        'ARTBANK' => 'ART Bank',
        'ARTSURROGACY' => 'Clinic Surrogacy',
    ];
@endphp

<style nonce="{{ $cspNonce }}">
    .csp-admin-state-session {
        border-color: #0b5ed7;
        color: #0b5ed7;
    }
</style>
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <?php //if(@$row['role_id'] == 1) {
        ?>
        <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
            <div class="header-info2 align-items-center">
                <!--img src="images/profile/pic1.jpg" alt=""-->
                <div class="align-items-center sidebar-info text-center">

                    <small class="text-end font-w500 text-dark mt-2">Welcome:</small>
                    <span class="font-w400 d-block csp-admin-state-session">{{ session('state_name') }}</span>



                </div>

            </div>
        </a>
        <?php //}
        ?>
        <ul class="metismenu" id="menu">
            <li><a href="{{ route('ssa.dashboard') }}" class="" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

           
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">Reg. Details</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href=" {{ route('admin.reg_ssaForm_list') }}">ART Clinic (View/upload)</a></li>
                    <li><a href="{{ route('admin.bank_reg_ssaForm_list') }}">ART Bank (View/upload)</a></li>
                    <li><a href="{{ route('admin.surrogacy_reg_ssaForm_list') }}">Surrogacy Clinic (View/upload)</a>
                    </li>
                    {{-- <li><a href="{{ route('admin.artimportdata') }}">art-Clinic</a></li> --}}
                    {{-- <li><a href="{{ route('admin.surrogacyimportdata') }}">art-Surrogacy-Clinic</a></li> --}}
                    {{-- <li><a href="{{ route('admin.artbankimportdata') }}">art-Clinic-bank</a></li>  --}}
                </ul>

            </li>

            @if (!empty($clinicsWithData))
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Renewal</span></a>
                    <ul aria-expanded="false">
                        @foreach ($clinics as $key => $label)
                            @if (in_array($key, $clinicsWithData))
                                <li>
                                    <a href="{{ route('registration.clinic-list', Crypt::encryptString($key)) }}">
                                        {{ $label }} (View/Upload)
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif

            @php
                $changeNames = [
                    'ARTCLINIC' => 'ARTCLINIC',
                   
                ];
               
            @endphp

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="nav-text">Change of Name</span>
                </a>

                <ul aria-expanded="false">

                    @foreach ($changeNames as $key => $label)
                     @if (in_array($key, $changeNames))
                               
                                 <li>
                            <a href="{{ route('admin.change_name', Crypt::encryptString($key)) }}">
                              Application Change
                            </a>
                        </li>
                            @endif
                       
                    @endforeach
                </ul>
            </li>
            <!-- Change address -->
            @if(!empty($clinicsWithData))
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Change Address</span></a>
                    <ul aria-expanded="false">
                            @if (in_array($key, $clinicsWithData))
                                <li>
                                    <a
                                        href="{{ route('change_address.registration.clinic_list', Crypt::encryptString($key)) }}">
                                        Applications
                                    </a>
                                </li>
                            @endif
                    </ul>
                </li>
            @endif
             @if(!empty($clinicsWithData))
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Change Manpower</span></a>
                    <ul aria-expanded="false">
                        @foreach ($clinics as $key => $label)
                            @if(in_array($key, $clinicsWithData))
                                <li>
                                    <a href="{{ route('change_manpower.clinic_list', Crypt::encryptString($key)) }}">
                                        {{ $label }} (View/Upload)
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif

            @if(!empty($clinicsWithData))
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Withdrawal</span></a>
                    <ul aria-expanded="false">
                            @if(in_array($key, $clinicsWithData))
                                <li>
                                    <a href="{{ route('withdrawal.sa.clinic_list', Crypt::encryptString($key)) }}">
                                        Applications
                                    </a>
                                </li>
                            @endif
                    </ul>
                </li>
            @endif 

            <!-- Suspension -->
            @if(!empty($clinicsWithData))
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Suspension</span></a>
                    <ul aria-expanded="false">
                            @if(in_array($key, $clinicsWithData))
                                <li>
                                    <a href="{{ route('suspension.sa.clinic_list', Crypt::encryptString($key)) }}">
                                        Applications
                                    </a>
                                </li>
                            @endif
                    </ul>
                </li>
            @endif 

            <!-- Suspension -->

            @if(!empty($clinicsWithData))
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Revocation</span></a>
                    <ul aria-expanded="false">
                            @if(in_array($key, $clinicsWithData))
                                <li>
                                    <a href="{{ route('revocation.sa.clinic_list', Crypt::encryptString($key)) }}">
                                        Applications
                                    </a>
                                </li>
                            @endif
                    </ul>
                </li>
            @endif

            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Archive Panel</span>
                </a>
                <ul aria-expanded="false">
                   {{-- <li><a href="{{ route('admin.art_clinic') }}">Art Clinic</a></li>
                    <li><a href="{{ route('admin.art_bank') }}">Art Bank</a></li>
                    <li><a href="{{ route('admin.surrogacy_details_view') }}">Art Surrogacy</a></li>  --}}
                    <li><a href="{{ route('admin.archived_apps') }}">List of Archive</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Clinic Access change</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('clinic.email_change') }}">Email Change</a></li>
                    <li><a href="{{ route('clinic.access.changelist') }}">Email Change Requests</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Quarterly Report</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('report.Quarterlyreport') }}">Quarterly Report Form</a></li>
                    <li><a href="{{ route('report.QuarterlyreportList', ['flagid' => 2]) }}">Quarterly Report View</a>
                    </li>
                    <!--Coded by manoj-->
                    <li><a href="{{ route('report.surrogacyArtClinic') }}">Detail Reports ART Clinic for Surrogacy</a>
                    </li>
                </ul>
            </li>
            <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Patient Reports</span>
                    </a>
                    <ul aria-expanded="false">
                        {{-- <li>
                            <a class="has-arrow" href="{{ route('admin.dynamic.reporting') }}" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Detail Reports Dashboard</span>
                            </a>
                        </li> --}}
                         <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Reports</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('report.clinicReportOneForm') }}">Detail Reports ART (Level 1)</a></li>
                                <li><a href="{{ route('report.clinicReportLevelTwoForm') }}">Detail Reports ART (Level 2)</a></li>
                                <li><a href="{{ route('report.bankClinicReport') }}">Detail Reports ART Bank</a></li>
                                <li><a href="{{ route('report.surrogacyClinicReport') }}">Detail Reports Surrogacy Clinic</a></li>
                                <li><a href="{{ route('report.surrogacyArtClinic') }}">Detail Reports ART Treatment for Surrogacy Clinic</a></li>
                                
                            </ul>
                        </li>
                    
                        <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Reports Clinic-wise</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('admin.clinic_patient_list', ['type' => 'artclinic']) }}">ART Clinic</a></li>
                                <li><a href="{{ route('admin.clinic_patient_list', ['type' => 'artbank']) }}">ART Bank</a></li>
                                <li><a href="{{ route('admin.clinic_patient_list', ['type' => 'artsurrogacy']) }}">Surrogacy Clinic</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrowd" href="{{ route('admin.patient_detail_consolidated') }}" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Filling status</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a class="has-arrow" href="{{ route('reports.daily.snapshot') }}" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">View Daily Reporting</span>
                            </a>
                        </li> --}}
                    </ul>
                </li> 
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Reports</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="{{ route('admin.art_clinic_request') }}">Art Clinic</a></li>
                    <li><a href="{{ route('admin.art_bank_request') }}">Art Bank</a></li> --}}
                    <li><a href="{{ route('admin.monthly_report') }}">Summary of Clinic</a></li>
                    <li><a href="{{ route('admin.state_wise_report') }}">State Wise Report</a></li>
                    <li><a href="{{ route('admin.view_applications') }}">view applications</a></li>                       
                    {{-- <li><a href="{{route('report.QuarterlyreportList', ['flagid' =>1]) }}">Comprehensive Quarterly Report</a></li>
                    <li><a href="{{route('report.ConsolidatedQuarterlyReport') }}">Consolidated Comprehensive Quarterly Report</a></li>  --}}
                </ul>
            </li>
            



            {{-- @if ($settings['role'] == 4 || $settings['role'] == 5 || $settings['role'] == 7)
                <li><a href="{{ route('admin.noc_details') }}" class="" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Pendancy</span>
                    </a>
                </li> --}}

            {{-- <li><a href="{{ route('admin.arc_details') }}" class="" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Archived Details</span>
                    </a>
                </li> --}}

            {{-- <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Archived Details</span>
                </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.art_clinic') }}">Art Clinic</a></li>
                        <li><a href="{{ route('admin.art_clinic_detail') }}">Art Bank</a></li>
                        <li><a href="{{ route('admin.surrogacy_details_view') }}">Art Surrogacy</a></li>
                    </ul>

               </li> --}}

            {{-- <li><a href="{{ route('admin.art_clinic_detail') }}" class="" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Art Clinic Bank</span>
                    </a>
                </li>

                <li><a href="{{ route('admin.surrogacy_details_view') }}" class="" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">Surrogacy Clinic</span>
                </a>
            </li> --}}
            {{-- @endif
            --}}

            {{-- <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">User</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="add_user.php">Add User</a></li>
                    <li><a href="user_list.php">Total User</a></li>
                </ul>

            </li>  --}}
            {{-- @if ($settings['role'] == 3)
                <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-text">User (NOC)</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.add_user') }}">Add User</a></li>
                        <li><a href="{{ route('admin.user_list') }}">Total User</a></li>
                    </ul>

                </li>

                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-text">User (Role)</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.add_user_role') }}">Add User Role</a></li>
                        <li><a href="{{ route('admin.add_user_role_access') }}">Assign Role</a></li>
                        <li><a href="{{ route('admin.user_list_noc_role') }}">Total User Role</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-text">Services</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.add_service') }}">Add Service</a></li>
                        <li><a href="{{ route('admin.assign_service') }}">Assign service </a></li>
                        <li><a href="{{ route('admin.list_service_approval') }}">Send for Approval</a></li>
                    </ul>

                </li>
            @endif
            @if ($settings['role'] == 6)
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-text">Services</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.list_accept_approval') }}">Total Assign service</a></li>
                    </ul>
                </li>
            @endif --}}



            {{-- <li class="treeview">  
                <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">NOC Details</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="noc/noc_details.php">NOC Details</a></li>
                    <li><a href="noc/pending_noc_details.php">Pending NOC Details</a></li>
                    <li><a href="noc/assign_noc_user_list.php">Assign NOC ALL Users List</a></li>
                    <li><a href="noc/assign_noc_single_user.php">Assign NOC User List</a></li>

                </ul>

                </li>                   
            </li> --}}

        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
