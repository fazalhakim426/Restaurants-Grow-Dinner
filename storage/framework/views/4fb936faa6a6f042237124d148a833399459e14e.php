<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <?php
    $css_file = "css/app.css";
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(url('favicon.ico')); ?>">
    <title>
        <?php echo $__env->yieldContent('title', config('app.name', 'Skote')); ?>
    </title>
    <meta content="Skote is a fully featured premium Vuejs admin dashboard template built on top of awesome Bootstrap 5" name="description" />
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <link href="<?php echo e(asset($css_file)); ?>" rel="stylesheet" id="layout-css">

</head>

<body>
    <noscript>
        <strong>We're sorry but skote doesn't work properly without JavaScript enabled. Please enable it to
            continue.</strong>
    </noscript>
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!-- built files will be auto injected -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH /home/krupali/laravelvue/skote-Admin/resources/views/layouts/app.blade.php ENDPATH**/ ?>