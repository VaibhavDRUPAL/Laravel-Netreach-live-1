<?php

namespace App\Common;

use App\Common\APICaller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class IPStack
{
    protected $ip;

    // Request Parameters
    const access_key = 'access_key';

    // Response Parameters
    const ip = 'ip';
    const latitude = 'latitude';
    const longitude = 'longitude';
    const country_name = 'country_name';
    const region_code = 'region_code';
    const region_name = 'region_name';
    const city = 'city';
    const zip = 'zip';
    const connection = 'connection';
    const isp = 'isp';

    public function __construct()
    {
        $this->ip = App::environment('local') ? '110.226.178.226' : request()->ip();
    }

    /**
     * Get State
     * 
     * @return string
     */
    public function state(): string
    {
        $data = $this->callAPI();

        return $data[self::region_code];
    }
    /**
     * Get IP Details
     * 
     * @return array
     */
    public function getIPDetails(): array
    {
        $data = $this->callAPI();

        return $data;
    }
    /**
     * Call API
     * 
     * @param string $ip
     * @param string $method
     * 
     * @return array
     */
    protected function callAPI(): array
    {
        $parameters = [
            self::access_key => Config::get('services.ip-stack.key')
        ];

        $data = APICaller::callAPI(sprintf(Config::get('services.ip-stack.url'), $this->ip), GET, [], $parameters);

        $data = $data->json();

        return $data;
    }
}