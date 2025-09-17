<?php $__env->startSection('content'); ?>
    <style>
        .topfooter .footer-disclaimer {
            display: none;
        }

        .chcek_box_valid {
            border: 1px solid red;
        }
    </style>
    <style>
        input[type="checkbox"] {
            appearance: none;
            border: 1px solid black;
            width: 20px;
            height: 20px;
            content: none;
            outline: none;
            margin-top: 5px;
            /* border-radius: 3px; */
            border-width: 0.9px;
            box-shadow: rgba(0, 0, 0, 0.10) 0px 3px 8px;
        }

        input[type="checkbox"]:checked {
            appearance: none;
            outline: none;
            padding: 0;
            content: none;
            border: none;
        }

        input[type="checkbox"]:checked::before {
            position: absolute;
            color: green !important;
            content: "\00A0\2713\00A0" !important;
            border: 1px solid skyblue;
            font-weight: bolder;
            font-size: 13px;
            width: 20px;
            height: 20px;
            border-radius: 3px;
            border-width: 3px;
        }

        #landing-page-bg-img .left_img {
            position: relative;
            right: 16px;
            /* top: -350px; */
            background-image: url("home_bg.png");
            /* height: 300px; */

        }

        .heading1 {
            font-size: 2.5rem !important;
            /* font-size: 2.6rem !important; */
            /* color: #5772A3 !important; */
            color : #000000 !important;
        }

        #landing-page-button .checkbox_text {
            color: #000 !important;
        }
    </style>
    <section class="landing-sec-1 first-page ">
        <img src="<?php echo e(asset('assets/img/web/home_bg.png')); ?>" class="main-banner">
        <div class="banner-caption">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 text-left d-none d-sm-block " id="landing-page-bg-img">
                        <img src="<?php echo e(asset('assets/img/web/b.png')); ?>" class="left_img">
                    </div>
                    <div class="col-md-4 mb-3 ">
                        
                        <div>
                            <h1 class="heading1"><?php echo e(__('landing.title1')); ?> <br>
                                <?php echo e(__('landing.title2')); ?> 
                                <span><?php echo e(__('landing.title3')); ?></span>
                                
                            </h1>

                            <!-- button start -->
                                <div class="landing_page_btn mt-5 d-flex flex-column   justify-content-center">
                                    <button class="meetbtn w-100" id="hiv">
                                        HIV <?php echo e(__('landing.testing')); ?>

                                    </button>
                                    <button class="meetbtn w-100" id="prep">
                                        PrEP <?php echo e(__('landing.consultation')); ?>

                                    </button>
                                    <button class="meetbtn w-100" id="meet">
                                        <?php echo e(__('landing.Talk_to_a_Counsellor')); ?>

                                    </button>
                                    <div class="check_box mt-2 mt-md-0">
                                        <p class="checkbox_text " id="class_val"><input type="checkbox" id="disclaimer"
                                                name="disclaimer" value="1"><label class="align-top" for="disclaimer"
                                                style="font-size:x-small;">&nbsp;<?php echo e(__('landing.disclaimer_text1')); ?><br>&nbsp;<?php echo e(__('landing.disclaimer_text2')); ?><a
                                                    href="<?php echo e(url('index')); ?>" class="right1">&nbsp;
                                                    <?php echo e(__('landing.disclaimer_text3')); ?></a></label>
                                        </p>
                                    </div>
                                </div>

                            <!-- button end -->
                            <div id="landing-page-pointers">
                                <div class="text_area">
                                    <h4 class="title_h4"><?php echo e(__('landing.appointment_title')); ?></h4>
                                    <ul>
                                        <li><i class="fa-solid fa-circle fa-2xs" style="color: #117bdf;"></i>
                                            <?php echo e(__('landing.hiv_sti_testing')); ?></li>
                                        <li><i class="fa-solid fa-circle fa-2xs" style="color: #117bdf;"></i>
                                            <?php echo e(__('landing.govt_center')); ?></li>
                                        <li><i class="fa-solid fa-circle fa-2xs" style="color: #117bdf;"></i>
                                            <?php echo e(__('landing.private_healthcare')); ?></li>
                                    </ul>
                                    <h4 class="title_h4"> <?php echo e(__('landing.talk_to_counsellors')); ?></h4>
                                    <ul>
                                        <li><i class="fa-solid fa-circle fa-2xs" style="color: #117bdf;"></i>
                                            <?php echo e(__('landing.sexual_health_issues')); ?></li>
                                        <li><i class="fa-solid fa-circle fa-2xs" style="color: #117bdf;"></i>
                                            <?php echo e(__('landing.advise_testing_treatment')); ?></li>
                                        <li><i class="fa-solid fa-circle fa-2xs" style="color: #117bdf;"></i>
                                            <?php echo e(__('landing.mental_health_support')); ?></li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        
                        <div id="youtubeChannel" style="width: 100%"></div>
                    </div>
                </div>
                <!--banner-caption-->
    </section>
    <!--landing-sec-1-->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        // Replace 'YOUR_CHANNEL_ID' with the actual channel ID
        var channelID = 'UULFT-jihJ0zkx2OYgB2EtdqUQ';

        // Set the width and height for the embedded player
        var width = '100%';
        var height = 400;

        // Create the YouTube embedded player URL
        var youtubeURL = 'https://www.youtube.com/embed/?listType=playlist&list=' + channelID;

        // Create the <iframe> element
        var iframe = document.createElement('iframe');
        iframe.width = width;
        iframe.height = height;
        iframe.src = youtubeURL;
        iframe.frameborder = 0;
        iframe.allow = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
        iframe.allowfullscreen = true;

        // Append the <iframe> to the <div>
        document.getElementById('youtubeChannel').appendChild(iframe);
    </script>


    <script>
        $(document).ready(function() {

            $("#hiv").click(function(e) {
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
                            buttonUse: "hiv"
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
                            buttonUse: "prep"
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

            $("#meet").click(function(e) {
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
                            buttonUse: "meet"
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/home.blade.php ENDPATH**/ ?>