@extends('layouts.admin.admin_master')

@section('content')

<style nonce="{{ $cspNonce }}">
.report-scroll-container {
    overflow-x: auto;
    overflow-y: visible;
    width: 100%;
}
.report-scroll-container th:first-child,
.report-scroll-container td:first-child {
    position: sticky;
    left: 0;
    background-color: #f8f9fa;
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

            <!-- FILTER PANEL -->
            <div class="card shadow-sm border-0 bg-light mb-4 d-print-none">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('admin.daily_report_snapshot') }}" class="row g-3 align-items-end">
                        
                    <!-- Date Filter -->
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary">Report Date</label>
                        <input type="date" name="report_date" class="form-control border-0 shadow-sm py-2" value="{{ request('report_date', $reportDate) }}">
                    </div>

                    <!-- Year Dropdown (Multi-Select) -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Select Years</label>
                        @php 
                            // 1. Always fetch the master list of all available years for the dropdown options
                            $allAvailableYears = \App\Services\ReportService::getTargetYears(); 
                            
                            // 2. Get the currently selected years from request (defaults to empty array if not submitted yet)
                            $selectedYears = request('search_years', []);
                        @endphp
                        
                        <div class="dropdown">
                            <button class="btn btn-white bg-white border-0 shadow-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center py-2" type="button" id="yearDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <span class="text-dark">
                                    {{ count($selectedYears) > 0 ? count($selectedYears) . ' Year(s) Selected' : 'Select Years to Display...' }}
                                </span>
                            </button>
                            
                            <div class="dropdown-menu w-100 shadow p-3 border-0" aria-labelledby="yearDropdown">
                                <!-- Select All Option -->
                                <div class="form-check border-bottom pb-2 mb-2">
                                    <input class="form-check-input cursor-pointer" type="checkbox" id="selectAllYears" {{ count($selectedYears) === count($allAvailableYears) && count($allAvailableYears) > 0 ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold cursor-pointer text-primary" for="selectAllYears">
                                        Select All Years
                                    </label>
                                </div>

                                <!-- Individual Years (Always lists all choices) -->
                                @foreach($allAvailableYears as $y)
                                    <div class="form-check my-1">
                                        <input class="form-check-input year-checkbox cursor-pointer" type="checkbox" name="search_years[]" value="{{ $y }}" id="filter_year_{{ $y }}" {{ in_array($y, $selectedYears) ? 'checked' : '' }}>
                                        <label class="form-check-label cursor-pointer" for="filter_year_{{ $y }}">
                                            {{ $y }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-dark w-100 shadow-sm py-2">
                            <i class="fa fa-search me-1"></i> Apply
                        </button>
                    </div>

                </form>
                </div>
            </div>
            <!-- END FILTER PANEL -->
                
            @php
                // Use the filtered years passed directly from the controller
                $yearColumns = $dynamicYears ?? [];
                $srNo = 1; 
            @endphp

            <!-- Document Body -->
            <div class="document-content text-dark">
                <div class="table-responsive report-scroll-container">
                    <table class="table table-bordered table-hover align-middle" id="reportTable">

                        <thead class="table-light">
                            <tr>
                                <th width="{{ count($yearColumns) > 0 ? '50%' : '80%' }}" class="text-start">Report Parameter</th>
                                
                                @if(count($yearColumns) > 0)
                                    <th width="15%" class="text-center">Year</th>
                                    <th width="15%" class="text-end">Count</th>
                                @endif
                                
                                <th width="20%" class="text-end">Grand Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($groupedReport as $section)

                            <tr class="table-primary">
                                <td colspan="{{ count($yearColumns) > 0 ? 4 : 2 }}" class="fw-bold fs-6 text-start">
                                    {{ $section['name'] }}
                                </td>
                            </tr>

                            @foreach($section['items'] as $item)
                                @php
                                    $hasYears = count($yearColumns) > 0;
                                    $rowspan = $hasYears ? count($yearColumns) : 1;
                                    $firstRow = true;
                                    $grandTotal = $item['count'];
                                @endphp

                                @if($hasYears)
                                    {{-- CASE 1: Years ARE selected (Shows full breakdown) --}}
                                    @foreach($yearColumns as $year)
                                        <tr>
                                            @if($firstRow)
                                                <td rowspan="{{ $rowspan }}" class="align-middle fw-semibold text-start">
                                                    {{ $item['title'] }}
                                                </td>
                                            @endif

                                            <td class="text-center">
                                                {{ $year }}
                                            </td>

                                            <td class="text-end">
                                                {{ number_format($item['years'][$year] ?? 0) }}
                                            </td>

                                            @if($firstRow)
                                                <td rowspan="{{ $rowspan }}" class="align-middle text-end fw-bold bg-light">
                                                    {{ number_format($grandTotal) }}
                                                </td>
                                                @php $firstRow = false; @endphp
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    {{-- CASE 2: NO Years selected (Hides year columns, shows Parameter + Grand Total only) --}}
                                    <tr>
                                        <td class="align-middle fw-semibold text-start">
                                            {{ $item['title'] }}
                                        </td>
                                        <td class="align-middle text-end fw-bold bg-light">
                                            {{ number_format($grandTotal) }}
                                        </td>
                                    </tr>
                                @endif

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
                </div><!-- Closing .table-responsive -->
            </div><!-- Closing .document-content -->

        </div> <!-- Closing .card-body -->
    </div> <!-- Closing .card -->
</div> <!-- Closing .container -->

<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.getElementById('selectAllYears');
        const yearCheckboxes = document.querySelectorAll('.year-checkbox');

        if (selectAllBtn) {
            selectAllBtn.addEventListener('change', function () {
                yearCheckboxes.forEach(cb => {
                    cb.checked = selectAllBtn.checked;
                });
            });

            yearCheckboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    const allChecked = Array.from(yearCheckboxes).every(c => c.checked);
                    selectAllBtn.checked = allChecked;
                });
            });
        }
    });
</script>

@endsection