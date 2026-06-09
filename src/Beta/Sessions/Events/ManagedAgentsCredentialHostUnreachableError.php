<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus;
use Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * An `environment_variable` credential's `auth.networking.allowed_hosts` includes a host the environment's network policy does not permit.
 *
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus
 *
 * @phpstan-type ManagedAgentsCredentialHostUnreachableErrorShape = array{
 *   credentialID: string,
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: Type|value-of<Type>,
 *   vaultID: string,
 * }
 */
final class ManagedAgentsCredentialHostUnreachableError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsCredentialHostUnreachableErrorShape> */
    use SdkModel;

    /**
     * ID of the affected credential.
     */
    #[Required('credential_id')]
    public string $credentialID;

    /**
     * Human-readable error description.
     */
    #[Required]
    public string $message;

    /**
     * What the client should do next in response to this error.
     *
     * @var RetryStatusVariants $retryStatus
     */
    #[Required('retry_status', union: RetryStatus::class)]
    public ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * ID of the vault containing the affected credential.
     */
    #[Required('vault_id')]
    public string $vaultID;

    /**
     * `new ManagedAgentsCredentialHostUnreachableError()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsCredentialHostUnreachableError::with(
     *   credentialID: ..., message: ..., retryStatus: ..., type: ..., vaultID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsCredentialHostUnreachableError)
     *   ->withCredentialID(...)
     *   ->withMessage(...)
     *   ->withRetryStatus(...)
     *   ->withType(...)
     *   ->withVaultID(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $credentialID,
        string $message,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
        Type|string $type,
        string $vaultID,
    ): self {
        $self = new self;

        $self['credentialID'] = $credentialID;
        $self['message'] = $message;
        $self['retryStatus'] = $retryStatus;
        $self['type'] = $type;
        $self['vaultID'] = $vaultID;

        return $self;
    }

    /**
     * ID of the affected credential.
     */
    public function withCredentialID(string $credentialID): self
    {
        $self = clone $this;
        $self['credentialID'] = $credentialID;

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
     * What the client should do next in response to this error.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the vault containing the affected credential.
     */
    public function withVaultID(string $vaultID): self
    {
        $self = clone $this;
        $self['vaultID'] = $vaultID;

        return $self;
    }
}
