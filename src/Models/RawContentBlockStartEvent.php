<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

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
     * @param int                                                                                                    $index
     * @param string                                                                                                 $type
     */
    final public function __construct($contentBlock, $index, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

RawContentBlockStartEvent::_loadMetadata();
