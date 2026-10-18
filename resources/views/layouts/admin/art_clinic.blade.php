@extends('layouts.admin.admin_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-alert{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white;
        }
        .csp-admin-table{
            min-width: 845px;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
        .csp-admin-loader{
            display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-alert">
                            <strong> {{ session('success') }}</strong>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of ART Clinic</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="display csp-admin-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Name of Clinic</th>
                                        <th>Email Id</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="loader" class="csp-admin-loader">
        <div class="spinner"></div> <!-- Customize spinner as needed -->
    </div>
    <!-- jQuery -->
    <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {

            if ($.fn.dataTable.isDataTable('#example10')) {
                var table = $('#example12').DataTable();
                table.destroy(); // Destroy the existing DataTable
            }

            // Initialize DataTable
            $('#example12').DataTable({
                //processing: true, // This automatically shows a default loading indicator
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.art_clinic_ajax') }}', // The server-side route
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token from the meta tag
                    },
                    data: function(d) {
                        return {
                            search: d.search.value,
                            start: d.start,
                            length: d.length,
                            order: d.order
                        };
                    },
                    beforeSend: function() {
                        // Show the custom loader before making the request
                        $('#loader').show();
                    },
                    complete: function() {
                        // Hide the custom loader once the request is complete
                        $('#loader').hide();
                    },
                },
                language: {
                    paginate: {
                        previous: '<<', // Change the word for the "Previous" button
                        next: '>>'
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'applicationno'
                    },
                    {
                        data: 'clinicname'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'state'
                    },
                    {
                        data: 'datetime'
                    },
                    {

                        "render": function(data, type, row) {
                        
                            return '<a href="#" class="btn btn-info" role="button">Archive</a>';
                            
                        }
                    }
                ]
            });

        });
    </script>
@endsection
