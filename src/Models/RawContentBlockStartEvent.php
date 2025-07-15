<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class RawContentBlockStartEvent implements BaseModel
{
    use Model;

    #[Api('content_block')]
    public RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock;

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
     * @param RedactedThinkingBlock|ServerToolUseBlock|TextBlock|ThinkingBlock|ToolUseBlock|WebSearchToolResultBlock $contentBlock `required`
     * @param int                                                                                                    $index        `required`
     * @param string                                                                                                 $type         `required`
     */
    final public function __construct(
        $contentBlock,
        $index,
        $type = 'content_block_start'
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

RawContentBlockStartEvent::_loadMetadata();
