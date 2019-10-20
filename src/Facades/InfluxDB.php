<?php

namespace GeTracker\InfluxDBLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author James Austen <james@ge-tracker.com>
 */
class InfluxDB extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'influxdb';
    }
}
