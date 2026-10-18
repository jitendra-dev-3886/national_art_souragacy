<!DOCTYPE html>
<html>
<head>
    <title>Renewal Request </title>
</head>
<body>
    {{-- <p>Dear {{ $clinic_name }},</p> --}}
    <p>Greetings from National ART & Surrogacy</p>

    @if ($status == 'Approved')
    <p>We are pleased to inform you that the renewal application submitted by your clinic has been approved.</p>
    @else
    <p>We regret to inform you that the renewal application submitted by your clinic has not been approved.</p>    
    @endif
    
    <p>Application Details:</p>

    <ul>
        <li>Application Number: {{ $applicationNo }}</li>

        @if($status == 'Approved')
        <li>Registration No.: {{ $reg_rej_no }}</li>
        <li>Date of Renewal: {{ $reg_rej_date }}</li>
        <li>Valid upto: {{ $certificate_valid_date }}</li>
        @else
        <li>Rejection No.: {{ $reg_rej_no }}</li>
        <li>Rejection Date: {{ $reg_rej_date }}</li>
        
        @endif
    </ul>
    @if($status == 'Approved')
    <p>Your renewed certificate can be accessed through the portal or collected as per the applicable process.</p>
    @else
    <p>You may review the application details and resubmit the application, if permitted.</p>
    <p>For further clarification or assistance, please contact us at {{$state_email}}</p>
    @endif
    <p>Kindly do not reply to this email. For any queries, please contact the <strong>{{ $state_name }}</strong>State Appropriate authority.</p>
   
    <br>
    <p>Regards,</p>

    <p><strong>National ART & Surrogacy</strong></p>
    <p></p>
</body>
</html>



