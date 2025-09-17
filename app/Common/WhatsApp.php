<?php

namespace App\Common;

use App\Common\APICaller;
use Illuminate\Support\Facades\Config;

class WhatsApp
{
    protected $parameters = [];

    /**
     * Send OTP
     * 
     * @param string $otp
     * @param string $mobile
     * 
     * @return array
     */
    public function sendOTP(string $otp, string $mobile): array
    {
        $this->parameters = [
            'message' => [
                'channel' => 'WABA',
                'content' => [
                    'preview_url' => false,
                    'type' => 'MEDIA_TEMPLATE',
                    'shorten_url' => true,
                    'mediaTemplate' => [
                        'templateId' => 'login_otp_code',
                        'bodyParameterValues' => (object) [
                            "0" => $otp
                        ],
                        'buttons' => [
                            'actions' => [
                                [
                                    'type' => 'Url',
                                    'index' => 0,
                                    'payload' => $otp
                                ]
                            ]
                        ]
                    ]
                ],
                'preferences' => [
                    'webHookDNId' => '1001'
                ],
                'recipient' => [
                    'to' => '91' . $mobile,
                    'recipient_type' => 'individual'
                ],
                'sender' => [
                    'name' => 'Humsafar_netrch',
                    'from' => Config::get('services.whatsapp.from')
                ]
            ],
            'metaData' => [
                'version' => 'v1.0.9'
            ]
        ];

        $data = $this->send();
        return $data;
    }

    /**
     * Appointment Booked
     * 
     * @param string $to
     * @param string $fullname
     * @param string $uid
     * @param string $center
     * @param string $date
     * @param string $services
     * @param string $vnname
     * @param string $vnmobile
     * @param string $pdf
     * @param string $filename
     * 
     * @return array
     */
    public function appointmentBooked(string $to, string $fullname, string $uid, string $center, string $date, string $services, string $vnname, string $vnmobile, string $pdf, string $filename): array
    {
        $this->parameters = [
            'message' => [
                'channel' => 'WABA',
                'content' => [
                    'preview_url' => false,
                    'type' => 'MEDIA_TEMPLATE',
                    'mediaTemplate' => [
                        'templateId' => 'referralslip01',
                        'bodyParameterValues' => (object) [
                            '0' => $fullname,
                            '1' => $uid,
                            '2' => $center,
                            '3' => $date,
                            '4' => $services,
                            '5' => $vnname,
                            '6' => $vnmobile
                        ],
                        'buttons' => [
                            'actions' => []
                        ],
                        'media' => [
                            'type' => 'document',
                            'url' => $pdf,
                            'fileName' => $filename
                        ],
                    ],
                ],
                'recipient' => [
                    'to' => '91' . $to,
                    'recipient_type' => 'individual',
                ],
                'sender' => [
                    'name' => 'Humsafar_netrch',
                    'from' => Config::get('services.whatsapp.from')
                ],
                'preferences' => [
                    'webHookDNId' => '1001',
                ],
            ],
            'metaData' => [
                'version' => 'v1.0.9',
            ],
        ];

        $data = $this->send();

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
    protected function send(): array
    {
        $data = APICaller::callAPI(Config::get('services.whatsapp.url'), POST, [
            'Content-Type' => 'application/json',
            'Authentication' => 'Bearer ' . Config::get('services.whatsapp.key')
        ], $this->parameters);

        $data = $data->json();

        return $data;
    }
    // if questionnaire is not completed
    /**
     * Send OTP
     * 
     * @param string $mobile
     * 
     * @return array
     */
    public function user_notification(string $mobile): array
    {
        $this->parameters = [
            'message' => [
                'channel' => 'WABA',
                'content' => [
                    'preview_url' => false,
                    'type' => 'TEMPLATE',
                    'template' => [
                        'templateId' => 'user_engagement',
                        'parameterValues' => (object) [
                            "0" => "https://netreach.co.in/our-team . Complete the questionnaire by clicking following link: https://netreach.co.in/self-risk-assessment "
                        ]
                    ],
                    'shorten_url' => true
                ],
                'recipient' => [
                    'to' => '91' . $mobile,
                    'recipient_type' => 'individual'
                ],
                'sender' => [
                    'name' => 'Humsafar_netrch',
                    'from' => Config::get('services.whatsapp.from')
                ],
                'preferences' => [
                    'webHookDNId' => '1001'
                ]
            ],
            'metaData' => [
                'version' => 'v1.0.9'
            ]
        ];

        $data = $this->send();

        return $data;
    }

    // ----------------if appointment is not booked
    /**
     * Send OTP
     * 
     * @param string $mobile
     * 
     * @return array
     */
    public function user_notification_bookAppointment(string $mobile): array
    {
        $this->parameters = [
            'message' => [
                'channel' => 'WABA',
                'content' => [
                    'preview_url' => false,
                    'type' => 'TEMPLATE',
                    'template' => [
                        'templateId' => 'not_booked_appointment',
                        'parameterValues' => (object) [
                            "0" => "https://netreach.co.in/our-team .",
                            "1" => " https://netreach.co.in/self-risk-assessment ."
                        ]
                    ],
                    'shorten_url' => true
                ],
                'recipient' => [
                    'to' => '91' . $mobile,
                    'recipient_type' => 'individual'
                ],
                'sender' => [
                    'name' => 'Humsafar_netrch',
                    'from' => Config::get('services.whatsapp.from')
                ],
                'preferences' => [
                    'webHookDNId' => '1001'
                ]
            ],
            'metaData' => [
                'version' => 'v1.0.9'
            ]
        ];

        $data = $this->send();
        \Log::info(["data" => $data]);
        return $data;
    }
    /**
     * Send talk to counsellor msg
     * 
     * @param string $name
     * @param string $mobile
     * 
     * @return array
     */
    public function sendTalkToCounsellorMsg(string $name, string $mobile): array
    {
        \Log::info(["mob" => $mobile, "name" => $name]);
        $this->parameters = [
            'message' => [
                'channel' => 'WABA',
                'content' => [
                    'preview_url' => false,
                    'type' => 'TEMPLATE',
                    'template' => [
                        'templateId' => 'meet_counsellor',
                        'parameterValues' => (object) [
                            "0" => $name
                        ]
                    ],
                    'shorten_url' => true
                ],
                'recipient' => [
                    'to' => '91' . $mobile,
                    'recipient_type' => 'individual'
                ],
                'sender' => [
                    'name' => 'Humsafar_netrch',
                    'from' => Config::get('services.whatsapp.from')
                ],
                'preferences' => [
                    'webHookDNId' => '1001'
                ]
            ],
            'metaData' => [
                'version' => 'v1.0.9'
            ]
        ];

        $data = $this->send();
        \Log::info(["data" => $data]);
        return $data;
    }
}
