<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A `fallback` block echoed back from a prior response.
 *
 * Accepted in `messages[].content` and never rendered into the prompt,
 * not validated against the request's `fallbacks` chain or top-level
 * `model`, and stripped before the sticky-routing cache key is computed.
 *
 * Callers should echo the assistant turn verbatim — block included. The
 * block's position is load-bearing for thinking verification: the thinking
 * runs on either side of a fallback hop carry independently-rooted
 * verification hash chains, and this block is the only record of where one
 * chain ends and the next begins. When thinking runs flank the boundary,
 * omitting the block merges the runs into one contiguous span whose hashes
 * cannot verify (the request is rejected), and moving it into the middle of
 * a single run splits that run's chain and is likewise rejected; between
 * non-thinking blocks the block's placement has no verification effect.
 *
 * @phpstan-import-type BetaFallbackInfoParamShape from \Anthropic\Beta\Messages\BetaFallbackInfoParam
 *
 * @phpstan-type BetaFallbackBlockParamShape = array{
 *   from: BetaFallbackInfoParam|BetaFallbackInfoParamShape,
 *   to: BetaFallbackInfoParam|BetaFallbackInfoParamShape,
 *   type: 'fallback',
 * }
 */
final class BetaFallbackBlockParam implements BaseModel
{
    /** @use SdkModel<BetaFallbackBlockParamShape> */
    use SdkModel;

    /** @var 'fallback' $type */
    #[Required]
    public string $type = 'fallback';

    /**
     * Identifies one hop of a fallback transition.
     */
    #[Required]
    public BetaFallbackInfoParam $from;

    /**
     * Identifies one hop of a fallback transition.
     */
    #[Required]
    public BetaFallbackInfoParam $to;

    /**
     * `new BetaFallbackBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackBlockParam::with(from: ..., to: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackBlockParam)->withFrom(...)->withTo(...)
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
     * @param BetaFallbackInfoParam|BetaFallbackInfoParamShape $from
     * @param BetaFallbackInfoParam|BetaFallbackInfoParamShape $to
     */
    public static function with(
        BetaFallbackInfoParam|array $from,
        BetaFallbackInfoParam|array $to
    ): self {
        $self = new self;

        $self['from'] = $from;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Identifies one hop of a fallback transition.
     *
     * @param BetaFallbackInfoParam|BetaFallbackInfoParamShape $from
     */
    public function withFrom(BetaFallbackInfoParam|array $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    /**
     * Identifies one hop of a fallback transition.
     *
     * @param BetaFallbackInfoParam|BetaFallbackInfoParamShape $to
     */
    public function withTo(BetaFallbackInfoParam|array $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * @param 'fallback' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
