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
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock
     * > $content
     */
    final public function __construct(
        string $id,
        array $content,
        string $model,
        string $stopReason,
        ?string $stopSequence,
        Usage $usage,
        string $role = 'assistant',
        string $type = 'message',
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->model = $model;
        $this->role = $role;
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
        $this->type = $type;
        $this->usage = $usage;
    }
}

Message::_loadMetadata();
