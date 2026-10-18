{{-- @extends('layouts.admin.admin_master')
@section('content')
    <!-- DataTables CSS -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show"
                            style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">
                            <strong> {{ session('success') }}</strong>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Surrogacy </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('admin.surrogacy_remark') }}" method="post" autocomplete="off">
                                @csrf
                                <table id="example5" class="display data-table" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="form-check custom-checkbox ms-0">
                                                    <input type="checkbox" class="form-check-input checkAll_date"
                                                        id="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>

                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Name of Clinic</th>
                                            <th>Phone No</th>
                                            <th>State</th>
                                            <th>date</th>
                                            <th>Remarks</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($surrogacy_detail_data as $surrogacy_data)
                                            <tr>
                                                <td>
                                                    <div class="form-check custom-checkbox ms-2">
                                                        <input type="checkbox"
                                                            class="form-check-input customSingleCheckBox1"
                                                            id="customCheckBox2">
                                                        <label class="form-check-label" for="customCheckBox2"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $surrogacy_data->application_no }}</td>
                                                <td>{{ $surrogacy_data->clinicname }}</td>
                                                <td>{{ $surrogacy_data->mobile }}</td>
                                                <td>{{ $surrogacy_data->state }}</td>
                                                <td>{{ $surrogacy_data->created_at }}</td>
                                                <td><input type="text" name="remarks[]" class="form-control"
                                                        placeholder="Enter remark" /></td>
                                                @php
                                                    $workarc_id = $surrogacy_data->id;
                                                    //dd($arc_id);
                                                @endphp
                                                <td>
                                                    <div class="modal fade" id="exampleModalCenter{{ $workarc_id }}">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Modal title</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" id="work_flow" name="work_flow[]"
                                                                        value="{{ $workarc_id }}" />
                                                                    <p>{{ $surrogacy_data->remarks }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger light"
                                                                        data-bs-dismiss="modal">Close</button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#" id="show_archive_remark" type="button"
                                                        class="btn btn-warning mb-2" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalCenter{{ $workarc_id }}">Archive
                                                        Request</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" name="submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

@extends('layouts.admin.admin_master')

@section('content')

<style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-archive{
            background-color: #0000002e;
        }

        .csp-admin-table{
            min-width: 845px;
        }
        

    </style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                        <strong>{{ session('success') }}</strong>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-danger alert-dismissible alert-alt fade show">
                        <strong>{{ session('error') }}</strong>
                    </div>
                </div>
            @endif
            <div class="card-header  text-white text-center py-3 shadow-sm rounded-top csp-admin-archive">
                <h3 class="card-title m-0 fw-bold">Archive Applications- Request received</h3>
            </div>
            {{-- <div class="card-header" style="background-color: #0000002e;">
                <h3 class="card-title"><strong>Archive Applications</strong></h3>
            </div> --}}
            <div class="card">
                
                <div class="card-header">
                    <h4 class="card-title">Surrogacy Clinic</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('admin.surrogacy_remark') }}" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="surrogacy"  value="art_surrogacy" class="form-control" />
                            <table id="example3" class="display data-table csp-admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check custom-checkbox ms-0">
                                                <input type="checkbox" class="form-check-input" id="checkAllSurrogacy" name="checkAllSurrogacy">
                                                {{-- <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label> --}}
                                            </div>
                                        </th>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Name of Clinic</th>
                                        <th>Type of Clinic</th>
                                        <th>Clinic Level</th>
                                        <th>State</th>
                                        <th>Phone No</th>                                        
                                        <th>Date of Archival Request</th>
                                        <th>Comments</th>
                                        <th>Remarks</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @php $i = 1; @endphp
                                   
                                    @foreach ($surrogacy_detail_data as $surrogacy_data)
                                    
                                        <tr>
                                            <td>
                                                <div class="form-check custom-checkbox ms-2">
                                                    <input type="checkbox" name="work_flows[]" id="surrogacyCheckbox" value="{{ $surrogacy_data->id }}"
                                                           class="form-check-input surrogacyCheckbox">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $i++ }}</td>
                                            
                                            <td>{{ $surrogacy_data->application_no }}</td>
                                            <td>{{ $surrogacy_data->clinicname }}</td>
                                            <td>
                                                @if (str_contains($surrogacy_data->type_of_clinic, 'art_surrogacy'))
                                                    Surrogacy Clinic
                                                @elseif (str_contains($surrogacy_data->type_of_clinic, 'art_clinic'))
                                                    ART Clinic
                                                    @elseif (str_contains($surrogacy_data->type_of_clinic, 'art_bank'))
                                                    ART Bank                                             
                                                @endif
                                            </td>
                                            <td>{{ $surrogacy_data->cliniclevel ?? '-' }}</td>                                          
                                            <td>{{ $surrogacy_data->state }}</td>
                                            <td>{{ $surrogacy_data->mobile }}</td>                                            
                                            <td>{{ $surrogacy_data->created_at }}</td>
                                            <td>{{ $surrogacy_data->remarks }}</td>                                           
                                            <td>
                                                <input type="text" name="remarks[{{ $surrogacy_data->id }}]"  class="form-control"
                                                       placeholder="Enter remark" />
                                                    
                                                       
                                                    
                                                    </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(!empty($surrogacy_detail_data) && count($surrogacy_detail_data) > 0)
                            <button type="submit" class="btn btn-secondary mt-3">Approve</button>
                            <button type="submit" name="Reject" class="btn btn-secondary mt-3">Reject</button>
                        @endif                           
                        </form>
                    </div>
                </div>
            {{-- </div> --}}


            {{-- <div class="card"> --}}
                <div class="card-header">
                    <h4 class="card-title">ART Clinic</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('admin.surrogacy_remark') }}" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="surrogacy"  value="art_clinic" class="form-control" />
                            <table id="example3" class="display data-table csp-admin-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check custom-checkbox ms-0">
                                                <input type="checkbox" class="form-check-input" id="checkAllart">
                                                {{-- <input type="checkbox" class="form-check-input" id="checkAll1">
                                                <label class="form-check-label" for="checkAll"></label> --}}
                                            </div>
                                        </th>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Name of Clinic</th>
                                        <th>Type of Clinic</th>
                                        <th>Clinic Level</th>
                                        <th>State</th>
                                        <th>Phone No</th>                                        
                                        <th>Date of Archival Request</th>
                                        <th>Comments</th>
                                        <th>Remarks</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($art_detail_data as $art_data)
                                    
                                        <tr>
                                            <td>
                                                <div class="form-check custom-checkbox ms-2">
                                                    <input type="checkbox" name="work_flows[]" id="artClinicCheckbox" value="{{ $art_data->id }}"
                                                           class="form-check-input artClinicCheckbox">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $i++ }}</td>
                                            
                                            <td>{{ $art_data->application_no }}</td>
                                            <td>{{ $art_data->clinicname }}</td>
                                            <td>
                                                @if (str_contains($art_data->type_of_clinic, 'art_surrogacy'))
                                                    Surrogacy Clinic
                                                @elseif (str_contains($art_data->type_of_clinic, 'art_clinic'))
                                                    ART Clinic
                                                    @elseif (str_contains($art_data->type_of_clinic, 'art_bank'))
                                                    ART Bank                                             
                                                @endif
                                            </td>
                                            <td>{{ $art_data->cliniclevel ?? '-' }}</td>                                          
                                            <td>{{ $art_data->state }}</td>
                                            <td>{{ $art_data->mobile }}</td>                                            
                                            <td>{{ $art_data->created_at }}</td>
                                            <td>{{ $art_data->remarks }}</td>                                           
                                            <td>
                                                <input type="text" name="remarks[{{ $art_data->id }}]"  class="form-control"
                                                       placeholder="Enter remark" />
                                                    
                                                       
                                                    
                                                    </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(!empty($art_detail_data) && count($art_detail_data) > 0)
                            <button type="submit" class="btn btn-secondary mt-3">Approve</button>
                            <button type="submit" name="Reject" class="btn btn-secondary mt-3">Reject</button>
                        @endif                           
                        </form>
                    </div>
                </div>
                <div class="card-header">
                    <h4 class="card-title">ART Bank</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('admin.surrogacy_remark') }}" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="surrogacy"  value="art_bank" class="form-control" />
                            <table id="example3" class="display data-table csp-admin-table" >
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check custom-checkbox ms-0">
                                                 <input type="checkbox" class="form-check-input" id="checkAllbank">
                                                {{-- <input type="checkbox" class="form-check-input" id="checkAll2">
                                                <label class="form-check-label" for="checkAll"></label> --}}
                                            </div>
                                        </th>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Name of Clinic</th>
                                        <th>Type of Clinic</th>
                                        <th>Clinic Level</th>
                                        <th>State</th>
                                        <th>Phone No</th>                                        
                                        <th>Date of Archival Request</th>
                                        <th>Comments</th>
                                        <th>Remarks</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($bank_detail_data as $bank_data)
                                    
                                        <tr>
                                            <td>
                                                <div class="form-check custom-checkbox ms-2">
                                                    <input type="checkbox" name="work_flows[]" id="artBankCheckbox" value="{{ $bank_data->id }}"
                                                           class="form-check-input artBankCheckbox">
                                                    <label class="form-check-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $i++ }}</td>
                                            
                                            <td>{{ $bank_data->application_no }}</td>
                                            <td>{{ $bank_data->clinicname }}</td>
                                            <td>
                                                @if (str_contains($bank_data->type_of_clinic, 'art_surrogacy'))
                                                    Surrogacy Clinic
                                                @elseif (str_contains($bank_data->type_of_clinic, 'art_clinic'))
                                                    ART Clinic
                                                    @elseif (str_contains($bank_data->type_of_clinic, 'art_bank'))
                                                    ART Bank                                             
                                                @endif
                                            </td>
                                            <td>{{ $bank_data->cliniclevel ?? '-' }}</td>                                          
                                            <td>{{ $bank_data->state }}</td>
                                            <td>{{ $bank_data->mobile }}</td>                                            
                                            <td>{{ $bank_data->created_at }}</td>
                                            <td>{{ $bank_data->remarks }}</td>                                           
                                            <td>
                                                <input type="text" name="remarks[{{ $bank_data->id }}]"  class="form-control"
                                                       placeholder="Enter remark" /></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(!empty($bank_detail_data) && count($bank_detail_data) > 0)
                            <button type="submit" class="btn btn-secondary mt-3">Approve</button>
                            <button type="submit" name="Reject" class="btn btn-secondary mt-3">Reject</button>
                        @endif                           
                        </form>
                    </div>
                </div>
            </div>


            














        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
document.addEventListener("DOMContentLoaded", function () {
    function setupCheckboxToggle(checkAllId, checkboxClass) {
        let checkAllBox = document.getElementById(checkAllId);
        if (!checkAllBox) return; // Safety check

        checkAllBox.addEventListener("change", function () {
            let checkboxes = document.querySelectorAll("." + checkboxClass);
            checkboxes.forEach(checkbox => checkbox.checked = checkAllBox.checked);
        });
    }

    // Attach check-all functionality to each section
    setupCheckboxToggle("checkAllSurrogacy", "surrogacyCheckbox");  // Surrogacy Clinic
    setupCheckboxToggle("checkAllart", "artClinicCheckbox");        // ART Clinic
    setupCheckboxToggle("checkAllbank", "artBankCheckbox");         // ART Bank
});
</script>
    {{-- <script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function() {
        // Surrogacy Clinic Check All
        const checkAll = document.getElementById('checkAll');
        const surrogacyCheckboxes = document.querySelectorAll('table#example5 .surrogacyCheckbox');

        checkAll.addEventListener('change', function() {
            surrogacyCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Art Clinic Check All
        const checkAll1 = document.getElementById('checkAll1');
        const artClinicTable = document.querySelector('div:has(h4:contains("Art Applications")) + div table');
        const artClinicCheckboxes = artClinicTable.querySelectorAll('.artClinicCheckbox');

        checkAll1.addEventListener('change', function() {
            artClinicCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Art Bank Check All
        const checkAll2 = document.getElementById('checkAll2');
        const artBankTable = document.querySelector('div:has(h4:contains("Art Bank")) + div table');
        const artBankCheckboxes = artBankTable.querySelectorAll('.artBankCheckbox');

        checkAll2.addEventListener('change', function() {
            artBankCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });
</script> --}}



@endsection

