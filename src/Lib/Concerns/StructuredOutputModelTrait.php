<?php

declare(strict_types=1);

namespace Anthropic\Lib\Concerns;

use Anthropic\Lib\Attributes\Constrained;

/**
 * Trait for structured output models.
 *
 * Use this trait in a class that implements StructuredOutputModel to define
 * structured output schemas. The SDK will automatically convert your model
 * to a JSON schema for the API and parse responses back into instances.
 *
 * ## Type Inference
 *
 * Types and required/optional status are automatically inferred from PHP type hints:
 * - `string $name` -> required string
 * - `?string $name` -> optional string
 * - `int $age` -> required integer
 * - `float $price` -> required number
 * - `bool $active` -> required boolean
 * - `array $items` -> required array (use itemClass for typed arrays)
 * - `NestedModel $child` -> required nested object (auto-detected)
 *
 * ## Nested Models
 *
 * For nested objects, you have two options:
 * 1. Type hint with the model class directly: `public NestedModel $child;`
 * 2. For arrays of models, use `itemClass`: `#[Constrained(itemClass: Item::class)] public array $items;`
 *
 * **Note:** The schema generated from your class is subject to improvement between minor versions.
 * Pin your dependency if you need guaranteed schema stability.
 *
 * @example Basic usage:
 * ```php
 * use Anthropic\Lib\Attributes\Constrained;
 * use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
 * use Anthropic\Lib\Contracts\StructuredOutputModel;
 *
 * class FamousNumber implements StructuredOutputModel {
 *     use StructuredOutputModelTrait;
 *
 *     #[Constrained(description: 'The numerical value')]
 *     public float $value;
 *
 *     #[Constrained(description: 'Why this number is mathematically significant')]
 *     public ?string $reason = null;
 * }
 *
 * class Output implements StructuredOutputModel {
 *     use StructuredOutputModelTrait;
 *
 *     #[Constrained(description: 'A list of famous numbers', minItems: 1, itemClass: FamousNumber::class)]
 *     public array $numbers;
 * }
 * ```
 * @example Nested objects:
 * ```php
 * class Address implements StructuredOutputModel {
 *     use StructuredOutputModelTrait;
 *     public string $street;
 *     public string $city;
 *     public string $country;
 * }
 *
 * class Person implements StructuredOutputModel {
 *     use StructuredOutputModelTrait;
 *     public string $name;
 *     public Address $address;  // Nested object - auto-detected from type hint
 *
 *     #[Constrained(itemClass: Address::class)]
 *     public array $previousAddresses;  // Array of nested objects
 * }
 * ```
 */
trait StructuredOutputModelTrait
{
    /**
     * Optional description for this model.
     * Override this method to provide a description that will be included in the JSON schema.
     */
    public static function description(): ?string
    {
        return null;
    }

    /**
     * Converts the model instance to an array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $result = [];
        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $name = $property->getName();
            if ($property->isInitialized($this)) {
                $value = $this->{$name};

                // Recursively serialize nested models
                if ($value instanceof \Anthropic\Lib\Contracts\StructuredOutputModel) {
                    $value = $value->jsonSerialize();
                } elseif (is_array($value)) {
                    $value = array_map(
                        fn ($item) => $item instanceof \Anthropic\Lib\Contracts\StructuredOutputModel ? $item->jsonSerialize() : $item,
                        $value
                    );
                }

                $result[$name] = $value;
            }
        }

        return $result;
    }

    /**
     * Converts the model to a JSON string.
     */
    public function toJson(): string
    {
        return json_encode($this, JSON_THROW_ON_ERROR);
    }

    /**
     * Creates an instance from an array of data.
     *
     * This method handles:
     * - Basic types (string, int, float, bool)
     * - Nested objects (detected from type hints or itemClass attribute)
     * - Arrays of nested objects
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static
    {
        // Create instance using reflection to support classes without default constructors
        $reflection = new \ReflectionClass(static::class);

        /** @var static $instance */
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $name = $property->getName();
            if (!array_key_exists($name, $data)) {
                continue;
            }

            $value = $data[$name];

            // Skip null values
            if (null === $value) {
                $property->setValue($instance, null);

                continue;
            }

            // Determine the target class for hydration
            $targetClass = self::resolveTargetClass($property);

            if (null !== $targetClass && is_array($value)) {
                // Check if it's a nested object (associative array) or array of objects (sequential array)
                $propertyType = $property->getType();
                $isArray = $propertyType instanceof \ReflectionNamedType && 'array' === $propertyType->getName();

                if ($isArray) {
                    // Array of nested objects
                    $hydratedItems = [];
                    foreach ($value as $item) {
                        if (is_array($item)) {
                            /** @var array<string, mixed> $itemData */
                            $itemData = $item;
                            $hydratedItems[] = $targetClass::fromArray($itemData);
                        } else {
                            $hydratedItems[] = $item;
                        }
                    }
                    $value = $hydratedItems;
                } else {
                    // Single nested object
                    /** @var array<string, mixed> $objectData */
                    $objectData = $value;
                    $value = $targetClass::fromArray($objectData);
                }
            }

            $property->setValue($instance, $value);
        }

        return $instance;
    }

    /**
     * Resolves the target class for a property based on type hints and attributes.
     *
     * @return class-string<\Anthropic\Lib\Contracts\StructuredOutputModel>|null The target class or null if not a nested model
     */
    private static function resolveTargetClass(\ReflectionProperty $property): ?string
    {
        // First check #[Constrained] attribute for itemClass (for arrays)
        $attributes = $property->getAttributes(Constrained::class);
        if (!empty($attributes)) {
            $constraintAttr = $attributes[0]->newInstance();
            if (null !== $constraintAttr->itemClass && is_subclass_of($constraintAttr->itemClass, \Anthropic\Lib\Contracts\StructuredOutputModel::class)) {
                return $constraintAttr->itemClass;
            }
        }

        // Check PHP type hint for nested object
        $type = $property->getType();
        if ($type instanceof \ReflectionNamedType) {
            $typeName = $type->getName();
            if (class_exists($typeName) && is_subclass_of($typeName, \Anthropic\Lib\Contracts\StructuredOutputModel::class)) {
                return $typeName;
            }
        }

        return null;
    }
}
