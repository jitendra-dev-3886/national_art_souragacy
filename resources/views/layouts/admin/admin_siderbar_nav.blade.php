<!-- Sidebar start -->
<!-- *********************************** -->


<div class="dlabnav">
    <div class="dlabnav-scroll">
       
        <ul class="metismenu" id="menu">
            <li><a href="{{ route('dashboard') }}" class="" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li><a href="{{ route('admin.adminprofile') }}" class="" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            
            @if ($settings['role'] == 4 || $settings['role'] == 5 || $settings['role'] == 7)
                {{-- <li><a href="{{route('report.ConsolidatedQuarterlyReport') }}">Consolidated Comprehensive Quarterly Report</a></li> --}}
                <li><a href="{{ route('admin.noc_details') }}" class="" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Noc Pendency</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('admin.doe_estb') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">DoE Correction</span></a>
                </li> --}}
                 {{-- <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Reports</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('report.clinicReportOneForm') }}">Detail Reports ART (Level 1)</a></li>
                                <li><a href="{{ route('report.clinicReportLevelTwoForm') }}">Detail Reports ART (Level 2)</a></li>
                                <li><a href="{{ route('report.bankClinicReport') }}">Detail Reports ART Bank</a></li>
                                <li><a href="{{ route('report.surrogacyClinicReport') }}">Detail Reports ART Surrogacy</a></li>
                                <!--Coded by manoj-->
                                <li><a href="{{ route('report.surrogacyArtClinic') }}">Detail Reports ART Treatment for Surrogacy Clinic</a></li>
                            </ul>
                        </li>  --}}
                        {{-- <li><a href="{{route('report.ConsolidatedQuarterlyReport') }}">Consolidated Comprehensive Quarterly Report</a></li> --}}
            @endif                      
             
            @if ($settings['role'] == 4)
                {{-- <li><a href="{{ route('admin.pendency_report') }}" class="" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text">Pendency Report</span>
                        </a>
                </li> --}}
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
                            <a class="has-arrow" href="{{ route('admin.patient_detail_consolidated') }}" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Filling status</span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow" href="{{ route('reports.daily.snapshot') }}" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">View Daily Reporting</span>
                            </a>
                        </li>
                    </ul>
                </li> 
                {{-- <li><a href="{{ route('admin.accesschangelist') }}" class="" aria-expanded="false">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span class="nav-text">Access change list</span>
                        </a>
                </li> --}}
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
                           <li><a href="{{route('report.ConsolidatedQuarterlyReport') }}">Consolidated Comprehensive Quarterly Report</a></li>   
                           {{-- <li><a href="{{route('admin.daily_report') }}">Daily Report Generator</a></li>             --}}
                           {{-- <li><a href="{{route('admin.daily_report_snapshot') }}">Daily Report</a></li>             --}}
                            {{-- <li><a href="{{route('report.QuarterlyreportList', ['flagid' =>1]) }}">Comprehensive Quarterly Report</a></li> --}}
                        </ul>
                </li>
                <li>
                    <a href="{{ route('admin.doe_estb') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">DoE Correction</span></a>
                </li>
                
            @endif
            @if ($settings['role'] == 3)
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
            @endif
            @if ($settings['role'] == 69)
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Archive Details</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="{{ route('admin.art_clinic_request') }}">Art Clinic</a></li>
                    <li><a href="{{ route('admin.art_bank_request') }}">Art Bank</a></li> --}}
                    <li><a href="{{ route('admin.list_archive') }}">List of Archive</a></li>
                    <li><a href="{{ route('admin.surrogacy_request') }}">Archive Request</a></li>
                    <li><a href="{{ route('admin.unsurrogacy_request') }}">Unarchive Request</a></li>
                </ul>
            </li>
            {{-- <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">View application</span>
                </a>
                <ul aria-expanded="false">
                <li><a href="{{ route('admin.view_applications') }}">view applications</a></li>
                </ul>
            </li> --}}
                {{-- reset password --}}
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span class="nav-text">Reset Password</span>
                    </a>
                    <ul aria-expanded="false">
                    <li><a href="{{ route('admin.resetpassword') }}">Reset password</a></li>
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
                            <li><a href="{{route('report.QuarterlyreportList', ['flagid' =>1]) }}">Comprehensive Quarterly Report</a></li>
                            <li><a href="{{route('report.ConsolidatedQuarterlyReport') }}">Consolidated Comprehensive Quarterly Report</a></li> 
                        </ul>
                </li>
                <li>
                <a href="{{ route('admin.doe_estb') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">DoE Correction</span></a>
                </li>
                {{-- <li>
                <a href="{{ route('reports.generate-daily-snapshot') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">Generate Daily Report</span></a>
                </li> --}}
                <li>
                <a href="{{ route('reports.daily.snapshot') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">View Daily Reporting</span></a>
                </li>
            @endif
            @if ($settings['role'] == 71)
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Archive Panel</span>
                </a>
                <ul aria-expanded="false">
                    {{-- <li><a href="{{ route('admin.art_clinic') }}">Art Clinic</a></li>
                    <li><a href="{{ route('admin.art_bank') }}">Art Bank</a></li>
                    <li><a href="{{ route('admin.surrogacy_details_view') }}">Art Surrogacy</a></li> --}}
                    <li><a href="{{ route('admin.list_archive') }}">List of Archive</a></li>
                    <li><a href="{{ route('admin.archive_work') }}">Archive</a></li>
                    <li><a href="{{ route('admin.unarchive_work') }}">Unarchive</a></li>
    
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.doe_estb') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">DoE Correction</span></a>
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
                            <li><a href="{{route('report.QuarterlyreportList', ['flagid' =>1]) }}">Comprehensive Quarterly Report</a></li>
                            <li><a href="{{route('report.ConsolidatedQuarterlyReport') }}">Consolidated Comprehensive Quarterly Report</a></li> 
                        </ul>
                </li>
            {{-- <li>
                <a href="{{ route('admin.doe_correction') }}" class="" aria-expanded="false"><i class="fa fa-address-card" aria-hidden="true"></i><span class="nav-text">DoR Correction</span></a>
                
            </li> --}}
        @endif

        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
