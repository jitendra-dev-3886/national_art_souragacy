<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>Dear Clinic Representative,</p>

    <p>This is to inform you that a request has been initiated to change the clinic access.</p>

    <p>If this request is valid and approved by your clinic, please click the verification link below to confirm the update and proceed with authentication.</p>

    <p><a href="{{ $accesschangeverify['link'] }}" style="font-weight:bold;">Verify Clinic Email & Access Update</a></p> <br>

    <p>If you did not request this change, please ignore this email and contact support immediately.</p>

    <p>Thank you,<br>
    <strong>National ART & Surrogacy Team</strong></p>

    {{-- <p>After setting the password, you may submit your application to National ART & Surrogacy Secretariat for obtaining NOC for
    transfer of Gametes (sperms Oocyte)/Embryos (Within and Outside India) through online portal.</p>		 --}}
    
    {{-- <p>Note: Kindly copy and paste the link in the brower,if above link is not functioning.</p>
    
    <p> With best regards</p> 
    <p> National ART & Surrogacy Registry Secretariat</p> --}}
    
</body>
</html>
