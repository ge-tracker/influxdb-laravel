<?php

namespace GeTracker\InfluxDBLaravel\Support;

use InfluxDB2\Point;
use ReflectionClass;

class RefPoint extends Point
{
    private ReflectionClass $reflection;
    private Point $refPoint;

    public function __construct($name, $tags = null, $fields = null, $time = null, $precision = Point::DEFAULT_WRITE_PRECISION)
    {
        parent::__construct($name, $tags, $fields, $time, $precision);

        $this->reflection = new ReflectionClass(Point::class);
    }

    /**
     * Create a RefPoint instance from an existing Point.
     *
     * Reflection is used to access private properties of the Point class.
     *
     * @param Point|array $point
     *
     * @return \GeTracker\InfluxDBLaravel\Support\RefPoint|array
     */
    public static function from(Point|array $point): self|array
    {
        if ($point instanceof Point) {
            return self::fromPoint($point);
        }

        return array_map(
            static function($p) {
                return self::fromPoint($p);
            },
            $point
        );
    }

    private static function fromPoint(Point $point): self
    {
        $reflection = new ReflectionClass(Point::class);

        $refPoint = new self(
            $reflection->getProperty('name')->getValue($point),
            $reflection->getProperty('tags')->getValue($point),
            $reflection->getProperty('fields')->getValue($point),
            $reflection->getProperty('time')->getValue($point),
            $point->getPrecision()
        );

        $refPoint->setReflection($reflection)
            ->setRefPoint($point);

        return $refPoint;
    }

    public function getMeasurement(): string
    {
        return $this->getReflectedProperty('name');
    }

    public function getTags(): ?array
    {
        return $this->getReflectedProperty('tags');
    }

    public function getFields(): ?array
    {
        return $this->getReflectedProperty('fields');
    }

    public function setRefPoint(Point $refPoint): self
    {
        $this->refPoint = $refPoint;

        return $this;
    }

    public function setReflection(ReflectionClass $reflection): self
    {
        $this->reflection = $reflection;

        return $this;
    }

    private function getReflectedProperty(string $property): mixed
    {
        return $this->reflection->getProperty($property)->getValue($this->refPoint);
    }
}

