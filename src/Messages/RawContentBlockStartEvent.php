<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\RawContentBlockStartEvent\ContentBlock;

/**
 * @phpstan-type RawContentBlockStartEventShape = array{
 *   content_block: TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock,
 *   index: int,
 *   type: 'content_block_start',
 * }
 */
final class RawContentBlockStartEvent implements BaseModel
{
    /** @use SdkModel<RawContentBlockStartEventShape> */
    use SdkModel;

    /** @var 'content_block_start' $type */
    #[Api]
    public string $type = 'content_block_start';

    #[Api(
        union: ContentBlock::class
    )]
    public TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $content_block;

    #[Api]
    public int $index;

    /**
     * `new RawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RawContentBlockStartEvent::with(content_block: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RawContentBlockStartEvent)->withContentBlock(...)->withIndex(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $content_block,
        int $index,
    ): self {
        $obj = new self;

        $obj->content_block = $content_block;
        $obj->index = $index;

        return $obj;
    }

    public function withContentBlock(
        TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $contentBlock,
    ): self {
        $obj = clone $this;
        $obj->content_block = $contentBlock;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj->index = $index;

        return $obj;
    }
}
