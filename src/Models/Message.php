<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class Message implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    /**
     * @var list<RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock> $content
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

    /** @var string|string $model */
    #[Api]
    public mixed $model;

    #[Api]
    public string $role;

    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    #[Api]
    public string $type;

    #[Api]
    public Usage $usage;

    /**
     * @param string                                                                                                       $id
     * @param list<RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock> $content
     * @param string|string                                                                                                $model
     * @param string                                                                                                       $role
     * @param string                                                                                                       $stopReason
     * @param null|string                                                                                                  $stopSequence
     * @param string                                                                                                       $type
     * @param Usage                                                                                                        $usage
     */
    final public function __construct(
        $id,
        $content,
        $model,
        $role,
        $stopReason,
        $stopSequence,
        $type,
        $usage
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

Message::_loadMetadata();
