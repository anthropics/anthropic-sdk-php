<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class Message implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    /**
     * @var list<
     *   TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock
     * > $content
     */
    #[Api(
        type: new ListOf(
            new UnionOf(
                [
                    TextBlock::class,
                    ThinkingBlock::class,
                    RedactedThinkingBlock::class,
                    ToolUseBlock::class,
                    ServerToolUseBlock::class,
                    WebSearchToolResultBlock::class,
                ],
            ),
        ),
    )]
    public array $content;

    #[Api]
    public string $model;

    #[Api]
    public string $role = 'assistant';

    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    #[Api]
    public string $type = 'message';

    #[Api]
    public Usage $usage;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $id `required`
     * @param list<
     *   TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock
     * > $content `required`
     * @param string      $model        `required`
     * @param string      $role         `required`
     * @param string      $stopReason   `required`
     * @param null|string $stopSequence `required`
     * @param string      $type         `required`
     * @param Usage       $usage        `required`
     */
    final public function __construct(
        $id,
        $content,
        $model,
        $stopReason,
        $stopSequence,
        $usage,
        $role = 'assistant',
        $type = 'message',
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

Message::_loadMetadata();
