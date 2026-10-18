@extends('layouts.clinic.clinic_master')
@section('content')

<style nonce="{{$cspNonce}}">
    .step-indicator {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .indicator {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: #e9ecef;
    }
    .indicator.active {
      background-color: #0d6efd;
    }
    .progress-bar {
    background-color: #0d6efd;;
}
  </style>
<div class="container-fluid">
    <div class="col-lg-8">
        <div class="card">       
            <div class="card-body">  
                @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('exists'))
    <script nonce="{{ $cspNonce }}">
        alert("{{ session('exists') }}");
    </script>
@endif
            <h3 class="card-title mb-5 text-primary"></h3>            
            <form method="POST" action="#">
                @csrf
                {{-- <h3>UHIDs for Quarter {{ $quarter }}, Year {{ $year }}</h3> --}}
            <h3>Patient Details for Quarter ({{ $quarterDescriptions[$quarter] ?? 'Unknown Quarter' }}), {{ $year }}</h3>
                      <table id="quarterTable" class="table table-bordered table-striped dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>UHID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @if($data)
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                
                                        <td><a href="{{ route('uhid.editPatientArtclinicOutcome', encrypt($d->patient_uhid)) }}"> {{ $d->patient_uhid }}</a></td> 
                                 
                                </tr>
                                
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">No UHIDs found for this selection.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                </div>
      
<script nonce="{{ $cspNonce }}">
$(document).ready(function() {
    $('#quarterTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: true,
        ordering: false,
        language: {
            search: "Filter records:",
            lengthMenu: "Show _MENU_ entries per page",
            paginate: {
                previous: ">>",
                next: "<<"
            }
        }
    });
});
</script>
               
                {{-- <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>                           
                            <th>Quarter</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patient_list as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>                              
                                <td>
                                    @if(session('edit_id') == $report->id)
                                        <input type="number" name="quarter" value="{{ $report->quarter }}" class="form-control" min="1" max="4">
                                    @else
                                        {{ $report->quarter }}
                                    @endif
                                </td> 
                                <td>{{ $report->year }}</td>            
                                <td>
                                    @if(session('edit_id') == $report->id)
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        <a href="{{ route('cancel.edit') }}" class="btn btn-secondary btn-sm">Cancel</a>
                                    @else
                                        @if(!session()->has('edit_id'))
                                            <a href="{{ route('edit.quarter', $report->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>Edit</button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}
            </form>



{{-- <div> --}}







</div>







    </div>
</div>
    </div>
</div>
</div>



  <script nonce="{{ $cspNonce }}">
    function updateIUICounts() {
        const selfGametes = parseInt(document.getElementById('no_ongoing_self_gametes').value) || 0;
        const donorSemen = parseInt(document.getElementById('no_ongoing_donor_semen').value) || 0;
        const singleWomen = parseInt(document.getElementById('no_ongoing_single_woman').value) || 0;
    
        const marriedCouples = selfGametes + donorSemen;
        const totalPatients = marriedCouples + singleWomen;
    
        document.getElementById('no_married_couples').value = marriedCouples;
        document.getElementById('no_patient_IUI_onoing').value = totalPatients;
    }
    
    // Attach listener
    document.querySelectorAll('#no_ongoing_self_gametes, #no_ongoing_donor_semen, #no_ongoing_single_woman')
        .forEach(input => input.addEventListener('input', updateIUICounts));

        function updateIUICountss() {
        const selfGametess = parseInt(document.getElementById('no_completed_self_gametes').value) || 0;
        const donorSemens = parseInt(document.getElementById('no_completed_donor_semen').value) || 0;
        const singleWomens = parseInt(document.getElementById('no_completed_single_woman').value) || 0;
    
        const marriedCoupless = selfGametess + donorSemens;
        const totalPatientss = marriedCoupless + singleWomens;
    
        document.getElementById('no_married_couple').value = marriedCoupless;
        document.getElementById('no_patient_IUI_completed').value = totalPatientss;
    }
    
    // Attach listener
    document.querySelectorAll('#no_completed_self_gametes, #no_completed_donor_semen, #no_completed_single_woman')
        .forEach(input => input.addEventListener('input', updateIUICountss));
    </script>
  <script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const yearSelect = document.getElementById('yearSelect');
        const quarterSelect = document.getElementById('quarterSelect');

        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth() + 1; // 1-based

        // Determine current financial quarter
        let currentFinQuarter;
        if (currentMonth >= 4 && currentMonth <= 6) {
            currentFinQuarter = 1; // Q1 (Apr-Jun)
        } else if (currentMonth >= 7 && currentMonth <= 9) {
            currentFinQuarter = 2; // Q2 (Jul-Sep)
        } else if (currentMonth >= 10 && currentMonth <= 12) {
            currentFinQuarter = 3; // Q3 (Oct-Dec)
        } else {
            currentFinQuarter = 4; // Q4 (Jan-Mar)
        }

        function filterQuarters() {
            const selectedYear = parseInt(yearSelect.value);

            Array.from(quarterSelect.options).forEach(option => {
                const qNum = parseInt(option.getAttribute('data-quarter'));

                if (!qNum || isNaN(selectedYear)) {
                    option.hidden = false;
                    return;
                }

                if (selectedYear === currentYear) {
                    // Show only current financial quarter
                    option.hidden = qNum !== currentFinQuarter;
                } else {
                    option.hidden = false;
                }
            });

            const selectedOption = quarterSelect.selectedOptions[0];
            if (selectedOption && selectedOption.hidden) {
                quarterSelect.selectedIndex = 0;
            }
        }

        yearSelect.addEventListener('change', filterQuarters);
        filterQuarters();
    });
</script>
  <script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth() + 1;
        const currentQuarter = Math.ceil(currentMonth / 3);

        const yearSelect = document.getElementById('yearSelect');
        const quarterSelect = document.getElementById('quarterSelect');

        yearSelect.addEventListener('change', function () {
            const selectedYear = parseInt(this.value);

            // Reset quarter selection
            quarterSelect.value = '';

            Array.from(quarterSelect.options).forEach(option => {
                if (!option.value) return; // Skip default

                const quarterNum = parseInt(option.value.replace('Q', ''));

                if (selectedYear < currentYear) {
                    // Show all quarters
                    option.style.display = 'block';
                } else if (selectedYear === currentYear) {
                    // Show only up to the current quarter
                    option.style.display = quarterNum <= currentQuarter ? 'block' : 'none';
                } else {
                    // Future year selected — hide all
                    option.style.display = 'none';
                }
            });
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const numberInputs = document.querySelectorAll('input[type="number"]');

        numberInputs.forEach(input => {
            input.setAttribute('min', '0');

            input.addEventListener('input', function () {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    function validatesubmit() {
        if (document.getElementById("yearSelect").value == "") {
            alert("Select Year");
            document.getElementById("yearSelect").focus();
            return false;
        }
        if (document.getElementById("quarterSelect").value == "") {
            alert("Select Quarter");
            document.getElementById("quarterSelect").focus();
            return false;
        }           
        if (document.getElementById("no_ongoing_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_donor_semen").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_donor_semen").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_single_woman").focus();
            return false;
        } 
        if (document.getElementById("no_completed_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_completed_donor_semen").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_donor_semen").focus();
            return false;
        }        
        if (document.getElementById("no_completed_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_single_woman").focus();
            return false;
        }   
        var agree = confirm(
            "Kindly check and confirm all details before final submission. There is no provision for editing/correction once the form is submitted."
        );
        if (agree) {
    
            return true;
        } else {
            return false;
        }
        return true;
    }
    </script> 
@endsection