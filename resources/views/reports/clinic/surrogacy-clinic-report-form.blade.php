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
                        <h3 class="card-title mb-2 text-primary">SURROGACY - CLINIC</h3>
                        <h4 class="card-title text-primary">Detailed Reporting Format clinic wise</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pe-0">
                            <div class="form-left h-100 py-3 px-5">
                                <h3 class="mb-3">General Details</h3>

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

                                <form method="POST" id="surrogacy-clinic-table">
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
                                                <select name="quarter" id="quarter" class="form-control">
                                                    <option value="">All</option>
                                                    @foreach ($quarters as $quarter)
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
                                <div class="d-flex justify-content-end align-items-center mb-3 mt-4">
                                    <div class="text-end">
                                        <span class="fw-bold text-dark">From:</span>
                                        <span id="qtryrs">{{ @$quarter_desc . ' - ' . @$year >= 2022 ?? 'N/A' }}</span>
                                        {{-- <span class="mx-3 fw-bold text-dark">To:</span> {{ $to_period ?? 'N/A' }} --}}
                                    </div>
                                </div>


                                <div class="text-start">
                                    <h4 class="text-primary">1. General Details of Surrogacy</h4>
                                </div>
                                <div class="table-responsive">
                                    <table id="usersTable" class="display table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th rowspan="3" class="text-center">S.No.</th>
                                                <th rowspan="3" class="text-center">Name of the Clinic</th>
                                                <th rowspan="3" class="text-center">Registration No.</th>
                                                <th rowspan="3" class="text-center">State / UT</th>

                                                <th colspan="2" class="text-center">Total no. of Patients</th>
                                                <th colspan="2" class="text-center">Nationality (in figures)</th>
                                                <th colspan="5" class="text-center">Medical Indication (in figures)</th>
                                                <th colspan="2" class="text-center">Serving Children (in figures)</th>
                                                <th colspan="3" class="text-center">Type of Surrogacy Treatment</th>
                                                <th colspan="3" class="text-center">Total no. of Procedures Undertaken </th>
                                                <th colspan="4" class="text-center">Treatment Outcome</th>
                                                <th colspan="4" class="text-center">Pregnancy Outcome</th>
                                                <th colspan="3" class="text-center">No. of Child/Children Born</th>
                                                <th colspan="2" class="text-center">Gender</th>
                                            </tr>

                                            <tr>
                                                <th rowspan="2">Married Couples</th>
                                                <th rowspan="2">Single (Widow/Divorcee)</th>

                                                <th rowspan="2">Indian</th>
                                                <th rowspan="2">OCI Card Holder</th>

                                                <th rowspan="2">Male Factor</th>
                                                <th rowspan="2">Uterus Abnormalities</th>
                                                <th rowspan="2">Repeat IVF Failure</th>
                                                <th rowspan="2">Multiple Pregnancy Loss</th>
                                                <th rowspan="2">Life-threatening Illness</th>

                                                <th rowspan="2">Yes</th>
                                                <th rowspan="2">No</th>

                                                <th rowspan="2">With Self Gametes</th>
                                                <th colspan="2">With One Donor Gametes</th>

                                                <th rowspan="2">IVF-ET</th>
                                                <th rowspan="2">ICSI</th>
                                                <th rowspan="2">Other</th>

                                                <th rowspan="2">Total No. of Cycles undertaken</th>
                                                <th rowspan="2">Total No. of Cycles (Cancelled/Failed)</th>

                                                <th rowspan="2">Successful Pregnancies</th>
                                                <th rowspan="2">Failed Pregnancies</th>

                                                <th rowspan="2">Live Birth</th>
                                                <th rowspan="2">Still Birth</th>
                                                <th rowspan="2">Therapeutic Abortion</th>
                                                <th rowspan="2">Spontaneous Abortion</th>

                                                <th rowspan="2">Singleton</th>
                                                <th rowspan="2">Twin</th>
                                                <th rowspan="2">Higher Order</th>

                                                <th rowspan="2">Male</th>
                                                <th rowspan="2">Female</th>
                                            </tr>

                                            <tr>
                                                <th>Donor Egg</th>
                                                <th>Donor Sperm</th>
                                            </tr>
                                        </thead>


                                        <tbody id="report-result"></tbody>
                                        <tfoot id="totalRecords"></tfoot>
                                    </table>
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

            $('#surrogacy-clinic-table').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('report.surrogacyClinicReportGD') }}",
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
                        var quarterDesc = $('#report-result').find('.get_quater_desc').val();
                        $('#qtryrs').text(quarterDesc);

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
                                    if (index == 2) {
                                        // $(api.column(index).footer()).html('<tr class="text-center"><th colspan="3">Total</th>');

                                            $(api.column(index).footer()).text('Total');
                                            
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
                        // $('#totalRecords').html('Total Records: ' + table.rows().count());
                        // $('#totalRecords').text('Total Records: ' + table.rows().count());
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
                // console.log(cols);
                // console.log($('#usersTable tfoot th').length);
                cols = $('#usersTable').DataTable ? table.find('thead th').filter(function() {
                    return $(this).attr('colspan') == undefined || $(this).attr('colspan') == 1;
                }).length : cols;
                var footer = '<tfoot><tr>';
                    footer += '<th colspan=3></th>';
                for (var i = 3; i < cols; i++) {
                    footer += '<th></th>';
                }
                footer += '</tr></tfoot>';
                table.append(footer);
            });
        });
    </script>

@endsection
