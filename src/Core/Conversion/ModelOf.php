<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class ModelOf implements Converter
{
    /**
     * @var array<string, PropertyInfo>
     */
    public readonly array $properties;

    /**
     * @param \ReflectionClass<BaseModel> $class
     */
    public function __construct(public readonly \ReflectionClass $class)
    {
        $properties = [];

        foreach ($this->class->getProperties() as $property) {
            $attributes = [...$property->getAttributes(Required::class), ...$property->getAttributes(Optional::class)];

            if (!empty($attributes)) {
                $name = $property->getName();
                $properties[$name] = new PropertyInfo($property);
            }
        }
        $this->properties = $properties;
    }

    public function coerce(mixed $value, CoerceState $state): mixed
    {
        if ($value instanceof $this->class->name) {
            ++$state->yes;

            return $value;
        }

        if (!is_array($value) || (!empty($value) && array_is_list($value))) {
            ++$state->no;

            return $value;
        }

        ++$state->yes;

        $val = [...$value];
        $acc = [];

        foreach ($this->properties as $name => $info) {
            $srcName = $state->translateNames ? $info->apiName : $name;
            if (!array_key_exists($srcName, array: $val)) {
                if ($info->optional) {
                    ++$state->yes;
                } elseif ($info->nullable) {
                    ++$state->maybe;
                } else {
                    ++$state->no;
                }

                continue;
            }

            $item = $val[$srcName];
            unset($val[$srcName]);

            if (is_null($item) && ($info->nullable || $info->optional)) {
                if ($info->nullable) {
                    ++$state->yes;
                } elseif ($info->optional) {
                    ++$state->maybe;
                }
                $acc[$name] = null;
            } else {
                $coerced = Conversion::coerce($info->type, value: $item, state: $state);
                $acc[$name] = $coerced;
            }
        }

        foreach ($val as $name => $item) {
            $acc[$name] = $item;
        }

        return $this->from($acc); // @phpstan-ignore-line
    }

    /**
     * @param array<string, mixed> $data
     */
    public function from(array $data): BaseModel
    {
        $instance = $this->class->newInstanceWithoutConstructor();
        // @phpstan-ignore-next-line
        $instance->__unserialize($data);

        return $instance;
    }

    public function dump(mixed $value, DumpState $state): mixed
    {
        if ($value instanceof BaseModel) {
            $value = $value->toProperties();
        }

        if (is_array($value)) {
            $acc = [];

            foreach ($value as $name => $item) {
                if (array_key_exists($name, array: $this->properties)) {
                    $info = $this->properties[$name];
                    $acc[$info->apiName] = Conversion::dump($info->type, value: $item, state: $state);
                } else {
                    $acc[$name] = Conversion::dump_unknown($item, state: $state);
                }
            }

            return empty($acc) ? ((object) []) : $acc;
        }

        return Conversion::dump_unknown($value, state: $state);
    }
}
