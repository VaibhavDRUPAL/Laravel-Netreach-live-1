<?php
    if ($statusID == 1)  $class = 'text-info';
    else if ($statusID == 2)  $class = 'text-success';
    else if ($statusID == 3)  $class = 'text-danger';
    else $class = 'text-primary';
?>

<span class="font-weight-bold <?php echo e($class); ?>"><?php echo e($status); ?></span><?php /**PATH /var/www/netreach2/resources/views/outreach/ajax/status.blade.php ENDPATH**/ ?>