<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

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
    public static function new(
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
    public function setContent(
        array|BetaWebSearchToolRequestError $content
    ): self {
        $this->content = $content;

        return $this;
    }

    public function setToolUseID(string $toolUseID): self
    {
        $this->toolUseID = $toolUseID;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
