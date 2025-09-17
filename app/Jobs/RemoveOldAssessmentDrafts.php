<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Models\SelfModule\RiskAssessmentDraft;
use App\Models\SelfModule\RiskAssessmentDraftItems;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Common\AisensyService;

class RemoveOldAssessmentDrafts implements ShouldQueue, ShouldBeUnique
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

                // Below Time in Seconds = 30 mins
                if ($diff > 1800) {
                    $del_for_mobile_no = $draft['mobile_no'];
                    $del = RiskAssessmentDraft::deleteRecord(['mobile_no' => $del_for_mobile_no]);
                    if ($del) {
                        // Log::channel('cronForDraftDeletion')->info("Draft with time-diff (of " . $cur->diffInMinutes($upd) . " mins) was deleted successfully for " . $draft['mobile_no'] . " at " . now());
                    }
                } else {
                    // Draft is valid - do nothing
                    // Log::channel('cronForDraftDeletion')->error("FAILED: to delete Draft with time-diff (of " . $cur->diffInMinutes($upd) . " mins) for " . $draft['mobile_no'] . " at " . now());
                }
            }

            // Log::info('Rec Details: ' . $txt);
        }

        RemoveOldAssessmentDrafts::dispatch();
    }
}
