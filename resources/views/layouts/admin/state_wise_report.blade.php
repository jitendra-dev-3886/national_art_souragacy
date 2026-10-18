@extends(session('user_type') == '5' ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')

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
        table.data-table {
        border-collapse: collapse; /* Merge borders */
        width: 100%;
    }

    table.data-table th,
    table.data-table td {
        border: 1px solid #000; /* Black border */
        text-align: center;
        padding: 8px;
    }

    /* Optional: different style for main heading */
    table.data-table thead tr:first-child th {
        background-color: #f2f2f2;
    }

    .dt-column-title{
        text-align: center;
     }
    </style>
     {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css"> --}}
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
                    <h4 class="card-title">State Wise Clinic Data</h4>
                </div>
                {{-- <div class="col-xl-2">
                    <button type="button" id="btnExport" class="btn btn-sm btn-success" style="margin-top: 32px;">Export to Excel</button>
                </div> --}}
                <div class="card-body">
                    {{-- <div class="table-responsive"> --}}
                        <form action="#" id="btnform" method="GET">
                            @csrf
                            <div class="row">
                                {{-- <div class="col-xl-2 mb-3">  
                                </div> --}}
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
                                        <option value="">Select</option>
                                          @foreach($states as $data)
                                                <option value="{{ $data->state_name }}">{{ $data->state_name }}</option>
                                            @endforeach
                                    </select>
                                    @endif
                                </div>
                                <div class="col-xl-2">
                                    <label for="start_date"><strong>Type Of Clinic</strong><span
                                        class="csp-admin-clinic-type"></span></label>
                                    <select class="form-control" id="typeofclinic" name="typeofclinic">
                                        <option value="">Select</option>
                                         <option value="Art clinic">Art clinic</option>
                                         <option value="Art Bank">Art Bank</option>
                                         <option value="Surrogacy Clinic">Surrogacy Clinic</option>
                                         
                                    </select>
                                </div>
                                <div class="col-xl-2">
                                    <label for="start_date"><strong>Start Date</strong><span
                                        class="csp-admin-clinic-type"></span></label>
                                    <input class="form-control" type="date" id="start_date" name="start_date" value="">
                                </div>
                                <div class="col-xl-2">
                                    <label for="end_date"><strong>End Date</strong><span
                                        class="csp-admin-clinic-type">*</span></label>
                                    <input class="form-control" type="date" id="end_date" name="end_date" value="">
                                </div>
                                <div class="col-xl-2">
                                    <button type="submit" id="btnsubmit" class="btn btn-sm btn-primary csp-admin-submit-button">Search</button>
                                </div>
                            </div>
                        </form>
                <div class="mt-4">
                    <button id="exportBtn" class="btn btn-primary">Export to PDF</button>
                    <button id="exportExcelBtn" class="btn btn-primary">Export to Excel</button>
                </div>
                </br></br>
                 <table id="example5" class="display data-table">
                        <thead>
                            <!-- Main heading row -->
                            <tr>
                                <th colspan="16" class="typeofclinic2" id="typeofclinic2"></th>
                            </tr>
                            <!-- Sub-heading / label row -->
                            <tr>
                                <th>Sl. No</th>
                                <th>Application Status</th>
                                <th>Application No</th>
                                <th id="nameColumn">Name of the Clinic</th>
                                <th>Level</th>
                                <th id="addressColumn">Address of the Clinic</th>
                                <th>State</th>
                                <th>District</th>
                                <th id="TypeColumn">Type of Clinic</th>
                                <th>Emaiil ID</th>
                                <th>Date of online submission form</th>
                                <th>Date of payment of fees</th>
                                <th>Date on which application received by authority</th>
                                <th>Registration Certificate issued</th>
                                <th>Registration No</th>
                                <th>Registration Date</th>
                                {{-- <th>Registered</th>
                                <th>Rejected</th> --}}
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
{{-- <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script> --}}
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.umd.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.plugin.autotable.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/xlsx.full.min.js') }}"></script>



<script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
    $('#typeofclinic').on('change', function () {
        let value = $(this).val();
        if (value === 'Art Bank') {
            $('#nameColumn').text('Name of the Bank');
            $('#addressColumn').text('Address of the Bank');
            $('#TypeColumn').text('Type of Bank')
        } else {
            $('#nameColumn').text('Name of the Clinic');
            $('#addressColumn').text('Address of the Clinic');
            $('#TypeColumn').text('Type of Clinic')
        }
    });
    $("#exportBtn").click(function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4');  

    // Title
    doc.setFontSize(18); 
    doc.setTextColor(108, 117, 125); 
    doc.text("State wise of Clinic", 40, 40);

    // Fetch DataTable instance
    let table = $('#example5').DataTable();

    // Fetch ALL FILTERED rows (ignores pagination)
    let filteredData = table.rows({ search: 'applied' }).data();

    // Build temporary hidden HTML table
    let tempTableId = "pdfTempTable";
    let html = `<table id="${tempTableId}">
                    <thead>${$('#example5 thead').html()}</thead>
                    <tbody>`;
    let counter = 1;
    filteredData.each(function(row) {
        html += "<tr>";
        // Insert new serial number
        html += `<td>${counter}</td>`;
        counter++;

        // Add rest of columns (skip original serial no.)
        row.slice(1).forEach(col => {
            html += `<td>${col}</td>`;
        });
        html += "</tr>";
    });

    html += "</tbody></table>";

    // Add to DOM
    $('body').append(html);

    // Convert to PDF
    doc.autoTable({
        html: '#' + tempTableId,
        startY: 70,
        theme: 'grid',

        headStyles: {
            fillColor: [108, 117, 125],
            fontSize: 7,
            overflow: 'linebreak',
        },

        styles: {
            fontSize: 6,
            cellPadding: 2,
            halign: 'center',
            overflow: 'linebreak',
            cellWidth: 'auto',
        },

        // Wrap ONLY selected columns
        columnStyles: {
            0: { cellWidth: 20, overflow: 'linebreak' },
            1: { cellWidth: 40, overflow: 'linebreak' },
            2: { cellWidth: 60, overflow: 'linebreak' },
            3: { cellWidth: 80, overflow: 'linebreak' }, 
            5: { cellWidth: 42, overflow: 'linebreak' },
            5: { cellWidth: 80, overflow: 'linebreak' },
            6: { cellWidth: 50, overflow: 'linebreak' },
            10: { cellWidth: 40, overflow: 'linebreak' },
            11: { cellWidth: 40, overflow: 'linebreak' },
            12: { cellWidth: 50, overflow: 'linebreak' },
            14: { cellWidth: 85, overflow: 'linebreak' },
            15: { cellWidth: 40, overflow: 'linebreak' },
        },

        tableWidth: 'auto',
        pageBreak: 'auto',

        didDrawPage: function (data) {
            let pageHeight = doc.internal.pageSize.height;
            let pageNo = doc.internal.getNumberOfPages();
            doc.setFontSize(8);
            doc.text("Page " + pageNo, data.settings.margin.left, pageHeight - 10);
        }
    });

    // Remove the temp table
    $('#' + tempTableId).remove();

    // Save PDF
    doc.save("monthly-report.pdf");

    });
$("#exportExcelBtn").click(function () {

    let table = $('#example5').DataTable();

    // Array for Excel data
    let excelData = [];
    
    // Push visible table headers
    let headers = [];
    $('#example5 thead tr:not(:first) th').each(function () {
        headers.push($(this).text().trim());
    });
    excelData.push(headers);

    // Add ONLY searched rows with new serial number
    let counter = 1;

    table.rows({ search: 'applied' }).every(function () {

        let row = [];
        let cells = $(this.node()).find('td');

        // Insert custom serial number
        row.push(counter);
        counter++;

        // Add all columns except original serial no (index 0)
        cells.each(function (i) {
            if (i > 0) {
                row.push($(this).text().trim());
            }
        });

        excelData.push(row);
    });

    // Create Excel Sheet
    let ws = XLSX.utils.aoa_to_sheet(excelData);
    let wb = XLSX.utils.book_new();

    XLSX.utils.book_append_sheet(wb, ws, "Clinic Report");

    // Save Excel file
    XLSX.writeFile(wb, "Clinic-Report.xlsx");
});

    });
    $(document).ready(function (){
        if ($.fn.DataTable.isDataTable('#example5')) {
             $('#example5').DataTable().destroy();
        }
        function formatDate(dateString) {
                if (!dateString) return 'N/A';  // handles null
                const date = new Date(dateString);
                if (isNaN(date)) return 'N/A';  // handles invalid date
                return date.toISOString().split('T')[0]; // gives YYYY-MM-DD
        }
        $('#btnform').on('submit', function (e) {
            e.preventDefault();
            const formData = {
                state: $('#state').val(),
                typeofclinic: $('#typeofclinic').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                app_type:$('#app_type').val()
            };
        //    if (formData.end_date === '') {
        //         alert("Please select End Date.");
        //          $('#end_date').focus();
        //          return false; 
        //     }

             if (formData.typeofclinic === '') {
                alert("Please select Typeofclinic.");
                 $('#typeofclinic').focus();
                return false; 
            }
        $.ajax({
                url: '{{ route('admin.state_clinic_report_list') }}',
                type: 'GET',
                data: formData,
                beforeSend: function (){
                $('#tableBody').html('<tr><td colspan="16" style="text-align:center;">Loading.....</td></tr>');
             },
                success: function (response) {
                    console.log(response);
                    let rows = '';
                    $('#tableBody').html('');
                         if ($.fn.DataTable.isDataTable('#example5')) {
                             $('#example5').DataTable().clear().destroy();
                       }
                    if (response.length > 0){
                        $('#typeofclinic2').html(response[0].typeofclinic);

                        response.forEach((item, index) => {
                            rows += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.appstatus}</td>
                                <td>${item.applicationno}</td>
                                <td>${item.clinicname}</td>
                                <td>${!item.cliniclevel ? 'N/A' : item.cliniclevel}</td>
                                <td>${item.address}</td>
                                <td>${item.state}</td>
                                <td>${item.district}</td>
                                <td>${item.nature}</td>
                                <td>${item.email}</td> 
                                <td>${formatDate(item.applicationno_datetime_submission)}</td>
                                <td>${!item.app_date_payment ? 'N/A' : item.app_date_payment}</td>
                                <td>${!item.app_date_recieve ? 'N/A' : item.app_date_recieve}</td>
                                <td>${item.appstatus == 'Approved' ? 'Yes' : 'No'}</td>
                                <td>${item.registration_no}</td>
                                <td>${formatDate(item.rgistration_date)}</td>
                            </tr>`;
                        });
                        
                        $('#tableBody').html(rows);
                        $('#example5').DataTable({
                            pageLength: 10,
                            ordering: true,
                            searching: true,
                            scrollY: "400px",
                            scrollX: true,
                            scrollCollapse: true,
                            fixedHeader: true
                        });
                    }else{
                        $('#tableBody').html('<tr><td colspan="16">No records found.</td></tr>');
                    }
                },
                error: function (xhr){
                    console.error(xhr.responseText);
                    $('#tableBody').html('<tr><td colspan="16">Error loading data.</td></tr>');
                }
            });
        });
         $('#tableBody').html('<tr><td colspan="16">No records found.</td></tr>');
    });

</script>
@endsection

