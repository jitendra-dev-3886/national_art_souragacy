@extends('layouts.admin.admin_master')

@section('content')
<style nonce="{{ $cspNonce }}">
    .dashboard-title {
        color: #F8F9FA;
        font-weight: 600;
    }
    .lavender-card {
        background-color: #EDE9FE;
        border: 1px solid #DDD6FE;
        border-radius: 8px;
    }
    .toggle-row{
        color:#0d6efd;
    }

    .toggle-row i{
        transition:transform .2s;
    }

    .toggle-row.expanded i{
        transform:rotate(0deg);
    }

    .report-row:hover{
        background:#f8f9fa;
    }

</style>
@php
$sectionTitles = [

    'A' => 'Records Submitted',

    'B' => 'Pending Data Submission',

    'C' => 'Married Couples',

    'D' => 'Single Women',

    'E' => 'IUI Procedures',

    'F' => 'IVF / ICSI Procedures',

    'G' => 'Surrogacy Procedures',

    'H' => 'Cause of Infertility',

    'I' => 'Medical Indications',

    'J' => 'Previous Surviving Child',

    'K' => 'Treatment Outcome'

];

$currentSection = '';

@endphp

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0 dashboard-title">
                Daily Reporting Dashboard
            </h5>

        </div>
        <div class="alert alert-info text-end mb-0 lavender-card">
                <i class="fas fa-info-circle me-1"></i>
                <strong>Report as on:</strong>
                <strong>{{$reportgeneratedtime}}</strong>.
                {{-- <strong>{{ \Carbon\Carbon::parse($reportDate)->format('d-M-Y') }}</strong>. --}}
        </div>

        <div class="card-body" id="printableCardBody">

            <form method="GET" action="{{ route('reports.daily.snapshot') }}">

                <div class="row mb-4">

                    <div class="col-md-3">

                        <label><strong>View</strong></label>

                        <select name="view" id="view" class="form-control">

                            <option value="total" {{ $view=='total' ? 'selected' : '' }}>
                                Total Count
                            </option>

                            <option value="all" {{ $view=='all' ? 'selected' : '' }}>
                                All Years
                            </option>

                            @for($year=2022;$year<=$currentYear;$year++)

                                <option value="{{ $year }}"
                                    {{ $view==$year ? 'selected' : '' }}>

                                    {{ $year }}

                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label><strong>State</strong></label>

                        <select class="form-control" name="state_name" id="state_name">

                            <option value="" {{ empty($stateName) ? 'selected' : '' }}>
                                All
                            </option>

                            {{-- @foreach($states as $state)

                                <option value="{{ strtoupper($state) }}"
                                    {{ strtoupper($stateName) == strtoupper($state) ? 'selected' : '' }}>

                                    {{ strtoupper($state) }}

                                </option>

                            @endforeach --}}

                        </select>

                    </div>

                    <div class="col-md-2 align-self-end">

                        <button class="btn btn-primary">

                            Search

                        </button>

                    </div>

                </div>

            </form>

          <div class="d-flex justify-content-end mb-2">
            <button type="button" id="printPdfBtn" class="btn btn-light btn-sm mr-2">
                <i class="fa fa-print"></i> Print / PDF
            </button> &nbsp;

            <button type="button" id="exportExcelBtn" class="btn btn-success btn-sm">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </button>
        </div>
        <div class="mb-2 d-flex justify-content-end">

            <button
                type="button"
                id="toggleAllBtn"
                class="btn btn-sm btn-primary">

                <i class="fa fa-plus-square me-1"></i>

                <span>Expand All</span>

            </button>

        </div>
            <table class="table table-bordered table-hover" id="snapshotTable">

                <thead class="table-dark">
                <tr>
                    <th width="8%">S.No</th>
                    <th width="35%">Particulars</th>
                    <th width="25%">Category</th>

                    <th width="16%">
                        @if($view=='total')
                            Total Count
                        @elseif($view=='all')
                            Year-wise Count
                        @else
                            {{ $view }} Count
                        @endif
                    </th>

                    @if($view=='all')
                        <th width="16%">Total</th>
                    @endif
                </tr>
                </thead>

                <tbody>

                @php

                    $currentSection='';

                @endphp

                @foreach($details as $row)

                    @if($currentSection != $row->section)

                    @php
                        $currentSection = $row->section;
                    @endphp

                    <tr class="table-secondary">

                        <td>

                            <strong>{{ $currentSection }}</strong>

                        </td>

                        <td>

                            <strong>{{ $sectionTitles[$currentSection] ?? '' }}</strong>

                        </td>

                        <td></td>

                        @if($view=='all')
                            <td></td>
                        @endif

                    </tr>

                @endif

                    <tr
                        class="report-row"
                        data-id="{{ $row->id }}"
                        data-parent="{{ $row->parent_id }}"
                        data-level="{{ $row->level }}"
                        @if($row->level>0)
                            hidden
                        @endif
                    >


                        <td>
                            <div class="d-flex align-items-center">

                                <span style="display:inline-block;width:{{ $row->level * 20 }}px;"></span>

                                @if($row->has_children)

                                    <button
                                        type="button"
                                        class="btn btn-link btn-sm p-0 me-1 toggle-row"
                                        data-id="{{ $row->id }}"
                                        aria-expanded="false">

                                        <i class="fa fa-plus-square"></i>

                                    </button>

                                @else

                                    <span style="display:inline-block;width:30px;"></span>

                                @endif

                                {{ $row->serial_no }}

                            </div>
                        </td>


                        <td style="padding-left: {{ 15 + ($row->level * 25) }}px;">
                            {{ $row->metric_name }}
                        </td>

                        <td>
                            {{ $row->category_name ?? '-' }}
                        </td>

                        <td>

                            @if($view=='total')

                                {{ number_format($row->total_count) }}

                            @elseif($view=='all')

                                @foreach($row->years as $year=>$count)

                                    <div class="d-flex justify-content-between border-bottom py-1">

                                        <span>{{ $year }}</span>

                                        <strong>{{ number_format($count) }}</strong>

                                    </div>

                                @endforeach

                            @else

                                {{ number_format($row->selected_count) }}

                            @endif

                        </td>

                        @if($view=='all')

                            <td class="text-center">

                                <strong>{{ number_format($row->total_count) }}</strong>

                            </td>

                        @endif

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {

        const view = document.getElementById('view');
        const state = document.getElementById('state_name');

        if (view) {
            view.addEventListener('change', function () {
                this.form.submit();
            });
        }

        if (state) {
            state.addEventListener('change', function () {
                this.form.submit();
            });
        }

    });

    document.addEventListener('DOMContentLoaded', function () {
        // 1. Auto-submit form on dropdown changes
        const viewSelect = document.getElementById('view');
        const stateSelect = document.getElementById('state_name');
        const filterForm = document.getElementById('filterForm');

        if (viewSelect && filterForm) {
            viewSelect.addEventListener('change', function () {
                filterForm.submit();
            });
        }

        if (stateSelect && filterForm) {
            stateSelect.addEventListener('change', function () {
                filterForm.submit();
            });
        }

        // 2. Isolated Print / PDF Function via Popup Window
       const printBtn = document.getElementById('printPdfBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function () {
            const printableBody = document.getElementById('printableCardBody');
            if (!printableBody) return;

            const viewText = viewSelect ? viewSelect.options[viewSelect.selectedIndex].text.trim() : 'Total Count';
            const stateText = stateSelect && stateSelect.value !== '' ? stateSelect.options[stateSelect.selectedIndex].text.trim() : 'National';

            const clone = printableBody.cloneNode(true);
            const filterPanel = clone.querySelector('form');
            if (filterPanel) filterPanel.remove();
            const dashboardHeader = clone.querySelector('.card-header');
            if (dashboardHeader) dashboardHeader.remove();
            const actionBar = clone.querySelector('.d-flex');
            if (actionBar) actionBar.remove();

            const reportTable = clone.querySelector('#snapshotTable');
            if (reportTable) {
                reportTable.setAttribute('border', '1');
                reportTable.style.borderCollapse = 'collapse';
                reportTable.style.border = '1px solid #64748b';
                reportTable.querySelectorAll('th, td').forEach(function (cell) {
                    cell.style.border = '1px solid #cbd5e1';
                    cell.style.textAlign = 'center';
                    cell.style.verticalAlign = 'middle';
                });
            }

            const printWindow = window.open('', '_blank', 'height=800,width=1000');
            if (!printWindow) return;

            printWindow.document.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Daily Reporting Dashboard - Print</title>
                    <style>
                        /* 1. Screen Preview: Center the "paper" on the screen */
                        body { 
                            font-family: Arial, sans-serif; 
                            background-color: #e9ecef; /* Grey background for screen */
                            margin: 0; 
                            padding: 20px;
                            display: flex; 
                            justify-content: center; /* Horizontally centers the A4 container */
                        }
                        
                        /* 2. The A4 Paper Wrapper */
                        .a4-wrapper {
                            background-color: #ffffff;
                            width: 210mm; /* Exact A4 width */
                            padding: 15mm;
                            box-sizing: border-box;
                            box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Paper shadow effect */
                        }

                        /* 3. Header Table Centering */
                        .print-header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                        .print-header-table td { border: 1px solid #ddd; padding: 15px; background-color: #f8f9fa; text-align: center !important; vertical-align: middle; }
                        .print-header-table h3 { margin: 0 0 8px 0; font-size: 18px; text-transform: uppercase; color: #333; text-align: center; }
                        .print-header-table p { margin: 0; font-size: 14px; color: #555; text-align: center; }

                        /* 4. Main Table Styling */
                        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
                        .table-bordered th, .table-bordered td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        .table-dark th { background-color: #343a40 !important; color: #fff !important; -webkit-print-color-adjust: exact; }
                        .table-secondary td { background-color: #e2e3e5 !important; -webkit-print-color-adjust: exact; }

                        /* 5. Print Rules (Removes shadow and grey background when actually printing) */
                        @media print {
                            body { background-color: #ffffff; padding: 0; display: block; }
                            .a4-wrapper { width: 100%; padding: 0; box-shadow: none; }
                            @page { size: A4 portrait; margin: 15mm; }
                        }
                    </style>
                </head>
                <body>
                    <!-- Wrapper that forces the A4 centering -->
                    <div class="a4-wrapper">
                        <table class="print-header-table">
                            <tr>
                                <td style="text-align: center;">
                                    <h3>Daily Reporting as on date ${new Date().toLocaleDateString('en-GB')}</h3>
                                </td>
                            </tr>
                        </table>
                        ${clone.innerHTML}
                    </div>

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
                const table = document.getElementById('snapshotTable');
                if (!table) return;

                const tagWb = 'x:ExcelWorkbook';
                const tagWss = 'x:ExcelWorksheets';
                const tagWs = 'x:ExcelWorksheet';
                const tagName = 'x:Name';
                const tagOpts = 'x:WorksheetOptions';
                const tagGrid = 'x:DisplayGridlines';

                const excelTemplate = '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' +
                                     'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
                                     'xmlns="http://www.w3.org/TR/REC-html40">' +
                                     '<head><meta http-equiv="content-type" content="text/html; charset=UTF-8">' +
                                     '<!--[if gte mso 9]><xml><' + tagWb + '><' + tagWss + '><' + tagWs + '>' +
                                     '<' + tagName + '>Daily Dashboard</' + tagName + '>' +
                                     '<' + tagOpts + '><' + tagGrid + '/></' + tagOpts + '>' +
                                     '</' + tagWs + '></' + tagWss + '></' + tagWb + '></xml><![endif]-->' +
                                     '</head><body>' + table.outerHTML + '</body></html>';

                const blob = new Blob([excelTemplate], { type: 'application/vnd.ms-excel;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Daily_Reporting_Dashboard.xls';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        }
    });
    document.querySelectorAll('.toggle-row').forEach(function(btn){

    btn.addEventListener('click',function(e){

        e.preventDefault();
        e.stopPropagation();

        const id = this.dataset.id;

        const expanded = this.classList.contains('expanded');

        this.classList.toggle('expanded');

        this.setAttribute(
            'aria-expanded',
            expanded ? 'false' : 'true'
        );

        const icon=this.querySelector('i');

        if(icon){

            icon.classList.toggle('fa-plus-square');

            icon.classList.toggle('fa-minus-square');

        }

        toggleChildren(id,!expanded);

    });

});

function toggleChildren(parentId,show){

    document.querySelectorAll(
        'tr[data-parent="'+parentId+'"]'
    ).forEach(function(row){

        row.hidden=!show;

        if(!show){

            collapseChildren(row.dataset.id);

        }

    });

}

function collapseChildren(parentId){

    document.querySelectorAll(
        'tr[data-parent="'+parentId+'"]'
    ).forEach(function(row){

        row.hidden=true;

        const btn=row.querySelector('.toggle-row');

        if(btn){

            btn.classList.remove('expanded');

            btn.setAttribute('aria-expanded','false');

            const icon=btn.querySelector('i');

            if(icon){

                icon.classList.remove('fa-minus-square');

                icon.classList.add('fa-plus-square');

            }

        }

        collapseChildren(row.dataset.id);

    });

}
/*
|--------------------------------------------------------------------------
| Expand / Collapse All
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Expand / Collapse All
|--------------------------------------------------------------------------
*/

const toggleAllBtn = document.getElementById('toggleAllBtn');

let expandedAll = false;

if (toggleAllBtn) {

    toggleAllBtn.addEventListener('click', function () {

        if (!expandedAll) {

            /*
            |--------------------------------------------------------------------------
            | Expand Everything
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll('.report-row').forEach(function (row) {

                row.hidden = false;

            });

            document.querySelectorAll('.toggle-row').forEach(function (btn) {

                btn.classList.add('expanded');

                btn.setAttribute('aria-expanded', 'true');

                const icon = btn.querySelector('i');

                if (icon) {

                    icon.classList.remove('fa-plus-square');

                    icon.classList.add('fa-minus-square');

                }

            });

            this.querySelector('span').textContent = 'Collapse All';

            const icon = this.querySelector('i');

            icon.classList.remove('fa-plus-square');

            icon.classList.add('fa-minus-square');

        }
        else {

            /*
            |--------------------------------------------------------------------------
            | Collapse Everything
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll('.report-row').forEach(function (row) {

                if (row.dataset.level != "0") {

                    row.hidden = true;

                }

            });

            document.querySelectorAll('.toggle-row').forEach(function (btn) {

                btn.classList.remove('expanded');

                btn.setAttribute('aria-expanded', 'false');

                const icon = btn.querySelector('i');

                if (icon) {

                    icon.classList.remove('fa-minus-square');

                    icon.classList.add('fa-plus-square');

                }

            });

            this.querySelector('span').textContent = 'Expand All';

            const icon = this.querySelector('i');

            icon.classList.remove('fa-minus-square');

            icon.classList.add('fa-plus-square');

        }

        expandedAll = !expandedAll;

    });

}
</script>

@endsection