<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type web_search_tool_result_block_param_alias = array{
 *   content: list<WebSearchResultBlockParam>|WebSearchToolRequestError,
 *   toolUseID: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral,
 * }
 */
final class WebSearchToolResultBlockParam implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlockParam>|WebSearchToolRequestError $content */
    #[Api(union: WebSearchToolResultBlockParamContent::class)]
    public array|WebSearchToolRequestError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

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
     * @param list<WebSearchResultBlockParam>|WebSearchToolRequestError $content
     */
    public static function from(
        array|WebSearchToolRequestError $content,
        string $toolUseID,
        ?CacheControlEphemeral $cacheControl = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * @param list<WebSearchResultBlockParam>|WebSearchToolRequestError $content
     */
    public function setContent(array|WebSearchToolRequestError $content): self
    {
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
    public function setCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $this->cacheControl = $cacheControl;

        return $this;
    }
}
