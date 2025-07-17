<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde;
use Anthropic\Core\Serde\CoerceState;
use Anthropic\Core\Serde\DumpState;
use Anthropic\Core\Serde\PropertyInfo;
use Anthropic\Core\Util;

trait Model
{
    /**
     * @var \ReflectionClass<BaseModel>
     */
    private static \ReflectionClass $_class;

    /**
     * @var array<string, PropertyInfo>
     */
    private static array $_properties = [];

    /**
     * @var list<string>
     */
    private static array $_constructorArgNames = [];

    /**
     * @var array<string, mixed> keeps track of undocumented data
     */
    private array $_data = [];

    /**
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        $rows = [...Util::get_object_vars($this), ...$this->_data]; // @phpstan-ignore-line

        return array_map(static fn ($v) => self::serialize($v), array: $rows);
    }

    /**
     * @param array<mixed> $data
     */
    public function __unserialize(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function __debugInfo(): array
    {
        return $this->__serialize();
    }

    public function __toString(): string
    {
        return json_encode($this->__debugInfo(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?: '';
    }

    /**
     * Magic get is intended to occur when we have manually unset
     * a native class property, indicating an omitted value,
     * or a property overridden with an incongruent type.
     *
     * @throws \Exception
     */
    public function __get(string $key): mixed
    {
        if (!array_key_exists($key, self::$_properties)) {
            throw new \Exception("Property '{$key}' does not exist in {$this}::class");
        }

        // The unset property was overridden by a value with an incongruent type.
        // It's forbidden for an optional value to be `null` in the payload.
        if (array_key_exists($key, $this->_data)) {
            throw new \Exception(
                "The {$key} property is overridden, use the array access ['{$key}'] syntax to the raw payload property.",
            );
        }

        // An optional property which was unset to be omitted from serialized is being accessed.
        // Return null to match user's expectations.
        return null;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->__serialize();
    }

    public function offsetExists(mixed $offset): bool
    {
        if (!is_string($offset)) { // @phpstan-ignore-line
            throw new \InvalidArgumentException();
        }

        if (array_key_exists($offset, array: $this->_data)) {
            return true;
        }

        if (property_exists($this, property: $offset)) {
            if (isset($this->{$offset})) {
                return true;
            }

            $property = self::$_properties[$offset]->property ?? new \ReflectionProperty($this, property: $offset);

            return $property->isInitialized($this);
        }

        return false;
    }

    public function &offsetGet(mixed $offset): mixed
    {
        if (!is_string($offset)) { // @phpstan-ignore-line
            throw new \InvalidArgumentException();
        }

        if (!$this->offsetExists($offset)) {
            return null;
        }

        if (array_key_exists($offset, array: $this->_data)) {
            return $this->_data[$offset];
        }

        return $this->{$offset};
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_string($offset)) { // @phpstan-ignore-line
            throw new \InvalidArgumentException();
        }

        $type = array_key_exists($offset, array: self::$_properties)
            ? self::$_properties[$offset]->type
            : 'mixed';

        $coerced = Serde::coerce($type, value: $value, state: new CoerceState(translateNames: false));

        if (property_exists($this, property: $offset)) {
            try {
                $this->{$offset} = $coerced;
                unset($this->_data[$offset]);

                return;
                // @phpstan-ignore-next-line
            } catch (\TypeError) {
                unset($this->{$offset});
            }
        }

        $this->_data[$offset] = $coerced;
    }

    public function offsetUnset(mixed $offset): void
    {
        if (!is_string($offset)) { // @phpstan-ignore-line
            throw new \InvalidArgumentException();
        }

        if (property_exists($this, property: $offset)) {
            unset($this->{$offset});
        }

        unset($this->_data[$offset]);
    }

    public static function coerce(mixed $value, CoerceState $state): mixed
    {
        if ($value instanceof self) {
            ++$state->yes;

            return $value;
        }

        if (!is_array($value) || array_is_list($value)) {
            ++$state->no;

            return $value;
        }

        ++$state->yes;

        $val = [...$value];
        $acc = [];

        foreach (self::$_properties as $name => $info) {
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
                $coerced = Serde::coerce($info->type, value: $item, state: $state);
                $acc[$name] = $coerced;
            }
        }

        foreach ($val as $name => $item) {
            $acc[$name] = $item;
        }

        // @phpstan-ignore-next-line
        return static::from($acc);
    }

    public static function dump(mixed $value, DumpState $state): mixed
    {
        if ($value instanceof self) {
            $value = $value->__serialize();
        }

        if (is_array($value)) {
            $acc = [];

            foreach ($value as $name => $item) {
                if (array_key_exists($name, array: self::$_properties)) {
                    $info = self::$_properties[$name];
                    $acc[$info->apiName] = Serde::dump($info->type, value: $item, state: $state);
                } else {
                    $acc[$name] = Serde::dump_unknown($item, state: $state);
                }
            }

            return empty($acc) ? ((object) []) : $acc;
        }

        return Serde::dump_unknown($value, state: $state);
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        // @phpstan-ignore-next-line
        return Serde::dump($this::class, value: $this->__serialize());
    }

    public static function from(mixed $data): self
    {
        self::_introspect();

        /** @var self $instance */
        $instance = self::$_class->newInstanceWithoutConstructor();
        $instance->__unserialize($data); // @phpstan-ignore-line

        return $instance;
    }

    private function unsetOptionalProperties(): void
    {
        foreach (self::$_properties as $name => $info) {
            if ($info->optional) {
                unset($this->{$name});
            }
        }
    }

    private static function _introspect(): void
    {
        if (isset(self::$_class)) {
            return;
        }

        self::$_class = new \ReflectionClass(static::class);

        foreach (self::$_class->getConstructor()?->getParameters() ?? [] as $parameter) {
            self::$_constructorArgNames[] = $parameter->getName();
        }

        foreach (self::$_class->getProperties() as $property) {
            if (!empty($property->getAttributes(Api::class))) {
                $name = $property->getName();
                self::$_properties[$name] = new PropertyInfo($property);
            }
        }
    }

    private static function serialize(mixed $value): mixed
    {
        if ($value instanceof BaseModel) {
            return $value->toArray();
        }

        if (is_array($value) || is_object($value)) {
            return array_map(static fn ($v) => self::serialize($v), array: (array) $value);
        }

        return $value;
    }
}
