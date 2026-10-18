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
                        <h3 class="card-title mb-2 text-primary">BANK</h3>
                        <h4 class="card-title text-primary">Detailed Reporting Format Bank wise</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pe-0">
                            <div class="form-left h-100 py-3 px-5">

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

                                <form method="POST" id="bank-form">
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
                                    <div class="d-flex justify-content-end align-items-center mb-3 mt-4">
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
                                        <table id="bankReportTable" class="display table table-bordered table-striped">
                                            <thead>
                                                <!-- Row 1: top-level headings -->
                                                <tr>
                                                    <th rowspan="2" class="text-center align-middle">Sr. No.</th>
                                                    <th rowspan="2" class="text-center align-middle">Name of the Bank
                                                    </th>
                                                    <th rowspan="2" class="text-center align-middle">Registration Number
                                                    </th>
                                                    <th rowspan="2" class="text-center align-middle">State / UT</th>
                                                    <th colspan="2" class="text-center align-middle">Total No. of
                                                        registered semen donors</th>
                                                    <th colspan="2" class="text-center align-middle">Total No. of
                                                        registered oocyte donors</th>
                                                    <th colspan="4" class="text-center align-middle">Nationality of
                                                        Registered Donors (in figures)</th>
                                                    <th colspan="2" class="text-center align-middle">Total No. of Samples
                                                        Stored</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center align-middle">Married</th>
                                                    <th class="text-center align-middle">Single</th>


                                                    <th class="text-center align-middle">Married</th>
                                                    <th class="text-center align-middle">Single</th>
                                                    <th class="text-center align-middle">Semen (in vials) Indian</th>
                                                    <th class="text-center align-middle">No. of oocytes Indian</th>

                                                    <th class="text-center align-middle">Semen (in vials) Foreigner</th>
                                                    <th class="text-center align-middle">No. of oocytes Foreigner</th>

                                                    <th class="text-center align-middle">Semen (in vials)</th>
                                                    <th class="text-center align-middle">No. of oocytes</th>
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
            $('#bank-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('report.bankClinicReportAjax') }}",
                    method: "POST",
                    data: formData,
                    beforeSend: function() {
                        $('#report-result').html(
                            '<div class="text-center p-3"><b>Loading Report...</b></div>');
                    },
                    success: function(response) {
                        $('#report-result').empty();

                        if ($.fn.DataTable.isDataTable('#bankReportTable')) {
                            $('#bankReportTable').DataTable().clear().destroy();
                        }
                        $('#report-result').html(response);

                        var table = $('#bankReportTable').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            responsive: true,
                            scrollX: true,
                            destroy: true,
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
                var table = $('#bankReportTable');
                table.find('tfoot').remove();
                var cols = table.find('thead tr:last th').length;
                // console.log(cols);
                // console.log($('#usersTable tfoot th').length);
                cols = $('#bankReportTable').DataTable ? table.find('thead th').filter(function() {
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
