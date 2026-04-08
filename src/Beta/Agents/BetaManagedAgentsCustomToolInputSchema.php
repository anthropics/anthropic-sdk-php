<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * JSON Schema for custom tool input parameters.
 *
 * @phpstan-type BetaManagedAgentsCustomToolInputSchemaShape = array{
 *   properties?: array<string,mixed>|null,
 *   required?: list<string>|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsCustomToolInputSchema implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCustomToolInputSchemaShape> */
    use SdkModel;

    /**
     * JSON Schema properties defining the tool's input parameters.
     *
     * @var array<string,mixed>|null $properties
     */
    #[Optional(map: 'mixed', nullable: true)]
    public ?array $properties;

    /**
     * List of required property names.
     *
     * @var list<string>|null $required
     */
    #[Optional(list: 'string')]
    public ?array $required;

    /**
     * Must be 'object' for tool input schemas.
     *
     * @var value-of<Type>|null $type
     */
    #[Optional(enum: Type::class)]
    public ?string $type;

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
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?array $properties = null,
        ?array $required = null,
        Type|string|null $type = null
    ): self {
        $self = new self;

        null !== $properties && $self['properties'] = $properties;
        null !== $required && $self['required'] = $required;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * JSON Schema properties defining the tool's input parameters.
     *
     * @param array<string,mixed>|null $properties
     */
    public function withProperties(?array $properties): self
    {
        $self = clone $this;
        $self['properties'] = $properties;

        return $self;
    }

    /**
     * List of required property names.
     *
     * @param list<string> $required
     */
    public function withRequired(array $required): self
    {
        $self = clone $this;
        $self['required'] = $required;

        return $self;
    }

    /**
     * Must be 'object' for tool input schemas.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
