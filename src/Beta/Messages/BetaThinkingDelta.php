<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingDeltaShape = array{
 *   estimatedTokens: int|null, thinking: string, type: 'thinking_delta'
 * }
 */
final class BetaThinkingDelta implements BaseModel
{
    /** @use SdkModel<BetaThinkingDeltaShape> */
    use SdkModel;

    /** @var 'thinking_delta' $type */
    #[Required]
    public string $type = 'thinking_delta';

    /**
     * Per-frame increment of a coarse, running estimate of the tokens this thinking block has produced so far. Present whenever the `thinking-token-count-2026-05-13` beta is set; `null` unless `thinking.display` resolves to `"omitted"` and a count is due this frame. Sum the increments across `thinking_delta` frames on this block for a progress indicator. Each increment is a non-negative multiple of a fixed quantum and the cadence is rate-limited, so this is a deliberately lossy display hint, not a billable count; `usage.output_tokens` remains authoritative.
     */
    #[Required('estimated_tokens')]
    public ?int $estimatedTokens;

    #[Required]
    public string $thinking;

    /**
     * `new BetaThinkingDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingDelta::with(estimatedTokens: ..., thinking: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingDelta)->withEstimatedTokens(...)->withThinking(...)
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
    public static function with(?int $estimatedTokens, string $thinking): self
    {
        $self = new self;

        $self['estimatedTokens'] = $estimatedTokens;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * Per-frame increment of a coarse, running estimate of the tokens this thinking block has produced so far. Present whenever the `thinking-token-count-2026-05-13` beta is set; `null` unless `thinking.display` resolves to `"omitted"` and a count is due this frame. Sum the increments across `thinking_delta` frames on this block for a progress indicator. Each increment is a non-negative multiple of a fixed quantum and the cadence is rate-limited, so this is a deliberately lossy display hint, not a billable count; `usage.output_tokens` remains authoritative.
     */
    public function withEstimatedTokens(?int $estimatedTokens): self
    {
        $self = clone $this;
        $self['estimatedTokens'] = $estimatedTokens;

        return $self;
    }

    public function withThinking(string $thinking): self
    {
        $self = clone $this;
        $self['thinking'] = $thinking;

        return $self;
    }

    /**
     * @param 'thinking_delta' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
