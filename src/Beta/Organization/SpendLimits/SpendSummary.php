<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\SpendSummary\Actor;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary\Scope;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary\Source;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-member effective-limit report row (`GET /spend_limits/effective`).
 *
 * @phpstan-import-type ActorShape from \Anthropic\Beta\Organization\SpendLimits\SpendSummary\Actor
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendSummary\Scope
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Organization\SpendLimits\SpendSummary\Source
 * @phpstan-import-type ActorVariants from \Anthropic\Beta\Organization\SpendLimits\SpendSummary\Actor
 * @phpstan-import-type ScopeVariants from \Anthropic\Beta\Organization\SpendLimits\SpendSummary\Scope
 * @phpstan-import-type SourceVariants from \Anthropic\Beta\Organization\SpendLimits\SpendSummary\Source
 *
 * @phpstan-type SpendSummaryShape = array{
 *   actor: ActorShape,
 *   amount: string|null,
 *   currency: string,
 *   period: SpendLimitPeriod|value-of<SpendLimitPeriod>,
 *   periodToDateSpend: string,
 *   scope: ScopeShape,
 *   source: SourceShape,
 *   spendLimitID: string,
 * }
 */
final class SpendSummary implements BaseModel
{
    /** @use SdkModel<SpendSummaryShape> */
    use SdkModel;

    /** @var ActorVariants $actor */
    #[Required(union: Actor::class)]
    public SpendLimitUserActor|SpendLimitScopedAPIKeyActor $actor;

    /**
     * Effective limit amount as a non-negative integer decimal string in the minor unit of `currency` (cents for USD). `null` means no limit applies for this row's `period` — each period resolves independently, so another period may still cap this member.
     */
    #[Required]
    public ?string $amount;

    /**
     * ISO 4217 code of the organization's billing currency; the unit for `amount` and `period_to_date_spend`.
     */
    #[Required]
    public string $currency;

    /**
     * Period this row's effective limit and spend are reported for.
     *
     * @var value-of<SpendLimitPeriod> $period
     */
    #[Required(enum: SpendLimitPeriod::class)]
    public string $period;

    /**
     * The member's spend so far in the current period, as a non-negative decimal string in the minor unit of `currency` (cents for USD). May carry fractional minor units up to three decimal places (e.g. `"12050.5"`) — metered usage is not rounded to whole cents. Reads as `"0"` when the spend reading is temporarily unavailable.
     */
    #[Required('period_to_date_spend')]
    public string $periodToDateSpend;

    /** @var ScopeVariants $scope */
    #[Required(union: Scope::class)]
    public SpendLimitUserScope|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope;

    /** @var SourceVariants $source */
    #[Required(union: Source::class)]
    public SpendLimitUserScope|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $source;

    #[Required('spend_limit_id')]
    public string $spendLimitID;

    /**
     * `new SpendSummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendSummary::with(
     *   actor: ...,
     *   amount: ...,
     *   currency: ...,
     *   period: ...,
     *   periodToDateSpend: ...,
     *   scope: ...,
     *   source: ...,
     *   spendLimitID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendSummary())
     *   ->withActor(...)
     *   ->withAmount(...)
     *   ->withCurrency(...)
     *   ->withPeriod(...)
     *   ->withPeriodToDateSpend(...)
     *   ->withScope(...)
     *   ->withSource(...)
     *   ->withSpendLimitID(...)
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
     * @param ActorShape $actor
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     * @param ScopeShape $scope
     * @param SourceShape $source
     */
    public static function with(
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor $actor,
        ?string $amount,
        string $currency,
        SpendLimitPeriod|string $period,
        string $periodToDateSpend,
        SpendLimitUserScope|array|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope,
        SpendLimitUserScope|array|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $source,
        string $spendLimitID,
    ): self {
        $self = new self;

        $self['actor'] = $actor;
        $self['amount'] = $amount;
        $self['currency'] = $currency;
        $self['period'] = $period;
        $self['periodToDateSpend'] = $periodToDateSpend;
        $self['scope'] = $scope;
        $self['source'] = $source;
        $self['spendLimitID'] = $spendLimitID;

        return $self;
    }

    /**
     * @param ActorShape $actor
     */
    public function withActor(
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor $actor
    ): self {
        $self = clone $this;
        $self['actor'] = $actor;

        return $self;
    }

    /**
     * Effective limit amount as a non-negative integer decimal string in the minor unit of `currency` (cents for USD). `null` means no limit applies for this row's `period` — each period resolves independently, so another period may still cap this member.
     */
    public function withAmount(?string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * ISO 4217 code of the organization's billing currency; the unit for `amount` and `period_to_date_spend`.
     */
    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Period this row's effective limit and spend are reported for.
     *
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     */
    public function withPeriod(SpendLimitPeriod|string $period): self
    {
        $self = clone $this;
        $self['period'] = $period;

        return $self;
    }

    /**
     * The member's spend so far in the current period, as a non-negative decimal string in the minor unit of `currency` (cents for USD). May carry fractional minor units up to three decimal places (e.g. `"12050.5"`) — metered usage is not rounded to whole cents. Reads as `"0"` when the spend reading is temporarily unavailable.
     */
    public function withPeriodToDateSpend(string $periodToDateSpend): self
    {
        $self = clone $this;
        $self['periodToDateSpend'] = $periodToDateSpend;

        return $self;
    }

    /**
     * @param ScopeShape $scope
     */
    public function withScope(
        SpendLimitUserScope|array|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope,
    ): self {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * @param SourceShape $source
     */
    public function withSource(
        SpendLimitUserScope|array|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $source,
    ): self {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withSpendLimitID(string $spendLimitID): self
    {
        $self = clone $this;
        $self['spendLimitID'] = $spendLimitID;

        return $self;
    }
}
