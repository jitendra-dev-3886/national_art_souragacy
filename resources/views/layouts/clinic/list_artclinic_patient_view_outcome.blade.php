@extends('layouts.clinic.clinic_master')
@section('content')
    <div class="container mt-4">
        @php

            $totalPatients = $patient_list->sum('patient_count');
            $drafted = $patient_list_draft->sum('patient_count');
            $complte = $patient_list_complte->sum('patient_count');
            $duePatients = $totalPatients - $complte;

        @endphp
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- Top Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Total Patients</h6>
                    <h3>{{ $totalPatients }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Due Patients</h6>
                    <h3>{{ $duePatients }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Drafted</h6>
                    <h3>{{ $drafted }}</h3>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3">
                    <h6>Completed</h6>
                    <h3>{{ $complte }}</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Table -->
            <div class="col-md-8">
                <div class="card p-3">
                    <h5>Quarter Reports</h5>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Quarter & Year</th>
                                <th>Total</th>
                                <th>Due</th>
                                <th>Patients</th>
                                <th>Drafted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach ($quarter_list as $index => $group)
                                @php
                                    $encryptedParams = encrypt($group->quarter . '|' . $group->year);
                                    $patient = $patient_list
                                        ->where('year', $group->year)
                                        ->where('quarter', $group->quarter)
                                        ->first();

                                    $patient_draft = $patient_list_draft
                                        ->where('year', $group->year)
                                        ->where('quarter', $group->quarter)
                                        ->first();
                                    $patient_complte = $patient_list_complte
                                        ->where('year', $group->year)
                                        ->where('quarter', $group->quarter)
                                        ->first();

                                    $totalPatients = $patient->patient_count ?? 0;
                                    $completedPatients = $patient_complte->patient_count ?? 0;
                                    $duePatients = $totalPatients - $completedPatients;

                                @endphp
                                <tr>

                                    <td> {{ ($quarterDescriptions[$group->quarter] ?? $group->quarter) . ', ' . $group->year }}
                                    </td>
                                    <td> {{ $patient->patient_count ?? 0 }} </td>
                                    <td> {{ $duePatients ?? 0 }} </td>
                                    <td>{{ $patient_complte->patient_count ?? 0 }}</td>
                                    <td>{{ $patient_draft->patient_count ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('clinic.outcome.uhids_artclinic', ['encrypted' => $encryptedParams, 'type' => 'draft']) }}"
                                            class="btn btn-primary btn-sm">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Submission Panel -->
            <div class="col-md-4">
                <div class="card p-3">

                    <div class="alert alert-warning">
                        You have {{ $drafted }} pending drafts
                    </div>

                    <div class="mb-2">
                        <strong> {{ $daysRemaining }} days remaining</strong>
                    </div>

                    <div class="mb-3">
                        You can submit up to 25 records at a time.
                    </div>
                    @php
                        $isDisabled = $drafted >= 25 || ($daysRemaining <= 0 && $drafted > 0);
                    @endphp

                    <!-- Final Submit -->
                    <form method="POST" action="{{ route('clinic.patient_part2_detail_form') }}">
                        @csrf
                        <!-- Start Filing -->
                        <input type="submit" id="startBtn" name="action" value="Start Filling Patient Output"
                            class="btn btn-primary w-100 mb-2" {{ $isDisabled ? 'disabled' : '' }}>
                        <input type="hidden" name="ref_no" value="{{ $ref_no ?? '' }}">
                        <button type="submit" name="action" value="Final Submit" class="btn btn-primary w-100"
                            @if ($drafted == 0) disabled @endif>
                            Final Submit
                        </button>
                    </form>

                </div>
            </div>
        </div>

    </div>

    <script nonce="{{ $cspNonce }}">
        document.addEventListener('DOMContentLoaded', function() {

            const startBtn = document.getElementById('startBtn');
            const finalSubmitBtn = document.querySelector('button[value="Final Submit"]');

            const drafted = {{ $drafted ?? 0 }};
            const daysRemaining = {{ $daysRemaining ?? 0 }};

            // Final Submit disable when no draft
            if (drafted == 0 && finalSubmitBtn) {
                finalSubmitBtn.disabled = true;
            }

            if (startBtn) {
                startBtn.addEventListener('click', function(e) {

                    // ❌ draft limit
                    if (drafted >= 25) {
                        e.preventDefault();
                        alert("You can only have 25 pending drafts.");
                        return;
                    }

                    // ❌ 30 days passed ONLY if draft exists
                    if (daysRemaining <= 0 && drafted > 0) {
                        e.preventDefault();
                        alert("30 days have passed. Please Final Submit first.");
                        return;
                    }

                    // ✅ drafted == 0 → allow
                });
            }
        });
    </script>
@endsection
