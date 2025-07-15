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
    public mixed $content;

    #[Api]
    public string $role;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string|list<
     *   TextBlockParam|ImageBlockParam|DocumentBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam
     * > $content `required`
     * @param string $role `required`
     */
    final public function __construct($content, $role)
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageParam::_loadMetadata();
