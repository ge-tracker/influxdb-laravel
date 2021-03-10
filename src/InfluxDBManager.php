<?php

namespace GeTracker\InfluxDBLaravel;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * @mixin \InfluxDB2\Client
 *
 * @author James Austen <james@ge-tracker.com>
 */
class InfluxDBManager extends AbstractManager
{
    /**
     * The factory instance.
     */
    protected InfluxDBFactory $factory;

    public function __construct(Repository $config, InfluxDBFactory $factory)
    {
        parent::__construct($config);
        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return \InfluxDB2\Client
     */
    protected function createConnection(array $config): \InfluxDB2\Client
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'influxdb';
    }

    /**
     * Get the factory instance
     *
     * @return InfluxDBFactory
     */
    public function getFactory(): InfluxDBFactory
    {
        return $this->factory;
    }
}
