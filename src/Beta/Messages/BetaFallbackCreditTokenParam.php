<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaFallbackCreditTokenParam\Mode;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Object form of ``fallback_credit_token``: the token plus a redemption
 * mode.
 *
 * Requires ``anthropic-beta: fallback-credit-2026-07-01``; without that
 * header the field accepts the bare string only. The bare string and the
 * mode-less object are equivalent (both select ``strict``), so wrapping
 * an existing token changes nothing by itself.
 *
 * @phpstan-type BetaFallbackCreditTokenParamShape = array{
 *   token: string, mode?: null|Mode|value-of<Mode>
 * }
 */
final class BetaFallbackCreditTokenParam implements BaseModel
{
    /** @use SdkModel<BetaFallbackCreditTokenParamShape> */
    use SdkModel;

    /**
     * The opaque `fallback_credit_token` from a prior refusal's `stop_details` — the same string the bare-string form carries.
     */
    #[Required]
    public string $token;

    /**
     * How a failing token affects the retry. `strict` (the default, and the bare-string behavior): a failing redemption is a 400 and the retry is not served. `best_effort`: the retry is served either way — a token-layer failure no longer rejects the request; the retry proceeds at normal price and the outcome is reported on the response's `usage.fallback_credit`. Two failures stay hard in both modes: a malformed token, and combining `fallback_credit_token` with `fallbacks`.
     *
     * @var value-of<Mode>|null $mode
     */
    #[Optional(enum: Mode::class)]
    public ?string $mode;

    /**
     * `new BetaFallbackCreditTokenParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackCreditTokenParam::with(token: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackCreditTokenParam)->withToken(...)
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
     * @param Mode|value-of<Mode>|null $mode
     */
    public static function with(string $token, Mode|string|null $mode = null): self
    {
        $self = new self;

        $self['token'] = $token;

        null !== $mode && $self['mode'] = $mode;

        return $self;
    }

    /**
     * The opaque `fallback_credit_token` from a prior refusal's `stop_details` — the same string the bare-string form carries.
     */
    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }

    /**
     * How a failing token affects the retry. `strict` (the default, and the bare-string behavior): a failing redemption is a 400 and the retry is not served. `best_effort`: the retry is served either way — a token-layer failure no longer rejects the request; the retry proceeds at normal price and the outcome is reported on the response's `usage.fallback_credit`. Two failures stay hard in both modes: a malformed token, and combining `fallback_credit_token` with `fallbacks`.
     *
     * @param Mode|value-of<Mode> $mode
     */
    public function withMode(Mode|string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }
}
