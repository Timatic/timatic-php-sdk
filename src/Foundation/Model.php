<?php

declare(strict_types=1);

namespace Timatic\SDK\Foundation;

use Illuminate\Support\Str;
use ReflectionClass;
use Timatic\SDK\Attributes\Property;

abstract class Model implements ModelInterface
{
    use HasAttributes;

    #[Property(isReadOnly: true)]
    public string $id;

    protected null|string $type = null;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function fill(array $attributes): void
    {
        $propertyNames = $this->propertyNames();

        foreach ($attributes as $key => $value) {
            if (in_array($key, $propertyNames)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array<int, string>
     */
    private function propertyNames(): array
    {
        $reflectionClass = new ReflectionClass($this);
        $properties = $reflectionClass->getProperties();
        $propertyNames = [];

        foreach ($properties as $property) {
            $attributes = $property->getAttributes(Property::class);
            if (count($attributes) > 0) {
                $propertyNames[] = $property->getName();
            }
        }

        return $propertyNames;
    }

    public function type(): string
    {
        return $this->type ?? Str::of(
            (new ReflectionClass($this))->getShortName()
        )->camel()->plural()->toString();
    }
}
