<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An `environment_variable` credential's `auth.networking.allowed_hosts` includes a host the environment's network policy does not permit.
 *
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus
 * @phpstan-import-type RetryStatusVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus
 *
 * @phpstan-type ManagedAgentsCredentialHostUnreachableErrorShape = array{
 *   credentialID: string,
 *   message: string,
 *   retryStatus: RetryStatusShape,
 *   type: 'credential_host_unreachable_error',
 *   vaultID: string,
 * }
 */
final class ManagedAgentsCredentialHostUnreachableError implements BaseModel
{
    /** @use SdkModel<ManagedAgentsCredentialHostUnreachableErrorShape> */
    use SdkModel;

    /** @var 'credential_host_unreachable_error' $type */
    #[Required(type: new ConstantOf('credential_host_unreachable_error'))]
    public string $type = 'credential_host_unreachable_error';

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
     * What the client should do next.
     *
     * @var RetryStatusVariants $retryStatus
     */
    #[Required('retry_status', union: RetryStatus::class)]
    public ManagedAgentsRetryStatusRetrying|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus;

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
     *   credentialID: ..., message: ..., retryStatus: ..., vaultID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsCredentialHostUnreachableError())
     *   ->withCredentialID(...)
     *   ->withMessage(...)
     *   ->withRetryStatus(...)
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
     */
    public static function with(
        string $credentialID,
        string $message,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
        string $vaultID,
    ): self {
        $self = new self;

        $self['credentialID'] = $credentialID;
        $self['message'] = $message;
        $self['retryStatus'] = $retryStatus;
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
     * @param 'credential_host_unreachable_error' $type
     */
    public function withType(string $type): self
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
