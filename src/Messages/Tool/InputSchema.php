<?php

declare(strict_types=1);

namespace Anthropic\Messages\Tool;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * [JSON schema](https://json-schema.org/draft/2020-12) for this tool's input.
 *
 * This defines the shape of the `input` that your tool accepts and that the model will produce.
 *
 * @phpstan-type InputSchemaShape = array{
 *   type: 'object',
 *   properties?: array<string,mixed>|null,
 *   required?: list<string>|null,
 * }
 */
final class InputSchema implements BaseModel
{
    /** @use SdkModel<InputSchemaShape> */
    use SdkModel;

    /** @var 'object' $type */
    #[Required]
    public string $type = 'object';

    /** @var array<string,mixed>|null $properties */
    #[Optional(map: 'mixed', nullable: true)]
    public ?array $properties;

    /** @var list<string>|null $required */
    #[Optional(list: 'string', nullable: true)]
    public ?array $required;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $properties
     * @param list<string>|null $required
     */
    public static function with(
        ?array $properties = null,
        ?array $required = null
    ): self {
        $self = new self;

        null !== $properties && $self['properties'] = $properties;
        null !== $required && $self['required'] = $required;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $properties
     */
    public function withProperties(?array $properties): self
    {
        $self = clone $this;
        $self['properties'] = $properties;

        return $self;
    }

    /**
     * @param list<string>|null $required
     */
    public function withRequired(?array $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }
}
