<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

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

    final public function __construct(
        BetaCacheCreation $cacheCreation,
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        int $inputTokens,
        int $outputTokens,
        BetaServerToolUsage $serverToolUse,
        ?string $serviceTier
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

BetaUsage::_loadMetadata();
