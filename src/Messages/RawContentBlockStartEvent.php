<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\RawContentBlockStartEvent\ContentBlock as ContentBlock1;

/**
 * @phpstan-type raw_content_block_start_event_alias = array{
 *   contentBlock: TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock,
 *   index: int,
 *   type: string,
 * }
 */
final class RawContentBlockStartEvent implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'content_block_start';

    #[Api('content_block', union: ContentBlock1::class)]
    public RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock;

    #[Api]
    public int $index;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock,
        int $index,
    ): self {
        $obj = new self;

        $obj->contentBlock = $contentBlock;
        $obj->index = $index;

        return $obj;
    }

    public function setContentBlock(
        RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock,
    ): self {
        $this->contentBlock = $contentBlock;

        return $this;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

        return $this;
    }
}
