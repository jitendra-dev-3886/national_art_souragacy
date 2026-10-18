@extends('layouts.admin.admin_master')

@section('content')

<style nonce="{{ $cspNonce }}">
.report-scroll-container {
    overflow-x: auto;       /* Enables left-to-right scrolling */
    overflow-y: visible;    /* Shows all rows top-to-bottom (no vertical scroll) */
    width: 100%;
}

.report-scroll-container th:first-child,
.report-scroll-container td:first-child {
    position: sticky;
    left: 0;
    background-color: #f8f9fa; /* Matches table background */
    z-index: 1;
}

@media print {
    .report-scroll-container {
        overflow-x: visible !important;
    }
    .report-scroll-container th:first-child,
    .report-scroll-container td:first-child {
        position: static !important;
    }
}
</style>
<div class="container py-4">

    <!-- Action Buttons (Top) -->
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ route('admin.daily_report') }}" class="btn btn-outline-secondary px-4 shadow-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to Daily Report
        </a>
        
        <div>
            <!-- NEW FILTER BUTTON -->

            <button class="btn btn-success me-2 px-4 shadow-sm" onclick="window.print()">
                <i class="fa fa-print me-1"></i> Print / Save PDF
            </button>
            <button class="btn btn-primary px-4 shadow-sm">
                <i class="fa fa-file-excel-o me-1"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- Document Container -->
   <div class="card shadow border-0 mx-auto printable-document" style="max-width: 800px;">
    <div class="card-body p-5">
        
        <!-- Document Header -->
        <div class="text-center mb-5 border-bottom pb-3">
            <h3 class="fw-bold text-dark text-uppercase mb-2">Daily Reporting National Registry Portal</h3>
            <h6 class="text-muted">Report Date: {{ \Carbon\Carbon::parse($reportDate)->format('d F, Y') }}</h6>
        </div>

            @php
                // 1. Get all available dynamic years
                $allYears = $dynamicYears ?? \App\Services\ReportService::getTargetYears();

                // 2. Filter them so we ONLY keep the years the user actually checked in the form
                $requestedFields = request()->input('search_years', request()->input('fields', $allYears));
                $yearColumns = array_intersect($allYears, $requestedFields);

                // Fallback
                if (empty($yearColumns)) {
                    $yearColumns = []; 
                }

                $srNo = 1; 
            @endphp

        <!-- Document Body -->
        <div class="document-content text-dark">
          <div class="table-responsive report-scroll-container">
                <table class="table table-bordered table-hover align-middle" id="reportTable">

                    <thead class="table-light">
                        <tr>
                            <th width="50%" class="text-start">Report Parameter</th>
                            <th width="15%" class="text-center">Year</th>
                            <th width="15%" class="text-end">Count</th>
                            <th width="20%" class="text-end">Grand Total</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($groupedReport as $section)

                        {{-- Section Heading --}}
                        <tr class="table-primary">
                            <td colspan="4" class="fw-bold fs-6 text-start">
                                {{ $section['name'] }}
                            </td>
                        </tr>

                        @foreach($section['items'] as $item)

                            @php
                                $rowspan = count($yearColumns);
                                $firstRow = true;
                                $grandTotal = array_sum($item['years']);
                            @endphp

                            @foreach($yearColumns as $year)

                                <tr>

                                    {{-- Report Parameter --}}
                                    @if($firstRow)
                                        <td rowspan="{{ $rowspan }}" class="align-middle fw-semibold text-start">
                                            {{ $item['title'] }}
                                        </td>
                                    @endif

                                    {{-- Year --}}
                                    <td class="text-center">
                                        {{ $year }}
                                    </td>

                                    {{-- Count --}}
                                    <td class="text-end">
                                        {{ number_format($item['years'][$year] ?? 0) }}
                                    </td>

                                    {{-- Grand Total --}}
                                    @if($firstRow)
                                        <td rowspan="{{ $rowspan }}"
                                            class="align-middle text-end fw-bold bg-light">
                                            {{ number_format($grandTotal) }}
                                        </td>

                                        @php $firstRow = false; @endphp
                                    @endif

                                </tr>

                            @endforeach

                        @endforeach

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-4">
                                No report data found for the selected date or filters.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>
            </div>
        </div>

    </div> <!-- End Card Body -->
</div> <!-- End Card -->
</div> <!-- End Container -->

    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/app.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function() {
        
        window.toggleYears = function() {
            const yearColumns = document.querySelectorAll('.year-col');
            const btn = document.getElementById('toggleYearsBtn');
            
            if (!yearColumns || yearColumns.length === 0) return;
            
            const isHidden = yearColumns[0].style.display === 'none';
            
            yearColumns.forEach(function(col) {
                col.style.display = isHidden ? 'table-cell' : 'none';
            });
            
            if (isHidden) {
                btn.innerHTML = '<i class="fa fa-minus"></i> Hide';
                btn.classList.remove('btn-outline-secondary');
                btn.classList.add('btn-secondary');
            } else {
                btn.innerHTML = '<i class="fa fa-plus"></i> Years';
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-outline-secondary');
            }
        };
        
    });

    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.getElementById('selectAllYears');
        const yearCheckboxes = document.querySelectorAll('.year-checkbox');

        // 1. When "Select All" is clicked, check/uncheck all years
        selectAllBtn.addEventListener('change', function () {
            yearCheckboxes.forEach(cb => {
                cb.checked = selectAllBtn.checked;
            });
        });

        // 2. If user manually clicks individual years, update the "Select All" box accordingly
        yearCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const allChecked = Array.from(yearCheckboxes).every(c => c.checked);
                selectAllBtn.checked = allChecked;
            });
        });
    });
</script>

@endsection