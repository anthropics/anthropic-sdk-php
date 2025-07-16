<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaWebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /**
     * @var BetaWebSearchToolRequestError|list<BetaWebSearchResultBlockParam> $content
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(BetaWebSearchResultBlockParam::class),
                BetaWebSearchToolRequestError::class,
            ],
        ),
    )]
    public array|BetaWebSearchToolRequestError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   BetaWebSearchResultBlockParam
     * >|BetaWebSearchToolRequestError $content
     */
    final public function __construct(
        array|BetaWebSearchToolRequestError $content,
        string $toolUseID,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $cacheControl && $this->cacheControl = $cacheControl;
    }
}
