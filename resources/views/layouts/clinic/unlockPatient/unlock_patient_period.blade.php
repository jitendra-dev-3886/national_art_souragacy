@extends('layouts.clinic.clinic_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
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
            background-color: #0d6efd;
            ;
        }

        /* .csp-clinic-select-half {
                        width: 48%;
                    } */

        .csp-clinic-btn-primary {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }
    </style>



    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('exists'))
                        <div class="alert alert-warning">
                            {{ $messagea ?? 'This quarter and year have already been added!' }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (isset($error))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endif
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    <h3 class="card-title mb-5 text-primary">Unlock Closed Quarter for Patient/Donor Reporting</h3>
                    <form action="{{ route('clinic.unlock.patient.report.submit') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @php
                                $currentYear = date('Y');
                                $currentQuarter = ceil(date('n') / 3);
                            @endphp

                            <div class="col-md-6">
                                <div class="mb-3">
                                    {{-- <label class="form-label d-block">
                                        <strong>Report Filing for Patient details</strong>
                                    </label> --}}
                                    <div class="d-flex gap-2">
                                        <div class="col-md-4">
                                            <select class="form-control csp-clinic-select-half" name="clinic_type">
                                                <option value="">Select</option>
                                                @forelse($clinics as $clinic)
                                                    <option value="{{ $clinic->clinic_type ?? '' }}"
                                                        data-clinic_id="{{ Illuminate\Support\Facades\Crypt::encryptString($clinic->clinic_id) }}">
                                                        {{ match ($clinic->clinic_type) {
                                                            'ARTCLINIC' => 'ART Clinic',
                                                            'ARTBANK' => 'ART Bank',
                                                            'ARTSURROGACY' => 'Surrogacy Clinic',
                                                            default => 'Clinic',
                                                        } }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <span id="error_clinic_type" class="text-danger"></span>
                                            <input type="hidden" name="clinic_id" class="clinic_id" id="clinic_id"
                                                value="">
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control year" name="year">
                                                <option value="">Select Year</option>
                                            </select>
                                            <span id="error_year" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control quarter" name="quarter">
                                                <option value="">Select Quarter</option>
                                            </select>
                                            <span id="error_quarter" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <textarea name="revision_reason" id="revision_reason" class="form-control revision_reason" cols="30" rows="5"
                                    placeholder="Enter reason"></textarea>
                                <span id="error_revision_reason" class="text-danger"></span>
                            </div>
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn me-2 csp-clinic-btn-primary">Unlock Reporting Period</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {

            $('.csp-clinic-select-half').on('change', function() {
                var clinic_type = $(this).val();
                var clinic_id = $(this).find(':selected').data('clinic_id');

                $.ajax({
                    url: '{{ route('clinic.ajax.unlock.patient.report') }}',
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        clinic_type: clinic_type,
                        clinic_id: clinic_id,
                    },
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success: function(response) {
                        $('#clinic_id').val(clinic_id);
                        let previousYear = $('.year');
                        var optionHtml = `<option value="">Select Year</option>`;

                        previousYear.html(optionHtml);

                        let currentYear = '';
                        let optgroup;
                        if (!response.message) {
                            $.each(response.previousRecord, function(index, item) {

                                if (currentYear != item.year) {
                                    currentYear = item.year;
                                    optgroup = $('<option value="' + item.year + '">' +
                                        item
                                        .year + '</option>', {

                                        });
                                    previousYear.append(optgroup);
                                }
                            });
                            previousYear.data('recourd', response.previousRecord);
                            previousYear.data('quarters', response.quarterTable);
                        } else {
                            alert(response.message);
                        }

                    },
                    error: function(xhr) {
                        alert('Something went wrong.');
                    },
                    complete: function() {
                        $('#loader').hide();
                    }
                });
            });

            $('.year').on('change', function() {

                let selectedYear = $(this).val();
                let records = $(this).data('recourd');
                let quarters = $(this).data('quarters');

                $('.quarter').empty();
                $('.quarter').append(`<option value=""> Select Quarter</option>`);

                $.each(records, function(index, item) {

                    if (String(item.year) === selectedYear) {
                        let description = item.quarter;

                        $.each(quarters, function(id, desc) {
                            if (desc.quarter == item.quarter) {
                                description = desc.description;
                                return false;
                            }
                        });
                        $('.quarter').append('<option value="' + item.quarter + '">' + description +
                            '</option>');
                    }
                });
            })

            $('.csp-clinic-btn-primary').on('click', function(e) {

                let fields = [{
                        value: $('.csp-clinic-select-half').val(),
                        selector: '.csp-clinic-select-half',
                        error: '#error_clinic_type',
                        message: 'Please select a valid clinic type.'
                    },
                    {
                        value: $('.year').val(),
                        selector: '.year',
                        error: '#error_year',
                        message: 'Please select year.'
                    },
                    {
                        value: $('.quarter').val(),
                        selector: '.quarter',
                        error: '#error_quarter',
                        message: 'Please select quarter.'
                    },
                    {
                        value: $.trim($('.revision_reason').val()),
                        selector: '.revision_reason',
                        error: '#error_revision_reason',
                        message: 'Please enter revision reason.'
                    }
                ];
                let isValid = true;

                $.each(fields, function(index, field) {

                    if (!field.value) {

                        $(field.error).text(field.message);

                        if (isValid) {
                            $(field.selector).focus();
                            isValid = false;
                        }

                    } else {
                        $(field.error).text('');
                    }

                });

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endsection
