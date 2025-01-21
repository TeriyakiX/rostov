<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SmsService
{
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = env('NOTISEND_API_TOKEN');
    }

    public function sendSMS($phoneNumber, $message)
    {
        $requestBody = [
            'project'    => 'mkrostov',
            'recipients' => $phoneNumber,
            'message'    => $message,
            'apikey'     => $this->apiToken,
        ];

        $response = Http::asForm()->withHeaders([
            'Accept' => 'application/json',
        ])->post('https://sms.notisend.ru/api/message/send', $requestBody);

        if ($response->successful()) {
            return true;
        } else {
            return false;
        }
    }
}
