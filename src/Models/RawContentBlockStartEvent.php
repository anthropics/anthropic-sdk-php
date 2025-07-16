<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\RawContentBlockStartEvent\Type;

final class RawContentBlockStartEvent implements BaseModel
{
    use Model;

    #[Api('content_block')]
    public RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock;

    #[Api]
    public int $index;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'content_block_start';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock,
        int $index,
        string $type = 'content_block_start',
    ) {
        $this->contentBlock = $contentBlock;
        $this->index = $index;
        $this->type = $type;
    }
}

RawContentBlockStartEvent::_loadMetadata();
