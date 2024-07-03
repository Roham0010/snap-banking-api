<?php

namespace App\Services\SMS;

use Illuminate\Support\Facades\Http;

class KavenegarSMSService implements SMSServiceInterface
{
	public function sendSMS(string $phoneNumber, string $message): bool
	{
		$apiKey = config('services.sms.kavenegar.api_key');

		$response = Http::get("https://api.kavenegar.com/v1/{$apiKey}/sms/send.json", [
			'receptor' => $phoneNumber,
			'message' => $message,
		]);

		return $response->successful();
	}
}
