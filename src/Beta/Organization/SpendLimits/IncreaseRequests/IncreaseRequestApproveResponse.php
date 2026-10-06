<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests;

use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse\Actor;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse\ResolvedBy;
use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitScopedAPIKeyActor;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitUserActor;
use Anthropic\Beta\Organization\SpendLimits\SpendSummary;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ActorShape from \Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse\Actor
 * @phpstan-import-type ResolvedByShape from \Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse\ResolvedBy
 * @phpstan-import-type SpendLimitShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimit
 * @phpstan-import-type SpendSummaryShape from \Anthropic\Beta\Organization\SpendLimits\SpendSummary
 * @phpstan-import-type ActorVariants from \Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse\Actor
 * @phpstan-import-type ResolvedByVariants from \Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse\ResolvedBy
 *
 * @phpstan-type IncreaseRequestApproveResponseShape = array{
 *   id: string,
 *   actor: ActorShape,
 *   createdAt: \DateTimeInterface,
 *   period: SpendLimitPeriod|value-of<SpendLimitPeriod>,
 *   resolvedAt: \DateTimeInterface|null,
 *   resolvedBy: ResolvedByShape|null,
 *   spendLimit: SpendLimit|SpendLimitShape,
 *   spendSummary: null|SpendSummary|SpendSummaryShape,
 *   status: BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus>,
 *   type: 'spend_limit_increase_request',
 * }
 */
final class IncreaseRequestApproveResponse implements BaseModel
{
    /** @use SdkModel<IncreaseRequestApproveResponseShape> */
    use SdkModel;

    /** @var 'spend_limit_increase_request' $type */
    #[Required(type: new ConstantOf('spend_limit_increase_request'))]
    public string $type = 'spend_limit_increase_request';

    #[Required]
    public string $id;

    /** @var ActorVariants $actor */
    #[Required(union: Actor::class)]
    public SpendLimitUserActor|SpendLimitScopedAPIKeyActor $actor;

    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /** @var value-of<SpendLimitPeriod> $period */
    #[Required(enum: SpendLimitPeriod::class)]
    public string $period;

    #[Required('resolved_at')]
    public ?\DateTimeInterface $resolvedAt;

    /** @var ResolvedByVariants|null $resolvedBy */
    #[Required('resolved_by', union: ResolvedBy::class)]
    public SpendLimitUserActor|SpendLimitScopedAPIKeyActor|null $resolvedBy;

    /**
     * A configured spend limit: a cap on metered spend for one scope and period.
     */
    #[Required('spend_limit')]
    public SpendLimit $spendLimit;

    /**
     * Per-member effective-limit report row (`GET /spend_limits/effective`).
     */
    #[Required('spend_summary')]
    public ?SpendSummary $spendSummary;

    /** @var value-of<BetaSpendLimitIncreaseRequestStatus> $status */
    #[Required(enum: BetaSpendLimitIncreaseRequestStatus::class)]
    public string $status;

    /**
     * `new IncreaseRequestApproveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IncreaseRequestApproveResponse::with(
     *   id: ...,
     *   actor: ...,
     *   createdAt: ...,
     *   period: ...,
     *   resolvedAt: ...,
     *   resolvedBy: ...,
     *   spendLimit: ...,
     *   spendSummary: ...,
     *   status: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IncreaseRequestApproveResponse())
     *   ->withID(...)
     *   ->withActor(...)
     *   ->withCreatedAt(...)
     *   ->withPeriod(...)
     *   ->withResolvedAt(...)
     *   ->withResolvedBy(...)
     *   ->withSpendLimit(...)
     *   ->withSpendSummary(...)
     *   ->withStatus(...)
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
     * @param ResolvedByShape|null $resolvedBy
     * @param SpendLimit|SpendLimitShape $spendLimit
     * @param SpendSummary|SpendSummaryShape|null $spendSummary
     * @param BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus> $status
     */
    public static function with(
        string $id,
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor $actor,
        \DateTimeInterface $createdAt,
        SpendLimitPeriod|string $period,
        ?\DateTimeInterface $resolvedAt,
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor|null $resolvedBy,
        SpendLimit|array $spendLimit,
        SpendSummary|array|null $spendSummary,
        BetaSpendLimitIncreaseRequestStatus|string $status,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['actor'] = $actor;
        $self['createdAt'] = $createdAt;
        $self['period'] = $period;
        $self['resolvedAt'] = $resolvedAt;
        $self['resolvedBy'] = $resolvedBy;
        $self['spendLimit'] = $spendLimit;
        $self['spendSummary'] = $spendSummary;
        $self['status'] = $status;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     */
    public function withPeriod(SpendLimitPeriod|string $period): self
    {
        $self = clone $this;
        $self['period'] = $period;

        return $self;
    }

    public function withResolvedAt(?\DateTimeInterface $resolvedAt): self
    {
        $self = clone $this;
        $self['resolvedAt'] = $resolvedAt;

        return $self;
    }

    /**
     * @param ResolvedByShape|null $resolvedBy
     */
    public function withResolvedBy(
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor|null $resolvedBy
    ): self {
        $self = clone $this;
        $self['resolvedBy'] = $resolvedBy;

        return $self;
    }

    /**
     * A configured spend limit: a cap on metered spend for one scope and period.
     *
     * @param SpendLimit|SpendLimitShape $spendLimit
     */
    public function withSpendLimit(SpendLimit|array $spendLimit): self
    {
        $self = clone $this;
        $self['spendLimit'] = $spendLimit;

        return $self;
    }

    /**
     * Per-member effective-limit report row (`GET /spend_limits/effective`).
     *
     * @param SpendSummary|SpendSummaryShape|null $spendSummary
     */
    public function withSpendSummary(
        SpendSummary|array|null $spendSummary
    ): self {
        $self = clone $this;
        $self['spendSummary'] = $spendSummary;

        return $self;
    }

    /**
     * @param BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus> $status
     */
    public function withStatus(
        BetaSpendLimitIncreaseRequestStatus|string $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param 'spend_limit_increase_request' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
