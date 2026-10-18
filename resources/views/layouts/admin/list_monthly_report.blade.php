@extends(session('user_type') == '5' ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')

@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div {
            background-color: #141481;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-admin-submit-button {
            margin-top: 32px;
        }

        .csp-admin-table {
            min-width: 845px;
        }

        .csp-admin-clinic-type {
            color: #ff0000;
        }

        #dataTableContainer {
            display: none;
        }

        table.data-table {
            border-collapse: collapse;
            /* Merge borders */
            width: 100%;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            /* Black border */
            text-align: center;
            padding: 8px;
        }

        /* Optional: different style for main heading */
        table.data-table thead tr:first-child th {
            background-color: #f2f2f2;
        }
    </style>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

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
                        <h4 class="card-title">Summary of Clinic</h4>
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
                                    <label for="app_type"><strong>Application Type</strong><span
                                            class="csp-admin-clinic-type"></span></label>
                                    <select class="form-control" id="app_type" name="app_type">
                                        <option value="registration">Registration</option>
                                        <option value="renewal">Renewal</option>
                                        <option value="addresschange">Address Change</option>
                                        <option value="namechange">Name Change</option>
                                        <option value="manpowerchange">Manpower Change</option>
                                        <option value="withdrawl_closure">Withdrawl/Closure</option>
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <label for="start_date"><strong>State</strong><span
                                            class="csp-admin-clinic-type"></span></label>
                                    @if (session('user_type') == '5')
                                        <input type="text" id="state" name="state"
                                            value="{{ session('state_name') }}" readonly class="form-control">
                                    @else
                                        <select class="form-control" id="state" name="state">
                                            <option value="">All State</option>
                                            @foreach ($states as $data)
                                                <option value="{{ $data->state_name }}">{{ $data->state_name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-xl-2">
                                    <label for="start_date"><strong>Start Date</strong><span
                                            class="csp-admin-clinic-type"></span></label>
                                    <input class="form-control" type="date" id="start_date" name="start_date"
                                        value="">
                                </div>
                                <div class="col-xl-2">
                                    <label for="end_date"><strong>End Date</strong><span
                                            class="csp-admin-clinic-type">*</span></label>
                                    <input class="form-control" type="date" id="end_date" name="end_date"
                                        value="">
                                </div>
                                <div class="col-xl-2">
                                    <button type="submit" id="btnsubmit"
                                        class="btn btn-sm btn-primary csp-admin-submit-button">Search</button>
                                </div>
                            </div>

                        </form>
                        <button id="exportBtn" class="btn btn-primary">Export to PDF</button>
                        <button id="exportExcelBtn" class="btn btn-primary">Export to Excel</button>
                        <table id="example5" class="display data-table" style="min-width: 845px;">
                            <thead>
                                <!-- Main heading row -->
                                <tr>
                                    <th colspan="2"></th>
                                    <th colspan="3">ART</th>
                                    <th colspan="3">Surrogacy</th>
                                    <th colspan="3">ART BANK</th>
                                    <th colspan="3">TOTAL</th>
                                </tr>
                                <!-- Sub-heading / label row -->
                                <tr>
                                    <th>Sl. No</th>
                                    <th>State</th>
                                    <th>Received</th>
                                    <th>Registered</th>
                                    <th>Rejected</th>
                                    <th>Received</th>
                                    <th>Registered</th>
                                    <th>Rejected</th>
                                    <th>Received</th>
                                    <th>Registered</th>
                                    <th>Rejected</th>
                                    <th>Received</th>
                                    <th>Registered</th>
                                    <th>Rejected</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Example data row -->
                                {{-- <tr>
                                <td>1</td>
                                <td>State Name</td>
                                <td>10</td>
                                <td>8</td>
                                <td>2</td>
                                <td>5</td>
                                <td>4</td>
                                <td>1</td>
                                <td>3</td>
                                <td>2</td>
                                <td>1</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                            </tr> --}}
                                <!-- Add more rows dynamically -->
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jspdf.umd.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jspdf.plugin.autotable.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/xlsx.full.min.js') }}"></script>
    {{-- <script nonce="{{ $cspNonce }}" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> --}}





    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {

            $("#exportBtn").click(function() {
                const {
                    jsPDF
                } = window.jspdf;

                // Landscape, points, A4
                const doc = new jsPDF('l', 'pt', 'a4');

                // Heading text with Bootstrap secondary color (#6c757d)
                doc.setFontSize(18); // Bigger heading
                doc.setTextColor(108, 117, 125); // Bootstrap secondary rgb(108,117,125)
                doc.text("Summary of Clinic", 40, 40);

                // AutoTable configuration
                doc.autoTable({
                    html: '#example5',
                    startY: 70, // Push table below heading
                    theme: 'grid',
                    headStyles: {
                        fillColor: [108, 117, 125]
                    }, // Secondary color
                    styles: {
                        fontSize: 9
                    }
                });

                // Save file
                doc.save("monthly-report.pdf");
            });
            document.getElementById('exportExcelBtn').addEventListener('click', function() {
                var wb = XLSX.utils.table_to_book(document.getElementById('example5'), {
                    sheet: "Monthly_report"
                });
                XLSX.writeFile(wb, 'monthly-report.xlsx');
            });
        });
        $(document).ready(function() {

            if ($.fn.DataTable.isDataTable('#example5')) {
                $('#example5').DataTable().destroy();
            }

            $('#btnform').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    state: $('#state').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    app_type: $('#app_type').val()
                };
                //if (formData.end_date === '') {
                //    alert("Please select End Date.");
                //    
                //    if (formData.end_date === '') {
                //        $('#end_date').focus();
                //    } 
                //    return false; // stop further execution
                //}
                $.ajax({
                    url: '{{ route('admin.monthly_report_list') }}',
                    type: 'GET',
                    data: formData,
                    beforeSend: function() {
                        // Show loader before request starts
                        $('#tableBody').html(
                            '<tr><td colspan="14" style="text-align:center;">Loading...</td></tr>'
                            );
                    },
                    success: function(response) {
                        let rows = '';
                        $('#tableBody').html('');

                        if (response.length > 0) {
                            let total_artclinic_recieve = 0;
                            let total_artclinic_registered = 0;
                            let total_artclinic_rejected = 0;
                            let total_surrogacy_recieve = 0;
                            let total_surrogacy_registered = 0;
                            let total_surrogacy_rejected = 0;
                            let total_artbank_recieve = 0;
                            let total_artbank_registered = 0;
                            let total_artbank_rejected = 0;
                            let total_1 = 0;
                            let total_2 = 0;
                            let total_3 = 0;
                            response.forEach((item, index) => {
                                total_artclinic_recieve += Number(item
                                    .artclinic_recieve_count) || 0;
                                total_artclinic_registered += Number(item
                                    .artclinic_registerd_count) || 0;
                                total_artclinic_rejected += Number(item
                                    .artclinic_rejected_count) || 0;
                                total_surrogacy_recieve += Number(item
                                    .surrogacyclinic_recieve_count) || 0;
                                total_surrogacy_registered += Number(item
                                    .surrogacyclinic_registerd_count) || 0;
                                total_surrogacy_rejected += Number(item
                                    .surrogacyclinic_rejected_count) || 0;
                                total_artbank_recieve += Number(item
                                    .artbank_recieve_count) || 0;
                                total_artbank_registered += Number(item
                                    .artbank_registerd_count) || 0;
                                total_artbank_rejected += Number(item
                                    .artbank_rejected_count) || 0;
                                total_1 += Number(item.total_1) || 0;
                                total_2 += Number(item.total_2) || 0;
                                total_3 += Number(item.total_3) || 0;
                                rows += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.state}</td>
                                <td>${item.artclinic_recieve_count}</td>
                                <td>${item.artclinic_registerd_count}</td>
                                <td>${item.artclinic_rejected_count}</td>
                                <td>${item.surrogacyclinic_recieve_count}</td>
                                <td>${item.surrogacyclinic_registerd_count}</td>
                                <td>${item.surrogacyclinic_rejected_count}</td>
                                <td>${item.artbank_recieve_count}</td>
                                <td>${item.artbank_registerd_count}</td>
                                <td>${item.artbank_rejected_count}</td>
                                <td>${item.total_1}</td>
                                <td>${item.total_2}</td>
                                <td>${item.total_3}</td>
                            </tr>`;
                            });
                            rows += `<tr style="font-weight:bold; background-color:#f2f2f2;">
                                <td></td>
                                <td>Total</td>
                                <td>${total_artclinic_recieve}</td>
                                <td>${total_artclinic_registered}</td>
                                <td>${total_artclinic_rejected}</td>
                                <td>${total_surrogacy_recieve}</td>
                                <td>${total_surrogacy_registered}</td>
                                <td>${total_surrogacy_rejected}</td>
                                <td>${total_artbank_recieve}</td>
                                <td>${total_artbank_registered}</td>
                                <td>${total_artbank_rejected}</td>
                                <td>${total_1}</td>
                                <td>${total_2}</td>
                                <td>${total_3}</td>
                            </tr>`;
                            $('#tableBody').html(rows);
                        } else {
                            $('#tableBody').html(
                                '<tr><td colspan="14">No records found.</td></tr>');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#tableBody').html(
                            '<tr><td colspan="14">Error loading data.</td></tr>');
                    }
                });
            });
            $('#tableBody').html('<tr><td colspan="14">No records found.</td></tr>');
        });
    </script>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {

            // ✅ New Excel export
            $("#exportExcelBtn").click(function() {
                // Get the table element
                const table = document.getElementById("example5");

                // Convert to a workbook
                const wb = XLSX.utils.table_to_book(table, {
                    sheet: "Summary of Clinic"
                });

                // Export to file
                XLSX.writeFile(wb, "monthly-report.xlsx");
            });

        });
    </script>

@endsection
