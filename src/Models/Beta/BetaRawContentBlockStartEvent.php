<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaRawContentBlockStartEvent implements BaseModel
{
    use Model;

    /**
     * @var BetaTextBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaThinkingBlock|BetaRedactedThinkingBlock $contentBlock
     */
    #[Api('content_block')]
    public mixed $contentBlock;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param BetaTextBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaThinkingBlock|BetaRedactedThinkingBlock $contentBlock
     */
    final public function __construct(
        mixed $contentBlock,
        int $index,
        string $type,
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

BetaRawContentBlockStartEvent::_loadMetadata();
