<?php

namespace App\Providers;

use App\Adapters\WordSuggestionAdapter;
use App\Adapters\WordMeaningGeneratorAdapter;
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
        WordSuggestionAdapter::class => WordSuggestionAdapter::class,
        WordMeaningGeneratorAdapter::class => WordMeaningGeneratorAdapter::class,
    ];
}
