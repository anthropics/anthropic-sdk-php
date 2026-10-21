<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A custom tool that is executed by the API client rather than the agent. When the agent calls this tool, an `agent.custom_tool_use` event is emitted and the session goes idle, waiting for the client to provide the result via a `user.custom_tool_result` event.
 *
 * @phpstan-import-type BetaManagedAgentsCustomToolInputSchemaShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema
 *
 * @phpstan-type BetaManagedAgentsCustomToolParamsShape = array{
 *   description: string,
 *   inputSchema: BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape,
 *   name: string,
 *   type: 'custom',
 * }
 */
final class BetaManagedAgentsCustomToolParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsCustomToolParamsShape> */
    use SdkModel;

    /** @var 'custom' $type */
    #[Required(type: new ConstantOf('custom'))]
    public string $type = 'custom';

    /**
     * Description of what the tool does, shown to the agent to help it decide when to use the tool.
     */
    #[Required]
    public string $description;

    /**
     * JSON Schema defining the expected input parameters for the tool.
     */
    #[Required('input_schema')]
    public BetaManagedAgentsCustomToolInputSchema $inputSchema;

    /**
     * Unique name for the tool. 1-128 characters; letters, digits, underscores, and hyphens.
     */
    #[Required]
    public string $name;

    /**
     * `new BetaManagedAgentsCustomToolParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsCustomToolParams::with(
     *   description: ..., inputSchema: ..., name: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsCustomToolParams())
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

    /**
     * Description of what the tool does, shown to the agent to help it decide when to use the tool.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * JSON Schema defining the expected input parameters for the tool.
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

    /**
     * Unique name for the tool. 1-128 characters; letters, digits, underscores, and hyphens.
     */
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
