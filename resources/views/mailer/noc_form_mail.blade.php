<!DOCTYPE html>
<html>
<head>
    <title>Application Submission Confirmation</title>
</head>
<body>
    <p>Dear {{ $details['name_applicant'] }},</p>

    <p>You have successfully submitted your application from  for transfer of Embryos/Gametes/sperms/Oocyte (Within/Outside India).</p>
    
    {{-- <p>You have successfully submitted your application form for the transfer of Gametes (Sperms/Oocyte) or Embryos ({{ $details['transfer_type'] }}).</p> --}}
    <p>Your application form number is: <strong>{{ $details['application_no'] }}</strong>.</p>
    <p>Thank you for your submission.</p>

    {{-- <p> With best regards</p> 
    <p> National ART & Surrogacy Registry Secretariat</p> --}}
</body>
</html>