<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\BetaMonetaryAmount;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cumulative token usage for a session across all turns.
 *
 * @phpstan-import-type BetaManagedAgentsCacheCreationUsageShape from \Anthropic\Beta\Sessions\BetaManagedAgentsCacheCreationUsage
 * @phpstan-import-type BetaMonetaryAmountShape from \Anthropic\Beta\BetaMonetaryAmount
 * @phpstan-import-type BetaManagedAgentsServerToolUsageShape from \Anthropic\Beta\Sessions\BetaManagedAgentsServerToolUsage
 *
 * @phpstan-type BetaManagedAgentsSessionUsageShape = array{
 *   activeSeconds?: float|null,
 *   cacheCreation?: null|BetaManagedAgentsCacheCreationUsage|BetaManagedAgentsCacheCreationUsageShape,
 *   cacheReadInputTokens?: int|null,
 *   inputTokens?: int|null,
 *   listCost?: null|BetaMonetaryAmount|BetaMonetaryAmountShape,
 *   outputTokens?: int|null,
 *   serverToolUse?: null|BetaManagedAgentsServerToolUsage|BetaManagedAgentsServerToolUsageShape,
 * }
 */
final class BetaManagedAgentsSessionUsage implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionUsageShape> */
    use SdkModel;

    /**
     * Cumulative time in seconds during which the session had at least one thread in running status. Overlapping activity from concurrent threads is counted once, unlike `stats.active_seconds`, which sums each thread's own active time. This is the duration the session's runtime cost is priced on.
     */
    #[Optional('active_seconds')]
    public ?float $activeSeconds;

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
     * A monetary amount in a specific currency.
     */
    #[Optional('list_cost', nullable: true)]
    public ?BetaMonetaryAmount $listCost;

    /**
     * Total output tokens generated across all turns.
     */
    #[Optional('output_tokens')]
    public ?int $outputTokens;

    /**
     * Cumulative count of server-executed tool invocations, broken down by tool.
     */
    #[Optional('server_tool_use', nullable: true)]
    public ?BetaManagedAgentsServerToolUsage $serverToolUse;

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
     * @param BetaMonetaryAmount|BetaMonetaryAmountShape|null $listCost
     * @param BetaManagedAgentsServerToolUsage|BetaManagedAgentsServerToolUsageShape|null $serverToolUse
     */
    public static function with(
        ?float $activeSeconds = null,
        BetaManagedAgentsCacheCreationUsage|array|null $cacheCreation = null,
        ?int $cacheReadInputTokens = null,
        ?int $inputTokens = null,
        BetaMonetaryAmount|array|null $listCost = null,
        ?int $outputTokens = null,
        BetaManagedAgentsServerToolUsage|array|null $serverToolUse = null,
    ): self {
        $self = new self;

        null !== $activeSeconds && $self['activeSeconds'] = $activeSeconds;
        null !== $cacheCreation && $self['cacheCreation'] = $cacheCreation;
        null !== $cacheReadInputTokens && $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        null !== $inputTokens && $self['inputTokens'] = $inputTokens;
        null !== $listCost && $self['listCost'] = $listCost;
        null !== $outputTokens && $self['outputTokens'] = $outputTokens;
        null !== $serverToolUse && $self['serverToolUse'] = $serverToolUse;

        return $self;
    }

    /**
     * Cumulative time in seconds during which the session had at least one thread in running status. Overlapping activity from concurrent threads is counted once, unlike `stats.active_seconds`, which sums each thread's own active time. This is the duration the session's runtime cost is priced on.
     */
    public function withActiveSeconds(float $activeSeconds): self
    {
        $self = clone $this;
        $self['activeSeconds'] = $activeSeconds;

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
     * A monetary amount in a specific currency.
     *
     * @param BetaMonetaryAmount|BetaMonetaryAmountShape|null $listCost
     */
    public function withListCost(BetaMonetaryAmount|array|null $listCost): self
    {
        $self = clone $this;
        $self['listCost'] = $listCost;

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

    /**
     * Cumulative count of server-executed tool invocations, broken down by tool.
     *
     * @param BetaManagedAgentsServerToolUsage|BetaManagedAgentsServerToolUsageShape|null $serverToolUse
     */
    public function withServerToolUse(
        BetaManagedAgentsServerToolUsage|array|null $serverToolUse
    ): self {
        $self = clone $this;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }
}
