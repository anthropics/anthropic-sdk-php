<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class WebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlockParam>|WebSearchToolRequestError $content */
    #[Api(union: WebSearchToolResultBlockParamContent::class)]
    public array|WebSearchToolRequestError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<WebSearchResultBlockParam>|WebSearchToolRequestError $content
     */
    final public function __construct(
        array|WebSearchToolRequestError $content,
        string $toolUseID,
        ?CacheControlEphemeral $cacheControl = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->content = $content;
        $this->toolUseID = $toolUseID;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
