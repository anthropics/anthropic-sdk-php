<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Mid-conversation directive to surface a declared tool.
 *
 * ``tool`` references a tool (or MCP toolset) by name from the request's
 * ``tools``; it is offered to the model from this point in the
 * conversation onward.
 *
 * @phpstan-import-type ToolVariants from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type BetaRequestToolAdditionBlockShape = array{
 *   tool: ToolShape,
 *   type: 'tool_addition',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 * }
 */
final class BetaRequestToolAdditionBlock implements BaseModel
{
    /** @use SdkModel<BetaRequestToolAdditionBlockShape> */
    use SdkModel;

    /** @var 'tool_addition' $type */
    #[Required]
    public string $type = 'tool_addition';

    /**
     * Reference to a single tool the caller declared directly in
     * ``tools[]``. Does not accept the composed ``{server}_{name}`` form the
     * server assigns to MCP-resolved tools — use ``mcp_tool_reference`` or
     * ``mcp_toolset_reference`` for those.
     *
     * @var ToolVariants $tool
     */
    #[Required(union: Tool::class)]
    public BetaToolChangeToolReference|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference $tool;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaRequestToolAdditionBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRequestToolAdditionBlock::with(tool: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRequestToolAdditionBlock)->withTool(...)
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference $tool,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['tool'] = $tool;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Reference to a single tool the caller declared directly in
     * ``tools[]``. Does not accept the composed ``{server}_{name}`` form the
     * server assigns to MCP-resolved tools — use ``mcp_tool_reference`` or
     * ``mcp_toolset_reference`` for those.
     *
     * @param ToolShape $tool
     */
    public function withTool(
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference $tool,
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

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
