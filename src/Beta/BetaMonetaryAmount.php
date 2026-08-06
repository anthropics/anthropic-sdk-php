<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A monetary amount in a specific currency.
 *
 * @phpstan-type BetaMonetaryAmountShape = array{
 *   amount: string, currency: BetaCurrency|value-of<BetaCurrency>
 * }
 */
final class BetaMonetaryAmount implements BaseModel
{
    /** @use SdkModel<BetaMonetaryAmountShape> */
    use SdkModel;

    /**
     * Amount in minor units of the currency, as an integer decimal string with no leading zeros: "2500" is $25.00 and "50" is fifty cents. A string rather than a number so no float rounding is ever applied.
     */
    #[Required]
    public string $amount;

    /**
     * Uppercase ISO-4217 currency code. `USD` is the only currency currently supported; the accepted set is closed and grows only when a new currency is priced.
     *
     * @var value-of<BetaCurrency> $currency
     */
    #[Required(enum: BetaCurrency::class)]
    public string $currency;

    /**
     * `new BetaMonetaryAmount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaMonetaryAmount::with(amount: ..., currency: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaMonetaryAmount)->withAmount(...)->withCurrency(...)
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
     * @param BetaCurrency|value-of<BetaCurrency> $currency
     */
    public static function with(
        string $amount,
        BetaCurrency|string $currency
    ): self {
        $self = new self;

        $self['amount'] = $amount;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Amount in minor units of the currency, as an integer decimal string with no leading zeros: "2500" is $25.00 and "50" is fifty cents. A string rather than a number so no float rounding is ever applied.
     */
    public function withAmount(string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Uppercase ISO-4217 currency code. `USD` is the only currency currently supported; the accepted set is closed and grows only when a new currency is priced.
     *
     * @param BetaCurrency|value-of<BetaCurrency> $currency
     */
    public function withCurrency(BetaCurrency|string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }
}
