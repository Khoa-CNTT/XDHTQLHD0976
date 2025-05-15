<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Role;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        \App\Models\Service::class => \App\Policies\ServicePolicy::class,
        \App\Models\Contract::class => \App\Policies\ContractPolicy::class,
        \App\Models\ContractAmendment::class => \App\Policies\ContractAmendmentPolicy::class,
     
        
    ];
    protected $listen = [
    \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\UpdateLastLoginAt::class,
    ],
];
    
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
    }
}
}
