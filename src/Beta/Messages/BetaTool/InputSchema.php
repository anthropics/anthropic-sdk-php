<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTool;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
 *
 * This defines the shape of the `input` that your tool accepts and that the model will produce.
 *
 * @phpstan-type input_schema_alias = array{
 *   type: string, properties?: mixed, required?: list<string>|null
 * }
 */
final class InputSchema implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'object';

    #[Api(optional: true)]
    public mixed $properties;

    /** @var null|list<string> $required */
    #[Api(type: new ListOf('string'), nullable: true, optional: true)]
    public ?array $required;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|list<string> $required
     */
    public static function with(
        mixed $properties = null,
        ?array $required = null
    ): self {
        $obj = new self;

        null !== $properties && $obj->properties = $properties;
        null !== $required && $obj->required = $required;

        return $obj;
    }

    public function withProperties(mixed $properties): self
    {
        $obj = clone $this;
        $obj->properties = $properties;

        return $obj;
    }

    /**
     * @param null|list<string> $required
     */
    public function withRequired(?array $required): self
    {
        $obj = clone $this;
        $obj->required = $required;

        return $obj;
    }
}
