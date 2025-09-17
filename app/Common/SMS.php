<?php

namespace App\Common;

use App\Common\APICaller;
use Illuminate\Support\Facades\{Config, Lang};

class SMS
{
    protected $parameters = [];

    public function __construct()
    {
        $this->parameters = [
            'username=' . Config::get('services.sms.username'),
            'password=' . Config::get('services.sms.password'),
            'from=' . Config::get('services.sms.from'),
            'pe_id=' . Config::get('services.sms.pe_id')
        ];
    }

    /**
     * Send OTP
     * 
     * @param string $otp
     * @param string $mobile
     * 
     * @return void
     */
    public function sendOTP(string $otp, string $mobile): void
    {
        $this->parameters[] = 'text=' . $otp . ' is the Code for NETREACH website. Validity 60 seconds only. The Humsafar Trust';
        // $this->parameters[] = 'text=' . urlencode(Lang::get('integrations.text.otp', ['otp' => $otp]));
        $this->parameters[] = 'to=' . $mobile;
        $this->parameters[] = 'template_id=' . '1707175100524738575';

        $this->send();
    }

    /**
     * Appointment Booked
     *
     * @param string $to
     * @param string $name
     * @param string $mobile
     *
     * @return void
     */
    public function appointmentBooked(string $to, string $name, string $mobile): void
    {
        $this->parameters[] = 'text=' . 'Your appointment is booked successfully. For any further assistance, please contact ' . $name . ' on mobile number ' . $mobile . '. The Humsafar Trust - NETREACH';
        // $this->parameters[] = 'text=' . urlencode(Lang::get('integrations.text.appointment_booked', ['name' => $name, 'mobile' => $mobile]));
        $this->parameters[] = 'to=' . $to;
        $this->parameters[] = 'template_id=' . '1707173469315379576';
        // $this->parameters[] = 'template_id=' . '1707168078030025497';

        $this->send();
    }
    /**
     * Send
     *
     * @param string $ip
     * @param string $method
     *
     * @return void
     */
    protected function send(): void
    {
        $url = Config::get('services.sms.url') . '?' . implode('&', $this->parameters);

        $data = APICaller::callAPI($url, GET, [
            'Content-Type' => 'application/json'
        ]);

        return;
    }
    /**
     * Send user notification
     * 
     * @param string $name
     * @param string $mobile
     * 
     * @return void
     */
    public function sendUserNotification(string $otp, string $mobile): void
    {
        $this->parameters[] = 'text=' . urlencode(Lang::get('integrations.text.otp', ['otp' => $otp]));
        $this->parameters[] = 'to=' . $mobile;
        $this->parameters[] = 'template_id=' . '1707166607845969067';

        $this->send();
    }
    public function sendTalkToCounsellorMsg(string $name, string $mobile): void
    {
        // $this->parameters[] = 'text=' . 'Dear ' . $name . ', thank you for submitting your query on NETREACH, your appointment with our counsellor has been booked, they will get in touch with you soon.';
        $this->parameters[] = 'text=' . 'Hi, Thank you for submitting your query on NETREACH, your appointment with our counsellor has been booked, they will get in touch with you soon.Humsafar Trust - NETREACH';
        $this->parameters[] = 'to=' . $mobile;
        $this->parameters[] = 'template_id=' . '1707173805263555496';

        $this->send();
    }
}

