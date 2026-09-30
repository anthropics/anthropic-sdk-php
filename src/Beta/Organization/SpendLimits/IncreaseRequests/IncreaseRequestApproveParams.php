<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests;

use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Approve a pending spend limit increase request.
 *
 * Writes a per-user spend limit at `amount` for the requester and
 * transitions the request to `approved`. `period` defaults to the period
 * the member was blocked on. Anthropic emails the requester unless
 * `suppress_notification` is set.
 *
 * @see Anthropic\Services\Beta\Organization\SpendLimits\IncreaseRequestsService::approve()
 *
 * @phpstan-type IncreaseRequestApproveParamsShape = array{
 *   amount: string,
 *   period?: null|SpendLimitPeriod|value-of<SpendLimitPeriod>,
 *   suppressNotification?: bool|null,
 * }
 */
final class IncreaseRequestApproveParams implements BaseModel
{
    /** @use SdkModel<IncreaseRequestApproveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * New per-user spend limit as a non-negative integer decimal string (minor units).
     */
    #[Required]
    public string $amount;

    /** @var value-of<SpendLimitPeriod>|null $period */
    #[Optional(enum: SpendLimitPeriod::class, nullable: true)]
    public ?string $period;

    #[Optional('suppress_notification')]
    public ?bool $suppressNotification;

    /**
     * `new IncreaseRequestApproveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IncreaseRequestApproveParams::with(amount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IncreaseRequestApproveParams)->withAmount(...)
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
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod>|null $period
     */
    public static function with(
        string $amount,
        SpendLimitPeriod|string|null $period = null,
        ?bool $suppressNotification = null,
    ): self {
        $self = new self;

        $self['amount'] = $amount;

        null !== $period && $self['period'] = $period;
        null !== $suppressNotification && $self['suppressNotification'] = $suppressNotification;

        return $self;
    }

    /**
     * New per-user spend limit as a non-negative integer decimal string (minor units).
     */
    public function withAmount(string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

        return $self;
    }

    /**
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod>|null $period
     */
    public function withPeriod(SpendLimitPeriod|string|null $period): self
    {
        $self = clone $this;
        $self['period'] = $period;

        return $self;
    }

    public function withSuppressNotification(bool $suppressNotification): self
    {
        $self = clone $this;
        $self['suppressNotification'] = $suppressNotification;

        return $self;
    }
}
