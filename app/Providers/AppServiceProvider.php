<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\File;
use App\Policies\FilePolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {
    Gate::policy(File::class, FilePolicy::class);
    }
}
