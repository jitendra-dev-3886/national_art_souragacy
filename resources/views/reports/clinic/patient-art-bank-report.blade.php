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
                        <h3 class=" bc-color-csp-clinic-four">Art bank Report</h3>
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
    <div class="row card" id="view_art_cl" >
        <div class="col-lg-12 pt-2 pb-2"><h3><u>Consolidated Reporting Format for Art Bank</u></h3></div>
        <div class="col-lg-6 pt-2 pb-2"><button id="exportBtn" class="link btn btn-primary csp-clinic-btn-blue">Export PDF</button>     
        <button id="exportExcelBtn" class="btn btn-primary">Export to Excel</button>
       </div>
        <div class="table-responsive">
            <table id="usersTable" class="display table table-bordered table-striped">
                <thead>
                    <tr> 
                        <th rowspan="3" class="text-center">S.No.</th>
                        <th rowspan="3" class="text-center">Bank Name</th>
                        <th rowspan="3" class="text-center">Registration<br /> No.</th>
                        <th rowspan="3" class="text-center">State/UT</th>            
                        <th colspan="2" class="text-center">Donors Screened <br> & Registered</th> 
                        <th colspan="2" class="text-center">Total Number of Oocytes <br>cryopreserved / Stored</th>                 
                        <th colspan="4" class="text-center">Total Number of Oocytes <br>supplied</th>  
                        <th colspan="2" class="text-center">Total Number of Semen<br> samples cryopreserved</th>                       
                        <th colspan="4" class="text-center">Total Number of Semen <br>samples supplied</th>                    
                        <th rowspan="3" class="text-center">Last <br>Submission<br> Date</th>
                    </tr>  
                    <tr> 
                        <th rowspan="2">Oocyte Donor</th>
                        <th rowspan="2">Sperm Donor</th>
                        <th rowspan="2">Patient</th>
                        <th rowspan="2">Donor</th>    
                        <th colspan="2">Art Clinic</th>  
                        <th colspan="2">Surrogacy Clinic</th>
                        <th  rowspan="2">Patient</th> 
                        <th  rowspan="2">Donor</th> 
                        <th colspan="2">Art Clinic</th>  
                        <th colspan="2">Surrogacy Clinic</th>
                    </tr>
                    <tr> 
                        <th>P</th>
                        <th>D</th>
                        <th>P</th>
                        <th>D</th>
                        <th>P</th>
                        <th>D</th>
                        <th>P</th>
                        <th>D</th>
                    </tr>
                </thead>
                <tbody id="report-result"></tbody>
            </table>
        </div>    
        <div><br/><span class="fw-bold">Abbrevations: </span>
            <p><span class="fw-bold">P: </span> Patient | 
            <span class="fw-bold">D: </span> Donor          
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
            doc.text("Consolidated Reporting Format for Art Bank", 40, 40);
            // AutoTable configuration
            doc.autoTable({
            html: '#usersTable',
            startY: 70, // Push table below heading
            theme: 'grid',
            headStyles: { fillColor: [108, 117, 125] }, // Secondary color
            styles: { fontSize: 9 }
            });
            // Save file
            doc.save("Art_Bank_Report.pdf");
        });

     // ✅ New Excel export  
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById('usersTable'), {sheet: "Art Bank Report"});
        XLSX.writeFile(wb, 'Art_Bank_Report.xlsx');
        });    
    })
     $("#view_art_cl").hide(); 
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
                        url: "{{ route('report.artbankClinicReportFilter') }}",
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
