<?php $__env->startComponent('mail::message'); ?>
<h1>We have received your request to reset your account password</h1>
<p>You can use the following code to recover your account:</p>

<?php $__env->startComponent('mail::panel'); ?>
<?php echo e($code); ?>

<?php echo $__env->renderComponent(); ?>

<p>The allowed duration of the code is one hour from the time the message was sent</p>
@endcompopnent<?php /**PATH D:\htdocs\Skote_vue_3.3.0\Laravel-vuejs\Starterkit\resources\views/emails/send-code-reset-password.blade.php ENDPATH**/ ?>