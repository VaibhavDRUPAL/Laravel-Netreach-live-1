<?php

namespace App\Jobs;

use App\Models\SelfModule\RiskAssessmentDraft;
use App\Models\SelfModule\RiskAssessmentDraftItems;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Common\AisensyService;

class SendAssessmentReminder implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $drafts = RiskAssessmentDraft::all();
        if (count($drafts) > 0) {
            foreach ($drafts as $draft) {
                // Check if the last updated time is more than 10 mins and no prior notification is sent
                $cur = Carbon::parse(now());
                $upd = Carbon::parse($draft['updated_at']);
                $diff = $cur->diffInSeconds($upd);

                // Below Time in Seconds = 10 mins
                if ($diff > 600) {
                    if (!$draft['reminder_sent']) {
                        $message = "Reminder: Please submit your questionnaire form within the next 10 minutes.";
                        // Whatsapp message sending here
                        $messageData = [
                            'message' => [
                                'channel' => 'WABA',
                                'content' => [
                                    'preview_url' => false,
                                    'type' => 'TEMPLATE',
                                    'template' => [
                                        'templateId' => 'otp',
                                        'parameterValues' => (object)[
                                            "0" => $message
                                        ]
                                    ],
                                    'shorten_url' => true
                                ],
                                'recipient' => [
                                    'to' => '91' . $draft['mobile_no'],
                                    'recipient_type' => 'individual',
                                    'reference' => [
                                        'cust_ref' => '',
                                        'messageTag1' => '',
                                        'conversationId' => ''
                                    ]
                                ],
                                'sender' => [
                                    'name' => 'Humsafar_netrch',
                                    'from' => env('AISENSY_FROM_NO')
                                ],
                                'preferences' => [
                                    'webHookDNId' => '1001'
                                ]
                            ],
                            'metaData' => [
                                'version' => 'v1.0.9'
                            ]
                        ];

                        // Log::info(json_encode($messageData));

                        $aisensyService = new AisensyService();
                        $response = $aisensyService->sendMessage($messageData);
                        $responseArray = json_decode($response, true);
                        // Log::info($responseArray);
                        if (isset($responseArray['statusCode']) && $responseArray['statusCode'] == 200) {
                            // Log::channel('cronForReminder')->info("Whatsapp msg sent to " . $draft['mobile_no'] . " at " . now());
                            $draft = RiskAssessmentDraft::editReminder(
                                [
                                    'reminder_sent' => 1,
                                    'reminder_sent_at' => now()
                                ],
                                [
                                    'mobile_no' => $draft['mobile_no']
                                ]
                            );
                            if ($draft) {
                                // Log::channel('cronForReminder')->info("Reminder sent status update for " . $draft['mobile_no'] . " at " . now());
                            } else {
                                // Log::channel('cronForReminder')->error("FAILED: Reminder sent status update for " . $draft['mobile_no'] . " at " . now());
                            }
                        } else {
                            // Log::channel('cronForReminder')->error("FAILED: To send Whatsapp msg " . $draft['mobile_no'] . " at " . now());
                        }
                    } else {
                        // Reminder is already sent
                        // Possible position to delete records if last modified time is more that 30 mins
                    }
                } else {
                    // Draft is valid - do nothing
                }
            }
        }

        SendAssessmentReminder::dispatch();
    }
}
