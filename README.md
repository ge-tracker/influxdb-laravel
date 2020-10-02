# InfluxDB Laravel

This package is a Laravel wrapper for the [influxdb-php](https://packagist.org/packages/influxdb/influxdb-php) client. We utilise [graham-campbell/manager](https://packagist.org/packages/graham-campbell/manager) to provide multiple connection interfaces.

## Installation

This package requires PHP 7.1+, and supports Laravel 5.6 - 8.

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

**Default Connection Name**

This option (`'default'`) is where you may specify which  of the connections below you wish to use as your default connection for  all work. Of course, you may use many connections at once using the  manager class. The default value for this setting is `'main'`.

**InfluxDB Connections**

This option (`'connections'`) is where each of the  connections are setup for your application. An example configuration has  been included, but you may add as many connections as you would like.

## Usage

The underlying InfluxDB connection instance can be accessed via Facade or Dependency Injection. Unless specified, the package will use the `main` connection by default.

**Facade**

```php
<?php

// create an array of points
$points = array(
    new InfluxDB\Point(
        'test_metric', // name of the measurement
        null, // the measurement value
        ['host' => 'server01', 'region' => 'us-west'], // optional tags
        ['cpucount' => 10], // optional additional fields
        time() // Time precision has to be set to seconds!
    ),
    new InfluxDB\Point(
        'test_metric', // name of the measurement
        null, // the measurement value
        ['host' => 'server01', 'region' => 'us-west'], // optional tags
        ['cpucount' => 10], // optional additional fields
        time() // Time precision has to be set to seconds!
    )
);

$result = InfluxDB::writePoints($points, \InfluxDB\Database::PRECISION_SECONDS);
```

**Dependency Injection** 

DI can be used by type-hinting the `InfluxDBManager` class:

```php
<?php

namespace App;

use GeTracker\InfluxDBLaravel\InfluxDBManager;

class Foo
{
    /** @var InfluxDBManager */
    protected $influxDb;

    public function __construct(InfluxDBManager $influxDb)
    {
        $this->influxDB = $influxDB;
    }

    public function bar()
    {
        return $this->influxDb->getQueryBuilder()
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

### Connections

Both the `InfluxDBManager` and `InfluxDB` facade provide a `connection()` method, which will allow another InfluxDB connection to be interacted with:

```php
// The `main` connection will be used
$manager->query("SELECT * FROM cpu");

// The `alternative` connection will be used
$manager->connection('alternative')->query("SELECT * FROM cpu");
```

## Credits

* [GE Tracker](https://www.ge-tracker.com)
* [InfluxData](https://www.influxdata.com)
* [GrahamCampbell](https://github.com/GrahamCampbell)
