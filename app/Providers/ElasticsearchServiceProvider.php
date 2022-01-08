<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use App\ElasticsearchEngine;
use Elasticsearch\ClientBuilder;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('elasticsearch', function () {
            return ClientBuilder::create()
            ->setHosts(['elasticsearch'])
            ->build();
        });

        resolve(EngineManager::class)->extend('elasticsearch', function () {
            return new ElasticsearchEngine(app('elasticsearch'));
        });
    }
}
