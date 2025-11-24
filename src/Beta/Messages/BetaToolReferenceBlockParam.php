<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Tool reference block that can be included in tool_result content.
 *
 * @phpstan-type BetaToolReferenceBlockParamShape = array{
 *   tool_name: string,
 *   type: "tool_reference",
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaToolReferenceBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolReferenceBlockParamShape> */
    use SdkModel;

    /** @var "tool_reference" $type */
    #[Api]
    public string $type = 'tool_reference';

    #[Api]
    public string $tool_name;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaToolReferenceBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolReferenceBlockParam::with(tool_name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolReferenceBlockParam)->withToolName(...)
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
    public static function with(
        string $tool_name,
        ?BetaCacheControlEphemeral $cache_control = null
    ): self {
        $obj = new self;

        $obj->tool_name = $tool_name;

        null !== $cache_control && $obj->cache_control = $cache_control;

        return $obj;
    }

    public function withToolName(string $toolName): self
    {
        $obj = clone $this;
        $obj->tool_name = $toolName;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }
}
