<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Usage;

use Anthropic\Beta\Messages\BetaCacheCreation;
use Anthropic\Beta\Organization\Analytics\AnalyticsServerToolUse;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The token usage of one row.
 *
 * @phpstan-import-type BetaCacheCreationShape from \Anthropic\Beta\Messages\BetaCacheCreation
 * @phpstan-import-type AnalyticsServerToolUseShape from \Anthropic\Beta\Organization\Analytics\AnalyticsServerToolUse
 *
 * @phpstan-type BetaAnalyticsUsageMetricsShape = array{
 *   cacheCreation: BetaCacheCreation|BetaCacheCreationShape,
 *   cacheReadInputTokens: int,
 *   outputTokens: int,
 *   requests: int|null,
 *   serverToolUse: AnalyticsServerToolUse|AnalyticsServerToolUseShape,
 *   totalTokens: int,
 *   uncachedInputTokens: int,
 * }
 */
final class BetaAnalyticsUsageMetrics implements BaseModel
{
    /** @use SdkModel<BetaAnalyticsUsageMetricsShape> */
    use SdkModel;

    /**
     * The number of input tokens for cache creation.
     */
    #[Required('cache_creation')]
    public BetaCacheCreation $cacheCreation;

    /**
     * The number of input tokens read from the cache.
     */
    #[Required('cache_read_input_tokens')]
    public int $cacheReadInputTokens;

    /**
     * The number of output tokens generated.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * Number of API requests in this row's scope. For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    #[Required]
    public ?int $requests;

    /**
     * Server-side tool usage metrics.
     */
    #[Required('server_tool_use')]
    public AnalyticsServerToolUse $serverToolUse;

    /**
     * Total token count across all token types. This is the value the default `order_by` (`total_tokens`) sorts on.
     */
    #[Required('total_tokens')]
    public int $totalTokens;

    /**
     * The number of uncached input tokens processed.
     */
    #[Required('uncached_input_tokens')]
    public int $uncachedInputTokens;

    /**
     * `new BetaAnalyticsUsageMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAnalyticsUsageMetrics::with(
     *   cacheCreation: ...,
     *   cacheReadInputTokens: ...,
     *   outputTokens: ...,
     *   requests: ...,
     *   serverToolUse: ...,
     *   totalTokens: ...,
     *   uncachedInputTokens: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAnalyticsUsageMetrics())
     *   ->withCacheCreation(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withOutputTokens(...)
     *   ->withRequests(...)
     *   ->withServerToolUse(...)
     *   ->withTotalTokens(...)
     *   ->withUncachedInputTokens(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCacheCreation|BetaCacheCreationShape $cacheCreation
     * @param AnalyticsServerToolUse|AnalyticsServerToolUseShape $serverToolUse
     */
    public static function with(
        BetaCacheCreation|array $cacheCreation,
        int $cacheReadInputTokens,
        int $outputTokens,
        ?int $requests,
        AnalyticsServerToolUse|array $serverToolUse,
        int $totalTokens,
        int $uncachedInputTokens,
    ): self {
        $self = new self;

        $self['cacheCreation'] = $cacheCreation;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['outputTokens'] = $outputTokens;
        $self['requests'] = $requests;
        $self['serverToolUse'] = $serverToolUse;
        $self['totalTokens'] = $totalTokens;
        $self['uncachedInputTokens'] = $uncachedInputTokens;

        return $self;
    }

    /**
     * The number of input tokens for cache creation.
     *
     * @param BetaCacheCreation|BetaCacheCreationShape $cacheCreation
     */
    public function withCacheCreation(
        BetaCacheCreation|array $cacheCreation
    ): self {
        $self = clone $this;
        $self['cacheCreation'] = $cacheCreation;

        return $self;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * The number of output tokens generated.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * Number of API requests in this row's scope. For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    public function withRequests(?int $requests): self
    {
        $self = clone $this;
        $self['requests'] = $requests;

        return $self;
    }

    /**
     * Server-side tool usage metrics.
     *
     * @param AnalyticsServerToolUse|AnalyticsServerToolUseShape $serverToolUse
     */
    public function withServerToolUse(
        AnalyticsServerToolUse|array $serverToolUse
    ): self {
        $self = clone $this;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }

    /**
     * Total token count across all token types. This is the value the default `order_by` (`total_tokens`) sorts on.
     */
    public function withTotalTokens(int $totalTokens): self
    {
        $self = clone $this;
        $self['totalTokens'] = $totalTokens;

        return $self;
    }

    /**
     * The number of uncached input tokens processed.
     */
    public function withUncachedInputTokens(int $uncachedInputTokens): self
    {
        $self = clone $this;
        $self['uncachedInputTokens'] = $uncachedInputTokens;

        return $self;
    }
}
