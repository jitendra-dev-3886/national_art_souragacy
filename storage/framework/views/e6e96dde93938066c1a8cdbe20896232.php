<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Error'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo e(asset('css/tailwind.min.css')); ?>" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-2xl shadow-xl max-w-md w-full text-center">
        <h1 class="text-6xl font-extrabold text-red-500"><?php echo $__env->yieldContent('code', 'Error'); ?></h1>

        <p class="mt-4 text-2xl font-semibold text-gray-800">
            <?php echo $__env->yieldContent('message', 'Something went wrong.'); ?>
        </p>

        
        <?php echo $__env->yieldContent('error_ref'); ?>

        <p class="text-sm text-gray-500 mt-2">
            Please try again or contact support if the issue persists.
        </p>

        <a href="<?php echo e(url('/')); ?>" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            ← Back to Home
        </a>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/errors/fancy.blade.php ENDPATH**/ ?>