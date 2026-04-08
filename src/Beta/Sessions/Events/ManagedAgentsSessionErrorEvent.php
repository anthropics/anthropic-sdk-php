<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An error event indicating a problem occurred during session execution.
 *
 * @phpstan-import-type ErrorVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error
 * @phpstan-import-type ErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error
 *
 * @phpstan-type ManagedAgentsSessionErrorEventShape = array{
 *   id: string,
 *   error: ErrorShape,
 *   processedAt: \DateTimeInterface,
 *   type: Type|value-of<Type>,
 * }
 */
final class ManagedAgentsSessionErrorEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionErrorEventShape> */
    use SdkModel;

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /**
     * An unknown or unexpected error occurred during session execution. A fallback variant; clients that don't recognize a new error code can match on `retry_status` and `message` alone.
     *
     * @var ErrorVariants $error
     */
    #[Required(union: Error::class)]
    public ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError $error;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSessionErrorEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionErrorEvent::with(
     *   id: ..., error: ..., processedAt: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionErrorEvent)
     *   ->withID(...)
     *   ->withError(...)
     *   ->withProcessedAt(...)
     *   ->withType(...)
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
     * @param ErrorShape $error
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        ManagedAgentsUnknownError|array|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError $error,
        \DateTimeInterface $processedAt,
        Type|string $type,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['error'] = $error;
        $self['processedAt'] = $processedAt;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Unique identifier for this event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * An unknown or unexpected error occurred during session execution. A fallback variant; clients that don't recognize a new error code can match on `retry_status` and `message` alone.
     *
     * @param ErrorShape $error
     */
    public function withError(
        ManagedAgentsUnknownError|array|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
