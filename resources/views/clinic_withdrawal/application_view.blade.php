@extends('layouts.clinic.clinic_master') @section('content')

<style nonce="{{ $cspNonce }}">
    body {
        background: #f4f6f9;
    }

    .form-wrapper {
        border: 1px solid #d6dbe1;
        border-radius: 10px;
        background: #fff;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .page-title {
        font-weight: 700;
        color: #133c37;
        margin-bottom: 0;
    }

    .form-section {
        border: 1px solid #d6dbe1;
        border-radius: 8px;
        margin-bottom: 20px;
        overflow: hidden;
        background: #fff;
    }

    .section-header {
        background: #333;
        color: #fff;
        padding: 8px;
        font-size: 15px;
        font-weight: bold;
        margin-top: 15px;
    }

    .section-body {
        padding: 10px;
        border: 1px solid #ddd;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th {
        background: #f8f9fa;
        width: 30%;
        text-align: left;
        padding: 10px;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    table td {
        padding: 10px;
        border: 1px solid #dee2e6;
    }

    .declaration-box {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 12px;
        margin-top: 15px;
    }

    .signature-box {
        text-align: right;
        margin-top: 40px;
    }
</style>

<div class="container-fluid">
    <div class="form-wrapper">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="m-3"> 
                    <b> Withdrawal Request Details for 
                        {{ substr($application->clinic_type, 0, 3) . ' ' . ucfirst(strtolower(substr($application->clinic_type, 3))) }}
                    </b> </h3> <a href="{{ route('withdrawal.application_view', [ 'encryptedClinicId' => Crypt::encryptString($application->id), 'mode' => 'pdf' ]) }}" class="btn btn-primary me-3" target="_blank"> Download PDF </a> </div>
        </div> {{-- SECTION 1 --}}

        @if(session('success'))
            <div class="alert alert-{{ session('type') === 'submit' ? 'success' : 'success' }}">
                {{ session('success') }}
            </div>
        @endif

        <div class="section-header bg-light">
            1. Clinic Details
        </div>

        <div class="section-body">
            <table class="table table-bordered">
                <tr>
                    <th>Application No.</th>
                    <td>{{ $application->applicationno ?? '-' }}</td>

                    <th>Registration No.</th>
                    <td>{{ $application->registration_no ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Name of Clinic</th>
                    <td>{{ $application->clinic_name ?? '-' }}</td>

                    <th>Clinic Type</th>
                    <td>{{ $application->clinic_type ?? '-' }}</td>
                </tr>

                <tr>
                    <th>State</th>
                    <td>{{ $application->state ?? '-' }}</td>

                    <th>District</th>
                    <td>{{ $application->district ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Address</th>
                    <td colspan="3">{{ $application->address ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="section-header bg-light">
            2. Withdrawal Details
        </div>

        <div class="section-body">
            <table class="table table-bordered">
                <tr>
                    <th>Application Date</th>
                    <td>
                        {{ !empty($application->application_date) ? date('d-m-Y', strtotime($application->application_date)) : '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Reason for Withdrawal</th>
                    <td>{{ $application->withdrawal_reason ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{{ $application->withdrawal_description ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="section-header bg-light">
            3. Uploaded Documents
        </div>
        <div class="section-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="10%">S.No.</th>
                        <th>Document Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($uploadDocs as $doc)
                    <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="input-group">
                                <div class="input-group">
                                    <i class="fa fa-download"></i> &nbsp;
                                        <a href="{{ asset('webprodfiles/clinic_application/' . str_replace('/', '_', $application->applicationno) . '/' . $doc->file_name) }}"
                                           target="_blank">
                                            View Document
                                        </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">No documents uploaded</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="section-header bg-light"> 4. Declaration</div>
           <div class="section-body">
            <p> <input type="checkbox" id="declaration" name="declaration" class="form-check-input"
                    {{ $application->declaration ? 'checked' : '' }}>
                <strong>
                    I/We hereby declare that the information provided above is true
                    and correct to the best of my/our knowledge and belief.
                </strong>
            </p>

            <table class="table table-bordered">

                <tr>
                    <th>Authorized Signatory</th>
                    <td>{{ $application->authorized_signatory ?? '-' }}</td>

                    <th>Designation</th>
                    <td>{{ $application->designation ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Contact Number</th>
                    <td>{{ $application->contact_no ?? '-' }}</td>

                    <th>Date</th>
                    <td>

                        {{ !empty($application->declaration_date) ? date('d-m-Y', strtotime($application->declaration_date)) : '-' }}
                    </td>
                </tr>

            </table>

             <div class="text-end mt-3">
                <strong>Name & Signature (with Seal)</strong>
            </div>
        </div>

        @if($application->appstatus == 'Pending' && $application->status == 1)
        <div class="section-header bg-light"> 5. Withdrawal Cancellation Request </div>
            <div class="section-body">
                <!-- <div class="form-section"> -->
                <div class="form-section-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">Cancellation Remarks <span class="required">*</span></th>
                            <td>
                                <form method="POST" action="{{ route('withdrawal.cancel.request') }}" enctype="multipart/form-data"id="cancelRequestForm"> @csrf
                                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                                    <textarea name="cancel_remarks" class="form-control" rows="3" id="cancel_remarks"></textarea>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-warning"> Request Cancellation </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>

<script nonce="{{ $cspNonce }}">
    (() => {

        const form = document.getElementById('cancelRequestForm');

        if (!form) return;

        let submitting = false;

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            if (submitting) return;

            const remarks = document.querySelector('[name="cancel_remarks"]');
            const value = remarks.value.trim();

            if (value.length < 10) {
                alert('Please enter a valid cancellation reason (minimum 10 characters).');
                remarks.focus();
                return;
            }

            if (!confirm('Are you sure you want to submit the Withdrawal Cancellation Request?')) {
                return;
            }

            submitting = true;
            form.submit();

        });

    })();
</script>
@endsection