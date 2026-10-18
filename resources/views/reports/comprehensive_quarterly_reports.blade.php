@extends('layouts.admin.ssa_master')
<link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ url('public/css/app.css') }}" rel="stylesheet">
@section('content')
    <style nonce="{{ $cspNonce }}">
        .no-capitalize {
            text-transform: none !important;
        }
    </style>

    <div class="content-bodys">
        <div class="container-fluid" id="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center border main-tital rounded-top-4 py-5">
                        <h2 class="text-dark">Format for Quarterly report to be submitted by the <br>State / UT Appropriate
                            Authority</h2>
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
                <div class="alert alert-danger col-sm-12 errors"></div>
                <form id="multi-step-form" name="quarterlyreportfrm"
                    action="{{ route('report.quarterlyreportformCreate') }}" method="POST">
                    @csrf
                    <span id="submitType"></span>
                    <div class="border p-2 p-lg-4 rounded-bottom-3 bg-white mb-5 shadow-sm">
                        <div class="row">

                            <div class="col-md-3 mts">
                                <div class="mb-3">
                                    <label for="year" class="form-label">Year</label>
                                    <input type="text" name="year" id="year"class="form-control"
                                        value="{{ $filterData['Year'] }}" readonly>
                                    <span id="msgyear" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-3 mts">
                                <div class="mb-3">
                                    <label for="quarter" class="form-label">Period</label>
                                    <input type="text" class="form-control" value="{{ $filterData['Quartername'] }}"
                                        readonly>
                                    <input type="hidden" name="quarter" id="quarter"class="form-control"
                                        value="{{ $filterData['Quarter'] }}" readonly>
                                    <span id="msgqtr" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="report-result"></div>

                        <div class="row">
                            <div class="col-md-6 mts fw-bold">Name of the State / UT : {{ $filterData['state_name'] }}
                            </div>
                        </div>

                    </div>
                    <div id="allErrors" class="text-danger"></div>
                    <div class="rounded-4 pt-4">
                        <div class="progress px-1">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="step-container d-flex justify-content-between">
                            <div class="step-circle active" data-step="1">1</div>
                            <div class="step-circle" data-step="2">2</div>
                            <div class="step-circle" data-step="3">3</div>
                            <div class="step-circle" data-step="4">4</div>
                        </div>


                        <div class="step step-1">
                            <div class="border p-2 p-lg-4 rounded-3 bg-white mb-4 shadow-sm table-responsive">
                                @include('reports.includes.form_step1')
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>
                        </div>

                        <div class="step step-2">
                            <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.form_step2')
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-primary prev-step">Previous</button>
                                    <button type="button" class="btn btn-primary next-step">Next</button>
                                </div>
                            </div>
                        </div>

                        <div class="step step-3">
                            <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.form_step3')
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-primary prev-step">Previous</button>
                                    <button type="button" class="btn btn-primary next-step">Next</button>
                                </div>
                            </div>
                        </div>
                        <div class="step step-4">
                            <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.form_annexure1')
                                <div class="text-end row align-items-center pe-4">
                                    <div class="col-md-6 text-start">
                                        <p class="text-danger small q9_annx mb-0">Please fill all fields in the first row of
                                            Annexure-I Question 9. If you have no data, enter “NIL”. The date field may be
                                            left blank.</p>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-success btn-sm mt-2 addRowBtn"
                                            data-table="datafiels1">+</button>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                            @include('reports.includes.form_annexure2')                                                
                              <div class="text-end row align-items-center pe-4">
                                <div class="col-md-6 text-start">
                                   <p class="text-danger small q15_annx mb-0">  Please fill all fields in the first row of  Annexure-II Question 15. If you have no data, enter “NIL”. </p>
                                </div>
                                <div class="col-md-6">
                                   <button class="btn btn-success btn-sm mt-2 addRowBtn" data-table="datafiels2">+</button>
                                </div>
                            </div>                           
                        </div> --}}
                            <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.form_annexure2_q16')
                                <div class="text-end row align-items-center pe-4">
                                    <div class="col-md-6 text-start">
                                        <p class="text-danger small q16_annx mb-0"> Please fill all fields in the first row
                                            of Annexure-II Question 15 and 16. If you have no data, enter “NIL”. </p>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-success btn-sm mt-2 addRowBtn"
                                            data-table="datafiels3">+</button>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">                          
                                    @include('reports.includes.form_annexure3') 
                            <div class="text-end row align-items-center pe-4">
                                <div class="col-md-6 text-start">
                                     <p class="text-danger small q18_annx mb-0">  Please fill all fields in the first row of  Annexure-III Question 18. If you have no data, enter “NIL”. </p>
                                </div>
                                <div class="col-md-6">
                                     <button class="btn btn-success btn-sm mt-2 addRowBtn"  data-table="datafiels4">+</button>
                                </div>
                            </div>
                           
                        </div> --}}
                            <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">
                                @include('reports.includes.form_annexure3_q22')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/app.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
        const validations_Q2_Q7 = [

            // ================= Q2 ART CLINIC =================
            ['art_clinic_qtr_end_q2', 'art_clinic_qtr_end_q1', 'art_clinic_qtr_1_error_msg',
                'Q1 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q2', 'art_clinic_q2', 'art_clinic_qtr_2_error_msg',
                'ART Clinic value cannot be Less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q2', 'art_clinic_qtr_end_q2', 'art_clinic_left_2_error_msg',
                'ART Clinic cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],

            // ================= Q2 ART BANK =================
            ['art_banks_qtr_end_q2', 'art_banks_qtr_end_q1', 'art_banks_qtr_1_error_msg',
                'Q1 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q2', 'art_banks_q2', 'art_banks_qtr_2_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q2', 'art_banks_qtr_end_q2', 'art_bank_left_2_error_msg',
                'ART Bank cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],

            // ================= Q2 SURROGACY =================
            ['surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_qtr_end_q1', 'surrogacy_clinic_qtr_1_error_msg',
                'Q1 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_q2', 'surrogacy_clinic_qtr_2_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q2', 'surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_left_2_error_msg',
                'Surrogacy Clinic value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],

            // ================= Q3 ART CLINIC =================
            ['art_clinic_qtr_end_q3', 'art_clinic_qtr_end_q2', 'art_clinic_qtr_3_error_msg',
                'Q2 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q3', 'art_clinic_q3', 'art_clinic_qtr_3_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q3', 'art_clinic_qtr_end_q3', 'art_clinic_left_3_error_msg',
                'ART Clinic value cannot be Greater than the value on the right', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q2', 'art_clinic_qtr_end_q3', 'art_clinic_qtr_2_error_msg',
                'Q3 Art Clinic connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            // ================= Q3 ART BANK =================
            ['art_banks_qtr_end_q3', 'art_banks_qtr_end_q2', 'art_banks_qtr_3_error_msg',
                'Q2 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q3', 'art_banks_q3', 'art_banks_qtr_3_error_msg',
                'ART Banks value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q3', 'art_banks_qtr_end_q3', 'art_banks_left_3_error_msg',
                'ART Bank cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q2', 'art_banks_qtr_end_q3', 'art_banks_qtr_2_error_msg',
                'Q3 Art Bank connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            // ================= Q3 SURROGACY =================
            ['surrogacy_clinic_qtr_end_q3', 'surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_qtr_3_error_msg',
                'Q2 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q3', 'surrogacy_clinic_q3', 'surrogacy_clinic_qtr_3_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q3', 'surrogacy_clinic_qtr_end_q3', 'surrogacy_clinic_left_2_error_msg',
                'Surrogacy Clinic value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_qtr_end_q3', 'surrogacy_clinic_qtr_2_error_msg',
                'Q3 Surrogacy Clinic connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            /* ================= Q4 ART CLINIC ================= */
            ['art_clinic_qtr_end_q4', 'art_clinic_qtr_end_q3', 'art_clinic_qtr_4_error_msg',
                'Q3 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q4', 'art_clinic_q4', 'art_clinic_qtr_4_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q4', 'art_clinic_qtr_end_q4', 'art_clinic_left_4_error_msg',
                'ART Clinic value cannot be Greater than the value on the Right', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q3', 'art_clinic_qtr_end_q4', 'art_clinic_qtr_3_error_msg',
                'Q4 Art Clinic connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            /* ================= Q4 ART BANK ================= */
            ['art_banks_qtr_end_q4', 'art_banks_qtr_end_q3', 'art_banks_qtr_4_error_msg',
                'Q3 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q4', 'art_banks_q4', 'art_banks_qtr_4_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q4', 'art_banks_qtr_end_q4', 'art_banks_left_4_error_msg',
                'ART Bank cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q3', 'art_banks_qtr_end_q4', 'art_banks_qtr_3_error_msg',
                'Q4 Art Bank connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            /* ================= Q4 SURROGACY ================= */
            ['surrogacy_clinic_qtr_end_q4', 'surrogacy_clinic_qtr_end_q3', 'surrogacy_clinic_left_4_error_msg',
                'Q3 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q4', 'surrogacy_clinic_q4', 'surrogacy_clinic_left_4_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q4', 'surrogacy_clinic_qtr_end_q4', 'surrogacy_clinic_left_4_error_msg',
                'Surrogacy Clinic value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q3', 'surrogacy_clinic_qtr_end_q4', 'surrogacy_clinic_qtr_3_error_msg',
                'Q4 Surrogacy Clinic value connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            /* ================= Q6 ART CLINIC ================= */
            ['art_clinic_qtr_end_q6', 'art_clinic_qtr_end_q1', 'art_clinic_qtr_6_error_msg1',
                'Q1 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q6', 'art_clinic_q6', 'art_clinic_qtr_6_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q6', 'art_clinic_qtr_end_q6', 'art_clinic_left_6_error_msg',
                'ART Clinic value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],

            /* ================= Q6 ART BANK ================= */
            ['art_banks_qtr_end_q6', 'art_banks_qtr_end_q1', 'art_banks_qtr_6_error_msg1',
                'Q1 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q6', 'art_banks_q6', 'art_banks_qtr_6_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q6', 'art_banks_qtr_end_q6', 'art_banks_left_6_error_msg',
                'ART Bank cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],

            /* ================= Q6 SURROGACY ================= */
            ['surrogacy_clinic_qtr_end_q6', 'surrogacy_clinic_qtr_end_q1', 'surrogacy_clinic_qtr_6_error_msg1',
                'Q1 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q6', 'surrogacy_clinic_q6', 'surrogacy_clinic_qtr_6_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q6', 'surrogacy_clinic_qtr_end_q6', 'surrogacy_clinic_left_6_error_msg',
                'Surrogacy Clinic value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],

            /* ================= Q7 ART CLINIC ================= */
            ['art_clinic_qtr_end_q7', 'art_clinic_qtr_end_q1', 'art_clinic_qtr_7_error_msg1',
                'Q1 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q7', 'art_clinic_q7', 'art_clinic_qtr_7_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q7', 'art_clinic_qtr_end_q7', 'art_clinic_left_7_error_msg',
                'ART Clinic value cannot be Greater than the value on the right.', 'secondLessThanFirst'
            ],

            /* ================= Q7 ART BANK ================= */
            ['art_banks_qtr_end_q7', 'art_banks_qtr_end_q1', 'art_banks_qtr_7_error_msg1',
                'Q1 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q7', 'art_banks_q7', 'art_banks_qtr_7_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q7', 'art_banks_qtr_end_q7', 'art_banks_left_7_error_msg',
                'ART Bank cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],

            /* ================= Q7 SURROGACY ================= */
            ['surrogacy_clinic_qtr_end_q7', 'surrogacy_clinic_qtr_end_q1', 'surrogacy_clinic_qtr_7_error_msg1',
                'Q1 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q7', 'surrogacy_clinic_q7', 'surrogacy_clinic_qtr_7_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q7', 'surrogacy_clinic_qtr_end_q7', 'surrogacy_clinic_left_7_error_msg',
                'Surrogacy Clinic value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ]

        ];

        const validations_Q8_Q12 = [

            // ========================= Q8 ART CLINIC =========================
            ['art_clinic_qtr_end_q8', 'art_clinic_qtr_end_q2', 'art_clinic_qtr_8_error_msg',
                'Q2 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q2', 'art_clinic_qtr_end_q8', 'art_clinic_qtr_2_error_msg',
                'Q8 Art Clinic connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            ['art_clinic_q8', 'art_clinic_qtr_end_q8', 'art_clinic_left_8_error_msg',
                'ART Clinic Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q8', 'art_clinic_q8', 'art_clinic_qtr_8_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q8 ART BANK =========================
            ['art_banks_qtr_end_q8', 'art_banks_qtr_end_q2', 'art_banks_qtr_8_error_msg',
                'Q2 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q2', 'art_banks_qtr_end_q8', 'art_banks_qtr_2_error_msg',
                'Q8 ART Bank value cannot be greater than this value.', 'secondGreaterThanFirst'
            ],

            ['art_banks_q8', 'art_banks_qtr_end_q8', 'art_banks_left_8_error_msg',
                'ART Bank Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q8', 'art_banks_q8', 'art_banks_qtr_8_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q8 SURROGACY =========================
            ['surrogacy_clinic_qtr_end_q8', 'surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_qtr_8_error_msg',
                'Q2 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q2', 'surrogacy_clinic_qtr_end_q8', 'surrogacy_clinic_qtr_2_error_msg',
                'Q8 Surrogacy Clinic value cannot be Greater than this value.', 'secondGreaterThanFirst'
            ],

            ['surrogacy_clinic_q8', 'surrogacy_clinic_qtr_end_q8', 'surrogacy_clinic_left_8_error_msg',
                'Surrogacy Clinic Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q8', 'surrogacy_clinic_q8', 'surrogacy_clinic_qtr_8_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q9 ART CLINIC =========================
            ['art_clinic_q9', 'art_clinic_qtr_end_q9', 'art_clinic_left_9_error_msg',
                'ART Clinic Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q9', 'art_clinic_q9', 'art_clinic_qtr_9_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q9 ART BANK =========================
            ['art_banks_q9', 'art_banks_qtr_end_q9', 'art_banks_left_9_error_msg',
                'ART Banks Value cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q9', 'art_banks_q9', 'art_banks_qtr_9_error_msg',
                'ART Banks value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q9 SURROGACY =========================
            ['surrogacy_clinic_q9', 'surrogacy_clinic_qtr_end_q9', 'surrogacy_clinic_left_9_error_msg',
                'Surrogacy Clinic Value cannot be greater than the value on the right.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q9', 'surrogacy_clinic_q9', 'surrogacy_clinic_qtr_9_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q10 ART CLINIC =========================
            ['art_clinic_q10', 'art_clinic_qtr_end_q10', 'art_clinic_left_10_error_msg',
                'ART Clinic Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q10', 'art_clinic_q10', 'art_clinic_qtr_10_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q10 ART BANK =========================
            ['art_banks_q10', 'art_banks_qtr_end_q10', 'art_banks_left_10_error_msg',
                'ART Banks Value cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q10', 'art_banks_q10', 'art_banks_qtr_10_error_msg',
                'ART Banks value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q10 SURROGACY =========================
            ['surrogacy_clinic_q10', 'surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_left_10_error_msg',
                'Surrogacy Clinic Value cannot be greater than the value on the left.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_q10', 'surrogacy_clinic_qtr_10_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],


            // ========================= Q11 ART CLINIC =========================
            ['art_clinic_qtr_end_q11', 'art_clinic_qtr_end_q10', 'art_clinic_qtr_11_error_msg',
                'Q10 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q11', 'art_clinic_q11', 'art_clinic_qtr_11_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q11', 'art_clinic_qtr_end_q11', 'art_clinic_left_11_error_msg',
                'ART Clinic value cannot be Greater than the value on the Right', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q10', 'art_clinic_qtr_end_q11', 'art_clinic_qtr_10_error_msg',
                'Q11 Art Clinic connot be Greater than this value', 'secondGreaterThanFirst'
            ],

            // ========================= Q11 ART BANK =========================
            ['art_banks_qtr_end_q11', 'art_banks_qtr_end_q10', 'art_banks_qtr_11_error_msg',
                'Q10 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q11', 'art_banks_q11', 'art_banks_qtr_11_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q11', 'art_banks_qtr_end_q11', 'art_banks_left_11_error_msg',
                'ART Bank cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q10', 'art_banks_qtr_end_q11', 'art_banks_qtr_10_error_msg',
                'Q11 ART Bank value cannot be greater than this value.', 'secondGreaterThanFirst'
            ],

            // ========================= Q11 SURROGACY =========================
            ['surrogacy_clinic_qtr_end_q11', 'surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_qtr_11_error_msg',
                'Q10 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q11', 'surrogacy_clinic_q11', 'surrogacy_clinic_qtr_11_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q11', 'surrogacy_clinic_qtr_end_q11', 'surrogacy_clinic_left_11_error_msg',
                'Surrogacy Clinic value cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_qtr_end_q11', 'surrogacy_clinic_qtr_10_error_msg',
                'Q11 Surrogacy Clinic value cannot be greater than this value.', 'secondGreaterThanFirst'
            ],


            // ========================= Q12 ART CLINIC =========================
            ['art_clinic_qtr_end_q12', 'art_clinic_qtr_end_q10', 'art_clinic_qtr_12_error_msg',
                'Q10 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q12', 'art_clinic_q12', 'art_clinic_qtr_12_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q12', 'art_clinic_qtr_end_q12', 'art_clinic_left_12_error_msg',
                'ART Clinic value cannot be greater than the value on the right', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q10', 'art_clinic_qtr_end_q12', 'art_clinic_qtr_10_error_msg',
                'Q12 Art Clinic connot be greater than this value', 'secondGreaterThanFirst'
            ],

            // ========================= Q12 ART BANK =========================
            ['art_banks_qtr_end_q12', 'art_banks_qtr_end_q10', 'art_banks_qtr_12_error_msg',
                'Q10 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q12', 'art_banks_q12', 'art_banks_qtr_12_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q12', 'art_banks_qtr_end_q12', 'art_banks_left_12_error_msg',
                'ART Bank cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q10', 'art_banks_qtr_end_q12', 'art_banks_qtr_10_error_msg',
                'Q12 ART Bank value cannot be greater than this value.', 'secondGreaterThanFirst'
            ],

            // ========================= Q12 SURROGACY =========================
            ['surrogacy_clinic_qtr_end_q12', 'surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_qtr_12_error_msg',
                'Q10 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q12', 'surrogacy_clinic_q12', 'surrogacy_clinic_qtr_12_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q12', 'surrogacy_clinic_qtr_end_q12', 'surrogacy_clinic_left_12_error_msg',
                'Surrogacy Clinic value cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_qtr_end_q12', 'surrogacy_clinic_qtr_10_error_msg',
                'Q12 Surrogacy Clinic value cannot be greater than this value.', 'secondGreaterThanFirst'
            ]
        ];

        const validations_Q13_Q17 = [

            // ========================= Q13 ART CLINIC =========================
            ['art_clinic_qtr_end_q13', 'art_clinic_qtr_end_q10', 'art_clinic_qtr_13_error_msg',
                'Q10 Art Clinic connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q13', 'art_clinic_q13', 'art_clinic_qtr_13_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_clinic_q13', 'art_clinic_qtr_end_q13', 'art_clinic_left_13_error_msg',
                'ART Clinic value cannot be greater than the value on the Right', 'secondLessThanFirst'
            ],
            ['art_clinic_qtr_end_q10', 'art_clinic_qtr_end_q13', 'art_clinic_qtr_10_error_msg',
                'Q13 Art Clinic connot be greater than this value', 'secondGreaterThanFirst'
            ],

            // ========================= Q13 ART BANK =========================
            ['art_banks_qtr_end_q13', 'art_banks_qtr_end_q10', 'art_banks_qtr_13_error_msg',
                'Q10 Art Bank connot be less than this value', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q13', 'art_banks_q13', 'art_banks_qtr_13_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['art_banks_q13', 'art_banks_qtr_end_q13', 'art_banks_left_13_error_msg',
                'ART Bank cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_q10', 'art_banks_qtr_end_q13', 'art_banks_qtr_10_error_msg',
                'Q13 ART Bank value cannot be greater than this value.', 'secondGreaterThanFirst'
            ],

            // ========================= Q13 SURROGACY =========================
            ['surrogacy_clinic_qtr_end_q13', 'surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_qtr_13_error_msg',
                'Q10 Surrogacy Clinic value connot be less than this value', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q13', 'surrogacy_clinic_q13', 'surrogacy_clinic_qtr_13_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],
            ['surrogacy_clinic_q13', 'surrogacy_clinic_qtr_end_q13', 'surrogacy_clinic_left_13_error_msg',
                'Surrogacy Clinic value cannot be greater than the value on the left.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinic_qtr_end_q10', 'surrogacy_clinic_qtr_end_q13', 'surrogacy_clinic_qtr_10_error_msg',
                'Q13 Surrogacy Clinic value cannot be greater than this value.', 'secondGreaterThanFirst'
            ],


            // ========================= Q14 =========================
            ['appeal_rej_app_a_q14', 'appeal_rej_app_qtr_end_a_q14', 'renewal_left_14a_error_msg',
                'cannot be greater than the value on the right.', 'secondLessThanFirst'
            ],
            ['appeal_rej_app_qtr_end_a_q14', 'appeal_rej_app_a_q14', 'renewal_qtr_14a_error_msg',
                'cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            ['appeals_disposed_b_q14', 'appeals_disposed_qtr_end_b_q14', 'renewal_left_14b_error_msg',
                ' cannot be greater than the value on the right.', 'secondLessThanFirst'
            ],
            ['appeals_disposed_qtr_end_b_q14', 'appeals_disposed_b_q14', 'renewal_qtr_14b_error_msg',
                ' cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            ['appeals_disposed_qtr_end_b_q14', 'appeal_rej_app_qtr_end_a_q14', 'renewal_qtr_14b_error_msg',
                'Q14A value connot be less than this value', 'secondLessThanFirst'
            ],
            ['appeal_rej_app_qtr_end_a_q14', 'appeals_disposed_qtr_end_b_q14', 'renewal_qtr_14a_error_msg',
                'Q14 B value connot be greater than this value.', 'secondGreaterThanFirst'
            ],

            // ========================= Q15 =========================
            ['forwarded_dhr_i_q15', 'forwarded_dhr_qtr_end_i_q15', 'art_clinic_left_15_error_msg',
                'Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['forwarded_dhr_qtr_end_i_q15', 'forwarded_dhr_i_q15', 'art_clinic_qtr_15_error_msg',
                'value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q15 ART BANK =========================
            ['received_stakeholders_ii_q15', 'received_stakeholders_qtr_end_ii_q15', 'art_banks_left_15_error_msg',
                'Value cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['received_stakeholders_qtr_end_ii_q15', 'received_stakeholders_ii_q15', 'art_banks_qtr_15_error_msg',
                'value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q15 SURROGACY =========================
            ['suo_moto_cognizancеr_iii_q15', 'suo_moto_cognizancеr_qtr_end_iii_q15',
                'surrogacy_clinic_left_15_error_msg', 'Value cannot be greater than the value on the left.',
                'secondLessThanFirst'
            ],
            ['suo_moto_cognizancеr_qtr_end_iii_q15', 'suo_moto_cognizancеr_iii_q15',
                'surrogacy_clinic_qtr_15_error_msg', 'value cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],

            // ========================= Q16A =========================
            ['action_taken_a_q16', 'action_taken_qtr_end_a_q16', 'surrogacy_clinic_left_16a_error_msg',
                ' cannot be greater than the value on the right.', 'secondLessThanFirst'
            ],
            ['action_taken_qtr_end_a_q16', 'action_taken_a_q16', 'surrogacy_clinic_qtr_16a_error_msg',
                ' cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q16 B ART Clinic =========================
            ['art_clinics_b_q16', 'art_clinics_qtr_end_b_q16', 'art_clinic_left_b_16_error_msg',
                'ART Clinic Value cannot be Greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_clinics_qtr_end_b_q16', 'art_clinics_b_q16', 'art_clinic_qtr_b_16_error_msg',
                'ART Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q16 B ART BANK =========================
            ['art_banks_b_q16', 'art_banks_qtr_end_b_q16', 'art_banks_left_b_16_error_msg',
                'ART Bank Value cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['art_banks_qtr_end_b_q16', 'art_banks_b_q16', 'art_banks_qtr_b_16_error_msg',
                'ART Bank value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q16 B SURROGACY =========================
            ['surrogacy_clinics_b_q16', 'surrogacy_clinics_qtr_end_b_q16', 'surrogacy_clinics_left_b_16_error_msg',
                'Surrogacy Clinic Value cannot be greater than the value on the left.', 'secondLessThanFirst'
            ],
            ['surrogacy_clinics_qtr_end_b_q16', 'surrogacy_clinics_b_q16', 'surrogacy_clinics_qtr_b_16_error_msg',
                'Surrogacy Clinic value cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],


            // ========================= Q17 =========================
            ['appeal_received_a_q17', 'appeal_received_qtr_end_a_q17', 'appeal_received_left_17a_error_msg',
                'cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['appeal_received_qtr_end_a_q17', 'appeal_received_a_q17', 'appeal_received_qtr_17a_error_msg',
                'cannot be ess than the value on the left.', 'secondGreaterThanFirst'
            ],

            ['appeals_disposed_qtr_end_b_q17', 'appeals_disposed_b_q17', 'appeal_received_qtr_17b_error_msg',
                'Q17 B value connot be less than this value.', 'secondGreaterThanFirst'
            ],
            ['appeals_disposed_b_q17', 'appeals_disposed_qtr_end_b_q17', 'appeal_received_left_17b_error_msg',
                ' Q17 B value connot be greater than this value.', 'secondLessThanFirst'
            ],

            ['appeals_disposed_qtr_end_b_q17', 'appeal_received_qtr_end_a_q17', 'appeal_received_qtr_17b_error_msg',
                'Q17 A value connot be less than this value', 'secondLessThanFirst'
            ],
            ['appeal_received_qtr_end_a_q17', 'appeals_disposed_qtr_end_b_q17', 'appeal_received_qtr_17a_error_msg',
                'Q17 B value connot be greater than this value.', 'secondGreaterThanFirst'
            ]



        ];

        const validations_Q18_Q22 = [

            // ========================= Q18 =========================
            ['complaints_filed_q18', 'complaints_filed_qtr_end_q18', 'complaints_filed_left_18_error_msg',
                ' cannot be greater than the value on the right.', 'secondLessThanFirst'
            ],
            ['complaints_filed_qtr_end_q18', 'complaints_filed_q18', 'complaints_filed_qtr_18_error_msg',
                ' cannot be less than the value on the left.', 'secondGreaterThanFirst'
            ],

            // ========================= Q19 A =========================
            ['applications_received_i_a_q19', 'applications_received_qtr_end_i_a_q19',
                'appeal_received_left_19ai_error_msg', ' cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_received_ii_a_q19', 'applications_received_qtr_end_ii_a_q19',
                'appeal_received_left_19aii_error_msg', ' cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_received_iii_a_q19', 'applications_received_qtr_end_iii_a_q19',
                'appeal_received_left_19aiii_error_msg', ' cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_received_iv_a_q19', 'applications_received_qtr_end_iv_a_q19',
                'appeal_received_left_19aiv_error_msg', ' cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],

            ['applications_received_qtr_end_i_a_q19', 'applications_received_i_a_q19',
                'appeal_received_qtr_19ai_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_ii_a_q19', 'applications_received_ii_a_q19',
                'appeal_received_qtr_19aii_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_iii_a_q19', 'applications_received_iii_a_q19',
                'appeal_received_qtr_19aiii_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_iv_a_q19', 'applications_received_iv_a_q19',
                'appeal_received_qtr_19aiv_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],

            // ========================= Q19 B =========================
            ['applications_granted_i_b_q19', 'applications_granted_qtr_end_i_b_q19',
                'applications_granted_left_19bi_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_granted_ii_b_q19', 'applications_granted_qtr_end_ii_b_q19',
                'applications_granted_left_19bii_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_granted_iii_b_q19', 'applications_granted_qtr_end_iii_b_q19',
                'applications_granted_left_19biii_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_granted_iv_b_q19', 'applications_granted_qtr_end_iv_b_q19',
                'applications_granted_left_19biv_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],

            ['applications_granted_qtr_end_i_b_q19', 'applications_granted_i_b_q19',
                'applications_granted_qtr_19bi_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_granted_qtr_end_ii_b_q19', 'applications_granted_ii_b_q19',
                'applications_granted_qtr_19bii_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_granted_qtr_end_iii_b_q19', 'applications_granted_iii_b_q19',
                'applications_granted_qtr_19biii_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_granted_qtr_end_iv_b_q19', 'applications_granted_iv_b_q19',
                'applications_granted_qtr_19biv_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],

            // ========================= Q19 A - B =========================
            ['applications_granted_qtr_end_i_b_q19', 'applications_received_qtr_end_i_a_q19',
                'applications_granted_qtr_19bi_error_msg', 'Q19 A.i value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['applications_granted_qtr_end_ii_b_q19', 'applications_received_qtr_end_ii_a_q19',
                'applications_granted_qtr_19bii_error_msg', 'Q19 A.ii value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['applications_granted_qtr_end_iii_b_q19', 'applications_received_qtr_end_iii_a_q19',
                'applications_granted_qtr_19biii_error_msg', 'Q19 A.iii value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['applications_granted_qtr_end_iv_b_q19', 'applications_received_qtr_end_iv_a_q19',
                'applications_granted_qtr_19biv_error_msg', 'Q19 A.iv value connot be less than this value.',
                'secondLessThanFirst'
            ],

            // ========================= Q19 B - A =========================
            ['applications_received_qtr_end_i_a_q19', 'applications_granted_qtr_end_i_b_q19',
                'appeal_received_qtr_19ai_error_msg', 'Q19 B.i value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_ii_a_q19', 'applications_granted_qtr_end_ii_b_q19',
                'appeal_received_qtr_19aii_error_msg', ' Q19 B.ii value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_iii_a_q19', 'applications_granted_qtr_end_iii_b_q19',
                'appeal_received_qtr_19aiii_error_msg', 'Q19 B.iii value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_iv_a_q19', 'applications_granted_qtr_end_iv_b_q19',
                'appeal_received_qtr_19aiv_error_msg', 'Q19 B.iv value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],

            // ========================= Q19 C =========================
            ['applications_rejected_i_c_q19', 'applications_rejected_qtr_end_i_c_q19',
                'applications_rejected_left_19ci_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_rejected_ii_c_q19', 'applications_rejected_qtr_end_ii_c_q19',
                'applications_rejected_left_19cii_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_rejected_iii_c_q19', 'applications_rejected_qtr_end_iii_c_q19',
                'applications_rejected_left_19ciii_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['applications_rejected_iv_c_q19', 'applications_rejected_qtr_end_iv_c_q19',
                'applications_rejected_left_19civ_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],

            ['applications_rejected_qtr_end_i_c_q19', 'applications_rejected_i_c_q19',
                'applications_rejected_qtr_19ci_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_rejected_qtr_end_ii_c_q19', 'applications_rejected_ii_c_q19',
                'applications_rejected_qtr_19cii_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_rejected_qtr_end_iii_c_q19', 'applications_rejected_iii_c_q19',
                'applications_rejected_qtr_19ciii_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],
            ['applications_rejected_qtr_end_iv_c_q19', 'applications_rejected_iv_c_q19',
                'applications_rejected_qtr_19civ_error_msg', ' cannot be less than the value on the left.',
                'secondGreaterThanFirst'
            ],

            // ========================= Q19 A - C =========================
            ['applications_rejected_qtr_end_i_c_q19', 'applications_received_qtr_end_i_a_q19',
                'applications_rejected_qtr_19ci_error_msg', 'Q19 A.i value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['applications_rejected_qtr_end_ii_c_q19', 'applications_received_qtr_end_ii_a_q19',
                'applications_rejected_qtr_19cii_error_msg', 'Q19 A.ii value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['applications_rejected_qtr_end_iii_c_q19', 'applications_received_qtr_end_iii_a_q19',
                'applications_rejected_qtr_19ciii_error_msg', 'Q19 A.iii value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['applications_rejected_qtr_end_iv_c_q19', 'applications_received_qtr_end_iv_a_q19',
                'applications_rejected_qtr_19civ_error_msg', 'Q19 A.iv value connot be less than this value.',
                'secondLessThanFirst'
            ],

            // ========================= Q19 C - A =========================
            ['applications_received_qtr_end_i_a_q19', 'applications_rejected_qtr_end_i_c_q19',
                'appeal_received_qtr_19ai_error_msg', 'Q19 C.i value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_ii_a_q19', 'applications_rejected_qtr_end_ii_c_q19',
                'appeal_received_qtr_19aii_error_msg', 'Q19 C.ii value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_iii_a_q19', 'applications_rejected_qtr_end_iii_c_q19',
                'appeal_received_qtr_19aiii_error_msg', 'Q19 C.iii value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],
            ['applications_received_qtr_end_iv_a_q19', 'applications_rejected_qtr_end_iv_c_q19',
                'appeal_received_qtr_19aiv_error_msg', 'Q19 C.iv value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],


            // ========================= Q20 =========================
            ['appeals_against_rejection_a_q20', 'appeals_against_rejection_qtr_end_a_q20',
                'appeals_against_rejection_left_20a_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['appeals_against_rejection_qtr_end_a_q20', 'appeals_against_rejection_a_q20',
                'appeals_against_rejection_qtr_20a_error_msg', 'connot be less than the value on the Left',
                'secondGreaterThanFirst'
            ],

            ['appeals_disposed_b_q20', 'appeals_disposed_qtr_end_b_q20', 'appeals_disposed_left_20b_error_msg',
                'connot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['appeals_disposed_qtr_end_b_q20', 'appeals_disposed_b_q20', 'appeals_disposed_qtr_20b_error_msg',
                'connot be less than the value on the Left.', 'secondGreaterThanFirst'
            ],

            ['appeals_disposed_qtr_end_b_q20', 'appeals_against_rejection_qtr_end_a_q20',
                'appeals_disposed_qtr_20b_error_msg', 'Q20 A value connot be less than this value.',
                'secondLessThanFirst'
            ],
            ['appeals_against_rejection_qtr_end_a_q20', 'appeals_disposed_qtr_end_b_q20',
                'appeals_against_rejection_qtr_20a_error_msg', 'Q20 B value connot be greater than this value.',
                'secondGreaterThanFirst'
            ],

            // ========================= Q22 =========================
            ['chapter_v_art_q22', 'chapter_v_art_qtr_end_q22', 'chapter_v_art_left_22_error_msg',
                'cannot be greater than the value on the Right.', 'secondLessThanFirst'
            ],
            ['chapter_v_art_qtr_end_q22', 'chapter_v_art_q22', 'chapter_v_art_qtr_22_error_msg',
                'cannot be less than the value on the Left.', 'secondGreaterThanFirst'
            ],

            ['surrogacy_chapter_vii_q22', 'surrogacy_chapter_qtr_end_vii_q22',
                'surrogacy_chapter_vii_left_22_error_msg', 'cannot be greater than the value on the Right.',
                'secondLessThanFirst'
            ],
            ['surrogacy_chapter_qtr_end_vii_q22', 'surrogacy_chapter_vii_q22', 'surrogacy_chapter_vii_qtr_22_error_msg',
                'cannot be less than the value on the Left.', 'secondGreaterThanFirst'
            ],

        ];

        const validations = [
            ...validations_Q2_Q7,
            ...validations_Q8_Q12,
            ...validations_Q13_Q17,
            ...validations_Q18_Q22
        ];

        $(document).ready(function() {
            $('.errors').hide();
            $('.alowedchar').on('input', function() {
                this.value = this.value.replace(/[^0-9/,]/g, '');
            });

            function compareFields(firstInputId, secondInputId, errorSelector, errorMsg, rule) {
                $(document).on('keyup', '#' + firstInputId + ', #' + secondInputId, function() {

                    let firstVal = Number(document.getElementById(firstInputId).value || 0);
                    let secondVal = document.getElementById(secondInputId).value;

                    if (secondVal === '') {
                        document.getElementById(errorSelector).textContent = '';
                        return;
                    }

                    secondVal = Number(secondVal);

                    let isError = false;

                    if (rule === 'secondLessThanFirst') {
                        isError = secondVal < firstVal;
                    }

                    if (rule === 'secondGreaterThanFirst') {
                        isError = secondVal > firstVal;
                    }

                    document.getElementById(errorSelector).textContent = isError ? errorMsg : '';
                });
            }

            function setvalueto5(firstInputId, secondInputId, thirdInputId) {
                const firstInput = document.getElementById(firstInputId);
                const secondInput = document.getElementById(secondInputId);
                const thirdInput = document.getElementById(thirdInputId);

                function sanitizeInteger(input) {
                    // Remove anything that is not a digit or minus sign
                    input.value = input.value.replace(/[^0-9-]/g, '');
                }

                function calculate() {
                    let val1 = parseInt(firstInput.value, 10);
                    let val2 = parseInt(secondInput.value, 10);

                    if (isNaN(val1)) val1 = 0;
                    if (isNaN(val2)) val2 = 0;

                    thirdInput.value = val2 - val1;
                }

                function handleInput(e) {
                    sanitizeInteger(e.target);
                    calculate();
                }

                firstInput.addEventListener("input", handleInput);
                secondInput.addEventListener("input", handleInput);
            }

            function subtractOnKeyupTriggers(triggerIds, staticA, staticB, resultId) {

                function calculate() {
                    let v1 = Number(document.getElementById(staticA).value || 0);
                    let v2 = Number(document.getElementById(staticB).value || 0);

                    document.getElementById(resultId).value = v1 - v2;
                }

                triggerIds.forEach(id => {
                    document.getElementById(id).addEventListener('keyup', calculate);
                });
            }








            // 4 or 3 calculation value
            setvalueto5('art_clinic_qtr_end_q4', 'art_clinic_qtr_end_q3', 'art_clinic_qtr_end_q5');
            setvalueto5('art_banks_qtr_end_q4', 'art_banks_qtr_end_q3', 'art_banks_qtr_end_q5');
            setvalueto5('surrogacy_clinic_qtr_end_q4', 'surrogacy_clinic_qtr_end_q3',
            'surrogacy_clinic_qtr_end_q5');
            setvalueto5('art_clinic_q4', 'art_clinic_q3', 'art_clinic_q5');
            setvalueto5('art_banks_q4', 'art_banks_q3', 'art_banks_q5');
            setvalueto5('surrogacy_clinic_q4', 'surrogacy_clinic_q3', 'surrogacy_clinic_q5');
            setvalueto5('tno_q4', 'tno_q3', 'tno_q5');
            setvalueto5('tno_qtr_end_q4', 'tno_qtr_end_q3', 'tno_qtr_end_q5');

            let q3_q4_qtends_ids = ['art_clinic_qtr_end_q3', 'art_banks_qtr_end_q3', 'surrogacy_clinic_qtr_end_q3',
                'art_clinic_qtr_end_q4', 'art_banks_qtr_end_q4', 'surrogacy_clinic_qtr_end_q4'
            ];

            let q3_q4_ids = ['art_clinic_q3', 'art_banks_q3', 'surrogacy_clinic_q3', 'art_clinic_q4',
                'art_banks_q4', 'surrogacy_clinic_q4'
            ];
            subtractOnKeyupTriggers(
                q3_q4_qtends_ids, // different keyup elements
                'tno_qtr_end_q3', // static value A
                'tno_qtr_end_q4', // static value B
                'tno_qtr_end_q5' // static output
            );
            subtractOnKeyupTriggers(
                q3_q4_ids, // different keyup elements
                'tno_q3', // static value A
                'tno_q4', // static value B
                'tno_q5' // static output
            );
            validations.forEach(v => {
                compareFields(v[0], v[1], v[2], v[3], v[4]);
            });
             });

             $(document).ready(function() {

             function validateOnce(firstInputId, secondInputId, errorSelector, errorMsg, rule) {
                let firstVal = Number($('#' + firstInputId).val() || 0);
                let secondVal = $('#' + secondInputId).val();

                if (secondVal === '') {
                $(errorSelector).text('');
                return true;
                }
                secondVal = Number(secondVal);
                let isError = false;

                if (rule === 'secondLessThanFirst') {
                isError = secondVal < firstVal;
                }

                if (rule === 'secondGreaterThanFirst') {
                isError = secondVal > firstVal;
                }
                if (isError) {
                    console.log('Validation Error:', errorMsg);
                }
                $('#' + errorSelector).text(isError ? errorMsg : '');
                
                return !isError;
            }

            /*Validation*/
            $('.q9_annx, .q16_annx, .q22_annx').hide();
            $("#submitBtn").click(function(e) {
                e.preventDefault();
                let isFormValid = true;
                 $('.errors').show();
                $(".errors").text('');
                let errorSpan = '';

                validations.forEach(v => {
                    const isValid = validateOnce(v[0], v[1], v[2], v[3], v[4]);
                    if (!isValid) {
                        isFormValid = false;
                        }
                    });

                    if (!isFormValid) {
                //         e.preventDefault(); // stop form submission
                        alert("Incorrect Data Please check all the data before submitting.");
                        return false;
                    }
                let common = '<input type="hidden" name="common" value="submit">';
                $("#submitType").html(common);
                const byId = (id) => document.getElementById(id);
                let flag = 0;


                $('#msgqtr').html("");
                $('#msgyear').html("");
                let year = $('#year').val();
                let qtr = $('#quarter').val();

                let applicant_name = $('#applicant_name').val();
                let designation = $('#designation').val();
                let place = $('#place').val();
                if (qtr == "") {
                    $('#msgqtr').html("Please enter quarter");
                    flag = 1;
                }
                if (year == "") {
                    $('#msgyear').html("Please enter years");
                    flag = 1;
                }
                if (applicant_name == "") {
                    $('#msgapplicant_name').html("Please enter name");
                    flag = 1;
                }
                if (designation == "") {
                    $('#msgdesignation').html("Please enter designation");
                    flag = 1;
                }
                if (place == "") {
                    $('#msgplace').html("Please enter place");
                    flag = 1;
                }



                //Question 9 validation
                let firstRow = $('.q9-row:first');
                let clinicName = firstRow.find('.clinic-name').val().trim();
                let actionTaken = firstRow.find('.action-taken').val().trim();
                if (clinicName === '' || actionTaken === '') {
                    $('.q9_annx').show();
                    flag = 1;
                } else {
                    $('.q9_annx').hide();
                }

                //Question 15 and 16 validation
                let firstRowQ16 = $('.q16-row:first');
                let clinicNameQ16 = firstRowQ16.find('.complaint-source').val().trim();
                let filedbyQ16 = firstRowQ16.find('.filed-by').val().trim();
                let filedagainstQ16 = firstRowQ16.find('.filed-against').val().trim();
                let issuedetailsQ16 = firstRowQ16.find('.issue-details').val().trim();
                if (firstRowQ16 === '' || clinicNameQ16 === '' || filedbyQ16 === '' || filedagainstQ16 ===
                    '' || issuedetailsQ16 === "") {
                    $('.q16_annx').show();
                    flag = 1;
                } else {
                    $('.q16_annx').hide();
                }

                //Question 18 and 22 validation

                let firstRowQ22 = $('.q22-row:first');
                let caseFiledByQ22 = firstRowQ22.find('.case-filed-by').val().trim();
                let caseFiledAgainstQ22 = firstRowQ22.find('.case-filed-against').val().trim();
                let sectionActForViolationQ22 = firstRowQ22.find('.section-act-for-violation').val().trim();
                let issuedetailsQ22 = firstRowQ22.find('.issue-details').val().trim();
                let personsArrestedQ22 = firstRowQ22.find('.persons-arrested').val().trim();
                let caseOutcomeQ22 = firstRowQ22.find('.case-outcome').val().trim();


                if (caseFiledByQ22 === '' || caseFiledAgainstQ22 === '' || sectionActForViolationQ22 ===
                    '' || issuedetailsQ22 === '' || personsArrestedQ22 === "" || caseOutcomeQ22 === "") {
                    $('.q22_annx').show();
                    flag = 1;
                } else {
                    $('.q22_annx').hide();
                }

                const decl = byId("declaration");
                if (decl && !decl.checked) {
                    // alert("Declaration cannot be blank");  
                    $('#msgdeclarationr').html("Declaration cannot be blank");
                    flag = 1;
                }
                if (flag == 1) {
                    e.preventDefault(); // 🚫 stop submit
                    alert("Please correct all invalid values");
                    $('#allErrors').html("Please correct the incorrect values entered for the questions.");
                    return false;
                }
                if (flag == 0) {
                    $('#allErrors').html("");
                    // Final confirm
                    const agree = confirm(
                        "Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted."
                    );
                    if (agree)
                        $('#multi-step-form').submit(); 
                }
            })

            //Save as draft
            $("#draftBtn").click(function(e) {
                e.preventDefault();
                let common = '<input type="hidden" name="common" value="draft">';
                $("#submitType").html(common);
                const byId = (id) => document.getElementById(id);
                let flag = 0;
                $('#msgqtr').html("");  
                $('#msgyear').html("");
                let year = $('#year').val();
                let qtr = $('#quarter').val();
                let applicant_name = $('#applicant_name').val();
                let designation = $('#designation').val();
                let place = $('#place').val();
                if (qtr == "") {
                    $('#msgqtr').html("Please enter quarter");
                    flag = 1;
                }
                if (year == "") {
                    $('#msgyear').html("Please enter years");
                    flag = 1;
                }
                if (flag == 0) {
                    $('#multi-step-form').submit();
                }
            })
        });
    </script>
@endsection
