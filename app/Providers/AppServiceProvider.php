<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domains\Payment\Services\AbstractPaymentService;
use App\Domains\Payment\Services\PaymentService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Xendit\Configuration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AbstractPaymentService::class, function () {
            return new PaymentService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Configuration::setXenditKey(config('services.xendit.api_key'));
        
        Vite::prefetch(concurrency: 3);

        Model::preventsLazyLoading();
        Model::preventsAccessingMissingAttributes();
    }
}
