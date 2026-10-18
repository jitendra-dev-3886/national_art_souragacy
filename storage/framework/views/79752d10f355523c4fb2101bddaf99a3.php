<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>National ART & Surrogacy Registry</title>
    <!-- Bootstrap 5 CSS -->
    <link href="<?php echo e(url('public/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(url('public/css/bootstrap5.min.css')); ?>" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link href="<?php echo e(url('public/vendor/datatables/css/jquery.dataTables.min.css')); ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(url('public/css/font-awesome.min.css')); ?>">
    <!-- jQuery -->
    <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jquery-3.6.0.min.js')); ?>"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
   
    <!-- Navbar -->
    <?php echo $__env->make('pages.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <?php echo $__env->make('pages.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Scripts -->
    <!-- jQuery -->
    
	<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/vendor/datatables/js/jquery.dataTables.min.js')); ?>"></script>
	<script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/plugins-init/datatables.init.js')); ?>"></script>
    <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/bootstrap.bundle.min.js')); ?>"></script>
    <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/bootstrap5.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/main.blade.php ENDPATH**/ ?>