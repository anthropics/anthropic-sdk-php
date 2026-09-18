<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The tokens that a dream has used so far.
 *
 * The counts are zero while the dream is `pending` and update while it is `running`. They can keep changing after a cancel.
 *
 * See the [Dreams guide](https://platform.claude.com/docs/en/managed-agents/dreams#billing) for how dreams are billed. See the [prompt caching guide](https://platform.claude.com/docs/en/build-with-claude/prompt-caching#tracking-cache-performance) for how the input token counts add up.
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
     * The dream's input tokens that were written to the prompt cache, for both the 5-minute and 1-hour cache durations.
     */
    #[Required('cache_creation_input_tokens')]
    public int $cacheCreationInputTokens;

    /**
     * The dream's input tokens that were read from the prompt cache.
     */
    #[Required('cache_read_input_tokens')]
    public int $cacheReadInputTokens;

    /**
     * The dream's input tokens that weren't read from or written to the prompt cache.
     */
    #[Required('input_tokens')]
    public int $inputTokens;

    /**
     * The tokens that the model generated for the dream.
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
     * The dream's input tokens that were written to the prompt cache, for both the 5-minute and 1-hour cache durations.
     */
    public function withCacheCreationInputTokens(
        int $cacheCreationInputTokens
    ): self {
        $self = clone $this;
        $self['cacheCreationInputTokens'] = $cacheCreationInputTokens;

        return $self;
    }

    /**
     * The dream's input tokens that were read from the prompt cache.
     */
    public function withCacheReadInputTokens(int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * The dream's input tokens that weren't read from or written to the prompt cache.
     */
    public function withInputTokens(int $inputTokens): self
    {
        $self = clone $this;
        $self['inputTokens'] = $inputTokens;

        return $self;
    }

    /**
     * The tokens that the model generated for the dream.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }
}
