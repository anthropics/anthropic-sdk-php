<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A `fallback` block echoed back from a prior response.
 *
 * Accepted in `messages[].content` and not rendered into the prompt; not
 * validated against the request's `fallbacks` chain or top-level `model`.
 *
 * Echo the assistant turn back verbatim, including this block in its
 * original position. The block marks the boundary between content produced
 * before and after a fallback hop, and the server relies on that boundary
 * to validate the turn: when thinking runs flank the boundary, omitting
 * the block merges them into one span the server cannot validate (the
 * request is rejected), and moving it into the middle of a single run is
 * likewise rejected; between non-thinking blocks the block's placement has
 * no validation effect.
 *
 * @phpstan-import-type BetaFallbackInfoParamShape from \Anthropic\Beta\Messages\BetaFallbackInfoParam
 *
 * @phpstan-type BetaFallbackBlockParamShape = array{
 *   from: BetaFallbackInfoParam|BetaFallbackInfoParamShape,
 *   to: BetaFallbackInfoParam|BetaFallbackInfoParamShape,
 *   type: 'fallback',
 *   trigger?: mixed,
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
     * The response block's `trigger`, echoed verbatim. Accepted and ignored by the server; any object or `null` is allowed.
     */
    #[Optional]
    public mixed $trigger;

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
        BetaFallbackInfoParam|array $to,
        mixed $trigger = null,
    ): self {
        $self = new self;

        $self['from'] = $from;
        $self['to'] = $to;

        null !== $trigger && $self['trigger'] = $trigger;

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

    /**
     * The response block's `trigger`, echoed verbatim. Accepted and ignored by the server; any object or `null` is allowed.
     */
    public function withTrigger(mixed $trigger): self
    {
        $self = clone $this;
        $self['trigger'] = $trigger;

        return $self;
    }
}
