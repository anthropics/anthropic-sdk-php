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

    /** @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content */
    #[Api(
        type: new UnionOf(
            [
                BetaWebSearchToolResultError::class,
                new ListOf(BetaWebSearchResultBlock::class),
            ],
        ),
    )]
    public array|BetaWebSearchToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type = 'web_search_tool_result';

    /**
     * You must use named parameters to construct this object.
     *
     * @param BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     */
    final public function __construct(
        array|BetaWebSearchToolResultError $content,
        string $toolUseID,
        string $type = 'web_search_tool_result',
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;
        $this->type = $type;
    }
}

BetaWebSearchToolResultBlock::_loadMetadata();
