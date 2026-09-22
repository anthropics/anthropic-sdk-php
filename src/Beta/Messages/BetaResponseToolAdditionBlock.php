<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaResponseToolAdditionBlock\Tool;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An entry of a `compaction` block's `tool_changes`: a tool the
 * compacted range made available, as a reference to a `tools` entry or
 * MCP toolset, or as the tool definition in effect at the end of the
 * range, by value. Send it back unchanged.
 *
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Messages\BetaResponseToolAdditionBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaResponseToolAdditionBlock\Tool
 *
 * @phpstan-type BetaResponseToolAdditionBlockShape = array{
 *   tool: ToolShape, type: 'tool_addition'
 * }
 */
final class BetaResponseToolAdditionBlock implements BaseModel
{
    /** @use SdkModel<BetaResponseToolAdditionBlockShape> */
    use SdkModel;

    /** @var 'tool_addition' $type */
    #[Required(type: new ConstantOf('tool_addition'))]
    public string $type = 'tool_addition';

    /**
     * The tool made available: a reference to a `tools` entry or MCP toolset, or a `tool_definition` carrying the definition by value.
     *
     * @var ToolVariants $tool
     */
    #[Required(union: Tool::class)]
    public BetaResponseToolChangeToolReference|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference|BetaToolChangeToolDefinition $tool;

    /**
     * `new BetaResponseToolAdditionBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaResponseToolAdditionBlock::with(tool: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaResponseToolAdditionBlock)->withTool(...)
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
     * @param ToolShape $tool
     */
    public static function with(
        BetaResponseToolChangeToolReference|array|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference|BetaToolChangeToolDefinition $tool,
    ): self {
        $self = new self;

        $self['tool'] = $tool;

        return $self;
    }

    /**
     * The tool made available: a reference to a `tools` entry or MCP toolset, or a `tool_definition` carrying the definition by value.
     *
     * @param ToolShape $tool
     */
    public function withTool(
        BetaResponseToolChangeToolReference|array|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference|BetaToolChangeToolDefinition $tool,
    ): self {
        $self = clone $this;
        $self['tool'] = $tool;

        return $self;
    }

    /**
     * @param 'tool_addition' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
