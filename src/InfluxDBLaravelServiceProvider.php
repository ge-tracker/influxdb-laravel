<?php

namespace GeTracker\InfluxDBLaravel;

use Illuminate\Support\ServiceProvider;

class InfluxDBLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    private function setupConfig()
    {
        $source = __DIR__ . '/../config/influxdb.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('influxdb.php')]);
        }

        $this->mergeConfigFrom($source, 'influxdb');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register factory instance
     */
    protected function registerFactory()
    {
        $this->app->singleton('influxdb.factory', function ($app) {
            return new InfluxDBFactory();
        });

        $this->app->alias('influxdb.factory', InfluxDBFactory::class);
    }

    /**
     * Register manager instance
     */
    protected function registerManager()
    {
        $this->app->singleton('influxdb', function ($app) {
            return new InfluxDBManager(
                $app['config'],
                $app['influxdb.factory']
            );
        });

        $this->app->alias('influxdb', InfluxDBManager::class);
    }

    /**
     * Register InfluxDB application bindings
     */
    protected function registerBindings()
    {
        $this->app->singleton('influxdb.connection', function ($app) {
            /** @var InfluxDBManager $manager */
            $manager = $app['influxdb'];

            return $manager->connection();
        });

        $this->app->alias('influxdb.connection', \InfluxDB\Database::class);
    }

    public function provides()
    {
        return [
            'influxdb.factory',
            'influxdb',
            'influxdb.connection',
        ];
    }
}
