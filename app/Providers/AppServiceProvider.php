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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
