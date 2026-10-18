@php
    $userType = session('user_type');
@endphp

@extends(
    $userType == 5 
        ? 'layouts.admin.ssa_master' 
        : (in_array($userType, range(6,10)) 
            ? 'layouts.admin.admin_master' 
            : 'layouts.admin.admin_master')
)
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">       
            <div class="card-body">  
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h3 class="card-title mb-2 text-primary">ART TREATMENT FOR SURROGACY</h3>
                    <h4 class="card-title text-primary">Detailed Reporting Format ART Treatment Clinic Wise</h4>
                </div>
                <div class="row">
                    <div class="col-md-12 pe-0">
                        <div class="form-left h-100 py-3 px-5">
                            <h3 class="mb-3">Patient Report ART Treatment for Surrogacy Clinic</h3>
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
                            
                            <form id="report-level-one" method="POST"  name="filterform">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="year">Year</label>
                                            <select name="year" id="year" class="form-control" required>
                                                <option value="">-- Select Year --</option>
                                                @for($year = date('Y'); $year >= 2022; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="quarter">Quarter</label>
                                            <select name="quarter" id="quarter" class="form-control" required>
                                                <option value="All">All</option>
                                                @foreach(App\Models\patient\QuarterTable::all() as $quarter)
                                                    <option value="{{ $quarter->quarter }}">{{ $quarter->description }}</option>
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
                                    {{-- <span class="fw-bold text-dark">From:</span> <span id="qtryrs">{{ @$quarter_desc.' - '.@$year ?? 'N/A' }}</span> --}}
                                    <span class="fw-bold text-dark">From:</span> <span id="qtryrs">{{ @$quarter_desc.' - '.@$year >= 2022 ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="text-start"><h4 class="text-primary">1. General Details</h4></div>
                            <div class="table-responsive">
                                <table id="example9" class="display table table-bordered table-striped">                                        
                                    <thead>                                            
                                        <tr>
                                            <th rowspan="3" class="text-center">S.No.</th>
                                            <th rowspan="3" class="text-center">Name of the ART Clinic</th>
                                            <th rowspan="3" class="text-center">Registration No.</th>
                                            <th colspan="2" class="text-center">Total no. of patients</th>
                                            <th colspan="3" class="text-center">Cause of Infertility (in figures)</th>
                                            <th colspan="4" class="text-center">Type of Treatment(in figure)</th>
                                            <th colspan="10" class="text-center">Type of Procedures Undertaken(in figure)</th>
                                            <th colspan="4" class="text-center">Treatment Outcome (in figures)</th>
                                            <th colspan="5" class="text-center">Pregnancy Outcome (in figures)</th>
                                            <th colspan="3" class="text-center">No. of child/children born</th>
                                            <th colspan="2" class="text-center">Gender (in figures)</th>
                                            <!--<th rowspan="3" class="text-center">Total no. of children Born</th>-->
                                        </tr>
                                        <tr>
                                            <th rowspan="2">Married Couples</th>
                                            <th rowspan="2">Single Women</th>
                                            <th rowspan="2">Male factor</th>
                                            <th rowspan="2">Female factor</th>
                                            <th rowspan="2">Unexplained</th>
                                            <th rowspan="2">With self-gametes</th>
                                            <th colspan="3">With donor gametes</th>
                                            <th rowspan="2">Artificial<br/> Insemination</th>
                                            <th rowspan="2">Intra-uteriane<br/> Insemination(IUI)</th>
                                            <th rowspan="2">In vitro <br/>Fertilization-Embryo<br/> Transfer(IVF-ET)</th>
                                            <th rowspan="2">Gamete Intrafallopian <br/>Tube Transfer(GIFT)</th>
                                            <th rowspan="2">Intra-cytoplasmic<br/> Sperm Injection(ICSI)</th>
                                            <th rowspan="2">Physiological <br/>Intra-cytoplasmic<br/> Sperm Injection(PICSI)</th>
                                            <th rowspan="2">Intra-cytoplasmic<br/> Morphologically <br/>Selecated Sperm Injection(IMSI)</th>
                                            <th rowspan="2">Round Spermatid<br/> Nucleus Injection(ROSNI)</th>
                                            <th rowspan="2">ELOngated Spermatid<br/> Injection(ELSI)</th>
                                            <th rowspan="2">Other</th>
                                            <th rowspan="2">Total No. of <br/>Cycles undertaken</th>
                                            <th rowspan="2">Total No. of <br/>Cycles cancelled</th>
                                            <th rowspan="2">Successful pregnancies</th>
                                            <th rowspan="2">Failed pregnancies</th>
                                            <th rowspan="2">Live Birth</th>
                                            <th rowspan="2">Stillbirth</th>
                                            <th rowspan="2">Therapeutic <br/>Abortion</th>
                                            <th rowspan="2">Spontaneous <br/>Abortion</th>
                                            <th rowspan="2">Elective<br/> Termination</th>
                                            <th rowspan="2">singleton</th>
                                            <th rowspan="2">Twin</th>
                                            <th rowspan="2">higher order</th>
                                            <th rowspan="2">Males</th>
                                            <th rowspan="2">Female</th>
                                        </tr>
                                        <tr>                                                
                                            <th>Oocyte donor</th>
                                            <th>Sperm donor</th>
                                            <th>Both donor</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody id="report-result"></tbody>
                                    <tfoot id="reportTotal" ></tfoot>
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
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });   
$('#report-level-one').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let $table = $('#report-result');

    $.ajax({
        url: "{{ route('report.surrogacyArtClinicFilter') }}",
        type: "POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        beforeSend: function () {
            $table.html('<tr><td colspan="40" class="text-center"><b>Loading Report...</b></td></tr>');
        },

        success: function (response) {

            $("#qtryrs").html(response.quarteryear);

            // Destroy old DataTable
            if ($.fn.DataTable.isDataTable('#example9')) {
                $('#example9').DataTable().destroy();
            }

            // Columns list
            const columns = [
                'married_couple_count','single_women_count','male_factor','female_factor','unexplained',
                'self_gametes','oocyte_donor','sperm_donor','both_donor','artificial_insemination',
                'iui','ivfet','gitt','icsi','picsi','icmssi','rsni','esi','other',
                'total_num_of_cyc_undertaking','art_no_cycles','success_pregnant','failed_pregnant',
                'live_birth','still_birth','therapeutic_aboration','spontaneous_aboration',
                'elective_termination','singleton','twin','higher_order','male','female'
            ];

            // Initialize totals
            let total = {};
            columns.forEach(col => total[col] = 0);

            let rowsHtml = '';

            // Loop data
            $.each(response.reportResult, function (index, form) {

                let row = `<tr class="text-center">
                    <td>${index + 1}</td>
                    <td>${form.clinic_name ?? 'N/A'}</td>
                    <td class="text-center">${form.registration_no ?? 'N/A'}</td>`;

                columns.forEach(col => {
                    let val = Number(form[col] ?? 0);
                    total[col] += val;
                    row += `<td class="text-center">${val}</td>`;
                });

                row += `</tr>`;
                rowsHtml += row;
            });

            // Append rows
            $table.html(rowsHtml);

            //  Footer Total Row
            let totalRow = `<tr class="text-center fw-bold">
                <th colspan="3">Total</th>`;

            columns.forEach(col => {
                totalRow += `<th class="text-center">${total[col]}</th>`;
            });

            totalRow += `</tr>`;

            $('#reportTotal').html(totalRow);

            //  Reinitialize DataTable
            $('#example9').DataTable({           
                 paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                scrollX: true,

                footerCallback: function () {
                    let api = this.api();
                    let colIndex = 3; // skip first 3 columns

                    columns.forEach(() => {
                        // Page total
                        let pageTotal = api
                            .column(colIndex, { page: 'current' })
                            .data()
                            .reduce((a, b) => (Number(a) || 0) + (Number(b) || 0), 0);
                        // Full total
                        let fullTotal = api
                            .column(colIndex)
                            .data()
                            .reduce((a, b) => (Number(a) || 0) + (Number(b) || 0), 0);
                        // Update footer
                        $(api.column(colIndex).footer())
                            .html(`${pageTotal}`);
                        colIndex++;
                    });
                    // First footer column
                    $(api.column(0).footer()).html('Total');
                }
            });
        },

        error: function () {
            $table.html('<tr><td colspan="40" class="text-center text-danger">No record found</td></tr>');
            $('#reportTotal').html('');
        }
    });
});
});
</script>
@endsection