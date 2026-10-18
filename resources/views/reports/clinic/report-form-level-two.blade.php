@extends(session('user_type') == '5' ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')
@section('content')

    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height:80px;">
                        <h3 class="card-title mb-2 text-primary">ART CLINIC - LEVEL 2</h3>
                        <h4 class="card-title text-primary">Detailed Reporting Format clinic wise</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pe-0">
                            <div class="form-left h-100 py-3 px-5">
                                <h3 class="mb-3">Patient Report Clinic Level Two</h3>

                                <!-- Display success message -->
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger col-sm-12">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif

                                <form method="POST" id="report-level-two">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="year">Year</label>
                                                <select name="year" id="year" class="form-control" required>
                                                    <option value="">-- Select Year --</option>
                                                    @for ($year = date('Y'); $year >= 2022; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="quarter">Quarter</label>
                                                <select name="quarter" id="quarter" class="form-control" required>
                                                    <option>All</option>
                                                    @foreach (App\Models\patient\QuarterTable::all() as $quarter)
                                                        <option value="{{ $quarter->quarter }}">{{ $quarter->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary mt-4">Submit</button>
                                        </div>
                                    </div>
                                </form>

                                <div id="report-resulte" class="mt-4">
                                    <div class="d-flex justify-content-end align-items-center mb-3">
                                        <div class="text-end">
                                            <span class="fw-bold text-dark">From:</span>
                                            {{ @$quarter_desc . ' - ' . @$year ?? 'N/A' }}
                                            {{-- <span class="mx-3 fw-bold text-dark">To:</span> {{ $to_period ?? 'N/A' }} --}}
                                        </div>
                                    </div>
                                    <div class="text-start">
                                        <h4 class="text-primary">1. General Details</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="usersTable" class="display table table-bordered table-striped">
                                            <thead>

                                                <tr>
                                                    <th rowspan="2"class="text-center align-middle">S.No.</th>
                                                    <th rowspan="2"class="text-center align-middle">Name of the ART Clinic</th>
                                                    <th rowspan="2"class="text-center align-middle">Registration No.</th>
                                                    <th rowspan="2"class="text-center align-middle">State / UT</th>
                                                    <th colspan="2"class="text-center align-middle">Total no. of patients</th>

                                                    <th colspan="3"class="text-center align-middle">Cause of Infertility(in figures)</th>
                                                    <th colspan="4"class="text-center align-middle">Type of Treatment(in figure)</th>
                                                    <th colspan="10" class="text-center align-middle">Type of Procedures Undertaken(in figure)</th>

                                                    <th colspan="4"class="text-center align-middle">Treatment Outcome (in figures)</th>
                                                    <th colspan="5"class="text-center align-middle">Pregnancy Outcome (in figures)</th>
                                                    <th colspan="3"class="text-center align-middle">No. of child/children born</th>
                                                    <th colspan="2"class="text-center align-middle">Gender (in figures) </th>
                                                </tr>
                                                <tr>
                                                    <th>Married Couples</th>
                                                    <th>Single Women</th>
                                                    <th>Male factor</th>
                                                    <th>Female factor</th>
                                                    <th>Unexplained</th>

                                                    <th>With self-gametes</th>
                                                    <th>Oocyte donor</th>
                                                    <th>Sperm donor</th>
                                                    <th>Both donor</th>

                                                    <th>Artificial Insemination</th>
                                                    <th>Intra-uteriane Insemination(IUI)</th>
                                                    <th>In vitro Fertilization-Embryo Transfer(IVF-ET)</th>
                                                    <th>Gamete Intrafallopian Tube Transfer(GIFT)</th>
                                                    <th>Intra-cytoplasmic Sperm Injection(ICSI)</th>
                                                    <th>Physiological Intra-cytoplasmic Sperm Injection(PICSI)</th>
                                                    <th>Intra-cytoplasmic Morphologically Selecated Sperm Injection(IMSI)</th>
                                                    <th>Round Spermatid Nucleus Injection(ROSNI)</th>
                                                    <th>ELOngated Spermatid Injection(ELSI)</th>
                                                    <th>Other</th>

                                                    <th>Total No. of Cycles undertaken</th>
                                                    <th>Total No. of Cycles cancelled/Failed</th>
                                                    <th>Successful pregnancies</th>
                                                    <th>Failed pregnancies</th>

                                                    <th>Live Birth</th>
                                                    <th>Stillbirth</th>
                                                    <th>Therapeutic Abortion</th>
                                                    <th>Spontaneous Abortion</th>
                                                    <th>Elective Termination</th>

                                                    <th>singleton</th>
                                                    <th>Twin</th>
                                                    <th>higher order</th>

                                                    <th>Male</th>
                                                    <th>Female</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody id="report-result"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {

            $('#report-level-two').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('report.clinicReportLevelTwo') }}",
                    method: "POST",
                    data: formData,
                    beforeSend: function() {
                        $('#report-result').html(
                            '<div class="text-center p-3"><b>Loading Report...</b></div>');
                    },
                    success: function(response) {
                        $('#report-result').empty(); // Clear previous results


                        if ($.fn.DataTable.isDataTable('#usersTable')) {
                            $('#usersTable').DataTable().clear().destroy();
                        }
                        $('#report-result').html(response);
                        // Initialize DataTable on newly loaded content
                        var table = $('#usersTable').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            responsive: true,
                            scrollX: true,
                            destroy: true, // destroy old instance if exists
                            // dom: '<"row"<"col-md-2"l><"col-md-7"B><"col-md-3"f>>' +
                            //     'rt' +
                            //     '<"row"<"col-md-6"p>>',
                            buttons: [{
                                    extend: 'excel',
                                    text: 'Export Excel'
                                },
                                {
                                    extend: 'pdf',
                                    text: 'Export PDF'
                                },
                                {
                                    extend: 'print',
                                    text: 'Print Table'
                                }
                            ],
                            createdRow: function(row, data, dataIndex) {
                                $('td', row).addClass('align-middle text-wrap');
                            },
                            footerCallback: function(row, data, start, end, display) {
                                var api = this.api();
                                api.columns().every(function(index) {
                                    // First 3 columns are text
                                    if (index == 3) {
                                        // $(api.column(index).footer()).html('<tr class="text-center"><th colspan="3">Total</th>');

                                        $(api.column(index).footer()).text(
                                            'Total');

                                        return;
                                    }
                                    if (index == 1 || index == 2) {
                                        $(api.column(index).footer()).html(
                                            '');
                                        return;
                                    }
                                    var total = api.column(index).data()
                                        .reduce(function(a, b) {
                                            a = String(a).replace(
                                                /<[^>]*>/g, '');
                                            b = String(b).replace(
                                                /<[^>]*>/g, '');

                                            a = parseFloat(a.replace(
                                                /,/g, '')) || 0;
                                            b = parseFloat(b.replace(
                                                /,/g, '')) || 0;
                                            return a + b;
                                        }, 0);
                                    $(api.column(index).footer()).html(
                                        total);
                                });
                            }
                        });
                        // Replace report section with response HTML

                    },
                    error: function(xhr) {
                        let errorMessage = 'Something went wrong!';
                        if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }
                        $('#report-result').html(
                            '<div class="alert alert-danger">No record found</div>');
                    }
                });
                var table = $('#usersTable');
                table.find('tfoot').remove();
                var cols = table.find('thead tr:last th').length;
                cols = $('#usersTable').DataTable ? table.find('thead th').filter(function() {
                    return $(this).attr('colspan') == undefined || $(this).attr('colspan') == 1;
                }).length : cols;
                var footer = '<tfoot><tr>';
                footer += '<th colspan=4></th>';
                for (var i = 4; i < cols; i++) {
                    footer += '<th></th>';
                }
                footer += '</tr></tfoot>';
                table.append(footer);
            });
        });
    </script>

@endsection
