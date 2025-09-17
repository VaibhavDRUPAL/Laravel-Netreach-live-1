<div class="col-12 col-sm-4 mx-auto">
    <div class="d-flex">
        <div class="img">
            <img src="<?php echo e($imageUrl); ?>" style="height: 100px; widht:100px" />
        </div>
        <div class="mx-2"></div>
        <div class="content">
            <strong><?php echo e($name); ?></strong>
            <p><?php echo e($region); ?></p>
            <strong> <a href="tel:<?php echo e($phone); ?>"><?php echo e($phone); ?></a> </strong>
            <div class="main-content d-flex mt-2">
                <div class="column">
                    <a href="<?php echo e($whatsappUrl); ?>">
                        <img src="<?php echo e(asset('assets/img/web/whatsappbk.png')); ?>">
                    </a>
                </div>
                <div style="width: 10px"></div>
                <div class="column">
                    <a href="<?php echo e($instagramUrl); ?>">
                        <img src="<?php echo e(asset('assets/img/web/instabk.png')); ?>">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr />
</div>
<?php /**PATH /var/www/netreach2/resources/views/components/contact-card.blade.php ENDPATH**/ ?>