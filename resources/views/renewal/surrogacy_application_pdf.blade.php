<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
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

        .section-title {
            font-size: 18px;
            color: green;
            margin: 10px 0;
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

        th[colspan="4"] {
            font-weight: bold;
        }

        /* Add page-break for PDF */
        @page {
            margin: 20px;
        }

        .page-break {
            page-break-after: always;
        }

        td {
            word-wrap: break-word;
            white-space: normal;
        }

        .csp-clinic-text-black {
            color: black;
        }

        th.csp-clinic-table-header {
            /* background-color: #d3d8fd; */
            text-align: center;
        }

        .sign-clinic-text-black {
            color: black;
            text-align: right;
        }

        .top-margin {
            margin-top: 50px;
        }
    </style>

</head>

<body>
    <!-- Main Heading -->
    <div class="main-heading">Application form for Surrogacy Clinic</div>
    <div class="application-number">
        <h4 class="card-title csp-clinic-text-black ">
            <strong>Application Number:</strong> {{ $application->applicationno }}
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <tbody>
                    <!-- ART Clinic Details -->
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Surrogacy Clinic Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name of the Clinic</th>
                        <td colspan="7">{{ $application->clinicname }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Address</th>
                        <td colspan="7">{{ $application->address }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">State</th>
                        <td colspan="3">{{ $application->state }}</td>
                        <th colspan="2">District</th>
                        <td colspan="3">{{ $application->district }}</td>

                    </tr>
                    <tr>
                        <th colspan="2">Pincode</th>
                        <td colspan="3">{{ $application->pincode }}</td>
                        <th colspan="2">Contact Number</th>
                        <td colspan="3">{{ $application->contactno }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Fax</th>
                        <td colspan="3">{{ $application->fax ?? '-' }}</td>
                        <th colspan="2">Nature</th>
                        <td colspan="3">{{ $application->nature }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Email ID</th>
                        <td colspan="3">{{ $application->email }}</td>
                        <th colspan="2">Website</th>
                        <td colspan="3">{{ $application->website ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Date of Establishment</th>
                        <td colspan="3">
                            {{ $application->dateestab ? date('d-m-Y', strtotime($application->dateestab)) : '' }}</td>
                        <th colspan="2">Current Registration Date</th>
                        <td colspan="3">
                            {{ $application->current_registration_date ? date('d-m-Y', strtotime($application->current_registration_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th colspan="6">Whether your ART Clinic is registered under MTP Act</th>
                        <td colspan="4">{{ $application->mtpact }}</td>
                    </tr>
                    <tr>
                        <th colspan="6">Whether your ART Clinic is registered under PCPNDT Act</th>
                        <td colspan="4">{{ $application->pcpndtact }}</td>
                    </tr>

                    <!-- Contact Person Details -->
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Contact Person Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name of the Contact Person</th>
                        <td colspan="3">{{ $application->contact_person_name }}</td>
                        <th colspan="2">Mobile Number</th>
                        <td colspan="2">{{ $application->contact_person_mobile }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Email ID</th>
                        <td colspan="7">{{ $application->contact_person_email }}</td>
                    </tr>

                    <!-- Application Details -->
                    <tr>
                        <th colspan="4">Director Available</th>
                        <td colspan="6">{{ $application->director }}</td>
                    </tr>

                    <!-- Directors -->
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    @if (trim($application->director) === 'Yes')
                        <tr>
                            <th colspan="10" class="csp-clinic-table-header">Details of the Director Available at your
                                Surrogacy Clinic</th>
                        </tr>
                        <tr>
                            <th colspan="6">Whether your ART Clinic has Director</th>
                            <td colspan="4">{{ $application->director }}</td>
                        </tr>
                        <tr>
                            <th colspan="3">Name</th>
                            <th colspan="3">Qualification</th>
                            <th colspan="4">Registration No.</th>
                        </tr>
                        @foreach ($directors as $director)
                            <tr>
                                <td colspan="3">{{ $director->name_director }}</td>
                                <td colspan="3">{{ $director->quali_director }}</td>
                                <td colspan="4">{{ $director->reg_director ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <!-- Staff -->
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Details of the Staff Available at your
                            Surrogacy Clinic</th>
                    </tr>
                    <tr>
                        <th colspan="3">Post</th>
                        <th colspan="3">Name</th>
                        <th colspan="2">Qualification</th>
                        <th colspan="2">Registration No.</th>
                    </tr>
                    @foreach ($staff as $staffs)
                        <tr>
                            <td colspan="3">{{ $staffs->post }}</td>
                            <td colspan="3">{{ $staffs->name }}</td>
                            <td colspan="2">{{ $staffs->qualification }}</td>
                            <td colspan="2">{{ $staffs->regno ?? '-' }}</td>
                        </tr>
                    @endforeach
                    <!-- Equipment -->
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Equipment Details</th>
                    </tr>
                    @foreach ($equipment as $equipments)
                        <tr>
                            <td colspan="10">{{ $equipments->equipmentname }}</td>
                        </tr>
                    @endforeach
                    <!-- Procedures -->
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Procedures Undertaken</th>
                    </tr>
                    <tr>
                        <th colspan="9">Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                        <td colspan="1">{{ $application->iuih }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                        <td colspan="1">{{ $application->iuid }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                        <td colspan="1">{{ $application->ivfet }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                        <td colspan="1">{{ $application->icsi }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">Pre-implantation Genetic Testing (PGT)</th>
                        <td colspan="1">{{ $application->pgt }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or
                            embryos of patient</th>
                        <td colspan="1">{{ $application->spermandoocyte }}</td>
                    </tr>
                    <tr>
                        <th colspan="9">Any Other Procedure</th>
                        <td colspan="1">{{ $application->anyotherprocedure }}</td>
                    </tr>
                    @if (trim($application->anyotherprocedure) === 'Yes')
                        <tr>
                            <th colspan="3">If yes, please specify</th>
                            <td colspan="7">{{ $application->otherprocedure }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3">Any Other Details</th>
                        <td colspan="7">{{ $application->otherdetails }}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        <p>Submission Date:{{ date('d-m-Y',strtotime($application->application_datetime_submission)) }}</p>
        @if($application->is_resubmission == 1)
                <div class="border application-number1">
                   {{ $renewal_fee }}
                </div>
            @endif
        <div class="application-number top-margin">
            <h4 class="card-title sign-clinic-text-black ">
                <strong>Name & Signature (with seal) of the Surrogacy Clinic Authority</strong>
            </h4>
        </div>
        <div class="application-number1">
            <span><small>{!! $note !!} 
                </small>
            </span>
            
            
        </div>
    </div>
</body>

</html>
