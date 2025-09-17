<?php

namespace App\Http\Controllers;

use App\Services\GoogleAnalyticsService;
use Carbon\Carbon;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;

class AnalyticsController extends Controller
{
    protected $analytics;

    public function __construct(GoogleAnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    public function index($total)
    {
        $propertyId = env('GOOGLE_ANALYTICS_PROPERTY_ID');

        try {
            // Initialize Google Analytics client
            $analyticsDataClient = new BetaAnalyticsDataClient([
                'credentials' => base_path(env('FIREBASE_CREDENTIALS')),
            ]);

            // Prepare parameters for the report request
            $requestParams = [
                'property' => 'properties/' . $propertyId,
                'dateRanges' => [
                    new DateRange(['start_date' => '2015-08-14', 'end_date' => Carbon::now()->format('Y-m-d')]),
                ],
                'metrics' => [
                    new Metric(['name' => 'screenPageViews']),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'pagePath']),
                ],
            ];

            // Run the report
            $response = $analyticsDataClient->runReport($requestParams);

            // Extract data into a structured array
            $pageViewsByURL = [];
            foreach ($response->getRows() as $row) {
                $dimensions = $row->getDimensionValues();
                $metrics = $row->getMetricValues();

                $url = $dimensions[0]->getValue();
                $pageViews = (int) $metrics[0]->getValue(); // Convert to integer

                $pageViewsByURL[$url] = $pageViews;
            }

            // Define the URLs you're interested in
            $urlsOfInterest = [
                '/contact-us',
                '/sra',
                '/self-risk-assessment',
                "/our-team"
            ];

            // Initialize counts
            $counts = [
                'total' => $total,
                'contactUs' => 0,
                'sra' => 0,
                'selfRiskAssessment' => 0,
                'ourTeam' => 0
            ];

            // Aggregate counts
            foreach ($pageViewsByURL as $url => $views) {
                if (in_array($url, $urlsOfInterest)) {
                    if ($url === '/contact-us') {
                        $counts['contactUs'] += $views;
                    } elseif ($url === '/sra') {
                        $counts['sra'] += $views;
                    } elseif ($url === '/self-risk-assessment') {
                        $counts['selfRiskAssessment'] += $views;
                    } elseif ($url === '/our-team') {
                        $counts['ourTeam'] += $views;
                    }
                }
            }
        } catch (\Google\ApiCore\ApiException $e) {
            // Handle Google Analytics API exceptions

            // Set counts to zero if an error occurs
            $counts = [
                'total' => 0,
                'contactUs' => 0,
                'sra' => 0,
                'selfRiskAssessment' => 0,
                'ourTeam' => 0
            ];
        } catch (\Exception $e) {
            // Handle general exceptions

            // Set counts to zero if an error occurs
            $counts = [
                'total' => 0,
                'contactUs' => 0,
                'sra' => 0,
                'selfRiskAssessment' => 0,
                'ourTeam' => 0
            ];
        }

        // Return the data in JSON format
        return view('analytics.page_views', compact('counts'));
    }
}