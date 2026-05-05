<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaWebhookVaultCredentialRefreshFailedEventDataShape = array{
 *   id: string,
 *   organizationID: string,
 *   type: 'vault_credential.refresh_failed',
 *   vaultID: string,
 *   workspaceID: string,
 * }
 */
final class BetaWebhookVaultCredentialRefreshFailedEventData implements BaseModel
{
    /** @use SdkModel<BetaWebhookVaultCredentialRefreshFailedEventDataShape> */
    use SdkModel;

    /** @var 'vault_credential.refresh_failed' $type */
    #[Required]
    public string $type = 'vault_credential.refresh_failed';

    /**
     * ID of the resource that triggered the event.
     */
    #[Required]
    public string $id;

    #[Required('organization_id')]
    public string $organizationID;

    /**
     * ID of the vault that owns this credential.
     */
    #[Required('vault_id')]
    public string $vaultID;

    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaWebhookVaultCredentialRefreshFailedEventData()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookVaultCredentialRefreshFailedEventData::with(
     *   id: ..., organizationID: ..., vaultID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookVaultCredentialRefreshFailedEventData)
     *   ->withID(...)
     *   ->withOrganizationID(...)
     *   ->withVaultID(...)
     *   ->withWorkspaceID(...)
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
     */
    public static function with(
        string $id,
        string $organizationID,
        string $vaultID,
        string $workspaceID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['organizationID'] = $organizationID;
        $self['vaultID'] = $vaultID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * ID of the resource that triggered the event.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * @param 'vault_credential.refresh_failed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the vault that owns this credential.
     */
    public function withVaultID(string $vaultID): self
    {
        $self = clone $this;
        $self['vaultID'] = $vaultID;

        return $self;
    }

    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
