<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaUsage implements BaseModel
{
    use Model;

    #[Api('cache_creation')]
    public BetaCacheCreation $cacheCreation;

    #[Api('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    #[Api('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    #[Api('input_tokens')]
    public int $inputTokens;

    #[Api('output_tokens')]
    public int $outputTokens;

    #[Api('server_tool_use')]
    public BetaServerToolUsage $serverToolUse;

    #[Api('service_tier')]
    public ?string $serviceTier;

    /**
     * @param BetaCacheCreation   $cacheCreation
     * @param null|int            $cacheCreationInputTokens
     * @param null|int            $cacheReadInputTokens
     * @param int                 $inputTokens
     * @param int                 $outputTokens
     * @param BetaServerToolUsage $serverToolUse
     * @param null|string         $serviceTier
     */
    final public function __construct(
        $cacheCreation,
        $cacheCreationInputTokens,
        $cacheReadInputTokens,
        $inputTokens,
        $outputTokens,
        $serverToolUse,
        $serviceTier,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaUsage::_loadMetadata();
