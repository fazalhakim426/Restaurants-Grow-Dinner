
<?php
    if(isset($id) && $component == "templates") {
        $component = (isset($group) ? "{$group}-{$component}-" : "").$id;
        $title = __("{$id}" );
    } else {
        $component = (isset($group) ? "{$group}-" : "").$component;
        $title = __("{$component}" );
    }
    if(strpos($title, 'page-titles.') !== false) {
        $title = "404 Page Not Found";
    }
?>
<?php $__env->startSection('title'); ?>
   <?php echo e($title); ?> | <?php echo e(config('app.name', 'Restaurants')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<dynamic-component component="<?php echo e($component); ?>" access_token="<?php echo e($access_token); ?>" id="<?php echo e($id ?? ""); ?>" />
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\htdocs\Skote_vue_3.3.0\Laravel-vuejs\Starterkit\resources\views/home.blade.php ENDPATH**/ ?>