<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

const DEFAULT_DATE_FORMAT = 'Y-m-d';
const DEFAULT_FORMAT = 'Y-m-d H:i:s';
const FOR_FILE_NAME_FORMAT = 'YmdHis';
const MONTH_YEAR = 'F Y';
const DATE_WITH_MONTH = 'd M Y';
const STANDARD_TIME_FORMAT = 'h:i A';

const READABLE_DATETIME = DATE_WITH_MONTH . NORMAL_SPACE . STANDARD_TIME_FORMAT;

const FROM = 'from';
const TO = 'to';

// Next Date Type
const YEARLY = 'yearly';
const MONTHLY = 'monthly';
const WEEKLY = 'weekly';
const DAILY = 'daily';
const TODAY = 'today';
const YESTERDAY = 'yesterday';

if (!function_exists('currentDateTime')) {
    /**
     * Current DateTime
     * 
     * @param string $format
     * 
     * @return string
     */
    function currentDateTime(string $format = DEFAULT_FORMAT): string
    {
        return Carbon::now()->format($format);
    }
}

if (!function_exists('parseDateTime')) {
    /**
     * Parse DateTime
     * 
     * @param string|int|Carbon $value
     * @param string $format
     * 
     * @return string
     */
    function parseDateTime(string|int|Carbon $value, string $format = DEFAULT_FORMAT): string
    {
        return Carbon::parse($value)->setTimezone(Config::get('app.timezone'))->format($format);
    }
}

if (!function_exists('getFutureDate')) {
    /**
     * Get Future date
     * 
     * @param string $type
     * @param int $interval
     * @param bool $isPrevious
     * @param string $format
     * 
     * @return string
     */
    function getFutureDate(string $type, int $interval = 1, bool $isPrevious = false, string $format = DEFAULT_DATE_FORMAT): string
    {
        $type = Str::lower($type);
        $date = Carbon::now();

        if ($type == MONTHLY) $date = $isPrevious ? $date->subMonths($interval) : $date->addMonths($interval);
        else if ($type == WEEKLY) $date = $isPrevious ? $date->subWeeks($interval) : $date->addWeeks($interval);
        else if ($type == YEARLY) $date = $isPrevious ? $date->subYears($interval) : $date->addYears($interval);
        else if ($type == DAILY) $date = $isPrevious ? $date->subDays($interval) : $date->addDays($interval);

        return $date->format($format);
    }
}