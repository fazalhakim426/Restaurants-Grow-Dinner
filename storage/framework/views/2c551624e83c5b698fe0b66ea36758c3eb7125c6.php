
<?php $__env->startSection('title'); ?>
   <?php echo e(__('page-titles.register')); ?> | <?php echo e(config('app.name', 'Skote')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div>
    <div class="account-pages my-5 pt-5">
      <div class="container">
        <register submit-url="<?php echo e(route('register')); ?>" reg-error="<?php echo e($errors->first()); ?>">
            <?php echo csrf_field(); ?>
        </register>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\htdocs\Skote_vue_3.3.0\Laravel-vuejs\Starterkit\resources\views/auth/register.blade.php ENDPATH**/ ?>