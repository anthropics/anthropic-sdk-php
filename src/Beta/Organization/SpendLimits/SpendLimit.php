<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\SpendLimit\Scope;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A configured spend limit: a cap on metered spend for one scope and period.
 *
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimit\Scope
 * @phpstan-import-type ScopeVariants from \Anthropic\Beta\Organization\SpendLimits\SpendLimit\Scope
 *
 * @phpstan-type SpendLimitShape = array{
 *   id: string,
 *   amount: string|null,
 *   createdAt: \DateTimeInterface,
 *   currency: string,
 *   isEnabled: bool,
 *   period: SpendLimitPeriod|value-of<SpendLimitPeriod>,
 *   scope: ScopeShape,
 *   type: 'spend_limit',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class SpendLimit implements BaseModel
{
    /** @use SdkModel<SpendLimitShape> */
    use SdkModel;

    /**
     * Object type. Always `spend_limit`.
     *
     * @var 'spend_limit' $type
     */
    #[Required(type: new ConstantOf('spend_limit'))]
    public string $type = 'spend_limit';

    /**
     * Unique tagged ID of the spend limit (`spl_...`).
     */
    #[Required]
    public string $id;

    /**
     * Limit amount as a non-negative integer decimal string in the minor unit of `currency` (cents for USD): "50000" is $500.00. `null` means no numeric cap is configured at this scope — see the effective report for whether a limit applies.
     */
    #[Required]
    public ?string $amount;

    /**
     * RFC 3339 datetime at which the spend limit was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * ISO 4217 code of the organization's billing currency; the unit for `amount`.
     */
    #[Required]
    public string $currency;

    /**
     * Read-only. `false` when extra usage is switched off for this organization (`organization` limit) or for this member (`user` limit); `amount` is kept and applies again when it's switched back on. Always `true` for other limits.
     */
    #[Required('is_enabled')]
    public bool $isEnabled;

    /**
     * Length of the window the limit resets over. `amount` caps spend within each period.
     *
     * @var value-of<SpendLimitPeriod> $period
     */
    #[Required(enum: SpendLimitPeriod::class)]
    public string $period;

    /**
     * What the limit applies to. A tagged union on `type`; each variant carries the identifier for its scope.
     *
     * @var ScopeVariants $scope
     */
    #[Required(union: Scope::class)]
    public SpendLimitUserScope|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope;

    /**
     * RFC 3339 datetime at which the spend limit was last modified.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new SpendLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimit::with(
     *   id: ...,
     *   amount: ...,
     *   createdAt: ...,
     *   currency: ...,
     *   isEnabled: ...,
     *   period: ...,
     *   scope: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimit())
     *   ->withID(...)
     *   ->withAmount(...)
     *   ->withCreatedAt(...)
     *   ->withCurrency(...)
     *   ->withIsEnabled(...)
     *   ->withPeriod(...)
     *   ->withScope(...)
     *   ->withUpdatedAt(...)
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
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     * @param ScopeShape $scope
     */
    public static function with(
        string $id,
        ?string $amount,
        \DateTimeInterface $createdAt,
        string $currency,
        bool $isEnabled,
        SpendLimitPeriod|string $period,
        SpendLimitUserScope|array|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['amount'] = $amount;
        $self['createdAt'] = $createdAt;
        $self['currency'] = $currency;
        $self['isEnabled'] = $isEnabled;
        $self['period'] = $period;
        $self['scope'] = $scope;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Unique tagged ID of the spend limit (`spl_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Limit amount as a non-negative integer decimal string in the minor unit of `currency` (cents for USD): "50000" is $500.00. `null` means no numeric cap is configured at this scope — see the effective report for whether a limit applies.
     */
    public function withAmount(?string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * RFC 3339 datetime at which the spend limit was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * ISO 4217 code of the organization's billing currency; the unit for `amount`.
     */
    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Read-only. `false` when extra usage is switched off for this organization (`organization` limit) or for this member (`user` limit); `amount` is kept and applies again when it's switched back on. Always `true` for other limits.
     */
    public function withIsEnabled(bool $isEnabled): self
    {
        $self = clone $this;
        $self['isEnabled'] = $isEnabled;

        return $self;
    }

    /**
     * Length of the window the limit resets over. `amount` caps spend within each period.
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
     * What the limit applies to. A tagged union on `type`; each variant carries the identifier for its scope.
     *
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
     * Object type. Always `spend_limit`.
     *
     * @param 'spend_limit' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * RFC 3339 datetime at which the spend limit was last modified.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
