<?php $__env->startSection('content'); ?>
<?php
$token = "page_fourth";
$keys = Crypt::encryptString($token);

$hivinfectionArr = array();
if (Session::has('hivinfection')) {
    $hivinfectionArr = Session::get('hivinfection');
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
        border-radius: 3px;
        border-width: 2px;
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

</style>
<section class="landing-sec-1 landing5-sec-1">
    <img src="<?php echo e(asset('assets/img/web/bg_blank.png')); ?>" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">

                <div class="col-md-1">
                </div>
                <div class="col-md-5 mb-5">
                    <?php echo e(Form::open(array('url' => '/letsgo_six'))); ?>


                    <h4 class="font5" style=""> Help Us Get To Know You Better </h4>
                    <h5 class="mt-4" style="color:black"><b>There are some circumstances that increase the risk of HIV. </b> <small>(Tick all that are applicable)</small></h5>
                    <h5>In the last six (6) months</h5>

                    <div class="space-20"></div>


                    <div class="row">
                        <div class="col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend1" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" onclick="uncheck_chbox_other()" id="gend1" name="hivinfection[]" value="1" <?php echo e(in_array("1",$hivinfectionArr) ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>Had sex without a condom </b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class=" col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend2" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" onclick="uncheck_chbox_other()" id="gend2" name="hivinfection[]" value="2" <?php echo e(in_array("2",$hivinfectionArr) ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>Had sex with more than one partner</b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend3" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" onclick="uncheck_chbox_other()" id="gend3" name="hivinfection[]" value="3" <?php echo e(in_array("3",$hivinfectionArr) ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>Had hi-fun sex</b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend4" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" onclick="uncheck_chbox_other()" id="gend4" name="hivinfection[]" value="4" <?php echo e(in_array("4",$hivinfectionArr) ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>shared needles for injecting Drugs</b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend5" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" onclick="uncheck_chbox_other()" id="gend5" name="hivinfection[]" value="5" <?php echo e(in_array("5",$hivinfectionArr) ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>You have a Sexually transmitted Infection </b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend6" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" onclick="uncheck_chbox_other()" id="gend6" name="hivinfection[]" value="6" <?php echo e(in_array("6",$hivinfectionArr) ? 'checked' : ''); ?>>

                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>Had sex in exchange for gifts or money</b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div class="card border-0 mb-2">
                                <label for="gend7" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="checkbox" id="gend7" onclick="uncheck_chbox()" name="hivinfection[]" value="8" <?php echo e(in_array("8",$hivinfectionArr) ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline;">&nbsp;&nbsp;<b>None of the above</b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>


                    <p><span id="infection_err"></span>
                    <p>


                    <div class="row mt-4">
                        <div class="col-6 col-md-5 text-left">
                            <a href="/letsgo/<?php echo e($keys); ?>" class="btn_back">
                                <img src="<?php echo e(asset('assets/img/web/left_arrow.png')); ?>" style="width:100px">
                            </a>
                        </div>

                        <div class="col-6 col-md-5 text-right">
                            <input type="submit" id="submit" class="btn_next" name="" value="">
                        </div>
                    </div>

                    <?php echo e(Form::close()); ?>

                </div>

                <div class="col-md-6 text-center">
                    <img src="<?php echo e(asset('assets/img/web/fift_right.png')); ?>" style="width:80%;">

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
        $(document).prop('title','Risk of HIV|NETREACH');
        $('#submit').click(function() {
            //alert("ff");
            var mesg = {};
            if (hiv.validate(mesg)) {
                return true;
            }
            return false;
        });
    });

    function uncheck_chbox() {
        document.getElementById("gend1").checked = false;
        document.getElementById("gend2").checked = false;
        document.getElementById("gend3").checked = false;
        document.getElementById("gend4").checked = false;
        document.getElementById("gend5").checked = false;
        document.getElementById("gend6").checked = false;
    }

    function uncheck_chbox_other() {
        document.getElementById("gend7").checked = false;
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/page_five.blade.php ENDPATH**/ ?>