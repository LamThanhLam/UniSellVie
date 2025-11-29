<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
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
    public function boot(GateContract $gate): void
    {
        // Add this line so that Laravel can initiate essential gates
        // without it, Laravel will not know how to generate gate.
        // Very important: Must call registerPolicies() first
        $this->registerPolicies();

        // This line help Laravel know how to generate Gate (REQUIRED)
        // This the last fix line for this BindingResolutionException error
        $gate->before(function ($user, $ability) {
            // Logic admin bypass
            if ($user->isAdmin()) {
                return true; 
            }
        });
    }
}