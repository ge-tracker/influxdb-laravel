<?php

namespace GeTracker\InfluxDBLaravel;

use InfluxDB\Client;

/**
 * @author James Austen <james@ge-tracker.com>
 */
class InfluxDBFactory
{
    /**
     * @param array $config
     *
     * @return \InfluxDB\Database
     */
    public function make(array $config)
    {
        $client = new Client(
            $config['host'],
            $config['port'],
            $config['username'],
            $config['password'],
            $config['ssl'],
            $config['verifySSL'],
            $config['timeout'],
            $config['connectTimeout']
        );

        return $client->selectDB($config['database']);
    }
}
