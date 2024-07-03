<?php

namespace App\Services\SMS;

/**
 * Interface SMSServiceInterface
 * Defines the contract for SMS service providers.
 */
interface SMSServiceInterface
{
	/**
	 * Send an SMS message to a phone number.
	 *
	 * @param string $phoneNumber
	 * @param string $message
	 * @return bool
	 */
	public function sendSMS(string $phoneNumber, string $message): bool;
}
