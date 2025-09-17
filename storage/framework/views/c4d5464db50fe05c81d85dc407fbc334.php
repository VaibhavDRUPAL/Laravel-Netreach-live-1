<?php $__env->startSection('content'); ?>
<?php
$token = "page_third";
$keys = Crypt::encryptString($token);

$sexuallyArr = array();
if (Session::has('sexually')) {
    $sexuallyArr = Session::get('sexually');
}

?>
<style>
    input[type="checkbox"] {
        appearance: none;
        border: 1px solid skyblue;
        width: 20px;
        height: 20px;
        content: none;
        outline: none;
        margin: 0;
        border-radius: 2px;
        border-width: 3px;
        box-shadow: rgba(0, 0, 0, 0.10) 0px 3px 8px;
        margin-top: -5px;
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


    @media (max-width: 768px) {
        .w-sm-100 {
            width: 100% !important;
        }
    }

    .bgcard {
        background-color: #F2FBFF;
    }

    .font3 {
        font-size: 1rem;

    }


    .bgcard:hover {
        background-color: #D7F3FF;
        ;
    }
</style>

<section class="landing-sec-1">
    <img src="<?php echo e(asset('assets/img/web/bg_blank.png')); ?>" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">
                <div class="col-md-1"> </div>
                <div class="col-md-5 mb-5">
                    <?php echo e(Form::open(array('url' => '/letsgo_five'))); ?>



                    <h4 class="font5" style=""> Help Us Get To Know You Better </h4>
                    <h5 class="mt-4"><b>Who are you sexually attracted to ? </b></h5>
                    <h5><small>(Tick all that are applicable)</small></h5>

                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendm" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <p class="checkbox-page"><input id="gendm" onclick="uncheck_chbox_other()" type="checkbox" name="sexually[]" value="Male" <?php echo e(in_array("Male",$sexuallyArr) ? 'checked' : ''); ?>>&nbsp; &nbsp;
                                            <span class="font3">Male </span>
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendf" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <p class="checkbox-page"><input type="checkbox" id="gendf" onclick="uncheck_chbox_other()" name="sexually[]" value="Female" <?php echo e(in_array("Female",$sexuallyArr) ? 'checked' : ''); ?>>&nbsp; &nbsp;
                                            <span class="font3">Female </span>
                                        </p>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendt" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <p class="checkbox-page"><input id="gendt" onclick="uncheck_chbox_other()" type="checkbox" name="sexually[]" value="Transgender" <?php echo e(in_array("Transgender",$sexuallyArr) ? 'checked' : ''); ?>>&nbsp;&nbsp;
                                            <span class="font3">Transgender</span>
                                        </p>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="other" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <p class="checkbox-page"><input id="other" onclick="return identify_cust(this.value);" type="checkbox" name="sexually[]" value="Others" <?php echo e(in_array("Other",$sexuallyArr) ? 'checked' : ''); ?>>&nbsp;&nbsp;
                                            <span class="font3">Other</span>
                                        </p>

                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <input class="poll mb-0 w-sm-100" type="text" id="other_speify" name="other_speify" value="" placeholder="Please specify"></p>


                    <p><span id="sexually_err"></span>
                    <p>

                    <div class="space-30"></div>

                    <div class="row">
                        <div class="col-6 col-md-4 text-left">
                            <a href="/letsgo/<?php echo e($keys); ?>" class="btn_back">
                                <img src="<?php echo e(asset('assets/img/web/left_arrow.png')); ?>" style="width:100px">
                            </a>
                        </div>



                        <div class="col-6 col-md-4 text-right">
                            <input type="submit" id="submit" class="btn_next" name="" value="">
                        </div>
                    </div>

                    <?php echo e(Form::close()); ?>

                </div>
                <div class="col-md-6 text-center mt-2">
                    <img src="<?php echo e(asset('assets/img/web/four_right.png')); ?>" width="70%">
                </div>
            </div>
            <!--row-->

        </div>
        <!--container-->
    </div>
    <!--banner-caption-->
</section>
<!--landing-sec-1-->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $(document).prop('title','Sexually Attraction|NETREACH');

        $('#submit').click(function() {
            //alert("ff");
            var mesg = {};
            if (hiv.validate(mesg)) {
                return true;
            }
            return false;
        });
    });



    $("#other_speify").hide();

    function identify_cust(i) {
        if (i == 'Others') {
            $("#other_speify").show();
            $("#other_speify").addClass("required");

            document.getElementById("gendm").checked = false;
            document.getElementById("gendf").checked = false;
            document.getElementById("gendt").checked = false;


        } else {
            $("#other_speify").hide();
            $("#other_speify").removeClass("required errborder");
            $(".err").remove();
        }
    }






    function uncheck_chbox_other() {
        document.getElementById("other").checked = false;
        $("#other_speify").hide();
        $("#other_speify").removeClass("required errborder");
        $(".err").remove();
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/page_fourth.blade.php ENDPATH**/ ?>