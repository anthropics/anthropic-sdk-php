<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackCreditUsage;

use Anthropic\Beta\Messages\BetaFallbackCreditNotApplied;
use Anthropic\Beta\Messages\BetaFallbackCreditNotApplied\Reason;
use Anthropic\Beta\Messages\BetaFallbackCreditRedeemed;
use Anthropic\Beta\Messages\BetaFallbackCreditUsage\Status\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the fallback-credit reprice was applied to this response's billing.
 *
 * A union discriminated on `type`. `redeemed`: the retry is billed as if
 * the conversation had been on the retry model all along — including when the
 * resulting shift is zero because there was nothing to move. `not_applied`:
 * no reprice was applied; the arm's `reason` says why.
 *
 * @phpstan-import-type BetaFallbackCreditRedeemedShape from \Anthropic\Beta\Messages\BetaFallbackCreditRedeemed
 * @phpstan-import-type BetaFallbackCreditNotAppliedShape from \Anthropic\Beta\Messages\BetaFallbackCreditNotApplied
 *
 * @phpstan-type StatusVariants = BetaFallbackCreditRedeemed|BetaFallbackCreditNotApplied
 * @phpstan-type StatusShape = StatusVariants|BetaFallbackCreditRedeemedShape|BetaFallbackCreditNotAppliedShape
 */
final class Status implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'redeemed' => BetaFallbackCreditRedeemed::class,
            'not_applied' => BetaFallbackCreditNotApplied::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param Reason|value-of<Reason>|null $reason
     * @param list<string>|null $removeToRedeem
     *
     * @return ($type is Type::REDEEMED|'redeemed' ? BetaFallbackCreditRedeemed : ($type is Type::NOT_APPLIED|'not_applied' ? BetaFallbackCreditNotApplied : BetaFallbackCreditRedeemed|BetaFallbackCreditNotApplied))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        Reason|string|null $reason = null,
        ?array $removeToRedeem = null,
    ): BetaFallbackCreditRedeemed|BetaFallbackCreditNotApplied {
        return match ($type) {
            Type::REDEEMED, 'redeemed' => BetaFallbackCreditRedeemed::with(),
            Type::NOT_APPLIED, 'not_applied' => BetaFallbackCreditNotApplied::with(
                reason: $reason ?? throw new \ArgumentCountError('$reason is required'),
                removeToRedeem: $removeToRedeem,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
