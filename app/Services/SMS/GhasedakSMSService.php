<?php

namespace App\Services\SMS;

use Illuminate\Support\Facades\Http;

class GhasedakSMSService implements SMSServiceInterface
{
	public function sendSMS(string $phoneNumber, string $message): bool
	{
		$apiKey = config('services.sms.ghasedak.api_key');

		$response = Http::get("https://api.ghasedak.me/v2/sms/send/simple/url", [
			'receptor' => $phoneNumber,
			'message' => $message,
			'apikey' => $apiKey,
			'linenumber' => '300002525', // Test line number of ghasedak
		]);

		return $response->successful();
	}
}
