<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
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
    public mixed $content;

    #[Api]
    public string $role;

    /**
     * @param list<DocumentBlockParam|ImageBlockParam|RedactedThinkingBlockParam|ServerToolUseBlockParam|TextBlockParam|ThinkingBlockParam|ToolResultBlockParam|ToolUseBlockParam|WebSearchToolResultBlockParam>|string $content
     * @param string                                                                                                                                                                                                    $role
     */
    final public function __construct($content, $role)
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageParam::_loadMetadata();
