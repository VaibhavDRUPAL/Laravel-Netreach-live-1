<?php $__env->startSection('content'); ?>
<?php
$token = "page_second";
$keys = Crypt::encryptString($token);
?>

<style>
    input[type="radio"] {
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

    input[type="radio"]:checked {
        appearance: none;
        outline: none;
        padding: 0;
        content: none;
        border: none;
    }

    input[type="radio"]:checked::before {
        position: absolute;
        color: green !important;
        content: "\00A0\2713\00A0" !important;
        border: 1px solid skyblue;
        font-weight: bolder;
        font-size: 12px;
        border-radius: 2px;
        border-width: 2px;
        width: 20px;
        height: 20px;
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
        ;
    }


    .bgcard:hover {
        background-color: #D7F3FF;
        
    }
</style>
<section class="landing-sec-1">
    <img src="<?php echo e(asset('assets/img/web/bg_blank.png')); ?>" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">
                <div class="col-lg-1"> </div>
                <div class="col-md-5">
                    <?php echo e(Form::open(array('url' => '/letsgo_third'))); ?>

                    <h4 class="font5" style=""> Help Us Get To Know You Better </h4>
                    <h5 class="mt-4"><b>You Identify As </b></h5>
                    <!-- <h1 class="heading1"> Whom do you identify  <br>
                           yourself?</h1> -->
                    <div class="row">
                        <div class="col-12 col-md-8 myBtn">
                            <div class="card border-0 mb-2">
                                <label for="gend" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="radio" id="gend" name="identify" value="1" onclick="return identify_cust(this.value);" class="required mt-2" <?php echo e((Session::get('identify')=="1") ? 'checked' : ''); ?>>
                                        <h5 class="font3 align-baseline" style="display:inline;">&nbsp; &nbsp; <b>Male </b> </h5> <br>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendf" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="radio" id="gendf" name="identify" value="2" onclick="return identify_cust(this.value);" class="required mt-2" <?php echo e((Session::get('identify')=="2") ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>Female </b> </h5> <br>

                                    </div>
                                </label>
                            </div>
                        </div>



                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendtt" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="radio" id="gendtt" name="identify" value="3" onclick="return identify_cust(this.value);" class="required mt-2" <?php echo e((Session::get('identify')=="3") ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>Transgender </b> </h5> <br>

                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendnot" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="radio" id="gendnot" name="identify" value="5" onclick="return identify_cust(this.value);" class="required mt-2" <?php echo e((Session::get('identify')=="5") ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>I prefer not to say </b> </h5> <br>

                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="card border-0 mb-2">
                                <label for="gendother" class="mb-0">
                                    <div class="card-body bgcard py-2">
                                        <input type="radio" id="gendother" name="identify" value="6" onclick="return identify_cust(this.value);" class="required mt-2" <?php echo e((Session::get('identify')=="6") ? 'checked' : ''); ?>>
                                        <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>Others <small>(tell us your preference)</small> </b> </h5>

                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>



                    <!-- <p class="checkbox"><input type="radio" name="identify" value="5" onclick="return identify_cust(this.value);" class="required mt-2" <?php echo e((Session::get('identify')=="5") ? 'checked' : ''); ?>>Wish not to say</p> -->


                    <input class="poll mb-0 w-sm-100" type="text" id="fname" name="fname" value="<?php echo e(Session::get('fname')); ?>" placeholder="Please specify"></p>

                    <p><span id="login_type_err"></span>
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

                <div class="col-md-6 text-center">
                    <img src="<?php echo e(asset('assets/img/web/third_right.png')); ?>" width="90%">
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
    $("#fname").hide();
    function identify_cust(i) {
        if (i == 6) {
            $("#fname").show();
            $("#fname").addClass("required");

        } else {
            $("#fname").hide();
            $("#fname").removeClass("required errborder");
            $(".err").remove();
        }
    }
    $(document).ready(function() {
        $(document).prop('title','Identify As|NETREACH');
        $('#submit').click(function() {
            //alert("ff");
            var mesg = {};
            if (hiv.validate(mesg)) {
                return true;
            }
            return false;
        });
    });

    function Page(page) {
        alert(page);
    }

    <?php if(Session::has('identify') && Session::get('identify') == '6'): ?>
    $("#fname").show();
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/page_third.blade.php ENDPATH**/ ?>