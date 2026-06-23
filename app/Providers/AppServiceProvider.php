<?php

namespace App\Providers;

use App\Contracts\PaymentServiceInterface;
use App\Services\MockDynamicPaymentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * PaymentServiceInterface is bound to MockDynamicPaymentService.
     * To switch to a real gateway (Midtrans, Xendit), change ONLY this binding:
     *   $this->app->bind(PaymentServiceInterface::class, MidtransPaymentService::class);
     * Zero controller changes required.
     */
    public function register(): void
    {
        $this->app->bind(
            PaymentServiceInterface::class,
            MockDynamicPaymentService::class,
        );

        $this->app->bind(
            \App\Contracts\NotificationServiceInterface::class,
            function ($app) {
                $driver = config('notification.default');
                if ($driver === 'telegram') {
                    return new \App\Services\TelegramNotificationService();
                }
                
                return new \App\Services\DummyNotificationService();
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
