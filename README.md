# InfluxDB Laravel

This package is a Laravel wrapper for the [influxdb-php](https://packagist.org/packages/influxdb/influxdb-php) client. We utilise [graham-campbell/manager](https://packagist.org/packages/graham-campbell/manager) to provide multiple connection interfaces.

## Installation

This package requires PHP 7.1 - 7.3, and supports Laravel 5.6 - 6.

1. To install the latest version of the package, run the following command in your terminal:

    ```bash
    composer require ge-tracker/influxdb-laravel
    ```

    Laravel will auto-discover the package's service provider, located at `GeTracker\InfluxDBLaravel\InfluxDBLaravelServiceProvider`.

2. Next, you should publish the application's configuration file

    ```bash
    php artisan vendor:publish
    ```

## Configuration

This package's configuration, after publishing, will be located at `config/influxdb.php`.

##### Default Connection Name

This option (`'default'`) is where you may specify which  of the connections below you wish to use as your default connection for  all work. Of course, you may use many connections at once using the  manager class. The default value for this setting is `'main'`.

##### InfluxDB Connections

This option (`'connections'`) is where each of the  connections are setup for your application. An example configuration has  been included, but you may add as many connections as you would like.

## Usage

The main `InfluxDBManager` class 

```php
<?php

namespace App;

use GeTracker\InfluxDBLaravel\InfluxDBManager;

class Foo
{
    /** @var InfluxDBManager */
    protected $influxDB;

    public function __construct(InfluxDBManager $influxDB)
    {
        $this->influxDB = $influxDB;
    }

    public function bar()
    {
        return $this->influxDB->getQueryBuilder()
            ->select('usage, idle')
            ->from('cpu')
            ->where([
                'time < now() -1d',
                "host='host01'",
            ])
            ->getResultSet();
    }
}
```

