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
        // No more use of this
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // No more use of this
    }
}