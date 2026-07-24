<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Reference to a single tool the caller declared directly in
 * ``tools[]``. Does not accept the composed ``{server}_{name}`` form the
 * server assigns to MCP-resolved tools — use ``mcp_tool_reference`` or
 * ``mcp_toolset_reference`` for those.
 *
 * @phpstan-type BetaToolChangeToolReferenceShape = array{
 *   name: string, type: 'tool_reference'
 * }
 */
final class BetaToolChangeToolReference implements BaseModel
{
    /** @use SdkModel<BetaToolChangeToolReferenceShape> */
    use SdkModel;

    /** @var 'tool_reference' $type */
    #[Required]
    public string $type = 'tool_reference';

    #[Required]
    public string $name;

    /**
     * `new BetaToolChangeToolReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolChangeToolReference::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolChangeToolReference)->withName(...)
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
     */
    public static function with(string $name): self
    {
        $self = new self;

        $self['name'] = $name;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param 'tool_reference' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
