<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
        }

        table,
        tr,
        td,
        th {
            border-collapse: collapse;
            font-size: 16px;
            padding: 15px;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    <?php
        use App\Models\SelfModule\Appointments;
    ?>
    <table>
        <tr>
            <td style="padding: 0;">
                <table style="padding:35px 0;">
                    <tr>
                        <td><img src="<?php echo e(asset('assets/img/web/logo.png')); ?>"></td>
                        <td style="text-align: right;"><img src="<?php echo e(asset('assets/img/web/humsafar-logo.png')); ?>"
                                style="width: 125px"></td>
                    </tr>
                </table>
                <table style="background: #146f98;color:#fff">
                    <tr>
                        <td></td>
                        <td
                            style="background: #fff;width: 165px;color: #146f98;font-size: 33px;text-transform: uppercase;text-align: center;font-weight: 600;">
                            E-Referral Slip</td>
                        <td style="width: 50px;"></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="line-height: 24px;"><strong>Client
                                Name</strong><br><?php echo e($pdfData[Appointments::full_name]); ?></td>
                        <td style="text-align: right;"><strong>Date :</strong>
                            <?php echo e($pdfData['today']); ?><br /><strong>Netreach UID
                                :</strong><?php echo e($pdfData[Appointments::uid]); ?></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <th>Service Provider Name/Address</th>
                        <th> <?php echo e($pdfData['center']); ?></th>
                    </tr>
                    <tr>
                        <td>Appointment Date</td>
                        <td><?php echo e($pdfData[Appointments::appointment_date]); ?></td>
                    </tr>
                    <tr>
                        <th colspan="2">Type of Services selected </th>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    <?php if(is_array($pdfData[Appointments::services])): ?>
                                    <?php $__currentLoopData = $pdfData[Appointments::services]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td
                                            style="padding:15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 10px;">
                                            <?php echo e(SERVICES[intval($item)]); ?>

                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <td
                                            style="padding:15px;border: 1px solid #8f8f8f;border-radius: 5px;width: 30%;margin: 10px;">
                                            <?php echo e($pdfData[Appointments::services]); ?>

                                        </td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <?php if(isset($pdfData['vnname'])): ?>
                            <td>VN Name: <?php echo e($pdfData['vnname']); ?></td>
                        <?php endif; ?>
                        <?php if(isset($pdfData['vnmobile'])): ?>
                            <td>VN Mobile: <?php echo e($pdfData['vnmobile']); ?></td>
                        <?php endif; ?>
                        
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>E-Referral Slip No: <?php echo e($pdfData[Appointments::referral_no]); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
<?php /**PATH /var/www/netreach2/resources/views/pdf/self-document.blade.php ENDPATH**/ ?>