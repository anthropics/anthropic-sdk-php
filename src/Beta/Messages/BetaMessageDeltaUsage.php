<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaIterationsUsageItemVariants from \Anthropic\Beta\Messages\BetaIterationsUsageItem
 * @phpstan-import-type BetaIterationsUsageItemShape from \Anthropic\Beta\Messages\BetaIterationsUsageItem
 * @phpstan-import-type BetaServerToolUsageShape from \Anthropic\Beta\Messages\BetaServerToolUsage
 *
 * @phpstan-type BetaMessageDeltaUsageShape = array{
 *   cacheCreationInputTokens: int|null,
 *   cacheReadInputTokens: int|null,
 *   inputTokens: int|null,
 *   iterations: list<BetaIterationsUsageItemShape>|null,
 *   outputTokens: int,
 *   serverToolUse: null|BetaServerToolUsage|BetaServerToolUsageShape,
 * }
 */
final class BetaMessageDeltaUsage implements BaseModel
{
    /** @use SdkModel<BetaMessageDeltaUsageShape> */
    use SdkModel;

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    #[Required('cache_creation_input_tokens')]
    public ?int $cacheCreationInputTokens;

    /**
     * The cumulative number of input tokens read from the cache.
     */
    #[Required('cache_read_input_tokens')]
    public ?int $cacheReadInputTokens;

    /**
     * The cumulative number of input tokens which were used.
     */
    #[Required('input_tokens')]
    public ?int $inputTokens;

    /**
     * Per-iteration token usage breakdown.
     *
     * Each entry represents one sampling iteration, with its own input/output token counts and cache statistics. This allows you to:
     * - Determine which iterations exceeded long context thresholds (>=200k tokens)
     * - Calculate the true context window size from the last iteration
     * - Understand token accumulation across server-side tool use loops
     *
     * @var list<BetaIterationsUsageItemVariants>|null $iterations
     */
    #[Required(list: BetaIterationsUsageItem::class)]
    public ?array $iterations;

    /**
     * The cumulative number of output tokens which were used.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * The number of server tool requests.
     */
    #[Required('server_tool_use')]
    public ?BetaServerToolUsage $serverToolUse;

    /**
     * `new BetaMessageDeltaUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMessageDeltaUsage::with(
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inputTokens: ...,
     *   iterations: ...,
     *   outputTokens: ...,
     *   serverToolUse: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMessageDeltaUsage)
     *   ->withCacheCreationInputTokens(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withInputTokens(...)
     *   ->withIterations(...)
     *   ->withOutputTokens(...)
     *   ->withServerToolUse(...)
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
     * @param list<BetaIterationsUsageItemShape>|null $iterations
     * @param BetaServerToolUsage|BetaServerToolUsageShape|null $serverToolUse
     */
    public static function with(
        ?int $cacheCreationInputTokens,
        ?int $cacheReadInputTokens,
        ?int $inputTokens,
        ?array $iterations,
        int $outputTokens,
        BetaServerToolUsage|array|null $serverToolUse,
    ): self {
        $self = new self;

        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inputTokens'] = $inputTokens;
        $self['iterations'] = $iterations;
        $self['outputTokens'] = $outputTokens;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }

    /**
     * The cumulative number of input tokens used to create the cache entry.
     */
    public function withCacheCreationInputTokens(
        ?int $cacheCreationInputTokens
    ): self {
        $self = clone $this;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $self;
    }

    /**
     * The cumulative number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(?int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * The cumulative number of input tokens which were used.
     */
    public function withInputTokens(?int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * Per-iteration token usage breakdown.
     *
     * Each entry represents one sampling iteration, with its own input/output token counts and cache statistics. This allows you to:
     * - Determine which iterations exceeded long context thresholds (>=200k tokens)
     * - Calculate the true context window size from the last iteration
     * - Understand token accumulation across server-side tool use loops
     *
     * @param list<BetaIterationsUsageItemShape>|null $iterations
     */
    public function withIterations(?array $iterations): self
    {
        $self = clone $this;
        $self['iterations'] = $iterations;

        return $self;
    }

    /**
     * The cumulative number of output tokens which were used.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * The number of server tool requests.
     *
     * @param BetaServerToolUsage|BetaServerToolUsageShape|null $serverToolUse
     */
    public function withServerToolUse(
        BetaServerToolUsage|array|null $serverToolUse
    ): self {
        $self = clone $this;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }
}
