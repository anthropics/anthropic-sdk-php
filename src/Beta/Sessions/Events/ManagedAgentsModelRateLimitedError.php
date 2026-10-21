<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The model request was rate-limited.
 *
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError\RetryStatus
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError\RetryStatus
 *
 * @phpstan-type ManagedAgentsModelRateLimitedErrorShape = array{
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: 'model_rate_limited_error',
 * }
 */
final class ManagedAgentsModelRateLimitedError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsModelRateLimitedErrorShape> */
    use SdkModel;

    /** @var 'model_rate_limited_error' $type */
    #[Required(type: new ConstantOf('model_rate_limited_error'))]
    public string $type = 'model_rate_limited_error';

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * What the client should do next.
     *
     * @var RetryStatusVariants $retryStatus
     */
    #[Required('retry_status', union: RetryStatus::class)]
    public ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus;

    /**
     * `new ManagedAgentsModelRateLimitedError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsModelRateLimitedError::with(message: ..., retryStatus: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsModelRateLimitedError())
     *   ->withMessage(...)
     *   ->withRetryStatus(...)
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
     * @param RetryStatusShape $retryStatus
     */
    public static function with(
        string $message,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
    ): self {
        $self = new self;

        $self['message'] = $message;
        $self['retryStatus'] = $retryStatus;

        return $self;
    }

    /**
     * Human-readable error description.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * What the client should do next.
     *
     * @param RetryStatusShape $retryStatus
     */
    public function withRetryStatus(
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
    ): self {
        $self = clone $this;
        $self['retryStatus'] = $retryStatus;

        return $self;
    }

    /**
     * @param 'model_rate_limited_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
