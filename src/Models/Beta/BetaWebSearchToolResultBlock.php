<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaWebSearchToolResultBlock implements BaseModel
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
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * @param BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     * @param string                                                      $toolUseID
     * @param string                                                      $type
     */
    final public function __construct($content, $toolUseID, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaWebSearchToolResultBlock::_loadMetadata();
