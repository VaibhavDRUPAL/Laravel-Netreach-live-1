<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="mb-0">Calendar</h3>

                            <div id='calendar'></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                
                // create/update attendance data
                dateClick: function(info) {
                    const hours = parseInt(prompt("Enter hours:"));

                    // hours should be a number between 0 and 12
                    if (isNaN(hours) || hours < 0 || hours > 12) {
                        return;
                    }
                    const data = {
                        date: info.dateStr,
                        _token: "<?php echo csrf_token(); ?>",
                        hours
                    }
                    console.log(data);
                    $.ajax({
                        url: "/attendance",
                        type: 'POST',
                        data,
                        success: function(res) {
                            calendar.refetchEvents();
                        }
                    });
                },
                // event source
                events: function(info, successCallback, failureCallback){
                    const data = {
                        startDate: info.startStr,
                        endDate: info.endStr
                    }
                    $.ajax({
                        url: "/attendance",
                        type: 'GET',
                        data,
                        success: function(attendances) {
                            console.log(attendances);
                            const eventsData = attendances.map((attendance)=>{
                                return { 
                                    title: `Hours logged: ${attendance.hours}`,
                                    start: attendance.date,
                                }
                            })
                            successCallback(eventsData);
                        },
                        fail: function(err){
                            failureCallback(err);
                        }
                    });
                }
            });
            calendar.render();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/calendar.blade.php ENDPATH**/ ?>