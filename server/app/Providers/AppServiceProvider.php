<?php

namespace App\Providers;

use App\Services\WordMeaningGeneratorService;
use App\Services\WordSuggestionService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }


    public $singletons = [
        WordSuggestionService::class => WordSuggestionService::class,
        WordMeaningGeneratorService::class => WordMeaningGeneratorService::class,
    ];
}
