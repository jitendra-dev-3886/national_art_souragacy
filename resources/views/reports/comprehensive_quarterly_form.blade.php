@extends('layouts.admin.ssa_master')   
@section('content')
<div class="content-bodys">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center border main-tital rounded-top-4 py-5">
                    <h2 class="text-dark">Format for Quarterly report to be submitted by the <br>State / UT Appropriate Authority</h2>
                </div>
            </div>
                 <!-- Display success message -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                    @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger col-sm-12">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif
            <form id="quarterlyReportForm" name="quarterlyReportForm" action="{{ route('report.Quarterlyreportform') }}" method="POST"> 
                 @csrf  
                <div class="border p-2 p-lg-4 rounded-bottom-3 bg-white mb-4 shadow-sm">
                    <div class="row">                  
                        <div class="col-md-3 mts">
                            <div class="mb-3">
                                <label for="state" class="form-label">Select Year  
                                    @php 
                                if(date('m')< 3 )
                                $currentYear=date('Y')-1;
                                else 
                                   $currentYear=date('Y') ;                                
                               @endphp </label>
                                <select name="year" id="year" class="form-select form-select-lg" aria-label="Large select example">
                                    {{-- <option value="">Choose Year</option>                                    --}}
                                    @for ($i = 2025; $i <= $currentYear; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor 
                                </select>
                                <span id="msgyear" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-3 mts">
                            <div class="mb-3">
                            <label for="quarter" class="form-label">Select Period</label>
                                <select name="quarter" id="quarter" class="form-select form-select-lg" aria-label="Large select example">
                                    {{-- <option value="">Choose Quarter</option> --}}

                                    {{-- @foreach($quarters as $qtrRow)  
                                    <option value="{{ $qtrRow->quarter }}">{{ $qtrRow->description}}</option>
                                    @endforeach   --}}
                                    <option value="4">Oct - Dec</option>
                                </select>
                                <span id="msgqtr" class="text-danger"></span> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3 mt-4"><label></label>
                                <button type="submit" name="submit" value="submit"  class="btn btn-primary flex-nowrap ms-2" >Submit</button></div>
                        </div>
                    </div>
                    <div class="row" id="report-result"></div>  
                </div>            
            </form>     
        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}">
$(document).ready(function () {
     $("#quarterlyReportForm").click(function (e) {        
       // e.preventDefault(); 
       let flag=0;
        $('#msgqtr').html("");
        $('#msgyear').html("");
        let  selectedYear=$('#year').val();
        let  selectedQuarter=$('#quarter').val();
        
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth() + 1; // 1–12
        const currentQuarter = Math.ceil(currentMonth / 3); // 1–4

        if(selectedQuarter==""){
          $('#msgqtr').html("Please enter quarter");
          flag=1;

        }             
        if(selectedYear==""){
            $('#msgyear').html("Please enter years");
            flag=1;
        }  
         if(selectedYear < 2022){
            $('#msgyear').html("Reports for years before 2022 are not allowed.");
            flag=1;
        } 
        if (selectedYear === currentYear && selectedQuarter > currentQuarter) {
            $('#msgqtr').html("Future quarter is not allowed.");
            flag=1;
        }
     
        if (selectedYear ==='2022' && selectedQuarter < 4) {              
            $('#msgqtr').html("For the year 2022, quarters before October - December are not allowed.");
            flag=1;
        }        

        if(flag==0){             
                $('#quarterlyReportForm').submit();
             
        }else{
            return false;
        }

    })
    let allQuarters = @json($quarters);
    function populateQuarter() {
        let selectedYear = parseInt($('#year').val());
        let currentDate = new Date();
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth() + 1;

        let allowedQuarters = [];

        // ✅ Year 2025 → only Oct-Dec
        if (selectedYear === 2025) {
            allowedQuarters = [4];
        }

        // ✅ Current year logic
        else if (selectedYear === currentYear) {

            if (currentMonth >= 4 && currentMonth <= 6) {
                allowedQuarters = [1];
            } 
            else if (currentMonth >= 7 && currentMonth <= 9) {
                allowedQuarters = [1, 2];
            } 
            else if (currentMonth >= 10 && currentMonth <= 12) {
                allowedQuarters = [1, 2, 3];
            } 
            else {
                allowedQuarters = [];
            }
        }

        // ✅ Future year → none
        else if (selectedYear > currentYear) {
            allowedQuarters = [];
        }

        // ✅ Past year → all
        else {
            allowedQuarters = [1, 2, 3, 4];
        }

        // 🔄 Populate dropdown
        let quarterDropdown = $('#quarter');
        quarterDropdown.empty();

        quarterDropdown.append(`<option value="">Select Quarter</option>`);

        allQuarters.forEach(q => {
            if (allowedQuarters.includes(parseInt(q.quarter))) {
                quarterDropdown.append(
                    `<option value="${q.quarter}">${q.description}</option>`
                );
            }
        });

        // Optional: disable if empty
        if (allowedQuarters.length === 0) {
            quarterDropdown.append(`<option value="">No quarters available</option>`);
        }
    }
    $('#year').on('change', function () {
        populateQuarter();
    });
});
</script> 
@endsection

