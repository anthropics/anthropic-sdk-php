<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Mid-conversation directive to make a tool available.
 *
 * ``tool`` is a reference to a tool (or MCP toolset) declared in the
 * request's ``tools``. Under the ``inline-tools-2026-09-15`` beta it may
 * instead be a reference to a tool defined earlier in ``messages``, or a
 * ``tool_definition`` object that carries an inline tool definition in
 * ``definition`` (the same object a ``tools`` entry holds). An ``mcp_toolset``
 * definition also requires the ``mcp-client-2026-09-15`` beta. The tool is
 * offered to the model from this point in the conversation onward.
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
    #[Required(type: new ConstantOf('tool_addition'))]
    public string $type = 'tool_addition';

    /** @var ToolVariants $tool */
    #[Required(union: Tool::class)]
    public BetaToolChangeToolReference|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam $tool;

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
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam $tool,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['tool'] = $tool;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param ToolShape $tool
     */
    public function withTool(
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam $tool,
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
