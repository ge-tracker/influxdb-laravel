<?php

namespace GeTracker\InfluxDBLaravel;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * @mixin \InfluxDB\Database
 *
 * @author James Austen <james@ge-tracker.com>
 */
class InfluxDBManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var InfluxDBFactory
     */
    protected $factory;

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
     * @return \InfluxDB\Database
     */
    protected function createConnection(array $config)
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName()
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
