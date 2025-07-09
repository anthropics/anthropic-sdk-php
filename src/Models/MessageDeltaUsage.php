<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class MessageDeltaUsage implements BaseModel
{
    use Model;

    #[Api('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    #[Api('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    #[Api('input_tokens')]
    public ?int $inputTokens;

    #[Api('output_tokens')]
    public int $outputTokens;

    #[Api('server_tool_use')]
    public ServerToolUsage $serverToolUse;

    /**
     * @param null|int        $cacheCreationInputTokens
     * @param null|int        $cacheReadInputTokens
     * @param null|int        $inputTokens
     * @param int             $outputTokens
     * @param ServerToolUsage $serverToolUse
     */
    final public function __construct(
        $cacheCreationInputTokens,
        $cacheReadInputTokens,
        $inputTokens,
        $outputTokens,
        $serverToolUse,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

MessageDeltaUsage::_loadMetadata();
