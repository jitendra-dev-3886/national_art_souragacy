<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>Dear Clinic Representative,</p>

    <p>This is to notify you that a request has been raised to change your registered clinic email ID.</p>

    <p>If this request has been initiated by your clinic and is valid, no action is required from your side. 
However, if you are not aware of this request or believe this change is unauthorized, click on the link below and please contact the {{ $accesschangerequest['state'] }} state authority immediately to stop or review the request.</p>
<p><a href="{{ $accesschangerequest['link'] }}" style="font-weight:bold;">Raise Objection for Access Change</a></p> <br>
<p>This notification is for your security to ensure that access to your clinic does not change without awareness.</p>

<p>Thank you,<br>
<strong>National ART & Surrogacy Team</strong></p>

    {{-- <p>After setting the password, you may submit your application to National ART & Surrogacy Secretariat for obtaining NOC for
    transfer of Gametes (sperms Oocyte)/Embryos (Within and Outside India) through online portal.</p>		 --}}
    
    {{-- <p>Note: Kindly copy and paste the link in the brower,if above link is not functioning.</p>
    
    <p> With best regards</p> 
    <p> National ART & Surrogacy Registry Secretariat</p> --}}
    
</body>
</html>
