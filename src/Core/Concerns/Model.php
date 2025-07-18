<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\CoerceState;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\ModelOf;
use Anthropic\Core\Util;

trait Model
{
    private static ModelOf $converter;

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
        if (!array_key_exists($key, array: self::$converter->properties)) {
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

        if (array_key_exists($offset, array: self::$converter->properties)) {
            if (isset($this->{$offset})) {
                return true;
            }

            $property = self::$converter->properties[$offset]->property ?? new \ReflectionProperty($this, property: $offset);

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

        $type = array_key_exists($offset, array: self::$converter->properties)
            ? self::$converter->properties[$offset]->type
            : 'mixed';

        $coerced = Conversion::coerce($type, value: $value, state: new CoerceState(translateNames: false));

        if (property_exists($this, property: $offset)) {
            try {
                $this->{$offset} = $coerced;
                unset($this->_data[$offset]);

                return;
            } catch (\TypeError) { // @phpstan-ignore-line
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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        // @phpstan-ignore-next-line
        return Conversion::dump(self::converter(), value: $this->__serialize());
    }

    public static function from(mixed $data): self
    {
        self::introspect();

        /** @var self $instance */
        $instance = self::$converter->class->newInstanceWithoutConstructor();
        $instance->__unserialize($data); // @phpstan-ignore-line

        return $instance;
    }

    public static function converter(): Converter
    {
        if (isset(self::$converter)) {
            return self::$converter;
        }

        $class = new \ReflectionClass(static::class);

        return self::$converter = new ModelOf($class);
    }

    public static function introspect(): void
    {
        static::converter();
    }

    private function unsetOptionalProperties(): void
    {
        foreach (self::$converter->properties as $name => $info) {
            if ($info->optional) {
                unset($this->{$name});
            }
        }
    }

    private static function serialize(mixed $value): mixed
    {
        if ($value instanceof BaseModel) {
            return $value->toArray();
        }

        if (is_array($value)) {
            return array_map(static fn ($v) => self::serialize($v), array: $value);
        }

        return $value;
    }
}
