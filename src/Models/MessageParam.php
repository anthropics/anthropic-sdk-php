<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class MessageParam implements BaseModel
{
    use Model;

    /**
     * @var string|list<
     *   TextBlockParam|ImageBlockParam|DocumentBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam
     * > $content
     */
    #[Api(
        type: new UnionOf(
            [
                'string',
                new ListOf(
                    new UnionOf(
                        [
                            TextBlockParam::class,
                            ImageBlockParam::class,
                            DocumentBlockParam::class,
                            ThinkingBlockParam::class,
                            RedactedThinkingBlockParam::class,
                            ToolUseBlockParam::class,
                            ToolResultBlockParam::class,
                            ServerToolUseBlockParam::class,
                            WebSearchToolResultBlockParam::class,
                        ],
                    ),
                ),
            ],
        ),
    )]
    public array|string $content;

    #[Api]
    public string $role;

    /**
     * You must use named parameters to construct this object.
     *
     * @param string|list<
     *   TextBlockParam|ImageBlockParam|DocumentBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam
     * > $content
     */
    final public function __construct(array|string $content, string $role)
    {
        $this->content = $content;
        $this->role = $role;
    }
}

MessageParam::_loadMetadata();
