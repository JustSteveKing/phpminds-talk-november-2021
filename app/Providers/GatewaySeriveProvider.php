<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Fathom\Service;
use Illuminate\Support\ServiceProvider;

class GatewaySeriveProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: Service::class,
            concrete: fn() => new Service(
                uri: config('services.fathom.uri'),
                token: config('services.fathom.token'),
                timeout: config('services.fathom.timeout'),
                retryTimes: config('services.fathom.retry.times'),
                retrySleep: config('services.fathom.retry.sleep'),
            ),
        );
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
