<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaFallbackCreditUsage\Status;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Outcome of the ``fallback_credit_token`` presented on this request.
 *
 * @phpstan-import-type StatusVariants from \Anthropic\Beta\Messages\BetaFallbackCreditUsage\Status
 * @phpstan-import-type StatusShape from \Anthropic\Beta\Messages\BetaFallbackCreditUsage\Status
 *
 * @phpstan-type BetaFallbackCreditUsageShape = array{status: StatusShape}
 */
final class BetaFallbackCreditUsage implements BaseModel
{
    /** @use SdkModel<BetaFallbackCreditUsageShape> */
    use SdkModel;

    /**
     * Whether the fallback-credit reprice was applied to this response's billing.
     *
     * A union discriminated on `type`. `redeemed`: the retry is billed as if
     * the conversation had been on the retry model all along — including when the
     * resulting shift is zero because there was nothing to move. `not_applied`:
     * no reprice was applied; the arm's `reason` says why.
     *
     * @var StatusVariants $status
     */
    #[Required(union: Status::class)]
    public BetaFallbackCreditRedeemed|BetaFallbackCreditNotApplied $status;

    /**
     * `new BetaFallbackCreditUsage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackCreditUsage::with(status: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackCreditUsage)->withStatus(...)
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
     * @param StatusShape $status
     */
    public static function with(
        BetaFallbackCreditRedeemed|array|BetaFallbackCreditNotApplied $status
    ): self {
        $self = new self;

        $self['status'] = $status;

        return $self;
    }

    /**
     * Whether the fallback-credit reprice was applied to this response's billing.
     *
     * A union discriminated on `type`. `redeemed`: the retry is billed as if
     * the conversation had been on the retry model all along — including when the
     * resulting shift is zero because there was nothing to move. `not_applied`:
     * no reprice was applied; the arm's `reason` says why.
     *
     * @param StatusShape $status
     */
    public function withStatus(
        BetaFallbackCreditRedeemed|array|BetaFallbackCreditNotApplied $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }
}
