<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Dimension;

class GoogleAnalyticsService
{
    protected $client;

    public function __construct()
    {
    //    dd(env('FIREBASE_CREDENTIALS'), base_path().'service-acc.json');

        $this->client = new BetaAnalyticsDataClient([
            'credentials' => base_path().'/service-acc.json'
            // 'credentials' => base_path(env('FIREBASE_CREDENTIALS')),
        ]);
    }

    public function getAnalyticsData($propertyId, $startDate, $endDate, $metrics, $dimensions)
    {
        // Create DateRange object
        $dateRange = new DateRange([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        // Create Metric objects
        $metricObjects = array_map(fn ($metric) => new Metric(['name' => $metric]), $metrics);

        // Create Dimension objects
        $dimensionObjects = array_map(fn ($dimension) => new Dimension(['name' => $dimension]), $dimensions);

        // Make the API request
        $response = $this->client->runReport([
            'property' => 'properties/' . $propertyId,
            'dateRanges' => [$dateRange],
            'metrics' => $metricObjects,
            'dimensions' => $dimensionObjects,
        ]);

        return $response->getRows();
    }
}