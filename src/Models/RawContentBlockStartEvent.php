<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class RawContentBlockStartEvent implements BaseModel
{
    use Model;

    /**
     * @var RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock
     */
    #[Api('content_block')]
    public mixed $contentBlock;

    #[Api]
    public int $index;

    #[Api]
    public string $type;

    /**
     * @param RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock
     */
    final public function __construct(
        mixed $contentBlock,
        int $index,
        string $type
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

RawContentBlockStartEvent::_loadMetadata();
