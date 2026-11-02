<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedError\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The turn stopped because the context was compacted the maximum number of times in a row without the model producing a message or a tool call, not because a request failed. The thread goes idle with `stop_reason: retries_exhausted` (a child thread then terminates); the next `user.message` starts a new turn.
 *
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedError\RetryStatus
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedError\RetryStatus
 *
 * @phpstan-type ManagedAgentsCompactionLimitReachedErrorShape = array{
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: 'compaction_limit_reached_error',
 * }
 */
final class ManagedAgentsCompactionLimitReachedError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsCompactionLimitReachedErrorShape> */
    use SdkModel;

    /** @var 'compaction_limit_reached_error' $type */
    #[Required(type: new ConstantOf('compaction_limit_reached_error'))]
    public string $type = 'compaction_limit_reached_error';

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
     * `new ManagedAgentsCompactionLimitReachedError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsCompactionLimitReachedError::with(message: ..., retryStatus: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsCompactionLimitReachedError())
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
     * @param 'compaction_limit_reached_error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
