<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Self_Controller\RiskAssessmentQuestionnaire;

class RiskAssessmentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('RiskAssessmentQuestionnaire', function ($app) {
            return new RiskAssessmentQuestionnaire();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
