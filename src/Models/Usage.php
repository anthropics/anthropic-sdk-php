<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Usage\ServiceTier;

final class Usage implements BaseModel
{
    use Model;

    #[Api('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    #[Api('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    #[Api('input_tokens')]
    public int $inputTokens;

    #[Api('output_tokens')]
    public int $outputTokens;

    #[Api('server_tool_use')]
    public ServerToolUsage $serverToolUse;

    /** @var null|ServiceTier::* $serviceTier */
    #[Api('service_tier')]
    public ?string $serviceTier;

    /**
     * You must use named parameters to construct this object.
     *
     * @param null|ServiceTier::* $serviceTier
     */
    final public function __construct(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        int $inputTokens,
        int $outputTokens,
        ServerToolUsage $serverToolUse,
        ?string $serviceTier,
    ) {
        self::introspect();

        $this->cacheCreationInputTokens = $cacheCreationInputTokens;
        $this->cacheReadInputTokens = $cacheReadInputTokens;
        $this->inputTokens = $inputTokens;
        $this->outputTokens = $outputTokens;
        $this->serverToolUse = $serverToolUse;
        $this->serviceTier = $serviceTier;
    }
}
