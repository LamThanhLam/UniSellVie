<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Product; // Import Product Model
use App\Policies\ProductPolicy; // Import ProductPolicy

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Register Policy here
        \App\Models\Product::class => \App\Policies\ProductPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Add this line so that Laravel can initiate essential gates
        // without it, Laravel will not know how to create gate.
        $this->registerPolicies();
    }
}