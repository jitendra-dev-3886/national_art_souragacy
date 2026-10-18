@extends('layouts.admin.admin_master')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">       
            <div class="card-body">
                <!----------SEARCH FORM START----------->
                <form action="" method="post" name="frmfilter" id="frmfilter">
                     @csrf
                    <div class="row">
                        <h3 class=" bc-color-csp-clinic-four">Surrogacy Clinics Report</h3>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select Year</strong><span class="color-red-fourtyseven">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                        <select name="year" id="year" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select year</option>
                                            @for ($i = 2022; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor                                                                                
                                        </select>
                                        <!-- Error Message Container -->
                                        <span id="msgyear" class="text-danger"></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select Period</strong><span class="color-red-fourtyseven">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                        <select name="quarter" id="quarter" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select Quarter</option>
                                                @foreach($quarters as $qtrRow)  
                                                    <option value="{{ $qtrRow->quarter }}">{{ $qtrRow->description}}</option>
                                                @endforeach                                                                                
                                            </select>
                                            <!-- Error Message Container -->
                                            <span id="msgqtr" class="text-danger"></span> 
                                    </div> 
                                </div>
                            </div>
                        </div>            						
                        <div class="col-md-1">
                            <div class="mb-2 pt-2">
                            <span>&nbsp; &nbsp;<a class="link btn btn-primary csp-clinic-btn-blue" id="submitfilter">Submit</a></span>							 
                            </div>
                        </div>                  
                    </div>
                </form>
                  <!----------FORM END------------->                
            </div>
        </div>
    </div>   			
    <div class="row card" id="view_art_cl"  >
        <div class="col-lg-12 pt-2 pb-2"><h3><u>Consolidated Reporting Format for Surrogacy Clinics</u></h3></div>
        <div class="col-lg-6 pt-2 pb-2"><button id="exportBtn" class="link btn btn-primary csp-clinic-btn-blue">Export PDF</button>     
        <button id="exportExcelBtn" class="btn btn-primary">Export to Excel</button>
       </div>
        <div class="table-responsive">
            <table id="usersTable" class="display table table-bordered table-striped">
                <thead>
                    <tr> 
                        <th rowspan="3" class="text-center">S.No.</th>
                        <th rowspan="3" class="text-center">Clinic <br>Name</th>
                        <th rowspan="3" class="text-center">Registration<br> No.</th>
                        <th rowspan="3" class="text-center">State/UT</th>            
                        <th colspan="2" class="text-center">Patients <br>Undergoing /Undergone <br>Surrogacy Procedure</th>
                        <th colspan="3" class="text-center">Ongoing Total <br>Surrogacy <br>Procedures </th>
                        <th colspan="3" class="text-center">Completed Total <br>IVF/ICSI <br>Procedures </th>
                        <th colspan="2" class="text-center">Total Number <br>of Surrogate <br> Mothers</th>  
                        <th colspan="3" class="text-center">Total Number <br> of Surgical <br>Retrievals</th>  
                        <th colspan="4" class="text-center">Total Number <br> of Gametes<br> cryopreserved</th> 
                        <th colspan="3" class="text-center">Total Number <br> of embryos <br> cryopreserved</th>                    
                        <th rowspan="3" class="text-center">Last <br>Submission<br> Date</th>
                    </tr>  
                    <tr> 
                        <th rowspan="2">Indian Nationals</th>
                        <th rowspan="2">Cople of India<br> origin OCI<br> Cardholders</th>
                        <th colspan="2">Married <br>Couple</th>
                        <th rowspan="2">Single <br>Women</th>  
                        <th colspan="2">Married <br>Couples</th>
                        <th rowspan="2">Single <br>Women</th>    
                        <th rowspan="2">Ongoing <br>Cases</th>  
                        <th rowspan="2">Completed <br>Cases</th>
                        <th rowspan="2">Sperm</th> 
                        <th colspan="2">Oocyte</th> 
                        <th colspan="2">Sperm </th> 
                        <th colspan="2">Oocyte</th>   
                        <th rowspan="2">Created<br> using <br>patient <br>self gametes</th>                                                                        
                        <th colspan="2">Created <br>using one<br>donor <br>gametes</th>    
                    </tr>
                     <tr> 
                        <th>SG</th>
                        <th>DG</th>
                        <th>SG</th>
                        <th>DG</th>    
                        <th>SO</th>
                        <th>DO</th>
                        <th>SS</th>
                        <th>DS</th>
                        <th>SO</th>
                        <th>DO</th>
                        <th>SS+DO</th>
                        <th>SO+DO</th>                           
                    </tr>
                </thead>
                <tbody id="report-result"></tbody>
            </table>
        </div>
    
          <div><br/><span class="fw-bold">Abbrevations: </span>
        <p><span class="fw-bold">SG: </span> self gametes | 
        <span class="fw-bold">DG: </span> Donor gamete 
        <span class="fw-bold">SO: </span> self Oocytes |
        <span class="fw-bold">DS: </span> donor sperm |
        <span class="fw-bold">DO: </span> donor oocytes |
        <span class="fw-bold">SS: </span> self sperm 
        </p>
        </div>
        </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.umd.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.plugin.autotable.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/xlsx.full.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function(){
        //Report PDF        
        $("#exportBtn").click(function () {
            const { jsPDF } = window.jspdf;
            // Landscape, points, A4
            const doc = new jsPDF('l', 'pt', 'a4'); 
            // Heading text with Bootstrap secondary color (#6c757d)
            doc.setFontSize(18);  // Bigger heading
            doc.setTextColor(108, 117, 125); // Bootstrap secondary rgb(108,117,125)
            doc.text("Consolidated Reporting Format for Surrogacy Clinics", 40, 40);
            // AutoTable configuration
            doc.autoTable({
            html: '#usersTable',
            startY: 70, // Push table below heading
            theme: 'grid',
            headStyles: { fillColor: [108, 117, 125] }, // Secondary color
            styles: { fontSize: 9 }
            });
            // Save file
            doc.save("Surrogacy_Clinics_Report.pdf");
        });
     // ✅ New Excel export  
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById('usersTable'), {sheet: "Surrogacy Clinics Report"});
        XLSX.writeFile(wb, 'Surrogacy_Clinics_Report.xlsx');
        });    
    })
    $(document).ready(function(){
        $("#view_art_cl").hide();      
        $("#submitfilter" ).click(function() {
            let flag=0;
            $("#view_art_cl").hide();
            let year=$("#year").val();
            let quarter=$("#quarter").val();
            $("#msgyear").html('');
            $("#msgqtr").html('');
            if(year==''){
                $("#msgyear").html("Please select year");
                flag=1;
            } 
            if(quarter==''){
                $("#msgqtr").html("Please select quarter");
                flag=1;
            }
            if(flag==0){          
                $.ajax({
                        url: "{{ route('report.surrogacyClinicReportFilter') }}",
                        method: "POST",                 
                        data: $("#frmfilter").serialize(),
                        beforeSend: function(){
                            $('#report-result').html('<div class="text-center p-3"><b>Loading Report...</b></div>');
                        },
                        success: function(response) {
                            $("#view_art_cl").show();
                            $('#report-result').empty();
                            if ($.fn.DataTable.isDataTable('#usersTable')) {
                                $('#usersTable').DataTable().clear().destroy();
                            }
                            $('#report-result').html(response); 
                            $('#usersTable').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                responsive: true,
                                scrollX: true,
                                destroy: true 
                            });
                        }
                });
            } 
        });
    });
</script>
@endsection
