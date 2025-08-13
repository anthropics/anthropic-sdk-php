<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_web_search_tool_result_block_param_alias = array{
 *   content: list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError,
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 * }
 */
final class BetaWebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /**
     * @var BetaWebSearchToolRequestError|list<BetaWebSearchResultBlockParam> $content
     */
    #[Api(union: BetaWebSearchToolResultBlockParamContent::class)]
    public array|BetaWebSearchToolRequestError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * `new BetaWebSearchToolResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebSearchToolResultBlockParam::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebSearchToolResultBlockParam)->withContent(...)->withToolUseID(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaWebSearchToolRequestError|list<BetaWebSearchResultBlockParam> $content
     */
    public static function with(
        array|BetaWebSearchToolRequestError $content,
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * @param BetaWebSearchToolRequestError|list<BetaWebSearchResultBlockParam> $content
     */
    public function withContent(
        array|BetaWebSearchToolRequestError $content
    ): self {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }
}
