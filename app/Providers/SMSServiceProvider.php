<?php

namespace App\Providers;

use App\Services\SMS\GhasedakSMSService;
use App\Services\SMS\KavenegarSMSService;
use App\Services\SMS\SMSServiceInterface;
use Illuminate\Support\ServiceProvider;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SMSServiceInterface::class, function ($app) {
            $service = config('services.sms.default');

            switch ($service) {
                case 'kavenegar':
                    return new KavenegarSMSService();
                case 'ghasedak':
                    return new GhasedakSMSService();
                default:
                    throw new \Exception("Unsupported SMS service: {$service}");
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
