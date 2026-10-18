<!DOCTYPE html>
<html>
<head>
    <title>Change Addrees Request </title>
</head>
<body>
    <p>Dear {{ $clinic_name }},</p>

    @if ($status == 'Approved')
    <p>We are pleased to inform you that the Change Addrees application submitted by your clinic has been approved.</p>
    @else
    <p>We regret to inform you that the Change Addrees application submitted by your clinic has not been approved.</p>    
    @endif
    
    <p>Application Details:</p>

    <ul>
        <li>Application Number: {{ $applicationNo }}</li>

        @if($status == 'Approved')
        <li>Registration No.: {{ $reg_rej_no }}</li>
        <li>Date of Change Addrees: {{ $reg_rej_date }}</li>
        @else
        <li>Rejection No.: {{ $reg_rej_no }}</li>
        <li>Rejection Date: {{ $reg_rej_date }}</li>
        
        @endif
    </ul>
    @if($status == 'Approved')
    <p>Your Change Addrees certificate can be accessed through the portal or collected as per the applicable process.</p>
    <p>If you have any questions, please contact us at {{ $state_email }} </p>
    {{-- <p>If you have any questions, please contact us at support-artsurrogacy@gov.in .</p> --}}
    @else
    <p>You may review the application details and resubmit the application, if permitted.</p>
    <p>For further clarification or assistance, please contact us at {{$state_email}}</p>
    {{-- <p>For further clarification or assistance, please contact us at support-artsurrogacy@gov.in .</p> --}}
    @endif
    
    <p>Regards,</p>

    <p><strong>National ART & Surrogacy</strong></p>
    <p>{{ $state_name }}</p>
</body>
</html>



