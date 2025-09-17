<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <h1>Analytics Dashboard</h1>

        <!-- Cards for aggregated page views -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <h3 class="card-title">Total Site Visits </h3>
                                <h2 class="card-text"><?php echo e(number_format($counts['total'])); ?></h2>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/our-team">Counsellers Page Visits</h4>
                        <h2 class="card-text"><?php echo e(number_format($counts['ourTeam'])); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/contact-us">VN/Counsellers Contact Page Visits</h4>
                        <h2 class="card-text"><?php echo e(number_format($counts['contactUs'])); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/sra">General Links</h4>
                        <h2 class="card-text"><?php echo e(number_format($counts['sra'])); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" data-toggle="tooltip" title="https://netreach.co.in/en/self-risk-assessment">Self Risk Assessment Page Views</h4>
                        <h2 class="card-text"><?php echo e(number_format($counts['selfRiskAssessment'])); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/analytics/page_views.blade.php ENDPATH**/ ?>