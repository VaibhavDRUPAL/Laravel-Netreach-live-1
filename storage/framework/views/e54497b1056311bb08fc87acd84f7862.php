<div class="card mb-5">
    <div class="card-body">
        <div class="pl-lg-4 select-profile mb-3">
            <h6 class="heading-small text-muted mb-4">Select profile</h6>
            <div class="row">
                <div class="col-md-12 text-justify">
                    <p>
                        Please select an existing profile by searching for unique serial number/profile name, or create a new one
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 text-left">
                    <a href="<?php echo e(route('outreach.profile.create')); ?>" class="btn btn-sm btn-neutral">Create New Profile</a>
                </div>
                <div class="col-lg-6 text-right">
                    <?php echo e(Form::text('search-profile', '', ['class' => 'form-control form-control-sm', 'placeholder' => 'Search profiles', 'id'=>'search-profile'])); ?>


                </div>
            </div>
        </div>

        <div class="pl-lg-4 ml-2">
            <div class="row">
                <div class="list-group col-md-12" id="profiles-list"></div>
            </div>
            
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        const listItem = $(`<button type="button" class="list-group-item list-group-item-action"></button>`);
        jQuery(document).ready(function(){
            // hide the main form
            // $('.main-form-card').hide();


            $('#search-profile').on('input',(e)=>{
                const val = e.target.value;
                if(val.length<3) return;

                $.ajax({
                    url: "<?php echo e(route('outreach.profile.search')); ?>",
                    type: 'GET',
                    data: {
                        q: val,
                    },
                    success: function(profiles) {
                        $('#profiles-list button').remove(); // remove all options

                        $.each(profiles, function(idx, profile) {
                            const listItem = $(`<button type="button" class="list-group-item list-group-item-action" data-unique-serial-number="${profile.unique_serial_number}">
                                                    <div class="row">
                                                        <div class="col-md-4 font-weight-bold">${profile.unique_serial_number} </div>
                                                        <div class="col-md-8">${profile.profile_name}</div>
                                                    </div>       
                                                </button>`);
                            $('#profiles-list').append(listItem);
                        });

                        $("#profiles-list button").click(function(){
                            $(this).siblings('button').removeClass('active');
                            $(this).addClass('active');
                            $("input#unique_serial_number").val($(this).data('unique-serial-number')).trigger('change');;
                            
                            // show the main form now that unique serial number is selected
                            $('.main-form-card').show();

                        })
                    }
                });

                
            })
        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/netreach2/resources/views/includes/select-profile.blade.php ENDPATH**/ ?>