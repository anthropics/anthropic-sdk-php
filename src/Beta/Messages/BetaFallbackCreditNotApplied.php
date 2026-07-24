<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaFallbackCreditNotApplied\Reason;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * No reprice was applied; ``reason`` says why.
 *
 * @phpstan-type BetaFallbackCreditNotAppliedShape = array{
 *   reason: Reason|value-of<Reason>,
 *   type: 'not_applied',
 *   removeToRedeem?: list<string>|null,
 * }
 */
final class BetaFallbackCreditNotApplied implements BaseModel
{
    /** @use SdkModel<BetaFallbackCreditNotAppliedShape> */
    use SdkModel;

    /** @var 'not_applied' $type */
    #[Required]
    public string $type = 'not_applied';

    /**
     * Why the reprice was not applied.
     *
     * A closed enum; additions to the redemption-check vocabulary arrive as
     * deliberate schema updates.
     *
     * @var value-of<Reason> $reason
     */
    #[Required(enum: Reason::class)]
    public string $reason;

    /**
     * Request fields to remove before retrying, so the retry can redeem this
     * token.
     *
     * Present exactly when `reason` is `variant_fields_present` — never null,
     * never an empty array; absent otherwise. Fields are named only from your own request, and only after
     * the sealed variant hash matched. A served best-effort retry has already
     * been billed at normal price; nothing redeems retroactively, but a corrected
     * re-send inside the token's five-minute window can still redeem.
     *
     * @var list<string>|null $removeToRedeem
     */
    #[Optional('remove_to_redeem', list: 'string', nullable: true)]
    public ?array $removeToRedeem;

    /**
     * `new BetaFallbackCreditNotApplied()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaFallbackCreditNotApplied::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaFallbackCreditNotApplied)->withReason(...)
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
     * @param Reason|value-of<Reason> $reason
     * @param list<string>|null $removeToRedeem
     */
    public static function with(
        Reason|string $reason,
        ?array $removeToRedeem = null
    ): self {
        $self = new self;

        $self['reason'] = $reason;

        null !== $removeToRedeem && $self['removeToRedeem'] = $removeToRedeem;

        return $self;
    }

    /**
     * Why the reprice was not applied.
     *
     * A closed enum; additions to the redemption-check vocabulary arrive as
     * deliberate schema updates.
     *
     * @param Reason|value-of<Reason> $reason
     */
    public function withReason(Reason|string $reason): self
    {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * @param 'not_applied' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Request fields to remove before retrying, so the retry can redeem this
     * token.
     *
     * Present exactly when `reason` is `variant_fields_present` — never null,
     * never an empty array; absent otherwise. Fields are named only from your own request, and only after
     * the sealed variant hash matched. A served best-effort retry has already
     * been billed at normal price; nothing redeems retroactively, but a corrected
     * re-send inside the token's five-minute window can still redeem.
     *
     * @param list<string>|null $removeToRedeem
     */
    public function withRemoveToRedeem(?array $removeToRedeem): self
    {
        $self = clone $this;
        $self['removeToRedeem'] = $removeToRedeem;

        return $self;
    }
}
