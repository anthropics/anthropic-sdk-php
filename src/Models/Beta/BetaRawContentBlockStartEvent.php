<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaRawContentBlockStartEvent implements BaseModel
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
    public string $type = 'content_block_start';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param BetaCodeExecutionToolResultBlock|BetaContainerUploadBlock|BetaMCPToolResultBlock|BetaMCPToolUseBlock|BetaRedactedThinkingBlock|BetaServerToolUseBlock|BetaTextBlock|BetaThinkingBlock|BetaToolUseBlock|BetaWebSearchToolResultBlock $contentBlock `required`
     * @param int                                                                                                                                                                                                                                 $index        `required`
     * @param string                                                                                                                                                                                                                              $type         `required`
     */
    final public function __construct(
        $contentBlock,
        $index,
        $type = 'content_block_start'
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaRawContentBlockStartEvent::_loadMetadata();
