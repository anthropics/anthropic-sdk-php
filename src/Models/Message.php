<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Model\UnionMember0;

final class Message implements BaseModel
{
    use Model;

    #[Api]
    public string $role = 'assistant';

    #[Api]
    public string $type = 'message';

    #[Api]
    public string $id;

    /**
     * @var list<
     *   TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock
     * > $content
     */
    #[Api(type: new ListOf(union: ContentBlock::class))]
    public array $content;

    /** @var string|UnionMember0::* $model */
    #[Api]
    public string $model;

    /** @var StopReason::* $stopReason */
    #[Api('stop_reason')]
    public string $stopReason;

    #[Api('stop_sequence')]
    public ?string $stopSequence;

    #[Api]
    public Usage $usage;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock
     * > $content
     * @param string|UnionMember0::* $model
     * @param StopReason::*          $stopReason
     */
    final public function __construct(
        string $id,
        array $content,
        string $model,
        string $stopReason,
        ?string $stopSequence,
        Usage $usage,
    ) {
        self::introspect();

        $this->id = $id;
        $this->content = $content;
        $this->model = $model;
        $this->stopReason = $stopReason;
        $this->stopSequence = $stopSequence;
        $this->usage = $usage;
    }
}
