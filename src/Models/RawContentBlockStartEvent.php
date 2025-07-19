<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawContentBlockStartEvent\ContentBlock;

final class RawContentBlockStartEvent implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'content_block_start';

    #[Api('content_block', union: ContentBlock::class)]
    public RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock;

    #[Api]
    public int $index;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock,
        int $index,
    ) {
        self::introspect();

        $this->contentBlock = $contentBlock;
        $this->index = $index;
    }
}
