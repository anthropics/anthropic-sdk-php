<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsToolUseLimitReachedErrorObject\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The turn stopped because the agent loop reached its limit on tool-use rounds (one model response that calls tools, plus running those tools, is one round), not because a request failed. The thread goes idle with `stop_reason: retries_exhausted` (a child thread then terminates); the next `user.message` starts a new turn.
 *
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsToolUseLimitReachedErrorObject\RetryStatus
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsToolUseLimitReachedErrorObject\RetryStatus
 *
 * @phpstan-type ManagedAgentsToolUseLimitReachedErrorObjectShape = array{
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: 'tool_use_limit_reached_error',
 * }
 */
class ManagedAgentsToolUseLimitReachedErrorObject implements BaseModel
{
    /** @use SdkModel<ManagedAgentsToolUseLimitReachedErrorObjectShape> */
    use SdkModel;

    /** @var 'tool_use_limit_reached_error' $type */
    #[Required(type: new ConstantOf('tool_use_limit_reached_error'))]
    public string $type = 'tool_use_limit_reached_error';

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
     * `new ManagedAgentsToolUseLimitReachedErrorObject()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsToolUseLimitReachedErrorObject::with(
     *   message: ..., retryStatus: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsToolUseLimitReachedErrorObject())
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
     * @param 'tool_use_limit_reached_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}

class_alias(
    ManagedAgentsToolUseLimitReachedErrorObject::class,
    'Anthropic\Beta\Sessions\Events\ManagedAgentsToolUseLimitReachedError',
);
