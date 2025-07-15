<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawContentBlockStartEvent implements BaseModel
{
    use Model;

    #[Api('content_block')]
    public BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock;

    #[Api]
    public int $index;

    #[Api]
    public string $type = 'content_block_start';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock,
        int $index,
        string $type = 'content_block_start',
    ) {
        $this->contentBlock = $contentBlock;
        $this->index = $index;
        $this->type = $type;
    }
}

BetaRawContentBlockStartEvent::_loadMetadata();
