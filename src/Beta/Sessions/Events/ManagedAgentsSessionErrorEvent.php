<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An error event indicating a problem occurred during session execution.
 *
 * @phpstan-import-type ErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error
 * @phpstan-import-type ErrorVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error
 *
 * @phpstan-type ManagedAgentsSessionErrorEventShape = array{
 *   id: string,
 *   error: ErrorShape,
 *   processedAt: \DateTimeInterface,
 *   type: 'session.error',
 * }
 */
final class ManagedAgentsSessionErrorEvent implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionErrorEventShape> */
    use SdkModel;

    /** @var 'session.error' $type */
    #[Required(type: new ConstantOf('session.error'))]
    public string $type = 'session.error';

    /**
     * Unique identifier for this event.
     */
    #[Required]
    public string $id;

    /** @var ErrorVariants $error */
    #[Required(union: Error::class)]
    public ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError|ManagedAgentsRepositoryAuthenticationError|ManagedAgentsRepositoryForbiddenError|ManagedAgentsRepositoryNotFoundError|ManagedAgentsRepositoryCheckoutError|ManagedAgentsRepositoryCloneError $error;

    /**
     * Timestamp when the error occurred.
     */
    #[Required('processed_at')]
    public \DateTimeInterface $processedAt;

    /**
     * `new ManagedAgentsSessionErrorEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionErrorEvent::with(id: ..., error: ..., processedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionErrorEvent())
     *   ->withID(...)
     *   ->withError(...)
     *   ->withProcessedAt(...)
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
     */
    public static function with(
        string $id,
        ManagedAgentsUnknownError|array|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError|ManagedAgentsRepositoryAuthenticationError|ManagedAgentsRepositoryForbiddenError|ManagedAgentsRepositoryNotFoundError|ManagedAgentsRepositoryCheckoutError|ManagedAgentsRepositoryCloneError $error,
        \DateTimeInterface $processedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['error'] = $error;
        $self['processedAt'] = $processedAt;

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
     * @param ErrorShape $error
     */
    public function withError(
        ManagedAgentsUnknownError|array|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError|ManagedAgentsRepositoryAuthenticationError|ManagedAgentsRepositoryForbiddenError|ManagedAgentsRepositoryNotFoundError|ManagedAgentsRepositoryCheckoutError|ManagedAgentsRepositoryCloneError $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * Timestamp when the error occurred.
     */
    public function withProcessedAt(\DateTimeInterface $processedAt): self
    {
        $self = clone $this;
        $self['processedAt'] = $processedAt;

        return $self;
    }

    /**
     * @param 'session.error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
