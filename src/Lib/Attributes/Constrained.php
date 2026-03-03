<?php

declare(strict_types=1);

namespace Anthropic\Lib\Attributes;

/**
 * Schema annotations and validation constraints for structured output properties.
 *
 * This attribute serves two purposes:
 *
 * 1. API-supported schema fields (included in the schema sent to the API):
 *    - description, format, const, itemClass, minItems (values 0 and 1)
 *
 * 2. Validation-only constraints (not supported by the API):
 *    - minimum, maximum, multipleOf, minLength, maxLength
 *    These are removed from the schema, appended to the description, and
 *    validated by the SDK when parsing responses.
 *
 * @example
 * ```php
 * #[Constrained(description: 'Age in years', minimum: 0, maximum: 150)]
 * public int $age;
 *
 * #[Required(enum: ['active', 'inactive'])]
 * #[Constrained(description: 'Current status')]
 * public string $status;
 *
 * #[Constrained(description: 'List of items', itemClass: Item::class, minItems: 1)]
 * public array $items;
 * ```
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Constrained
{
    /**
     * @param string|null $description Human-readable description of the property
     * @param string|null $format String format (email, uri, date-time, date, time, uuid, ipv4, ipv6, hostname)
     * @param mixed $const Fixed value the property must equal
     * @param class-string|null $itemClass For arrays: class of array items (schema generation and hydration)
     * @param int|null $minItems For arrays: minimum items. Values 0 and 1 are API-supported; higher values are validated by SDK.
     * @param int|null $minLength For strings: minimum length (validated by SDK, not sent to API)
     * @param int|null $maxLength For strings: maximum length (validated by SDK, not sent to API)
     * @param int|float|null $minimum For numbers: minimum value (validated by SDK, not sent to API)
     * @param int|float|null $maximum For numbers: maximum value (validated by SDK, not sent to API)
     * @param int|float|null $multipleOf For numbers: must be a multiple of this value (validated by SDK, not sent to API)
     */
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $format = null,
        public readonly mixed $const = null,
        public readonly ?string $itemClass = null,
        public readonly ?int $minItems = null,
        public readonly ?int $minLength = null,
        public readonly ?int $maxLength = null,
        public readonly int|float|null $minimum = null,
        public readonly int|float|null $maximum = null,
        public readonly int|float|null $multipleOf = null,
    ) {}
}
