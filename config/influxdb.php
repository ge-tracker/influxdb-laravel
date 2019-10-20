<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => env('INFLUXDB_CONNECTION', 'main'),

    /*
    |--------------------------------------------------------------------------
    | InfluxDB Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application.
    |
    */

    'connections' => [

        'main' => [
            'host'           => env('INFLUXDB_HOST'),
            'port'           => env('INFLUXDB_PORT', 8086),
            'username'       => env('INFLUXDB_USER'),
            'password'       => env('INFLUXDB_PASSWORD'),
            'database'       => env('INFLUXDB_DATABASE'),
            'ssl'            => env('INFLUXDB_SSL', false),
            'verifySSL'      => env('INFLUXDB_VERIFY_SSL', false),
            'timeout'        => env('INFLUXDB_TIMEOUT', 0),
            'connectTimeout' => env('INFLUXDB_CONNECT_TIMEOUT', 0),
        ],

    ],

];
