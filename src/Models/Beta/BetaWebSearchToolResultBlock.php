<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaWebSearchToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content */
    #[Api(
        union: new UnionOf(
            [
                BetaWebSearchToolResultError::class,
                new ListOf(BetaWebSearchResultBlock::class),
            ],
        ),
    )]
    public array|BetaWebSearchToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     */
    final public function __construct(
        array|BetaWebSearchToolResultError $content,
        string $toolUseID
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;

        self::_introspect();
    }
}
