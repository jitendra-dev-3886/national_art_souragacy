@extends(session('user_type') == '5' ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .select2-container .select2-selection--single {
        height: 38px !important;       
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 26px !important;
        color: #8e8f91 !important;
        font-weight: 500 !important;  
    }
    .select2-container--default .select2-selection__clear {
        color: #8e8f91 !important;  
        font-size: 18px !important;   
        margin-right: 8px;      
    }

    .accordion-item {
        background: #f7f7f7 !important; /* Light grey */
        border: 1px solid #dcdcdc !important;
        border-radius: 8px;
        overflow: hidden;
    }

    .accordion-button {
        background: #f7f7f7 !important;
        color: #8e8f91 !important;
        font-weight: 600;
        border: none !important;
        box-shadow: none !important;
    }

    .accordion-button:hover {
        background: #efefef !important;
    }

    .accordion-button:not(.collapsed) {
        background: #f7f7f7 !important; 
        color: #8e8f91 !important;
        box-shadow: none !important;
        border-bottom: 1px solid #dcdcdc !important;
    }


    .accordion-body {
        background: #fff !important;
        color: #8e8f91 !important;
        border-top: 1px solid #dcdcdc;
    }

    .accordion-body table {
        background: white;
        border-radius: 6px;
        overflow: hidden;
    }

    .accordion-button::after {
        content: "+";
        font-size: 20px;
        transform: none !important;
        background-image: none !important;
    }

    .accordion-button:not(.collapsed)::after {
        content: "-";
        font-size: 24px;
    }
    .accordion-header {
        padding: 0rem 1.75rem;
    }
    .accordion-item {
        margin-bottom: 0.50rem;
    }


    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
   
    .csp-clinic-text-left {
        text-align: left;
    }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-btn-blue {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-table-header {
        background-color: #d3d8fd;
        text-align: center;
    }

    .table-bordered th,
    .table-bordered td {
        vertical-align: middle;
    }

    .csp-clinic-table-header {
        background: #f0f0f0;
        color: #2c3e50;
        font-weight: bold;
        text-align: center;
    }
    .accordion-itesms .accordion-header{
      padding: 0rem 0rem !important;
    }
   .accordion-itesms .accordion-header{
    border-radius: 0px !important;
    border:none !important;
   }
  .accordion-itesms .accordion-button {
    padding: 12px;
}
.accordion-item.accordion-itesms {
    border-radius: 0px !important;
    margin-bottom: 0.2rem !important;
}
.accordion-itesms .accordion-button::after {
    content: "+";
    font-size: 20px;
    transform: none !important;
    background-image: none !important;
    background: #2d28c8;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    color: #fff;
}


</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">       
            <div class="card-body">  
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex flex-column justify-content-center align-items-center" style="min-height:80px;">
                    <h3 class="card-title mb-2 text-primary">ART {{ str_replace("ART", " ", strtoupper($type)) }} PATIENT LIST</h3>

                </div>
                    <div class="row">
                        <div class="col-md-12 pe-0">
                            <div class="form-left h-100 py-3 px-5">
                                @if($type=='artsurrogacy')
                                    <h3 class="mb-3">Patient Treatment Report {{ ucwords(str_replace('art', ' ', $type)) }} Clinic</h3> 
                                @else
                                    <h3 class="mb-3">Patient Treatment Report ART {{ ucwords(str_replace('art', ' ', $type)) }}</h3> 
                                @endif
                                
                                

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
                                
                                <form id="clinic-patient-report" method="POST">
                                    @csrf
                                    <input type="hidden" id="clinic_type_id" value="{{ $type }}">


                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="quarter">Clinic Name</label>

                                                <select name="clinic_id" id="clinic_id" class="form-control select2" required>
                                                    <option value="">Search by Clinic Name/Mobile/Email/State</option>

                                                @foreach(
                                                App\Models\clinic\ClinicRegistrationModel::select(
                                                'clinic_registration.clinic_id',
                                                'clinic_registration.name',
                                                'clinic_registration.mobile',
                                                'clinic_registration.email',
                                                'clinic_registration.state'
                                                )
                                                ->join(
                                                'patient_clinic_database.patient_period_reporting_table as pprt',
                                                // 'clinic_registration.clinic_id',
                                                // '=',
                                                // 'pprt.clinic_id'
                                                DB::raw('clinic_registration.clinic_id COLLATE utf8mb4_general_ci'),
                                                '=',
                                                DB::raw('pprt.clinic_id COLLATE utf8mb4_general_ci')
                                                )
                                                ->where('clinic_registration.clinic_type', strtoupper($type))
                                                ->where('clinic_registration.status', 1)
                                                ->where('pprt.status', 'Finished')
                                                ->when(session('user_type') == 5 && session('state_name'),function ($query) {
                                                    $query->where('clinic_registration.state', session('state_name'));
                                                })
                                                ->orderBy('clinic_registration.name')
                                                ->distinct()
                                                ->get()
                                                as $row
                                                )

                                                <option 
                                                value="{{ $row->clinic_id }}"
                                                data-name="{{ $row->name }}"
                                                data-mobile="{{ $row->mobile }}"
                                                data-email="{{ $row->email }}"
                                                data-state="{{ $row->state }}"
                                                >
                                                {{ $row->name }}
                                                </option>

                                                @endforeach
                                                </select>



                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary mt-4">Search</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="d-flex justify-content-end align-items-center mb-3 mt-4">
                                    <div class="text-end">
                                        
                                    </div>
                                </div>

                                <div id="report-result">
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                        <div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        @if(strtoupper($type)=='ARTBANK')
                                            <h5 class="modal-title" id="exampleModalLabel">Donor Details</h5>
                                        @else
                                            <h5 class="modal-title" id="exampleModalLabel">Patient Details</h5>
                                        @endif
                                        
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div id="patientDetails">Loading...</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- PDF Preview Modal -->
                        <div class="modal fade" id="pdfModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl"> <!-- Large popup -->
                                <div class="modal-content">
                                    
                                    <div class="modal-header">
                                        <h5 class="modal-title">Medical Certificate PDF</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <iframe id="pdfIframe" 
                                                src="" 
                                                width="100%" 
                                                height="600px" 
                                                style="border: none;">
                                        </iframe>
                                    </div>

                                </div>
                            </div>
                        </div>

       
            </div>
        </div>
    </div>
</div>

<script nonce="{{ $cspNonce }}">


    $(document).on("click", ".viewPdfBtn", function () {

            let file = $(this).data("file");

            $("#pdfIframe").attr("src", file);

            let pdfModal = new bootstrap.Modal(document.getElementById("pdfModal"));
            pdfModal.show();
        });
    $(document).on('click', '.downloadBtn', function () {

        let patientId = $(this).data('id');
        let clinic_type = $(this).data('type');

        let url = "{{ route('patientreport.downloadPatientReport') }}";

        window.location.href = url + '?id=' + patientId + '&clinic_type=' + clinic_type;

    });

    
    $(document).on('click', '.openPatientModal', function () {
        let patientId = $(this).data('id');
        let clinic_type = $(this).data('type');

        // $('#patientDetails').html('<p>Loading...</p>');

        $.ajax({
            url: "{{ route('admin.clinicPatientFullDetails') }}",  
            type: "GET",
            data: { id: patientId, clinic_type: clinic_type },
            success: function(response) {
                $('#patientDetails').html(response);
            },
            error: function() {
                $('#patientDetails').html('<p class="text-danger">Error loading data.</p>');
            }
        });

    });

    $(document).ready(function() {

    function customMatcher(params, data) {
        if ($.trim(params.term) === '') {
            return data;
        }

        let term = params.term.toLowerCase();

        let name = $(data.element).data('name')?.toString().toLowerCase();
        let mobile = $(data.element).data('mobile')?.toString().toLowerCase();
        let email = $(data.element).data('email')?.toString().toLowerCase();
        let state = $(data.element).data('state')?.toString().toLowerCase();

        if (
            (name && name.includes(term)) ||
            (mobile && mobile.includes(term)) ||
            (email && email.includes(term)) ||
            (state && state.includes(term))
        ) {
            return data;
        }

        return null;
    }

    function formatResult(dataObj) {
        if (!dataObj.id) return dataObj.text;

        let name = $(dataObj.element).data('name');
        let mobile = $(dataObj.element).data('mobile');
        let email = $(dataObj.element).data('email');
        let state = $(dataObj.element).data('state');

        return $(`
            <div>
                <strong>${name}</strong> - ${mobile} 
                (${email}) 
                [${state}]
            </div>
        `);
    }

    function formatSelection(dataObj) {
        if (!dataObj.id) return dataObj.text;

        let name = $(dataObj.element).data('name');
        let mobile = $(dataObj.element).data('mobile');
        let email = $(dataObj.element).data('email');
        let state = $(dataObj.element).data('state');

        return `${name} - ${mobile} (${email}) [${state}]`;
    }

    $('#clinic_id').select2({
        placeholder: "Search by Clinic Name/Mobile/Email/State",
        allowClear: true,
        width: '100%',
        matcher: customMatcher,
        templateResult: formatResult,
        templateSelection: formatSelection,
        escapeMarkup: m => m
    });

});


    $(document).ready(function() {
    
        $('#clinic-patient-report').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            // FIRST define selected option
            let selected = $("#clinic_id option:selected");

            // NOW you can access its data attributes
            let clinicId = selected.val();
            let clinicName = selected.data("name");
            let clinicMobile = selected.data("mobile");
            let clinicEmail = selected.data("email");
            let clinicState = selected.data("state");
            let clinic_type = $('#clinic_type_id').val()
            $.ajax({
                url: "{{ route('admin.clinicPatientReport') }}",
                method: "POST",
                data: { _token: '{{ csrf_token() }}',clinic_id: clinicId, name: clinicName, mobile: clinicMobile, email: clinicEmail, state: clinicState, clinic_type: clinic_type },
                beforeSend: function() {
                    $('#report-result').html('<div class="text-center p-3"><b>Loading Report...</b></div>');
                },
                success: function(response) {
                    $('#report-result').empty();

                    if ($.fn.DataTable.isDataTable('#example9')) {
                        $('#example9').DataTable().clear().destroy();
                    }

                    $('#report-result').html(response);
                },
                error: function(xhr) {
                    let errorMessage = 'Something went wrong!';
                    if (xhr.responseText) {
                        errorMessage = xhr.responseText;
                    }
                    $('#report-result').html('<div class="alert alert-danger">No record found</div>');
                }
            });
        });

    });

    document.addEventListener("shown.bs.collapse", function (e) {

    let table = e.target.querySelector("table");

    if (table && !$.fn.DataTable.isDataTable(table)) {
        $(table).DataTable({
            responsive: true,
            pageLength: 10
        });
    }

});

</script>


@endsection
