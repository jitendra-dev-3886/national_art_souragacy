<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class QueryLoggingServiceProvider extends ServiceProvider
{
   public function boot(): void
    {
     if (app()->environment('local')) {
        DB::listen(function ($query) {
            // Log all queries (optional, remove if too verbose)
            Log::info("Query Time: {$query->time} ms - {$query->sql} - Bindings: " . json_encode($query->bindings));

            // Log slow queries with route info
            if ($query->time > 300) {
                $routeName = Route::currentRouteName() ?? 'N/A';
                $routeAction = optional(Route::current())->getActionName() ?? 'N/A';

                Log::warning("Slow Query Detected on route [$routeName | $routeAction]: {$query->sql} with bindings [" . implode(',', $query->bindings) . "] took {$query->time}ms");
            }
        });
    }
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}

