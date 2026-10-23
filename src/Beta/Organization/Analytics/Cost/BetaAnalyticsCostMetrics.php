<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Cost;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The cost of one row.
 *
 * @phpstan-type BetaAnalyticsCostMetricsShape = array{
 *   amount: string, currency: string, listAmount: string, requests: int|null
 * }
 */
final class BetaAnalyticsCostMetrics implements BaseModel
{
    /** @use SdkModel<BetaAnalyticsCostMetricsShape> */
    use SdkModel;

    /**
     * Amount (post-discount, pre-credit) in fractional cents (minor units).
     */
    #[Required]
    public string $amount;

    /**
     * Currency code for the cost amount. Currently always `"USD"`.
     */
    #[Required]
    public string $currency;

    /**
     * List-price amount (pre-discount) in fractional cents.
     */
    #[Required('list_amount')]
    public string $listAmount;

    /**
     * Number of API requests in this row's scope. Null when `group_by` includes `cost_type` or `token_type` (the count has no per-component attribution; read it from the ungrouped response). For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    #[Required]
    public ?int $requests;

    /**
     * `new BetaAnalyticsCostMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAnalyticsCostMetrics::with(
     *   amount: ..., currency: ..., listAmount: ..., requests: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAnalyticsCostMetrics())
     *   ->withAmount(...)
     *   ->withCurrency(...)
     *   ->withListAmount(...)
     *   ->withRequests(...)
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
        string $amount,
        string $listAmount,
        ?int $requests,
        string $currency = 'USD'
    ): self {
        $self = new self;

        $self['amount'] = $amount;
        $self['currency'] = $currency;
        $self['listAmount'] = $listAmount;
        $self['requests'] = $requests;

        return $self;
    }

    /**
     * Amount (post-discount, pre-credit) in fractional cents (minor units).
     */
    public function withAmount(string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * Currency code for the cost amount. Currently always `"USD"`.
     */
    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * List-price amount (pre-discount) in fractional cents.
     */
    public function withListAmount(string $listAmount): self
    {
        $self = clone $this;
        $self['listAmount'] = $listAmount;

        return $self;
    }

    /**
     * Number of API requests in this row's scope. Null when `group_by` includes `cost_type` or `token_type` (the count has no per-component attribution; read it from the ungrouped response). For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    public function withRequests(?int $requests): self
    {
        $self = clone $this;
        $self['requests'] = $requests;

        return $self;
    }
}
