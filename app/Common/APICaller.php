<?php

namespace App\Common;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class APICaller
{
    /**
     * Call API
     * 
     * @param string $url
     * @param string $method
     * @param array $header
     * @param array $parameters
     * @param bool $isFormData
     * 
     * @return Response
     */
    public static function callAPI(string $url, string $method, array $header = [], array $parameters = [], bool $isFormData = false): Response
    {
        $http = Http::withHeaders($header);

        if ($isFormData) $http = $http->asForm();

        if ($method == GET) $http = empty($parameters) ? $http->get($url) : $http->get($url, $parameters);

        if ($method == POST) $http = $http->post($url, $parameters);

        return $http;
    }
}