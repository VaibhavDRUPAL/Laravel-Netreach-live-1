<?php

namespace App\Services;

use App\Models\FCMToken;
use App\Models\User;
use Google\Client as GoogleClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $httpClient;
    protected $googleClient;
    protected $firebaseUrl;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->googleClient = new GoogleClient();
        $this->firebaseUrl = 'https://fcm.googleapis.com/v1/projects/' . env('FIREBASE_PROJECT_ID') . '/messages:send';

        // $this->googleClient->setAuthConfig(base_path(env('FIREBASE_CREDENTIALS')));
        $this->googleClient->setAuthConfig( base_path().'/service-acc.json');
        $this->googleClient->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    public function sendNotification($title, $body, $url, $tokens)
    {
        $accessToken = $this->googleClient->fetchAccessTokenWithAssertion()['access_token'];


        foreach ($tokens as $token) {
            $message = [
                'message' => [
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => [
                        'url' => $url,
                    ],
                    'token' => $token,
                ],
            ];
            try {
                $response = $this->httpClient->post($this->firebaseUrl, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $message,
                ]);
                Log::info("RUN");
                json_decode($response->getBody(), true);
            } catch (RequestException $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
