<!-- <div id="main-wrapper">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script nonce="{{ $cspNonce }}" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <div class="content-body"> -->

@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{$cspNonce}}">
    .csp-clinic-alert-success-green {
        color: #186818;
    }

    .csp-clinic-table {
        min-width: 845px;
    }

    .csp-clinic-bg-blue {
        background-color: #13139d;
        border-block-color: #10107d;
        border-color: blue;
    }
</style>


    <div class="container-fluid">
        @if (session('success'))
              
                <div class="alert alert-success csp-clinic-alert-success-green">
                    {{ session('success') }}</strong>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Application</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                               
                                <table id="example1" class="display csp-clinic-table">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Transfer</th>
                                        <th>Transfer of</th>
                                        <th>Name of the Spouse</th>
                                        <th>Email ID of the Spouse</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Date of Submission of application form</th>
                                        <th>View</th>
                                        <th>Status of application</th>
                                        <th>Date of Issue of NOC</th>
                                        <th>Download NOC</th>                                        
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($userdata as $data)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ url('noc/view_user_form/' . $data->application_id) }}/{{ $data->level_id }}"
                                                  class="csp-clinic-bg-blue">"
                                                    
                                                    class="btn btn-info">
                                                    {{ $data->application_no }}
                                                </a>
                                            </td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>{{ $data->name_applicant }}</td>              
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->address }}</td>
                                            <td>{{ $data->state }}</td>
                                            <td>{{ $data->district }}</td>
                                            <td>{!! status_name($data->level_id) !!}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
    </div>
    <script nonce="{{ $cspNonce }}">
$(document).ready(function() {
        function initializeTable(tableId) {
            // Check if the table is already initialized
            if (!$.fn.dataTable.isDataTable(tableId)) {
                // Initialize DataTable
                var table = $(tableId).DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
            }
        }

        $.extend(true, $.fn.dataTable.defaults.oLanguage.oPaginate, {
    sNext: '<i class="fa fa-chevron-right" ></i>',
    sPrevious: '<i class="fa fa-chevron-left" ></i>'
});

        initializeTable('#example1');
    });
</script>
@endsection

<!-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('select').on('change', function() {
            var id = this.id;
            var value = this.value;
            var name = this.name;
            var $this = $(this);
            if (value == 'Approve') {
                $.ajax({
                    type: "POST",
                    url: "update_status.php",
                    data: {
                        id: id,
                        value: value,
                        name: name
                    },
                    success: function(data) {
                        $this.closest('td').html(data);
                    }
                });
            }
        });
    });
</script>

<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        // Function to initialize DataTable and style buttons for a single table
        function initializeTable(tableId) {
            // Check if the table is already initialized
            if (!$.fn.dataTable.isDataTable(tableId)) {
                $(tableId).DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });

                // Apply custom styles to the previous and next buttons
                $(tableId + '_previous').css({
                    'width': '114px', // Width of the previous button
                    'background-color': 'rgb(9 3 28)', // Blue background
                    'color': '#fff' // White text
                });
                $(tableId + '_next').css({
                    'width': '114px', // Width of the next button
                    'background-color': 'rgb(9 3 28)', // Blue background
                    'color': '#fff' // White text
                });
            }
        }

        // Initialize a specific table (e.g., #example1)
        initializeTable('#example');
    });


    function handleClick(checkbox) {
        let drpt = checkbox.value;
        let drval = 'drop' + drpt;
        var dropdown = $('#' + drval);
        var dropdownValue = dropdown.val();

        if (dropdownValue == null || dropdownValue == '') {
            alert("Please select to Assign Value!");
            checkbox.checked = false;
            dropdown.focus();
        }
    }

    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const checkboxes = document.querySelectorAll('input[name="select_check_box"]:checked');
        const selectedValues = Array.from(checkboxes).map(checkbox => checkbox.value);

        if (selectedValues.length > 0) {
            swal({
                title: "Confirm Action",
                text: "Are you sure you want to assign this role?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, load it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    selectedValues.forEach(value => {
                        let drval = 'drop' + value;
                        let dropdown = $('#' + drval).val();
                        const data = dropdown.split("-");
                        let nocid = data[0];
                        let level_id = data[1];
                        let userid = data[2];
                        let serviceid = data[3];

                        $.ajax({
                            url: 'http://localhost/artregistry_security_audit_noc/noc/ajax_data.php',
                            type: 'POST',
                            data: {
                                app_id: nocid,
                                level_id: level_id,
                                user_id: userid,
                                serviceid: serviceid
                            },
                            success: function(response) {
                                if (response) {
                                    // handle success if needed
                                }
                            }
                        });
                    });
                    swal("Success!", "Role assigned to users.", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                } else {
                    swal("Cancelled", "No changes were made.", "info");
                }
            });
        } else {
            swal("Warning", "Please select at least one item.", "warning");
        }
    });
</script> -->
