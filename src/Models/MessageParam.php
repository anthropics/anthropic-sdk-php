<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class MessageParam implements BaseModel
{
    use Model;

    /**
     * @var list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf(
                        [
                            ServerToolUseBlockParam::class,
                            WebSearchToolResultBlockParam::class,
                            TextBlockParam::class,
                            ImageBlockParam::class,
                            ToolUseBlockParam::class,
                            ToolResultBlockParam::class,
                            DocumentBlockParam::class,
                            ThinkingBlockParam::class,
                            RedactedThinkingBlockParam::class,
                        ],
                    ),
                ),
            ],
        ),
    )]
    public mixed $content;

    #[Api]
    public string $role;

    /**
     * @param list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     */
    final public function __construct(mixed $content, string $role)
    {
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

MessageParam::_loadMetadata();
