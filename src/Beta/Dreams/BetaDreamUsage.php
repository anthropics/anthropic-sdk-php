<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cumulative token usage for the dream across every pipeline stage.
 *
 * @phpstan-type BetaDreamUsageShape = array{
 *   cacheCreationInputTokens: int,
 *   cacheReadInputTokens: int,
 *   inputTokens: int,
 *   outputTokens: int,
 * }
 */
final class BetaDreamUsage implements BaseModel
{
    /** @use SdkModel<BetaDreamUsageShape> */
    use SdkModel;

    /**
     * Total tokens used to create prompt-cache entries (sum of all TTL tiers).
     */
    #[Required('cache_creation_input_tokens')]
    public int $cacheCreationInputTokens;

    /**
     * Total tokens read from prompt cache.
     */
    #[Required('cache_read_input_tokens')]
    public int $cacheReadInputTokens;

    /**
     * Total uncached input tokens consumed across every pipeline stage.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * Total output tokens generated across every pipeline stage.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * `new BetaDreamUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDreamUsage::with(
     *   cacheCreationInputTokens: ...,
     *   cacheReadInputTokens: ...,
     *   inputTokens: ...,
     *   outputTokens: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDreamUsage)
     *   ->withCacheCreationInputTokens(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withInputTokens(...)
     *   ->withOutputTokens(...)
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
     */
    public static function with(
        int $cacheCreationInputTokens,
        int $cacheReadInputTokens,
        int $inputTokens,
        int $outputTokens,
    ): self {
        $self = new self;

        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['inputTokens'] = $inputTokens;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * Total tokens used to create prompt-cache entries (sum of all TTL tiers).
     */
    public function withCacheCreationInputTokens(
        int $cacheCreationInputTokens
    ): self {
        $self = clone $this;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;

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
     * Total uncached input tokens consumed across every pipeline stage.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * Total output tokens generated across every pipeline stage.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }
}
