<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolSearchToolResultBlockParamShape = array{
 *   content: BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam,
 *   tool_use_id: string,
 *   type: 'tool_search_tool_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
 * }
 */
final class BetaToolSearchToolResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaToolSearchToolResultBlockParamShape> */
    use SdkModel;

    /** @var 'tool_search_tool_result' $type */
    #[Api]
    public string $type = 'tool_search_tool_result';

    #[Api]
    public BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam $content;

    #[Api]
    public string $tool_use_id;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * `new BetaToolSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolSearchToolResultBlockParam::with(content: ..., tool_use_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
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
        BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam $content,
        string $tool_use_id,
        ?BetaCacheControlEphemeral $cache_control = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->tool_use_id = $tool_use_id;

        null !== $cache_control && $obj->cache_control = $cache_control;

        return $obj;
    }

    public function withContent(
        BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam $content,
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->tool_use_id = $toolUseID;

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
