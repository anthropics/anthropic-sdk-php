<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;

class BetaWebSearchToolResultBlock implements BaseModel
{
    use Model;

    /**
     * @var BetaWebSearchToolResultError|list<BetaWebSearchResultBlock> $content
     */
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
     */
    final public function __construct(
        mixed $content,
        string $toolUseID,
        string $type,
    ) {

        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);

    }
}

BetaWebSearchToolResultBlock::_loadMetadata();
