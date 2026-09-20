<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaResponseToolRemovalBlock\Tool;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An entry of a `compaction` block's `tool_changes`: a tool of the
 * request's `tools` (or an MCP tool or toolset) that the compacted range
 * withdrew. Send it back unchanged.
 *
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Messages\BetaResponseToolRemovalBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaResponseToolRemovalBlock\Tool
 *
 * @phpstan-type BetaResponseToolRemovalBlockShape = array{
 *   tool: ToolShape, type: 'tool_removal'
 * }
 */
final class BetaResponseToolRemovalBlock implements BaseModel
{
    /** @use SdkModel<BetaResponseToolRemovalBlockShape> */
    use SdkModel;

    /** @var 'tool_removal' $type */
    #[Required(type: new ConstantOf('tool_removal'))]
    public string $type = 'tool_removal';

    /**
     * A reference to the withdrawn `tools` entry, MCP tool or MCP toolset.
     *
     * @var ToolVariants $tool
     */
    #[Required(union: Tool::class)]
    public BetaResponseToolChangeToolReference|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference $tool;

    /**
     * `new BetaResponseToolRemovalBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaResponseToolRemovalBlock::with(tool: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaResponseToolRemovalBlock)->withTool(...)
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
        BetaResponseToolChangeToolReference|array|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference $tool,
    ): self {
        $self = new self;

        $self['tool'] = $tool;

        return $self;
    }

    /**
     * A reference to the withdrawn `tools` entry, MCP tool or MCP toolset.
     *
     * @param ToolShape $tool
     */
    public function withTool(
        BetaResponseToolChangeToolReference|array|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference $tool,
    ): self {
        $self = clone $this;
        $self['tool'] = $tool;

        return $self;
    }

    /**
     * @param 'tool_removal' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
