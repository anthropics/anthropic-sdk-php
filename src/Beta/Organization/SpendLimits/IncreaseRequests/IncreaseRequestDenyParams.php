<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\IncreaseRequests;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Deny a pending spend limit increase request.
 *
 * Idempotent on `denied`; denying an already-`approved` request returns
 * 400. Anthropic emails the requester unless `suppress_notification` is set.
 *
 * @see Anthropic\Services\Beta\Organization\SpendLimits\IncreaseRequestsService::deny()
 *
 * @phpstan-type IncreaseRequestDenyParamsShape = array{
 *   suppressNotification?: bool|null
 * }
 */
final class IncreaseRequestDenyParams implements BaseModel
{
    /** @use SdkModel<IncreaseRequestDenyParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional('suppress_notification')]
    public ?bool $suppressNotification;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $suppressNotification = null): self
    {
        $self = new self;

        null !== $suppressNotification && $self['suppressNotification'] = $suppressNotification;

        return $self;
    }

    public function withSuppressNotification(bool $suppressNotification): self
    {
        $self = clone $this;
        $self['suppressNotification'] = $suppressNotification;

        return $self;
    }
}
