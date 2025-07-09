<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawContentBlockStartEvent implements BaseModel
{
    use Model;

    /**
     * @var BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock
     */
    #[Api('content_block')]
    public mixed $contentBlock;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock
     * @param int                                                                                                                                                                                                                                 $index
     * @param string                                                                                                                                                                                                                              $type
     */
    final public function __construct($contentBlock, $index, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawContentBlockStartEvent::_loadMetadata();
