@extends('layouts.admin.admin_master')

@section('content')

<div class="container-fluid">
    <div class="card shadow-sm">
        
        <!-- ========================================== -->
        <!-- HEADER SECTION                             -->
        <!-- ========================================== -->
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 text-primary fw-bold">
                        <i class="fa fa-file-text-o me-2"></i>
                        Daily Report Generator
                    </h4>
                    <small class="text-muted">
                        Select the required report parameters and date to generate the report.
                    </small>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- FORM BODY                                  -->
        <!-- ========================================== -->
        <div class="card-body">
            <form id="dailyReportForm" action="{{ route('admin.daily_report_preview') }}" method="POST">
                @csrf

                <!-- 1. Top Controls: Date Picker & Global "Select All" -->
                <div class="row mb-4 align-items-end border-bottom pb-3">
                    
                    <!-- Date Input -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label for="report_date" class="form-label fw-bold text-primary">
                            <i class="fa fa-calendar me-1"></i> Report Date:
                        </label>
                        <input type="date" 
                               name="report_date" 
                               id="report_date" 
                               class="form-control @error('report_date') is-invalid @enderror" 
                               value="{{ old('report_date', date('Y-m-d')) }}" 
                               required>
                        @error('report_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Global Select All Checkbox -->
                    <div class="col-md-8 text-md-end">
                        <div class="form-check form-check-inline bg-light p-2 rounded border">
                            <!-- Global Select All Checkbox -->
                            <!-- <div class="col-md-8 text-md-end"> -->
                                <div class="form-check form-check-inline bg-light p-2 rounded border">
                                    <input class="form-check-input" type="checkbox" id="global_select_all">
                                    <label class="form-check-label fw-bold text-dark px-2 cursor-pointer" for="global_select_all">
                                        Select All Fields Across All Categories
                                    </label>
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <!-- 2. Grid of Categories and Dropdowns -->
                <div class="row g-4 mb-4">
                    
                    {{-- Loop through every category (A, B, C, etc.) --}}
                    @foreach($sections as $section)

                    <div class="col-lg-4 col-md-6">
                            
                            <!-- Category Title (e.g., "Submitted Data") -->
                            <label class="form-label fw-bold text-dark text-truncate w-100" title="{{ $section['name'] }}">
                                {{ $section['name'] }}
                            </label>
                            
                            <!-- The Dropdown Container -->
                            <div class="dropdown w-100">
                                
                                <!-- The clickable button that opens the dropdown -->
                                <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center bg-white border" 
                                        type="button" 
                                        data-bs-toggle="dropdown" 
                                        data-bs-auto-close="outside" 
                                        aria-expanded="false"
                                        id="btn_{{ $section['id'] }}">
                                    
                                    <!-- This text changes based on how many boxes are checked -->
                                    <span class="selected-text text-truncate me-2" data-section="{{ $section['id'] }}">
                                        Select options...
                                    </span>
                                    <i class="fa fa-chevron-down text-muted" style="font-size: 12px;"></i>
                                </button>

                                <!-- The Dropdown Menu (Hidden until clicked) -->
                                <div class="dropdown-menu w-100 shadow p-4 mt-1 border-0" aria-labelledby="btn_{{ $section['id'] }}">
                                    
                                    {{-- Loop through every field inside this category --}}
                                    @foreach($section['fields'] as $field)
                                        <div class="form-check custom-hover p-1 rounded mb-1">
                                            
                                            <input class="form-check-input field-checkbox" 
                                                   type="checkbox" 
                                                   id="{{ $field['code'] }}" 
                                                   name="fields[]" 
                                                   value="{{ $field['code'] }}"
                                                   data-section="{{ $section['id'] }}"
                                                   {{ in_array($field['code'], old('fields', [])) ? 'checked' : '' }}>
                                            
                                            <label class="form-check-label d-block cursor-pointer small" for="{{ $field['code'] }}">
                                                {{ $field['name'] }}
                                            </label>
                                            
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Display Validation Errors if any -->
                @error('fields')
                    <div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle me-1"></i>
                        {{ $message }}
                    </div>
                @enderror

                <!-- 3. Submit Button -->
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Selected reports will be displayed in preview before export.
                        </small>
                        <button type="submit" class="btn btn-primary px-4">
                            Submit & Preview
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- CUSTOM CSS STYLES                          -->
<!-- ========================================== -->
<style>
    /* Make the dropdown scrollable if it has too many items */
    .dropdown-menu {
        border-radius: 0.5rem;
        max-height: 250px;
        overflow-y: auto;
    }
    
    /* Add a slight background color when hovering over a checkbox row */
    .custom-hover {
        transition: background-color 0.2s;
    }
    .custom-hover:hover {
        background-color: #f1f5f9;
    }
    
    /* Change mouse to pointer when hovering over text labels */
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<!-- JAVASCRIPT LOGIC          -->
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/app.js') }}"></script>
<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    
    const globalSelectAllBtn = document.getElementById('global_select_all');
    if (!globalSelectAllBtn) return;

    // Helper to get all field checkboxes dynamically every time
    function getAllCheckboxes() {
        return document.querySelectorAll('.field-checkbox');
    }

    function getSectionIds() {
        const boxes = getAllCheckboxes();
        return [...new Set(Array.from(boxes).map(box => box.dataset.section))];
    }

    function updateDropdownButtonText(sectionId) {
        const sectionCheckboxes = document.querySelectorAll(`.field-checkbox[data-section="${sectionId}"]`);
        if (sectionCheckboxes.length === 0) return;
        
        const checkedCount = Array.from(sectionCheckboxes).filter(box => box.checked).length;
        const buttonTextElement = document.querySelector(`.selected-text[data-section="${sectionId}"]`);
        if (!buttonTextElement) return;
        
        if (checkedCount === 0) {
            buttonTextElement.textContent = 'Select options...';
            buttonTextElement.classList.replace('text-primary', 'text-dark');
            buttonTextElement.classList.remove('fw-bold');
        } 
        else if (checkedCount === sectionCheckboxes.length) {
            buttonTextElement.textContent = 'All Selected';
            buttonTextElement.classList.replace('text-dark', 'text-primary');
            buttonTextElement.classList.add('fw-bold');
        } 
        else {
            buttonTextElement.textContent = checkedCount + ' Selected';
            buttonTextElement.classList.replace('text-dark', 'text-primary');
            buttonTextElement.classList.add('fw-bold');
        }
    }

    function updateGlobalCheckboxState() {
        const boxes = getAllCheckboxes();
        if (boxes.length === 0) return;
        const areAllBoxesChecked = Array.from(boxes).every(box => box.checked);
        globalSelectAllBtn.checked = areAllBoxesChecked;
    }

    // Initialize states on load
    getSectionIds().forEach(id => updateDropdownButtonText(id));
    updateGlobalCheckboxState();

    // Global Select All - Forces EVERY checkbox to match the global state safely
    globalSelectAllBtn.addEventListener('change', function (event) {
        const isChecked = event.target.checked;
        getAllCheckboxes().forEach(function (checkbox) {
            checkbox.checked = isChecked;
        });
        getSectionIds().forEach(id => updateDropdownButtonText(id));
    });

    // Individual checkbox change handling using event delegation
    document.addEventListener('change', function (event) {
        if (event.target && event.target.classList.contains('field-checkbox')) {
            const sectionId = event.target.dataset.section;
            updateDropdownButtonText(sectionId);
            updateGlobalCheckboxState();
        }
    });
});
</script>
@endsection