<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\None;
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
     * @var list<TextBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock|ThinkingBlock|RedactedThinkingBlock> $content
     */
    #[Api(
        type: new ListOf(
            new UnionOf(
                [
                    TextBlock::class,
                    ToolUseBlock::class,
                    ServerToolUseBlock::class,
                    WebSearchToolResultBlock::class,
                    ThinkingBlock::class,
                    RedactedThinkingBlock::class,
                ],
            ),
        ),
    )]
    public array $content;

    /**
     * @var string|string $model
     */
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
     * @param list<TextBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock|ThinkingBlock|RedactedThinkingBlock> $content
     * @param string|string                                                                                                $model
     */
    final public function __construct(
        string $id,
        array $content,
        mixed $model,
        string $role,
        string $stopReason,
        ?string $stopSequence,
        string $type,
        Usage $usage,
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

Message::_loadMetadata();
