@extends('layouts.admin.admin_master')
{{-- @extends('layouts.admin.admin_siderbar_nav') --}}
@section('content')


        <style nonce="{{ $cspNonce }}">
            .btn-secondary {
            --bs-btn-color: #fff;
            --bs-btn-bg: #210f77;
            --bs-btn-border-color: #210f77;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #210f77;
            --bs-btn-hover-border-color: #210f77;
            --bs-btn-focus-shadow-rgb: 55, 111, 106;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #210f77;
            --bs-btn-active-border-color: #210f77;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #210f77;
            --bs-btn-disabled-border-color: #210f77;
            }
            .table-responsive {
            position: relative;
            width: 100%;
            min-height: 200px; /* or height of your table */
            }

            .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
            z-index: 10;
            }

            @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
            }

            .data-table {
            opacity: 0.5; /* optional: show dimmed table under loader */
            }

            .csp-admin-message-div{
                background-color: #141481; border-color: #0b5ed7; color: white;
            }
            .csp-admin-table-100{
                min-width:100px
            }
            .csp-admin-anchor{
                background-color: #210f77; border-block-color: #210f77;border-color: #210f77;
            }
        </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="container-fluid">
            @if (session('success_add'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                        <strong> {{ session('success_add') }}</strong> 
                    </div>
                </div>
            @endif
                @if ($role == 4)
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>List of Assigned Application</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="loader"></div>
                                        <table id="example1" class="display csp-admin-table-100">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Application No.</th>
                                                    <th>Application Assigned Date</th>
                                                    {{-- <th>Applicant Details</th> --}}
                                                    <th>Embryo/Gamete</th>
                                                    <th>Transfer</th>
                                                    <th>purpose</th>    
                                                    <th>Country/State(From - To)</th>
                                                    <th>Assigned To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($get_pendency_list as $data)
                                                    <tr>
                                                        <td >{{ $loop->iteration }}</td>
                                                        {{-- <td><a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}" class="btn btn-info csp-admin-anchor">
                                                                {{ $data->application_no }}
                                                            </a>
                                                        </td> --}}

                                                        <td><a href="" class="btn btn-info csp-admin-anchor">{{ $data->application_no }}</a></td>
                                                        <td>{{ \Carbon\Carbon::parse($data->submission_date)->format('d-m-Y H:i:s') }}</td>
                                                        {{-- <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td> --}}
                                                        <td>{{ $data->transfer_of }}</td>   
                                                        <td>{{ $data->transfer }}</td>
                                                        <td>{{ $data->purpose_of_transfer }}</td>
                                                        @if(is_null($data->t_state))
                                                        <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                        @else
                                                        <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                        @endif
                                                        @if($data->user_id < 18)
                                                        <td>{{ username($data->user_id) ?? 'N/A' }}</td>
                                                        @else
                                                         <td>{{ username_request_table($data->user_id) ?? 'N/A' }}</td>
                                                         @endif
                                                        {{-- <td>{!! status_name($data->level_id) !!}</td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
    
    </div>
                            
     
       

<script nonce="{{ $cspNonce }}">

   
    // $(document).ready(function() {
    //     function initializeTable(tableId) {
    //         // Check if the table is already initialized
    //         if (!$.fn.dataTable.isDataTable(tableId)) {
    //             // Initialize DataTable
    //             var table = $(tableId).DataTable({
    //                 'paging': true,
    //                 'lengthChange': true,
    //                 'searching': true,
    //                 'ordering': true,
    //                 'info': true,
    //                 'autoWidth': true
    //             });
    //         }
    //     }

    //         $.extend(true, $.fn.dataTable.defaults.oLanguage.oPaginate, {
    //             sNext: '<i class="fa fa-chevron-right" ></i>',
    //             sPrevious: '<i class="fa fa-chevron-left" ></i>'
    //         });

    //         initializeTable('#example1');

    //          $('#searchBox').on('input', function () {
    //            $('#loader').show();

    //   // Add a slight delay to simulate loading
    //       setTimeout(() => {
    //     table.search(this.value).draw();
    //     $('#loader').hide();
    //   }, 3000); // Delay to show loader (you can adjust this)
    // });
   
    // });   


$(document).ready(function () {
 document.querySelector('.loader').style.display = 'none';

  let table;
    function initializeTable(tableId) {
        if (!$.fn.dataTable.isDataTable(tableId)) {
            table = $(tableId).DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                language: {
                    paginate: {
                        next: '<i class="fa fa-chevron-right"></i>',
                        previous: '<i class="fa fa-chevron-left"></i>'
                    }
                }
            });
        } else {
            table = $(tableId).DataTable();
        }
    }

    initializeTable('#example1');

    $('input[type="search"]').on('input', function () {
       document.querySelector('.loader').style.display = 'block';

        setTimeout(() => {
            table.search(this.value).draw();
            document.querySelector('.loader').style.display = 'none';
        }, 400); // Simulated delay
    });

    $('#example1').on('page.dt', function () {
       document.querySelector('.loader').style.display = 'block';
         setTimeout(() => {
        const table = $('#example1').DataTable(); 
        document.querySelector('.loader').style.display = 'none';
         }, 400); 
    });

});
</script>


@endsection