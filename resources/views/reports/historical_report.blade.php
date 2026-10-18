@extends('layouts.admin.admin_master')

@section('content')

<style nonce="{{ $cspNonce }}">
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
    }
    .main-heading {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 10px;
        color: #333;
        text-transform: uppercase;
    }
    .application-number {
        text-align: right;
        margin-right: 20px;
        margin-bottom: 10px;
        font-size: 14px;
        color: #555;
        font-weight: bold;
    }
    .card-body {
        padding: 20px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .table-bordered {
        border: 1px solid #ddd;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .table-bordered th {
        background-color: #f2f2f2;
    }
    .verticle-middle {
        vertical-align: middle;
    }
    .table-responsive-sm {
        overflow-x: auto;
    }
    td {
        word-wrap: break-word;
        white-space: normal;
    }
    .csp-clinic-text-black {
        color: black;
    }
    .csp-clinic-table-header {
        background-color: #d3d8fd;
        text-align: center;
    }
</style>

<div class="container py-4">

    <!-- Action Buttons (Top) -->
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ route('admin.daily_report') }}" class="btn btn-outline-secondary px-4 shadow-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to Daily Report
        </a>
        
        <div>
            <button type="button" id="printPdfBtn" class="btn btn-success me-2 px-4 shadow-sm">
                <i class="fa fa-print me-1"></i> Print / Save PDF
            </button>
            <button type="button" id="exportExcelBtn" class="btn btn-primary px-4 shadow-sm">
                <i class="fa fa-file-excel-o me-1"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- Document Container -->
    <div class="card shadow border-0 mx-auto printable-document" style="max-width: 800px;">
        <div class="card-body p-5" id="printableCardBody">
            
            <!-- FILTER PANEL -->
            <div class="card shadow-sm border-0 bg-light mb-4 d-print-none">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('admin.daily_filtered_report') }}" class="row g-3 align-items-end">
                        
                        <!-- Date Filter -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-secondary">Report Date</label>
                            <input type="date" name="report_date" class="form-control border-0 shadow-sm py-2" value="{{ request('report_date', $reportDate) }}">
                        </div>

                        <!-- Year Dropdown (Multi-Select) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Select Years</label>
                            @php 
                                $allYears = $dynamicYears ?? \App\Services\ReportService::getTargetYears(); 
                                $selectedYears = request('search_years', $allYears);
                                if (is_null($selectedYears)) {
                                    $selectedYears = [];
                                }
                            @endphp
                            
                            <div class="dropdown">
                                <button class="btn btn-white bg-white border-0 shadow-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center py-2" type="button" id="yearDropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <span class="text-dark">Select Years to Display...</span>
                                </button>
                                
                                <div class="dropdown-menu w-100 shadow p-3 border-0" aria-labelledby="yearDropdown">
                                    <!-- Select All Option -->
                                    <div class="form-check border-bottom pb-2 mb-2">
                                        <input class="form-check-input cursor-pointer" type="checkbox" id="selectAllYears" {{ count($selectedYears) === count($allYears) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold cursor-pointer text-primary" for="selectAllYears">
                                            Select All Years
                                        </label>
                                    </div>

                                    <!-- Individual Years -->
                                    @foreach($allYears as $y)
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
                $yearColumns = $dynamicYears ?? [];
                $hasYears = count($yearColumns) > 0;
            @endphp

            <!-- Main Heading -->
            <div class="main-heading">Daily Reporting National Registry Portal</div>
            <div class="application-number">
                <h4 class="card-title csp-clinic-text-black"><strong>Report Date:</strong> {{ \Carbon\Carbon::parse($reportDate)->format('d F, Y') }}</h4>
            </div>

            <!-- Document Body -->
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped verticle-middle" id="reportTable">
                        <thead>
                            <tr>
                                <th colspan="{{ $hasYears ? 4 : 2 }}" class="csp-clinic-table-header">Daily Report Summary</th>
                            </tr>
                            <tr>
                                <th colspan="{{ $hasYears ? 1 : 1 }}" style="width: {{ $hasYears ? '50%' : '80%' }};">Report Parameter</th>
                                @if($hasYears)
                                    <th style="width: 15%; text-align: center;">Year</th>
                                    <th style="width: 15%; text-align: right;">Count</th>
                                @endif
                                <th style="width: 20%; text-align: right;">Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groupedReport as $section)
                                <tr>
                                    <th colspan="{{ $hasYears ? 4 : 2 }}" style="background-color: #f8f9fa; font-weight: bold;">
                                        {{ $section['name'] }}
                                    </th>
                                </tr>

                                @foreach($section['items'] as $item)
                                    @php
                                        $rowspan = $hasYears ? count($yearColumns) : 1;
                                        $firstRow = true;
                                        $grandTotal = $item['count'];
                                    @endphp

                                    @if($hasYears)
                                        @foreach($yearColumns as $year)
                                            <tr>
                                                @if($firstRow)
                                                    <td rowspan="{{ $rowspan }}" class="verticle-middle" style="font-weight: 600;">
                                                        {{ $item['title'] }}
                                                    </td>
                                                @endif

                                                <td style="text-align: center;">
                                                    {{ $year }}
                                                </td>

                                                <td style="text-align: right;">
                                                    {{ number_format($item['years'][$year] ?? 0) }}
                                                </td>

                                                @if($firstRow)
                                                    <td rowspan="{{ $rowspan }}" class="verticle-middle" style="text-align: right; font-weight: bold; background-color: #f9f9f9;">
                                                        {{ number_format($grandTotal) }}
                                                    </td>
                                                    @php $firstRow = false; @endphp
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td style="font-weight: 600;">
                                                {{ $item['title'] }}
                                            </td>
                                            <td style="text-align: right; font-weight: bold; background-color: #f9f9f9;">
                                                {{ number_format($grandTotal) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            @empty
                                <tr>
                                    <td colspan="{{ $hasYears ? 4 : 2 }}" style="text-align: center; padding: 20px;">
                                        No report data found for the selected date or filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div> 
    </div> 
</div> 

<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Select All Years Functionality (Delegated & Optimized)
        const selectAllBtn = document.getElementById('selectAllYears');
        const yearCheckboxes = document.querySelectorAll('.year-checkbox');

        if (selectAllBtn) {
            selectAllBtn.addEventListener('change', function () {
                const isChecked = this.checked;
                yearCheckboxes.forEach(cb => cb.checked = isChecked);
            });

            yearCheckboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    selectAllBtn.checked = Array.from(yearCheckboxes).every(c => c.checked);
                });
            });
        }

        // 2. Isolated Print / Save PDF Function via Popup Window
        const printBtn = document.getElementById('printPdfBtn');
        if (printBtn) {
            printBtn.addEventListener('click', function () {
                const printableBody = document.getElementById('printableCardBody');
                if (!printableBody) return;

                const clone = printableBody.cloneNode(true);
                const filterPanel = clone.querySelector('.card.bg-light');
                if (filterPanel) filterPanel.remove();

                const printWindow = window.open('', '_blank', 'height=800,width=1000');
                if (!printWindow) return;

                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Daily Report - Print</title>
                        <style>
                            body { font-family: Arial, sans-serif; font-size: 14px; margin: 0; padding: 20px; background: #fff !important; color: #333; }
                            .main-heading { text-align: center; font-size: 18px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; text-transform: uppercase; }
                            .application-number { text-align: right; margin-right: 20px; margin-bottom: 10px; font-size: 14px; color: #555; font-weight: bold; }
                            .table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-top: 15px; }
                            .table-bordered { border: 1px solid #ddd; }
                            .table-bordered th, .table-bordered td { border: 1px solid #ddd; padding: 8px; text-align: left; word-wrap: break-word; white-space: normal; }
                            .table-bordered th { background-color: #f2f2f2; }
                            .table-primary td { background-color: #cfe2ff !important; -webkit-print-color-adjust: exact; }
                            .verticle-middle { vertical-align: middle; }
                            .csp-clinic-text-black { color: black; }
                            .csp-clinic-table-header { background-color: #d3d8fd !important; -webkit-print-color-adjust: exact; text-align: center; }
                        </style>
                    </head>
                    <body>
                        ${clone.innerHTML}
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();

                setTimeout(() => {
                    printWindow.print();
                    printWindow.close();
                }, 400);
            });
        }

        // 3. Native Client-side Excel Export using Dynamic XML Strings
        const exportBtn = document.getElementById('exportExcelBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function () {
                const table = document.getElementById('reportTable');
                if (!table) return;

                const excelTemplate = `
                    <html xmlns:o="urn:schemas-microsoft-com:office:office" 
                          xmlns:x="urn:schemas-microsoft-com:office:excel" 
                          xmlns="http://www.w3.org/TR/REC-html40">
                    <head>
                        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                        <!--[if gte mso 9]>
                        <xml>
                            <x:ExcelWorkbook>
                                <x:ExcelWorksheets>
                                    <x:ExcelWorksheet>
                                        <x:Name>Daily Report</x:Name>
                                        <x:WorksheetOptions>
                                            <x:DisplayGridlines/>
                                        </x:WorksheetOptions>
                                    </x:ExcelWorksheet>
                                </x:ExcelWorksheets>
                            </x:ExcelWorkbook>
                        </xml>
                        <![endif]-->
                    </head>
                    <body>
                        ${table.outerHTML}
                    </body>
                    </html>
                `;

                const blob = new Blob([excelTemplate], { type: 'application/vnd.ms-excel;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Daily_Report_{{ $reportDate }}.xls';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        }
    });
</script>

@endsection