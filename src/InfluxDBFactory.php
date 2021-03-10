<?php

namespace GeTracker\InfluxDBLaravel;

use InfluxDB2\Client;

/**
 * @author James Austen <james@ge-tracker.com>
 */
class InfluxDBFactory
{
    /**
     * @param array $config
     *
     * @return \InfluxDB2\Client
     */
    public function make(array $config): Client
    {
        return new Client([
            'url'       => $config['url'],
            'token'     => $config['token'],
            'bucket'    => $config['bucket'],
            'org'       => $config['org'],
            'verifySSL' => $config['verifySSL'],
            'precision' => $config['precision'],
        ]);
    }

//    /**
//     * @param string $precision
//     *
//     * @return string
//     */
//    private function getWritePrecision(string $precision): string
//    {
//        if (!in_array($precision, WritePrecision::getAllowableEnumValues())) {
//            // throw
//            $precision = 'ns';
//        }
//
//        return constant(WritePrecision::class . '::' . strtoupper($precision));
//    }
}
