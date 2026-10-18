@extends(session('user_type') == '5' ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')

@section('content')
    {{-- ERROR MESSAGE --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}</div>
    @endif
    <style nonce="{{ $cspNonce }}">
        .table th,
        .table td {
            text-align: left !important;
            vertical-align: middle !important;
            padding: 8px 12px;
        }
        td:empty::after {
    content: "\00a0"; /* adds a non-breaking space so borders remain visible */
}

    </style>
    <div class="container-fluid py-4">
        <div class="card shadow rounded-2xl">
            <div class="card-header">
                <h4 class="mb-0"><b>View Application</b></h4>
            </div>
            <div class="card-body">

                {{-- ONLY SHOW RESULTS IF $app IS SET --}}
                @if ($app)
                    {{-- Status Badge --}}
                    <div class="mb-3">
                        {{-- <span
                            class="badge fs-5
            @if ($status == 'Application is received by the State Authority') bg-info
            @elseif($status == 'Submitted') bg-success
            @elseif($status == 'Draft') bg-warning
            @else bg-secondary @endif">
                            Current status - {{ $status }}
                        </span> --}}
                    </div>

                    <div class="text-end">
                        {{-- <a href="{{ route('application.pdf', ['clinicType' => $clinicType, 'applicationNo' => $applicationNo]) }}" 
   class="btn btn-danger btn-sm">
   Download PDF
</a> --}}
                        <a href="{{ route('application.pdf', ['clinicType' => encrypt($clinicType), 'applicationNo' => encrypt($applicationNo)]) }}"class="btn btn-danger btn-sm"
                            target="_blank" download>Download PDF</a>

                    </div>
                    {{-- <h4><center>Application Details</center></h4> --}}
                    <table class="table table-bordered table-striped table-responsive">
                        <tbody>

                            {{-- =================== ART CLINIC =================== --}}
                            @if ($clinicType == 'art_clinic')
                            <tr>
                            <th colspan="8" class="csp-clinic-table-header">ART Clinic Details</th>
                            </tr>
                             <tr>
                                    <th colspan="1">Application status</th>
                                    <td colspan="7">

                                        @if($app->status == 1 && $app->appstatus === 'Approved')
                                            {{ 'Application Approved by the state authority' }}
                                        @elseif($app->status == 1 && $app->appstatus === 'Rejected')
                                            {{ 'Application Rejected  by the state authority' }}
                                        @elseif($app->status == 1 && $app->app_recieved === 'received')
                                            {{ 'Application Received  by the state authority' }}
                                        @elseif($app->status == 1)
                                            {{ 'Application Submitted by the clinic' }}
                                        @endif

                                    </td>
                                </tr>
                           
                                <tr>
                                    <th colspan="1">Application No</th>
                                    <td colspan="7">{{ $app->applicationno ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="1">Clinic Name</th>
                                    <td colspan="7">{{ $app->clinicname ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="1">Address</th>
                                    <td colspan="7">{{ $app->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ $app->state ?? '-' }}</td>
                                    <th>District</th>
                                    <td>{{ $app->district ?? '-' }}</td>
                                    <th>Pincode</th>
                                    <td>{{ $app->pincode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nature</th>
                                    <td>{{ $app->nature ?? '-' }}</td>
                                    <th>Email ID</th>
                                    <td>{{ $app->email ?? '-' }}</td>
                                    <th>Contact Number</th>
                                    <td>{{ $app->contactno ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $app->fax ?? '-' }}</td>
                                    <th>Website</th>
                                    <td colspan="2">{{ $app->website ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Establishment</th>
                                    <td colspan="5">{{ $app->dateestab ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>MTP Act Registered</th>
                                    <td>{{ $app->mtpact ?? '-' }}</td>
                                    <th>PCPNDT Act Registered</th>
                                    <td colspan="3">{{ $app->pcpndtact ?? '-' }}</td>
                                </tr>

                                {{-- Contact Person --}}
                                <tr>
                                    <th colspan="6" class="csp-clinic-table-header">Contact Person Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $app->contact_person_name ?? '-' }}</td>
                                    <th>Mobile</th>
                                    <td>{{ $app->contact_person_mobile ?? '-' }}</td>
                                    <th>Email</th>
                                    <td>{{ $app->contact_person_email ?? '-' }}</td>
                                </tr>

                                {{-- Directors --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Director Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Qualification</th>
                                    <th>Registration No</th>
                                     <th colspan="5"></th>
                                </tr>
                                @foreach ($directors as $director)
                                    <tr>
                                        <td>{{ $director->name_director ?? '-' }}</td>
                                        <td>{{ $director->quali_director ?? '-' }}</td>
                                        <td>{{ $director->reg_director ?? '-' }}</td>
                                        <td colspan="5"></td>
                                    </tr>
                                @endforeach

                                {{-- Staff --}}
                                <tr>
                                    <th colspan="8"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              "
                                        class="csp-clinic-table-header">Staff Details</th>
                                </tr>
                                <tr>
                                    <th>Post</th>
                                    <th>Name</th>
                                    <th>Qualification</th>
                                    <th>Registration No</th>
                                      <th colspan="4"></th>
                                </tr>
                                @foreach ($staff as $s)
                                    <tr>
                                        <td>{{ $s->post_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->name_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->quali_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->regno ?? '-' }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                @endforeach

                                {{-- Equipment --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Equipment Details</th>
                                </tr>
                                @foreach ($equipments as $e)
                                    <tr>
                                        <td colspan="8">{{ $e->equipmentname }}</td>
                                    </tr>
                                @endforeach

                                {{-- Procedures --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Procedures Undertaken</th>
                                </tr>
                                <tr>
                                    <th>IUI-H</th>
                                    <td>{{ $app->iuih ?? '-' }}</td>
                                    <th>IUI-D</th>
                                    <td>{{ $app->iuid ?? '-' }}</td>
                                    <th>IVF-ET</th>
                                    <td>{{ $app->ivfet ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>ICSI</th>
                                    <td>{{ $app->icsi ?? '-' }}</td>
                                    <th>PGT</th>
                                    <td>{{ $app->pgt ?? '-' }}</td>
                                    <th>Gametes/Embryos</th>
                                    <td>{{ $app->spermandoocyte ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Other Procedure</th>
                                    <td>{{ $app->anyotherprocedure ?? '-' }}</td>
                                    <th>If yes, specify</th>
                                    <td>{{ $app->otherprocedure ?? '-' }}</td>
                                    <th>Other Details</th>
                                    <td>{{ $app->otherdetails ?? '-' }}</td>
                                </tr>






                                <th colspan="8" class="csp-clinic-table-header">Fee Details</th>
                                <tr>
                                    <th colspan="2">Payment Mode</th>
                                <td colspan="8">@if($app->nature == 'Private')
            {{ $app->mode_payment ?? '-' }}
        @else
            Not applicable for government clinics
        @endif
                                </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Fee Amount</th>
                                    <td colspan="8">
                                         @if($app->nature == 'Private')
            {{ $app->fee_amount ?? '-' }}
        @else
            Not applicable for government clinics
        @endif
                                
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Date Of Fee Submission</th>
                                    <td colspan="8">  @if($app->nature == 'Private')
            {{ $app->app_date_payment ?? '-' }}
        @else
            Not applicable for government clinics
        @endif</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Date of Fee Recieving</th>
                                    <td colspan="8">{{ $app->app_date_recieve ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Fee Status</th>
                                    <td colspan="8">{{ $app->app_received ?? '-' }}</td>
                                </tr>
                                <tr colspan="8">
                                    <td> {{-- Fee Receipts --}}
                                                            
@if($app->nature === 'Private')
    @if (!empty($DocFilereceivedUpload) && $DocFilereceivedUpload->count())
        <h4>Fee Receipts</h4>
        <ul>
            @foreach ($DocFilereceivedUpload as $doc)
                @if (!empty($doc->file_url))
                    <li>
                        {{-- {{ $doc->doc_upload_ref }} --}}
                        <a href="{{ $doc->file_url }}" target="_blank">View</a>
                        | <a href="{{ $doc->file_url }}" download>Download</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <p>No Fee Receipts uploaded.</p>
    @endif
@endif
                                    </td>
                                </tr>

                                <th colspan="8" class="csp-clinic-table-header">Application Status</th>
                                <tr>

                                    <td colspan="8">{{ $app->appstatus ?? '-' }}   Certificate - 
                                        @if (!empty($docfilecertificate) && $docfilecertificate->count())
                                        
                                           
                                                @foreach ($docfilecertificate as $doc)
                                                    @if ($doc->file_url)
                                                       
                                                            {{-- {{ $doc->doc_upload_ref }} --}}
                                                            <a href="{{ $doc->file_url }}" target="_blank">View</a>
                                                            | <a href="{{ $doc->file_url }}" download>Download</a>
                                                        
                                                    @endif
                                                @endforeach
                                         
                                        @endif</td>
                                </tr>

                               
                                
                            @endif

                            {{-- =================== ART BANK =================== --}}
                            @if ($clinicType == 'art_bank')
                                <tr>
                                    <th colspan="6" class="csp-clinic-table-header">ART Bank Details</th>
                                </tr>
                  <tr>
                                    <th>Application status</th>
                                    <td colspan="8">

@if($app->status == 1 && $app->appstatus === 'Approved')
    {{ 'Application Approved by the state authority' }}
@elseif($app->status == 1 && $app->appstatus === 'Rejected')
    {{ 'Application Rejected  by the state authority' }}
@elseif($app->status == 1 && $app->app_recieved === 'received')
    {{ 'Application Received  by the state authority' }}
@elseif($app->status == 1)
    {{ 'Application Submitted by the clinic' }}
@endif

                                    </td>
                                </tr>
                                 <tr>
                                    <th>Application No</th>
                                    <td>{{ $app->applicationno ?? '-' }}</td>
                                </tr>
                                  
                                <tr>
                                    <th>Bank Name</th>
                                    <td colspan="5">{{ $app->clinicname ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td colspan="5">{{ $app->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ $app->state ?? '-' }}</td>
                                    <th>District</th>
                                    <td>{{ $app->district ?? '-' }}</td>
                                    <th>Pincode</th>
                                    <td>{{ $app->pincode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nature</th>
                                    <td>{{ $app->nature ?? '-' }}</td>
                                    <th>Email</th>
                                    <td>{{ $app->email ?? '-' }}</td>
                                    <th>Contact</th>
                                    <td>{{ $app->contactno ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $app->fax ?? '-' }}</td>
                                    <th>Website</th>
                                    <td colspan="3">{{ $app->website ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Establishment</th>
                                    <td colspan="5">{{ $app->dateestab ?? '-' }}</td>
                                </tr>

                                {{-- Contact Person --}}
                                <tr>
                                    <th colspan="6" class="csp-clinic-table-header">Contact Person Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $app->contact_person_name ?? '-' }}</td>
                                    <th>Mobile</th>
                                    <td>{{ $app->contact_person_mobile ?? '-' }}</td>
                                    <th>Email</th>
                                    <td>{{ $app->contact_person_email ?? '-' }}</td>
                                </tr>

                                {{-- Staff --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Staff Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Qualification</th>
                                     <th colspan="5"></th>
                                </tr>
                                @foreach ($staff as $s)
                                    <tr>
                                        <td>{{ $s->name_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->designation_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->quali_otherstaff ?? '-' }}</td>
                                        <td colspan="5"></td>
                                    </tr>
                                @endforeach


                                {{-- Equipment --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Equipment Details</th>
                                </tr>
                                @foreach ($equipments as $e)
                                    <tr>
                                        <td colspan="8">{{ $e->equipmentname ?? '-' }}</td>
                                    </tr>
                                @endforeach



                                <tr>

                                    <th colspan="8" class="csp-clinic-table-header">Procedure Undertaken</th>
                                </tr>

                                <tr>
                                    <th colspan="2"> a). Ejaculation</th>
                                    <td>{{ $app->ejaculation ?? '-' }}</td>
                                    <th colspan="2">b). Electroejaculation (in
                                        case of retrograde ejaculation)</th>
                                    <td colspan="2">{{ $app->electroejaculation ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2"> ii). Processing of Sperm</th>
                                    <td>{{ $app->processingsperm ?? '-' }}</td>
                                    <th colspan="2">iii). Storage of Sperm</th>
                                    <td colspan="2">{{ $app->storagesperm ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2"> iv). Provision/sourcing of
                                        Oocyte Donor</th>
                                    <td>{{ $app->oocytedonor ?? '-' }}</td>
                                    <th colspan="2">5. Cryopreservation of
                                        Sperm</th>
                                    <td colspan="2">{{ $app->cryopreservation ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th colspan="2"> i). Sperm Slow Freezing</th>
                                    <td>{{ $app->spermslow ?? '-' }}</td>
                                    <th colspan="2">ii). Sperm Vitrification</th>
                                    <td colspan="2">{{ $app->spermvitrification ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2"> 7. Whether Freezing of
                                        Testicular Tissue</th>
                                    <td>{{ $app->tisticulartissue ?? '-' }}</td>

                                </tr>
                                <tr>
                                    <th colspan="2">Any Other Details</th>
                                    <td colspan="8">{{ $app->otherdetails ?? '-' }}</td>
                                </tr>

                                <th colspan="8" class="csp-clinic-table-header">Fee Details</th>
                                <tr>
                                    <th colspan="2">Payment Mode</th>

                                      <td colspan="8"> @if($app->nature == 'Private')
            {{ $app->mode_payment ?? '-' }}
        @else
            Not applicable for government
        @endif
                                      </td>
                                    {{-- <td colspan="8">{{ $app->mode_payment ?? '-' }}</td> --}}
                                </tr>

                                <tr>
                                    <th colspan="2">Fee Amount</th>
                                    <td colspan="8">@if($app->nature == 'Private')
            {{ $app->fee_amount ?? '-' }}
        @else
            Not applicable for government
        @endif</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Date Of Fee Submission</th>
                                    <td colspan="8">
                                        @if($app->nature == 'Private')
            {{ $app->app_date_payment ?? '-' }}
        @else
            Not applicable for government
        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Date of Fee Recieving</th>
                                    <td colspan="8">{{ $app->app_date_recieve ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Fee Status</th>
                                    <td colspan="8">{{ $app->app_received ?? '-' }}</td>
                                </tr>
                                <tr colspan="8">
                                    <td> {{-- Fee Receipts --}}
                                                            
@if($app->nature === 'Private')
    @if (!empty($DocFilereceivedUpload) && $DocFilereceivedUpload->count())
        <h4>Fee Receipts</h4>
        <ul>
            @foreach ($DocFilereceivedUpload as $doc)
                @if (!empty($doc->file_url))
                    <li>
                        {{-- {{ $doc->doc_upload_ref }} --}}
                        <a href="{{ $doc->file_url }}" target="_blank">View</a>
                        | <a href="{{ $doc->file_url }}" download>Download</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <td>No Fee Receipts uploaded.</td>
    @endif
@endif
                                    </td>
                                </tr>

                                <th colspan="8" class="csp-clinic-table-header">Application Status</th>
                                <tr>

                                    <td colspan="8">{{ $app->appstatus ?? '-' }}

                                         <tr>

                                    <td colspan="8">{{ $app->appstatus ?? '-' }}   Certificate - 
                                        @if (!empty($docfilecertificate) && $docfilecertificate->count())
                                        
                                           
                                                @foreach ($docfilecertificate as $doc)
                                                    @if ($doc->file_url)
                                                       
                                                            {{-- {{ $doc->doc_upload_ref }} --}}
                                                            <a href="{{ $doc->file_url }}" target="_blank">View</a>
                                                            | <a href="{{ $doc->file_url }}" download>Download</a>
                                                        
                                                    @endif
                                                @endforeach
                                         
                                        @endif</td>
                                </tr>
                                   
                                
                            @endif

                            {{-- =================== ART SURROGACY =================== --}}
                            @if ($clinicType == 'art_surrogacy')
                                <tr>
                                    <th colspan="6" class="csp-clinic-table-header">Surrogacy Clinic Details</th>
                                </tr>
                              <tr>
                                    <th>Application status</th>
                                    <td colspan="8">

@if($app->status == 1 && $app->appstatus === 'Approved')
    {{ 'Application Approved by the state authority' }}
@elseif($app->status == 1 && $app->appstatus === 'Rejected')
    {{ 'Application Rejected  by the state authority' }}
@elseif($app->status == 1 && $app->app_recieved === 'received')
    {{ 'Application Received  by the state authority' }}
@elseif($app->status == 1)
    {{ 'Application Submitted by the clinic' }}
@endif

                                    </td>
                                </tr>
                                    <tr>
                                    <th>Application No</th>
                                    <td>{{ $app->applicationno ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $app->clinicname ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $app->address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ $app->state ?? '-' }}</td>
                                    <th>District</th>
                                    <td>{{ $app->district ?? '-' }}</td>
                                    <th>Pincode</th>
                                    <td>{{ $app->pincode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nature</th>
                                    <td>{{ $app->nature ?? '-' }}</td>
                                    <th>Email</th>
                                    <td>{{ $app->email ?? '-' }}</td>
                                    <th>Contact</th>
                                    <td>{{ $app->contactno ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Fax</th>
                                    <td>{{ $app->fax ?? '-' }}</td>
                                    <th>Website</th>
                                    <td colspan="3">{{ $app->website ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Establishment</th>
                                    <td colspan="5">{{ $app->dateestab ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>MTP Act Registered</th>
                                    <td>{{ $app->mtpact ?? '-' }}</td>
                                    <th>PCPNDT Act Registered</th>
                                    <td colspan="3">{{ $app->pcpndtact ?? '-' }}</td>
                                </tr>

                                {{-- Contact Person --}}
                                <tr>
                                    <th colspan="6" class="csp-clinic-table-header">Contact Person Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $app->contact_person_name ?? '-' }}</td>
                                    <th>Mobile</th>
                                    <td>{{ $app->contact_person_mobile ?? '-' }}</td>
                                    <th>Email</th>
                                    <td>{{ $app->contact_person_email ?? '-' }}</td>
                                </tr>

                                {{-- Directors --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Director Details</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Qualification</th>
                                    <th>Registration No</th>
                                    <th colspan="5"></th>
                                </tr>
                                @foreach ($directors as $d)
                                    <tr>
                                        <td>{{ $d->name_director ?? '-' }}</td>
                                        <td>{{ $d->quali_director ?? '-' }}</td>
                                        <td>{{ $d->reg_director ?? '-' }}</td>
                                        <td colspan="5"></td>
                                    </tr>
                                @endforeach

                                {{-- Staff --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Staff Details</th>
                                </tr>
                                <tr>
                                    <th>Post</th>
                                    <th>Name</th>
                                    <th>Qualification</th>
                                    <th>Registration No</th>
                                    <th colspan="4"></th>
                                </tr>
                                @foreach ($staff as $s)
                                    <tr>
                                        <td>{{ $s->post_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->name_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->quali_otherstaff ?? '-' }}</td>
                                        <td>{{ $s->regno ?? '-' }}</td>
                                         <td colspan="4"></td>
                                    </tr>
                                @endforeach

                                {{-- Equipment --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Equipment Details</th>
                                </tr>
                                @foreach ($equipments as $e)
                                    <tr>
                                        <td colspan="8">{{ $e->equipmentname }}</td>
                                    </tr>
                                @endforeach

                                {{-- Procedures --}}
                                <tr>
                                    <th colspan="8" class="csp-clinic-table-header">Procedures Undertaken</th>
                                </tr>
                                <tr>
                                    <th>IUI-H</th>
                                    <td>{{ $app->iuih ?? '-' }}</td>
                                    <th>IUI-D</th>
                                    <td>{{ $app->iuid ?? '-' }}</td>
                                    <th>IVF-ET</th>
                                    <td>{{ $app->ivfet ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>ICSI</th>
                                    <td>{{ $app->icsi ?? '-' }}</td>
                                    <th>PGT</th>
                                    <td>{{ $app->pgt ?? '-' }}</td>
                                    <th>Gametes/Embryos</th>
                                    <td>{{ $app->spermandoocyte ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Other Procedure</th>
                                    <td>{{ $app->anyotherprocedure ?? '-' }}</td>
                                    <th>If yes, specify</th>
                                    <td>{{ $app->otherprocedure ?? '-' }}</td>
                                    <th>Other Details</th>
                                    <td>{{ $app->otherdetails ?? '-' }}</td>
                                </tr>




                                <th colspan="8" class="csp-clinic-table-header">Fee Details</th>
                                <tr>
                                    <th colspan="2">Payment Mode</th>
                                    <td colspan="8"> @if($app->nature == 'Private')
            {{ $app->mode_payment ?? '-' }}
        @else
            Not applicable for government
        @endif
                                    </td>             </tr>

                                <tr>
                                    <th colspan="2">Fee Amount</th>
                                    <td colspan="8"> @if($app->nature == 'Private')
            {{ $app->fee_amount ?? '-' }}
        @else
            Not applicable for government
        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2">Date Of Fee Submission</th>
                                    <td colspan="8"> @if($app->nature == 'Private')
            {{ $app->app_date_payment ?? '-' }}
        @else
            Not applicable for government
        @endif</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Date of Fee Recieving</th>
                                    <td colspan="8">{{ $app->app_date_recieve ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Fee Status</th>
                                    <td colspan="8">{{ $app->app_received ?? '-' }}</td>
                                </tr>
                                <tr colspan="8">
                                    <td> {{-- Fee Receipts --}}
                      
@if($app->nature === 'Private')
    @if (!empty($DocFilereceivedUpload) && $DocFilereceivedUpload->count())
        <h4>Fee Receipts</h4>
        <ul>
            @foreach ($DocFilereceivedUpload as $doc)
                @if (!empty($doc->file_url))
                    <li>
                        {{-- {{ $doc->doc_upload_ref }} --}}
                        <a href="{{ $doc->file_url }}" target="_blank">View</a>
                        | <a href="{{ $doc->file_url }}" download>Download</a>
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        <p>No Fee Receipts uploaded.</p>
    @endif
@endif


                                    </td>
                                </tr>

                                <th colspan="8" class="csp-clinic-table-header">Application Status</th>
                                <tr>

                                    <td colspan="8">{{ $app->appstatus ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td>


                                        {{-- Certificates --}}
                                        @if (!empty($docfilecertificate) && $docfilecertificate->count())
                                            <h4>Certificates</h4>
                                            <ul>
                                                @foreach ($docfilecertificate as $doc)
                                                    @if ($doc->file_url)
                                                        <li>
                                                            {{-- {{ $doc->doc_upload_ref }} --}}
                                                            <a  href="{{ $doc->file_url }}" target="_blank">View</a>
                                                            | <a href="{{ $doc->file_url }}" download>Download</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif



                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection
