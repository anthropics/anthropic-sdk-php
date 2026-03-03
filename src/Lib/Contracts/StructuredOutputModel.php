<?php

declare(strict_types=1);

namespace Anthropic\Lib\Contracts;

interface StructuredOutputModel extends \JsonSerializable
{
    /**
     * Optional description for this model, included in the JSON schema.
     */
    public static function description(): ?string;

    /**
     * Converts the model to a JSON string.
     */
    public function toJson(): string;

    /**
     * Creates an instance from an array of data.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): static;
}
