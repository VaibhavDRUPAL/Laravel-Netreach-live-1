<?php

namespace App\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AisensyService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = config('aisensy.api_url');
        $this->apiKey = config('aisensy.api_key');
    }

    public function sendMessage($messageData)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://rcmapi.instaalerts.zone/services/rcm/sendMessage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30, // Set a reasonable timeout
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($messageData),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authentication: Bearer ssBVvBA0CQCEJNFjiLjjCg==',
            ),
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            Log::info('WtsUp_API_Error', [$error]);
            return "cURL Error: $error"; // Return or log the error message
        } else {
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode >= 200 && $httpCode < 300) {
                Log::info('...WtsUp_API_Response :-', [$response]);
                return $response; // Return response if successful
            } else {

                Log::info('...WtsUp_API_Response :-', [$httpCode]);
                // Log::info('...WtsUp_API_Response :-', $httpCode);
                return "HTTP Error: $httpCode"; // Return or log HTTP status code
            }
        }
    }
}
