<?php $__env->startSection('title'); ?>
   <?php echo e(__('page-titles.login')); ?> | <?php echo e(config('app.name', 'Skote')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div>
    <div class="account-pages my-5 pt-5">
      <div class="container">
        <login submit-url="<?php echo e(route('login')); ?>" auth-error="<?php echo e($errors->first()); ?>">
            <?php echo csrf_field(); ?>
        </login>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/krupali/laravelvue/skote-Admin/resources/views/auth/login.blade.php ENDPATH**/ ?>