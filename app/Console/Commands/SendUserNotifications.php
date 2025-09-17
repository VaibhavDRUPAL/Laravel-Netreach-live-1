<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SelfModule\RiskAssessment;
use App\Common\{SMS, WhatsApp};
use Carbon\Carbon;

class SendUserNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-user-notifications';
    protected $description = 'Send notifications to users who has SRA form incompletely filled';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */


    public function handle()
    {
        $flag = 0;
        $users = RiskAssessment::where('user_notification', 0)
            ->get();
        foreach ($users as $user) {
            $current_msg_count = $user->last_msg_sent_count;
            $last_msg_sent = $user->last_msg_sent;
            $notification_stage = $user->notification_stage;
            // if Questionnaire is incomplete
            if ($notification_stage == 0) {
                if ($current_msg_count < 2) {
                    if ($current_msg_count == 0 && Carbon::parse($last_msg_sent)->addMinutes(30)->isPast()) {
                        $this->sendNotification($user, $current_msg_count, $flag);
                    } elseif ($current_msg_count == 0 && $last_msg_sent == null) {
                        $this->sendNotification($user, $current_msg_count, $flag);
                    } elseif ($current_msg_count == 1 && Carbon::parse($last_msg_sent)->addWeek()->isPast()) {
                        $this->sendNotification($user, $current_msg_count, $flag);
                    }
                }
                // if appointment is not booked
            } else {
                $flag = 1;
                if ($current_msg_count < 2) {
                    if ($current_msg_count == 0 && Carbon::parse($last_msg_sent)->addMinutes(30)->isPast()) {
                        $this->sendNotification($user, $current_msg_count, $flag);
                    } elseif ($current_msg_count == 0 && $last_msg_sent == null) {
                        $this->sendNotification($user, $current_msg_count, $flag);
                    } elseif ($current_msg_count == 1 && Carbon::parse($last_msg_sent)->addWeek()->isPast()) {
                        $this->sendNotification($user, $current_msg_count, $flag);
                    }
                }
            }
        }
    }
    private function sendNotification($user, $current_msg_count, $flag)
    {
        try {
            if ($flag == 0) {
                (new WhatsApp)->user_notification($user->mobile_no);
            } elseif ($flag == 1) {
                (new WhatsApp)->user_notification_bookAppointment($user->mobile_no);
            }
            $user->last_msg_sent = Carbon::now();
            $user->last_msg_sent_count = $current_msg_count + 1;
            $user->save();
            // (new SMS)->sendUserNotification($user->mobile_no, $user->mobile_no);
            // (new SMS)->sendUserNotification($to,$name, $mobile);
        } catch (\Exception $e) {
            \Log::error("Failed to send notification to user: {$user->mobile_no}, Error: {$e->getMessage()}");
        }
    }
}