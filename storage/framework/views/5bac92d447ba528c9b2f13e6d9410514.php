<!DOCTYPE html>
<html>
<head>
    <title>Change Addrees Request </title>
</head>
<body>
    <p>Dear <?php echo e($clinic_name); ?>,</p>

    <?php if($status == 'Approved'): ?>
    <p>We are pleased to inform you that the Change Addrees application submitted by your clinic has been approved.</p>
    <?php else: ?>
    <p>We regret to inform you that the Change Addrees application submitted by your clinic has not been approved.</p>    
    <?php endif; ?>
    
    <p>Application Details:</p>

    <ul>
        <li>Application Number: <?php echo e($applicationNo); ?></li>

        <?php if($status == 'Approved'): ?>
        <li>Registration No.: <?php echo e($reg_rej_no); ?></li>
        <li>Date of Change Addrees: <?php echo e($reg_rej_date); ?></li>
        <?php else: ?>
        <li>Rejection No.: <?php echo e($reg_rej_no); ?></li>
        <li>Rejection Date: <?php echo e($reg_rej_date); ?></li>
        
        <?php endif; ?>
    </ul>
    <?php if($status == 'Approved'): ?>
    <p>Your Change Addrees certificate can be accessed through the portal or collected as per the applicable process.</p>
    <p>If you have any questions, please contact us at <?php echo e($state_email); ?> </p>
    
    <?php else: ?>
    <p>You may review the application details and resubmit the application, if permitted.</p>
    <p>For further clarification or assistance, please contact us at <?php echo e($state_email); ?></p>
    
    <?php endif; ?>
    
    <p>Regards,</p>

    <p><strong>National ART & Surrogacy</strong></p>
    <p><?php echo e($state_name); ?></p>
</body>
</html>



<?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/mailer/change_address_approve_reject.blade.php ENDPATH**/ ?>