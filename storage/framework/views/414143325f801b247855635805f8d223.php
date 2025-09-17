<?php $__env->startSection('title'); ?>
    Self Risk Assessment Tool
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var base_url = "<?php echo e(URL::to('/')); ?>";
    </script>
    <style>
        .right_btn,
        .left_btn {
            width: 350px;
            padding: 10px 25px;
            background-color: #1476A1 !important;
            border-radius: 15px !important;
            margin-left: 10px;
            text-align: center;
        }

        #landing-page-button .checkbox_text {
            color: #000 !important;
        }

        .chcek_box_valid {
            border: 1px solid red;
        }
    </style>
    <div class="mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-sm-6 mx-auto my-auto" id="sra-content">
                <div>
                    <h1 style="font-size: clamp(1.5rem, 2.5vw, 2.5rem)" class="my-4">
                        <?php echo e(__('sra.test0')); ?>

                    </h1><br>
                    <h4 style="font-size: clamp(1rem, 2.5vw, 1.5rem)">
                        <?php echo e(__('sra.test2')); ?><br>
                        <?php echo e(__('sra.test4')); ?><br>
                        <?php echo e(__('sra.test7')); ?><br>
                    </h4>
                    <br />
                </div>
                <!-- button start -->
                
                <button class="btn hiv mb-2" style="background-color: #1476A1; border-radius: 10px; color: #fff;"
                    id="hiv">
                    <?php echo e(__('sra.test14')); ?>

                    <?php echo e(__('sra.test16')); ?>

                    <input type="hidden" id="key" value="<?php if (isset($key)) {
                        echo $key;
                    } ?>" />
                </button>
                <button class="btn prep mb-2" style="background-color: #1476A1; border-radius: 10px; color: #fff;"
                    id="prep">
                    <?php echo e(__('sra.test18')); ?>

                    <?php echo e(__('sra.test20')); ?>


                </button>
                
                <div class="check_box mt-2 mt-md-0">
                    <p class="checkbox_text mt-2" id="class_val"><input type="checkbox" id="disclaimer" name="disclaimer"
                            value="1">
                        <label class="align-top mt-1" for="disclaimer"
                            style="font-size:x-small; color: red;">&nbsp;<?php echo e(__('sra.test22')); ?>&nbsp;<?php echo e(__('sra.test24')); ?><a
                                href="<?php echo e(url('index')); ?>" class="right1">&nbsp;<?php echo e(__('sra.test26')); ?></a></label>
                    </p>
                </div>
            </div>

            <div class="col-12 col-sm-6 pt-3 text-end">
                <img src="<?php echo e(asset('assets/img/web/netreach-mobile.png')); ?>" class="widthing" class="img-fluid">
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $("#hiv").click(function(e) {
                const name = $("#key").val();
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                if ($("#disclaimer").prop('checked') == true) {

                    $("#class_val").removeClass("chcek_box_valid");
                    var disclaimer_val = $('input[name="disclaimer"]:checked').val();
                    var jsonData = '{"_token": ' + csrf_token + ',"disclaimer":' + disclaimer_val + '}';
                    $.ajax({
                        type: "POST",
                        url: base_url + "/lets_go_disclaimer",
                        data: {
                            disclaimer: disclaimer_val,
                            buttonUse: "hiv",
                            name
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.disclaimer == "Not_Checked") {
                                $("#class_val").addClass("chcek_box_valid");
                                //alert("Please checked Disclaimer");
                                return false;
                            } else if (data.disclaimer == "Checked") {
                                window.location.href = base_url + "/" + data.disclaimer_url;
                            } else {
                                $("#class_val").addClass("chcek_box_valid");
                                return false;
                            }
                        }
                    });
                } else {
                    $("#class_val").addClass("chcek_box_valid");
                    return false;
                }


            });
            $("#prep").click(function(e) {
                const name = $("#key").val()
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                if ($("#disclaimer").prop('checked') == true) {

                    $("#class_val").removeClass("chcek_box_valid");
                    var disclaimer_val = $('input[name="disclaimer"]:checked').val();
                    var jsonData = '{"_token": ' + csrf_token + ',"disclaimer":' + disclaimer_val + '}';
                    $.ajax({
                        type: "POST",
                        url: base_url + "/lets_go_disclaimer",
                        data: {
                            disclaimer: disclaimer_val,
                            buttonUse: "prep",
                            name
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.disclaimer == "Not_Checked") {
                                $("#class_val").addClass("chcek_box_valid");
                                return false;
                            } else if (data.disclaimer == "Checked") {
                                window.location.href = base_url + "/" + data.disclaimer_url;
                            } else {
                                $("#class_val").addClass("chcek_box_valid");
                                return false;
                            }
                        }
                    });
                } else {
                    $("#class_val").addClass("chcek_box_valid");
                    return false;
                }


            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('self.layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/index.blade.php ENDPATH**/ ?>