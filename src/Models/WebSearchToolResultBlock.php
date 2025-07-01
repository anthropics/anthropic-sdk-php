<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class WebSearchToolResultBlock implements BaseModel
{
    use Model;

    /**
     * @var list<WebSearchResultBlock>|WebSearchToolResultError $content
     */
    #[Api(
        type: new UnionOf(
            [WebSearchToolResultError::class, new ListOf(WebSearchResultBlock::class)]
        ),
    )]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * @param list<WebSearchResultBlock>|WebSearchToolResultError $content
     */
    final public function __construct(
        mixed $content,
        string $toolUseID,
        string $type
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

WebSearchToolResultBlock::_loadMetadata();
