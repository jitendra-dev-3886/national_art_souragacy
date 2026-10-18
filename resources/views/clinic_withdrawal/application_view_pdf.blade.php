<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Withdrawal Application View</title>

    <style>
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

        .section-title {
            font-size: 18px;
            color: green;
            margin: 10px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .table-bordered th {
            background-color: #f2f2f2;
        }

        .signature-right {
            text-align: right;
            margin-top: 80px;
        }

        .top-margin {
            margin-top: 50px;
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
            border-top: 0;
        }

        @page {
            margin: 20px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <h3 class="main-heading">
        Withdrawal Request Details for
        {{ substr($application->clinic_type, 0, 3) . ' ' . ucfirst(strtolower(substr($application->clinic_type, 3))) }}
    </h3>

    <!-- SECTION 1 -->
    <div class="section-header">
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
                <td colspan="3">
                    {{ $application->address ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- SECTION 2 -->
    <div class="section-header bg-light">
        2. Withdrawal Request Details
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
                <td>
                    {{ $application->withdrawal_reason ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Description</th>
                <td>
                    {{ $application->withdrawal_description ?? '-' }}
                </td>
            </tr>

        </table>
    </div>

    <!-- SECTION 3 -->
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
                                 @php
                                    $path = str_replace('\\', '/', $doc->file_path);

                                    $relative = $path . '/' . $doc->file_name;

                                    $fullPath = $relative . '/' . $doc->file_name;
                                @endphp
                                <i class="fa fa-download"></i> &nbsp;
                                <a href="{{ $relative }}" target="_blank"> View Document</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">
                            No documents uploaded
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

    <!-- SECTION 4 -->
    <div class="section-header bg-light">
        4. Declaration
    </div>

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

        <div class="signature-right top-margin">
            <strong>
                Name & Signature (with Seal)
            </strong>
        </div>

    </div>

</body>

</html>

