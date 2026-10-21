<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A custom tool as returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsCustomToolInputSchemaShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema
 *
 * @phpstan-type BetaManagedAgentsCustomToolShape = array{
 *   description: string,
 *   inputSchema: BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape,
 *   name: string,
 *   type: 'custom',
 * }
 */
final class BetaManagedAgentsCustomTool implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCustomToolShape> */
    use SdkModel;

    /** @var 'custom' $type */
    #[Required(type: new ConstantOf('custom'))]
    public string $type = 'custom';

    #[Required]
    public string $description;

    /**
     * JSON Schema for custom tool input parameters.
     */
    #[Required('input_schema')]
    public BetaManagedAgentsCustomToolInputSchema $inputSchema;

    #[Required]
    public string $name;

    /**
     * `new BetaManagedAgentsCustomTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsCustomTool::with(description: ..., inputSchema: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsCustomTool())
     *   ->withDescription(...)
     *   ->withInputSchema(...)
     *   ->withName(...)
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
     */
    public static function with(
        string $description,
        BetaManagedAgentsCustomToolInputSchema|array $inputSchema,
        string $name,
    ): self {
        $self = new self;

        $self['description'] = $description;
        $self['inputSchema'] = $inputSchema;
        $self['name'] = $name;

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
     * @param 'custom' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
