<?php

declare(strict_types=1);

namespace Anthropic\Organization\SpendLimits\IncreaseRequests;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Organization\SpendLimits\SpendLimitScopedAPIKeyActor;
use Anthropic\Organization\SpendLimits\SpendLimitUserActor;
use Anthropic\Organization\SpendLimits\SpendSummary;

/**
 * @phpstan-import-type SpendLimitIncreaseRequestActorShape from \Anthropic\Organization\SpendLimits\IncreaseRequests\SpendLimitIncreaseRequestActor
 * @phpstan-import-type SpendLimitIncreaseRequestResolvedByShape from \Anthropic\Organization\SpendLimits\IncreaseRequests\SpendLimitIncreaseRequestResolvedBy
 * @phpstan-import-type SpendSummaryShape from \Anthropic\Organization\SpendLimits\SpendSummary
 * @phpstan-import-type SpendLimitIncreaseRequestActorVariants from \Anthropic\Organization\SpendLimits\IncreaseRequests\SpendLimitIncreaseRequestActor
 * @phpstan-import-type SpendLimitIncreaseRequestResolvedByVariants from \Anthropic\Organization\SpendLimits\IncreaseRequests\SpendLimitIncreaseRequestResolvedBy
 *
 * @phpstan-type SpendLimitIncreaseRequestShape = array{
 *   id: string,
 *   actor: SpendLimitIncreaseRequestActorShape,
 *   createdAt: \DateTimeInterface,
 *   period: SpendLimitPeriod|value-of<SpendLimitPeriod>,
 *   resolvedAt: \DateTimeInterface|null,
 *   resolvedBy: SpendLimitIncreaseRequestResolvedByShape|null,
 *   spendSummary: null|SpendSummary|SpendSummaryShape,
 *   status: SpendLimitIncreaseRequestStatus|value-of<SpendLimitIncreaseRequestStatus>,
 *   type: 'spend_limit_increase_request',
 * }
 */
final class SpendLimitIncreaseRequest implements BaseModel
{
    /** @use SdkModel<SpendLimitIncreaseRequestShape> */
    use SdkModel;

    /** @var 'spend_limit_increase_request' $type */
    #[Required(type: new ConstantOf('spend_limit_increase_request'))]
    public string $type = 'spend_limit_increase_request';

    #[Required]
    public string $id;

    /**
     * Who submitted the increase request.
     *
     * @var SpendLimitIncreaseRequestActorVariants $actor
     */
    #[Required(union: SpendLimitIncreaseRequestActor::class)]
    public SpendLimitUserActor|SpendLimitScopedAPIKeyActor $actor;

    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /** @var value-of<SpendLimitPeriod> $period */
    #[Required(enum: SpendLimitPeriod::class)]
    public string $period;

    #[Required('resolved_at')]
    public ?\DateTimeInterface $resolvedAt;

    /**
     * Who approved or denied the increase request.
     *
     * @var SpendLimitIncreaseRequestResolvedByVariants|null $resolvedBy
     */
    #[Required('resolved_by', union: SpendLimitIncreaseRequestResolvedBy::class)]
    public SpendLimitUserActor|SpendLimitScopedAPIKeyActor|null $resolvedBy;

    /**
     * Per-member effective-limit report row (`GET /spend_limits/effective`).
     */
    #[Required('spend_summary')]
    public ?SpendSummary $spendSummary;

    /** @var value-of<SpendLimitIncreaseRequestStatus> $status */
    #[Required(enum: SpendLimitIncreaseRequestStatus::class)]
    public string $status;

    /**
     * `new SpendLimitIncreaseRequest()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitIncreaseRequest::with(
     *   id: ...,
     *   actor: ...,
     *   createdAt: ...,
     *   period: ...,
     *   resolvedAt: ...,
     *   resolvedBy: ...,
     *   spendSummary: ...,
     *   status: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitIncreaseRequest())
     *   ->withID(...)
     *   ->withActor(...)
     *   ->withCreatedAt(...)
     *   ->withPeriod(...)
     *   ->withResolvedAt(...)
     *   ->withResolvedBy(...)
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
     * @param SpendLimitIncreaseRequestActorShape $actor
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     * @param SpendLimitIncreaseRequestResolvedByShape|null $resolvedBy
     * @param SpendSummary|SpendSummaryShape|null $spendSummary
     * @param SpendLimitIncreaseRequestStatus|value-of<SpendLimitIncreaseRequestStatus> $status
     */
    public static function with(
        string $id,
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor $actor,
        \DateTimeInterface $createdAt,
        SpendLimitPeriod|string $period,
        ?\DateTimeInterface $resolvedAt,
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor|null $resolvedBy,
        SpendSummary|array|null $spendSummary,
        SpendLimitIncreaseRequestStatus|string $status,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['actor'] = $actor;
        $self['createdAt'] = $createdAt;
        $self['period'] = $period;
        $self['resolvedAt'] = $resolvedAt;
        $self['resolvedBy'] = $resolvedBy;
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
     * Who submitted the increase request.
     *
     * @param SpendLimitIncreaseRequestActorShape $actor
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
     * Who approved or denied the increase request.
     *
     * @param SpendLimitIncreaseRequestResolvedByShape|null $resolvedBy
     */
    public function withResolvedBy(
        SpendLimitUserActor|array|SpendLimitScopedAPIKeyActor|null $resolvedBy
    ): self {
        $self = clone $this;
        $self['resolvedBy'] = $resolvedBy;

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
     * @param SpendLimitIncreaseRequestStatus|value-of<SpendLimitIncreaseRequestStatus> $status
     */
    public function withStatus(
        SpendLimitIncreaseRequestStatus|string $status
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
