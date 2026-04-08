<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsCustomTool\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A custom tool as returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsCustomToolInputSchemaShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema
 *
 * @phpstan-type BetaManagedAgentsCustomToolShape = array{
 *   description: string,
 *   inputSchema: BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape,
 *   name: string,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsCustomTool implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCustomToolShape> */
    use SdkModel;

    #[Required]
    public string $description;

    /**
     * JSON Schema for custom tool input parameters.
     */
    #[Required('input_schema')]
    public BetaManagedAgentsCustomToolInputSchema $inputSchema;

    #[Required]
    public string $name;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsCustomTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsCustomTool::with(
     *   description: ..., inputSchema: ..., name: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsCustomTool)
     *   ->withDescription(...)
     *   ->withInputSchema(...)
     *   ->withName(...)
     *   ->withType(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape $inputSchema
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $description,
        BetaManagedAgentsCustomToolInputSchema|array $inputSchema,
        string $name,
        Type|string $type,
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['inputSchema'] = $inputSchema;
        $self['name'] = $name;
        $self['type'] = $type;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * JSON Schema for custom tool input parameters.
     *
     * @param BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape $inputSchema
     */
    public function withInputSchema(
        BetaManagedAgentsCustomToolInputSchema|array $inputSchema
    ): self {
        $self = clone $this;
        $self['inputSchema'] = $inputSchema;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
