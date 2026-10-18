@extends($user_type == 5 ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')
@section('content')

<style nonce="{{ $cspNonce }}">
    .report-card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }

    .summary-card {
        padding: 15px;
        border-radius: 10px;
        color: #fff;
    }

    .bg-blue { background: #3498db; }
    .bg-green { background: #2ecc71; }
    .bg-orange { background: #f39c12; }
    .bg-red { background: #e74c3c; }

    .summary-title {
        font-size: 13px;
    }

    .summary-value {
        font-size: 22px;
        font-weight: bold;
    }

    table.report-table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    table.report-table th,
    table.report-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    table.report-table thead th {
        background: #34495e;
        color: #fff;
    }

    .sub-header {
        background: #ecf0f1 !important;
        color: #2c3e50 !important;
    }

    /* STATUS BADGES */
    .badge-status {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
    }

    .badge-final { background: #2ecc71; }
    .badge-pending { background: #f39c12; }
    .badge-nil { background: #e74c3c; }

   #consReport thead th {
        text-align: center;   /* horizontal centering */
    }
</style>

<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="summary-card bg-blue p-3 text-white rounded shadow-sm">
                <h5 class="mb-3">Total Registrations</h5>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-medical fa-2x me-3"></i>
                    <div>
                        <strong>ART Clinics:</strong> {{ $clinicCounts['ARTCLINIC'] ?? 0 }}
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-alt fa-2x me-3"></i>
                    <div>
                        <strong>ART Banks:</strong> {{ $clinicCounts['ARTBANK'] ?? 0 }}
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-invoice fa-2x me-3"></i>
                    <div>
                        <strong>Surrogacy Clinics:</strong> {{ $clinicCounts['ARTSURROGACY'] ?? 0 }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card bg-green p-3 text-white rounded shadow-sm">
                <h5 class="mb-3">Finalized Reports</h5>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-medical fa-2x me-3"></i>
                    <div>ART Clinic: {{ $finalizedCounts['ARTCLINIC'] ?? 0 }}</div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-alt fa-2x me-3"></i>
                    <div> ART Bank: {{ $finalizedCounts['ARTBANK'] ?? 0 }}</div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-invoice fa-2x me-3"></i>
                    <div>Surrogacy Clinics: {{ $finalizedCounts['ARTSURROGACY'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card bg-green p-3 text-white rounded shadow-sm">
                <h5 class="mb-3">Live Reports</h5>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-medical fa-2x me-3"></i>
                    <div>ART Clinic: 
                        <a href="#"
                        class="text-white text-decoration-underline clinic-list-link"
                        data-status="live"
                        data-type="{{ encrypt('ARTCLINIC') }}">
                            {{ $liveCounts['ARTCLINIC'] }}
                        </a>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-alt fa-2x me-3"></i>
                    ART Bank:  
                    <a href="#"
                        class="text-white text-decoration-underline clinic-list-link"
                        data-status="live"
                        data-type="{{ encrypt('ARTBANK') }}">
                            {{ $liveCounts['ARTBANK'] }}
                    </a>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-invoice fa-2x me-3"></i>
                    Surrogacy Clinics: 
                    <a href="#"
                        class="text-white text-decoration-underline clinic-list-link"
                        data-status="live"
                        data-type="{{ encrypt('ARTSURROGACY') }}">
                            {{ $liveCounts['ARTSURROGACY'] }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card bg-green p-3 text-white rounded shadow-sm">
                <h5 class="mb-3">Not Started</h5>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-medical fa-2x me-3"></i>
                        <div class="me-3">
                            ART Clinic: 
                            <a href="#"
                            class="text-white text-decoration-underline clinic-list-link"
                            data-status="not-started"
                            data-type="{{ encrypt('ARTCLINIC') }}">
                                {{-- {{ ($clinicCounts['ARTCLINIC']-($finalizedCounts['ARTCLINIC']+$liveCounts['ARTCLINIC'])) }} --}}
                                {{ $clinicsnotstarted['ARTCLINIC'] }}
                            </a>
                        </div>
                        @php
                            $totalNotStarted =
                                ($clinicsnotstarted['ARTCLINIC'] ?? 0) +
                                ($clinicsnotstarted['ARTBANK'] ?? 0) +
                                ($clinicsnotstarted['ARTSURROGACY'] ?? 0);
                        @endphp
                        @if(session('user_type') != 5)
                            <button type="button"
                                class="btn btn-light btn-sm py-1 px-2 send-notification"
                                data-type="{{ encrypt('ARTCLINIC') }}"
                                {{ $totalNotStarted == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-paper-plane me-1"></i> Send Notification
                            </button>
                        @endif
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-file-alt fa-2x me-3"></i>
                    <div> ART Bank: 
                        <a href="#"
                        class="text-white text-decoration-underline clinic-list-link"
                        data-status="not-started"
                        data-type="{{ encrypt('ARTBANK') }}">
                            {{-- {{ ($clinicCounts['ARTBANK']-($finalizedCounts['ARTBANK']+$liveCounts['ARTBANK'])) }} --}}
                            {{ $clinicsnotstarted['ARTBANK'] }}
                        </a>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-invoice fa-2x me-3"></i>
                    <div>Surrogacy Clinics: 
                        <a href="#"
                        class="text-white text-decoration-underline clinic-list-link"
                        data-status="not-started"
                        data-type="{{ encrypt('ARTSURROGACY') }}">
                            {{-- {{ ($clinicCounts['ARTSURROGACY']-($finalizedCounts['ARTSURROGACY']+$liveCounts['ARTSURROGACY'])) }} --}}
                            {{ $clinicsnotstarted['ARTSURROGACY'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card report-card">
        <div class="card-body">
            
          <div class="row mb-3">
                <div class="col-md-3">
                    <label for="yearFilter">Select Year:</label>
                    <select id="yearFilter" class="form-control" style="width:150px; display:inline-block;">
                        <option value="All" selected>All</option>
                        @foreach($allYears as $y)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table id="consReport" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Year</th>
                        <th>Quarter</th>
                        <th colspan="3">ART CLINIC</th>
                        <th colspan="3">ART BANK</th>
                        <th colspan="3">SURROGACY CLINIC</th>
                    </tr>
                    <tr>
                        <th></th><th></th><th></th>
                        <th>Submitted</th><th>Finalized</th><th>In-progress</th>
                        <th>Submitted</th><th>Finalized</th><th>In-progress</th>
                        <th>Submitted</th><th>Finalized</th><th>In-progress</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">Total</th>
                        <th></th><th></th><th></th>
                        <th></th><th></th><th></th>
                        <th></th><th></th><th></th>
                    </tr>
                </tfoot>
            </table>
       </div>
    </div>

</div>
<div class="modal fade"
     id="liveClinicModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header 
                d-flex align-items-center">
                <h5 class="modal-title" id="clinicModalTitle">
                    Live Reporting Clinics
                </h5>
                <button type="button" id="exportModalPdfBtn" class="btn btn-sm btn-primary ms-auto me-3" 
                    style="display: none;">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>

                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table id="liveClinicTable" class="table table-bordered table-striped w-100">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Clinic Name</th>
                        <th>State</th>
                        <th id="col4">Quarter</th>
                        <th id="col5">Year</th>
                    </tr>
                    </thead>
                </table>

            </div>

        </div>
    </div>
</div>
<!-- <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script> -->
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.umd.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.plugin.autotable.min.js')}}"></script>

<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {

        var columns = [
            { data: 'index' },
            { data: 'year' },
            { data: 'quarter' }
        ];

        columns = columns.concat([
            { data: 'art_total' },
            { data: 'art_submitted' },
            { data: 'art_inprogress' },
            { data: 'ban_total' },
            { data: 'ban_submitted' },
            { data: 'ban_inprogress' },
            { data: 'sur_total' },
            { data: 'sur_submitted' },
            { data: 'sur_inprogress' }
        ]);

        var table = $('#consReport').DataTable({
            responsive: true,
            paging: true,
            searching: false,
            ordering: true,
            ajax: {
                url: "{{ route('admin.patient_detail_consolidated') }}",
                data: function(d) {
                    d.year = $('#yearFilter').val();
                }
            },
            columns: columns,
               footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api();
                    var intVal = function ( i ) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
                    };
                    for (var i = 3; i <= 11; i++) {
                        var total = api.column(i).data().reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(i).footer()).html(total);
                    }
                }
            });

        $('#yearFilter').change(function() {
            table.ajax.reload();
        });
    });
    document.addEventListener("DOMContentLoaded", function () {

        const modalElement = document.getElementById("liveClinicModal");
        const clinicListBaseUrl = "{{ url('/dashboard/live-clinics') }}";
        

        document.querySelectorAll(".clinic-list-link").forEach(function (link) {

            link.addEventListener("click", function (e) {

                e.preventDefault();


                const status = this.dataset.status;

                if (status === "live") {
                    document.getElementById("clinicModalTitle").textContent = "Live Reporting Clinics";
                    $("#exportModalPdfBtn").hide(); // Hide button for Live
                } else {
                    document.getElementById("clinicModalTitle").textContent = "Clinics/Banks that have not started patient reporting";
                    $("#exportModalPdfBtn").show(); // Hide button for Live
                }

                const url = clinicListBaseUrl
                            + "/"
                            + status
                            + "/"
                            + encodeURIComponent(this.dataset.type);
                const liveColumns = [
                    {
                        data:null,
                        render:function(data,type,row,meta){
                            return meta.row+1;
                        }
                    },
                    {data:'name'},
                    {data:'state'},
                    {data:'description'},
                    {data:'year'}
                ];

                const notStartedColumns = [
                    {
                        data:null,
                        render:function(data,type,row,meta){
                            return meta.row+1;
                        }
                    },
                    {data:'name'},
                    {data:'state'},
                    {data:'email'},
                    {
                        data:null,
                        defaultContent:"Not Started"
                    }
                ];
                if(status==="live"){
                    $("#col4").text("Quarter");
                    $("#col5").text("Year").show();
                }else{
                    $("#col4").text("Email");
                    $("#col5").text("Status").show();
                }

                if ($.fn.DataTable.isDataTable('#liveClinicTable')) {
                    $('#liveClinicTable').DataTable().clear().destroy();
                }

                $('#liveClinicTable').DataTable({
                    processing: true,
                    destroy: true,
                    responsive: true,
                    searching: true,
                    paging: true,
                    ordering: true,
                    lengthChange: true,
                    pageLength: 10,

                    ajax: {
                        url: url,
                        dataSrc: 'livedata'
                    },

                    columns: status=="live"
                    ? liveColumns
                    : notStartedColumns,

                    dom: 'Bfrtip',

                    buttons: [
                        {
                            extend: 'excelHtml5',
                            title:
                                status === "live"
                                    ? "Live Reporting Clinics"
                                    : "Not Started Clinics"
                        },
                        {
                            extend: 'csvHtml5',
                            title:
                                status === "live"
                                    ? "Live Reporting Clinics"
                                    : "Not Started Clinics"
                        },
                        {
                            extend: 'pdfHtml5',
                            title:
                                status === "live"
                                    ? "Live Reporting Clinics"
                                    : "Not Started Clinics"
                        },
                        {
                            extend: 'print',
                            title:
                                status === "live"
                                    ? "Live Reporting Clinics"
                                    : "Not Started Clinics"
                        }
                    ]
                });

                bootstrap.Modal.getOrCreateInstance(modalElement).show();

            });

        });

    });

    $(document).ready(function () {
    
        $("#exportModalPdfBtn").off('click').on('click', function () {
            
            // 1. Fallback check for jsPDF
            let jsPDF_Constructor = window.jspdf ? window.jspdf.jsPDF : window.jsPDF;
            if (!jsPDF_Constructor) {
                alert("PDF library is not loaded properly! Please add the CDN scripts.");
                return;
            }

            const doc = new jsPDF_Constructor('p', 'pt', 'a4'); 

            // 2. Figure out which report we are viewing
            let reportTitle = document.getElementById("clinicModalTitle").textContent.trim();
            let isLive = reportTitle.includes("Live"); // true if Live, false if Not Started

            // Add Document Title
            doc.setFontSize(16); 
            doc.setTextColor(50, 50, 50); 
            doc.text(reportTitle, 40, 40);

            // Fetch Modal DataTable instance
            let table = $('#liveClinicTable').DataTable();
            let filteredData = table.rows({ search: 'applied' }).data();
            
            // 3. Build Header dynamically based on the view
            let tempTableId = "pdfTempTableModal";
            let html = `<table id="${tempTableId}"><thead><tr>`;
            
            if (isLive) {
                html += `<th>#</th>
                        <th>Clinic Name</th>
                        <th>State</th>
                        <th>Quarter</th>
                        <th>Year</th>`;
            } else {
                html += `<th>#</th>
                        <th>Clinic Name</th>
                        <th>State</th>
                        <th>Email</th>
                        <th>Status</th>`;
            }
            
            html += `</tr></thead><tbody>`;

            // 4. Loop through AJAX data and map specific JSON keys
            let counter = 1;
            filteredData.each(function(row) {
                // Common columns for both
                let name = row.name ? row.name : 'N/A';
                let state = row.state ? row.state : 'N/A';
                
                html += `<tr>
                            <td>${counter}</td>
                            <td>${name}</td>
                            <td>${state}</td>`;
                            
                // Conditional columns based on view
                if (isLive) {
                    // Your live query returns 'description' for quarter and 'year'
                    let quarter = row.description ? row.description : 'N/A';
                    let year = row.year ? row.year : 'N/A';
                    
                    html += `<td>${quarter}</td>
                            <td>${year}</td>`;
                } else {
                    // Your not started query returns 'email'
                    let email = row.email ? row.email : 'N/A';
                    
                    html += `<td>${email}</td>
                            <td>Not Started</td>`;
                }

                html += `</tr>`;
                counter++;
            });

            html += `</tbody></table>`;
            
            // Temporarily append to body
            $('body').append(html);

            // 5. Convert to PDF
            doc.autoTable({
                html: '#' + tempTableId,
                startY: 60,
                theme: 'grid',
                headStyles: { 
                    fillColor: [108, 117, 125], 
                    fontSize: 8 
                },
                styles: { 
                    fontSize: 8, 
                    cellPadding: 3, 
                    halign: 'center', 
                    overflow: 'linebreak' 
                },
                didDrawPage: function (data) {
                    let pageHeight = doc.internal.pageSize.height;
                    doc.setFontSize(8);
                    doc.text("Page " + doc.internal.getNumberOfPages(), data.settings.margin.left, pageHeight - 10);
                }
            });

            // Clean up DOM and Save (formats title nicely for filename)
            $('#' + tempTableId).remove();
            let fileName = reportTitle.replace(/\s+/g, '-') + ".pdf";
            doc.save(fileName);
        });

    
        $(document).on('click', '.send-notification', function (e) {
            e.preventDefault();

            let btn = $(this);

            if (!confirm('Are you sure you want to send reminder notifications to all clinics that have not started patient reporting?')) {
                return;
            }

            btn.prop('disabled', true);

            $.ajax({
                url: "{{ route('patient.reporting.reminder.send') }}",
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {

                    if (response.success) {
                        alert(response.message);

                        // Keep button disabled after successful initiation
                        btn.prop('disabled', true);
                    } else {
                        alert(response.message);

                        // Re-enable if initiation was not allowed
                        btn.prop('disabled', false);
                    }
                },
                error: function (xhr) {

                    btn.prop('disabled', false);

                    let message = "Something went wrong.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    alert(message);
                }
            });

        });
    });

</script>
@endsection