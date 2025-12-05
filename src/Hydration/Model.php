<?php

declare(strict_types=1);

namespace Timatic\Hydration;

use Illuminate\Support\Str;
use ReflectionClass;
use Timatic\Concerns\HasAttributes;
use Timatic\Hydration\Attributes\Property;

abstract class Model implements ModelInterface
{
    use HasAttributes;

    #[Property(isReadOnly: true)]
    public string $id;

    protected ?string $type = null;

    /**
     * Get a new factory instance for the model.
     */
    public static function factory(): mixed
    {
        $modelClass = static::class;
        $factoryClass = str_replace('\\Dto\\', '\\Factories\\', $modelClass).'Factory';

        if (class_exists($factoryClass)) {
            return $factoryClass::new();
        }

        throw new \RuntimeException("Factory [{$factoryClass}] not found for model [{$modelClass}].");
    }

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

    /**
     * Convert Model to JSON:API data object.
     * Returns the data object without the 'data' wrapper.
     *
     * @return array<string, mixed>
     */
    public function toJsonApi(): array
    {
        $data = [
            'type' => $this->type(),
        ];

        if (isset($this->id)) {
            $data['id'] = $this->id;
        }

        $data['attributes'] = $this->attributes();

        return $data;
    }
}
