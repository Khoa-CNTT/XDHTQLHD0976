<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        \App\Models\Service::class => \App\Policies\ServicePolicy::class,
        \App\Models\Contract::class => \App\Policies\ContractPolicy::class,
     
        
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
        //
    }
}
