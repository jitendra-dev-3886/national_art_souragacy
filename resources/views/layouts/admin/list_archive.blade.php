@extends('layouts.admin.admin_master')

@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-submit-button{
            margin-top: 32px;
        }

        .csp-admin-table{
            min-width: 845px;
        }
        .csp-admin-clinic-type{
            color:#ff0000;
        }
        #dataTableContainer {
            display: none;
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

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List of Archived Applications</h4>
                </div>
                {{-- <div class="col-xl-2">
                    <button type="button" id="btnExport" class="btn btn-sm btn-success" style="margin-top: 32px;">Export to Excel</button>
                </div> --}}
                <div class="card-body">
                    {{-- <div class="table-responsive"> --}}
                        <form action="#" id="btnform" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col-xl-2 mb-3">
                                    
                                </div>
                                <div class="col-xl-2">
                                    <label for="clinic_type"><strong>Type of Clinic</strong><span
                                        class="csp-admin-clinic-type">*</span></label>
                                    <select name="clinic_type" id="clinic_type" class="form-control">
                                        <option value="" {{ request('clinic_type') == '' ? 'selected' : '' }}>Select</option>
                                        <option value="art_surrogacy" {{ request('clinic_type') == 'art_surrogacy' ? 'selected' : '' }}>Surrogacy Clinic</option>
                                        <option value="art_clinic" {{ request('clinic_type') == 'art_clinic' ? 'selected' : '' }}>ART Clinic</option>
                                        <option value="art_bank" {{ request('clinic_type') == 'art_bank' ? 'selected' : '' }}>ART Bank</option>
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <label for="start_date"><strong>Start Date</strong><span
                                        class="csp-admin-clinic-type">*</span></label>
                                    <input class="form-control" type="date" id="start_date" name="start_date" value="">
                                </div>
                                <div class="col-xl-2">
                                    <label for="end_date"><strong>End Date</strong><span
                                        class="csp-admin-clinic-type">*</span></label>
                                    <input class="form-control" type="date" id="end_date" name="end_date" value="">
                                </div>
                                <div class="col-xl-2">
                                    <button type="submit" id="btnsubmit" class="btn btn-sm btn-primary csp-admin-submit-button">Filter</button>
                                </div>
                            </div>

                        </form>
                        <div id="dataTableContainer">
                            <table id="example5" class="display data-table csp-admin-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Name of Clinic</th>
                                        <th>State</th>
                                        <th>Address</th>
                                        <th>Archival Date</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    {{-- Data will be filled by AJAX --}}
                                </tbody>
                            </table>
                        </div>
                        {{-- <table id="example5" class="display data-table" style="min-width: 845px;" >
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Application No.</th>
                                    <th>Name of Clinic</th>
                                    <th>State</th>
                                    <th>Phone No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($combinedList as $list_data)
                                    <tr>                                           
                                        <td>{{ $i++ }}</td>                                        
                                        <td>{{ $list_data->application_no }}</td>
                                        <td>{{ $list_data->clinicname }}</td>
                                        <td>{{ $list_data->state }}</td>
                                        <td>{{ $list_data->mobile }}</td>                                          
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
        $('#btnform').on('submit', function (e) {
            e.preventDefault();

            const formData = {
                clinic_type: $('#clinic_type').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val()
            };

            $.ajax({
                url: '{{ route('admin.list_archive') }}',
                type: 'GET',
                data: formData,
                success: function (response) {

                  //  return false;
                    $('#tableBody').html('');
                    if (Array.isArray(response) && response.length > 0) {
                        let rows = '';
                        let i = 1;
                        response.forEach(item => {
                            rows += `
                                <tr>
                                    <td>${i++}</td>
                                    <td>${item.application_no ?? ''}</td>
                                    <td>${item.clinicname ?? ''}</td>
                                    <td>${item.state ?? ''}</td>
                                    <td>${item.address ?? ''}</td>
                                     <td>${item.created_at ?? ''}</td>
                                </tr>
                            `;
                        });
                        $('#tableBody').html(rows);
                        
                    } else {
                        $('#tableBody').html('<tr><td colspan="5">No records found.</td></tr>');
                    }
                    $('#dataTableContainer').show();
                },
                error: function (xhr, status, error) {
                console.error('AJAX Error:', error);

                let errorMessage = 'An error occurred while filtering.';

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }

                alert(errorMessage);
            }
                // error: function (xhr, status, error) {
                //     console.error('AJAX Error:', error);
                //     alert('An error occurred while filtering.');
                // }
            });
        });
    });
</script>

{{-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#btnform').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            var formData = {
                clinic_type: $('#clinic_type').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: '{{ route('admin.list_archive') }}', 
                type: 'GET',
                data: formData,
                success: function(response) {
                    // Assuming response is an HTML partial or JSON with rows
                    $('#tableBody').html(''); // Clear previous data

                    // If you're returning JSON from controller
                    if (Array.isArray(response)) {
                        let rows = '';
                        let i = 1;
                        response.forEach(item => {
                            rows += `
                                <tr>
                                    <td>${i++}</td>
                                    <td>${item.application_no}</td>
                                    <td>${item.clinicname}</td>
                                    <td>${item.state}</td>
                                    <td>${item.mobile}</td>
                                </tr>
                            `;
                        });
                        $('#tableBody').html(rows);
                    } else {
                        // If you're returning HTML rows directly from controller
                        $('#tableBody').html(response);
                    }

                    $('#dataTableContainer').show(); // Show the table now
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while submitting the form.');
                }
            });
        });
    });
</script> --}}

{{-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#btnform').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            // Get form data
            var formData = {
                clinic_type: $('#clinic_type').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
            };
            alert(formData);
            console.log(formData);

            // Send AJAX request
            $.ajax({
                url: '{{ route('admin.list_archive') }}', 
                type: 'GET',
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log('Success:', response);
                    alert('Form submitted successfully!');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error:', error);
                    alert('An error occurred while submitting the form.');
                }
            });
        });
    });
 </script> --}}
{{-- <script nonce="{{ $cspNonce }}">
    document.getElementById("checkAll").addEventListener("change", function () {
        let checkboxes = document.querySelectorAll(".customSingleCheckBox");
        alert(checkboxes)
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script> --}}
{{-- <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form[method='GET']");
        const clinicType = form.querySelector("select[name='clinic_type']");
        const startDate = form.querySelector("input[name='start_date']");
        const endDate = form.querySelector("input[name='end_date']");
        const button = form.querySelector("button[type='submit']");

        form.addEventListener("submit", function (e) {
            if (!clinicType.value || !startDate.value || !endDate.value) {
                e.preventDefault();
                alert("Please select clinic type and date range.");
            }
        });
    });
</script> --}}
@endsection

