<?php $__env->startComponent('mail::message'); ?>
# New User Registred
<?php $__env->startComponent('mail::panel'); ?>
A new user has been registered.

<?php echo $__env->renderComponent(); ?>


* Name : <?php echo e($user->name); ?>

* Email : <?php echo e($user->email); ?>


<?php $__env->startComponent('mail::button', ['url' => route('users.show', $user->id)]); ?>
View User Details
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/netreach2/resources/views/emails/users/registered.blade.php ENDPATH**/ ?>