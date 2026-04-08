<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cumulative token usage for a session across all turns.
 *
 * @phpstan-import-type BetaManagedAgentsCacheCreationUsageShape from \Anthropic\Beta\Sessions\BetaManagedAgentsCacheCreationUsage
 *
 * @phpstan-type BetaManagedAgentsSessionUsageShape = array{
 *   cacheCreation?: null|BetaManagedAgentsCacheCreationUsage|BetaManagedAgentsCacheCreationUsageShape,
 *   cacheReadInputTokens?: int|null,
 *   inputTokens?: int|null,
 *   outputTokens?: int|null,
 * }
 */
final class BetaManagedAgentsSessionUsage implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionUsageShape> */
    use SdkModel;

    /**
     * Prompt-cache creation token usage broken down by cache lifetime.
     */
    #[Optional('cache_creation')]
    public ?BetaManagedAgentsCacheCreationUsage $cacheCreation;

    /**
     * Total tokens read from prompt cache.
     */
    #[Optional('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    /**
     * Total input tokens consumed across all turns.
     */
    #[Optional('input_tokens')]
    public ?int $inputTokens;

    /**
     * Total output tokens generated across all turns.
     */
    #[Optional('output_tokens')]
    public ?int $outputTokens;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsCacheCreationUsage|BetaManagedAgentsCacheCreationUsageShape|null $cacheCreation
     */
    public static function with(
        BetaManagedAgentsCacheCreationUsage|array|null $cacheCreation = null,
        ?int $cacheReadInputTokens = null,
        ?int $inputTokens = null,
        ?int $outputTokens = null,
    ): self {
        $self = new self;

        null !== $cacheCreation && $self['cacheCreation'] = $cacheCreation;
        null !== $cacheReadInputTokens && $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        null !== $inputTokens && $self['inputTokens'] = $inputTokens;
        null !== $outputTokens && $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * Prompt-cache creation token usage broken down by cache lifetime.
     *
     * @param BetaManagedAgentsCacheCreationUsage|BetaManagedAgentsCacheCreationUsageShape $cacheCreation
     */
    public function withCacheCreation(
        BetaManagedAgentsCacheCreationUsage|array $cacheCreation
    ): self {
        $self = clone $this;
        $self['cacheCreation'] = $cacheCreation;

        return $self;
    }

    /**
     * Total tokens read from prompt cache.
     */
    public function withCacheReadInputTokens(int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * Total input tokens consumed across all turns.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * Total output tokens generated across all turns.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }
}
