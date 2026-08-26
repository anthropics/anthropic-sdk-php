<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type AzureExternalKeyConfigShape = array{
 *   keyName: string,
 *   tenantID: string,
 *   type: 'azure',
 *   vaultURI: string,
 *   clientID?: string|null,
 * }
 */
final class AzureExternalKeyConfig implements BaseModel
{
    /** @use SdkModel<AzureExternalKeyConfigShape> */
    use SdkModel;

    /** @var 'azure' $type */
    #[Required]
    public string $type = 'azure';

    /**
     * Name of the key within the vault.
     */
    #[Required('key_name')]
    public string $keyName;

    /**
     * Azure AD tenant ID.
     */
    #[Required('tenant_id')]
    public string $tenantID;

    /**
     * Key Vault data-plane URI — `https://{vault-name}.vault.azure.net` or `https://{hsm-name}.managedhsm.azure.net`.
     */
    #[Required('vault_uri')]
    public string $vaultURI;

    /**
     * Azure AD application (client) ID. Omit to use Anthropic's multitenant app. Provide only if using a single-tenant app registration in the customer's directory.
     */
    #[Optional('client_id', nullable: true)]
    public ?string $clientID;

    /**
     * `new AzureExternalKeyConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AzureExternalKeyConfig::with(keyName: ..., tenantID: ..., vaultURI: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AzureExternalKeyConfig)
     *   ->withKeyName(...)
     *   ->withTenantID(...)
     *   ->withVaultURI(...)
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
        string $keyName,
        string $tenantID,
        string $vaultURI,
        ?string $clientID = null,
    ): self {
        $self = new self;

        $self['keyName'] = $keyName;
        $self['tenantID'] = $tenantID;
        $self['vaultURI'] = $vaultURI;

        null !== $clientID && $self['clientID'] = $clientID;

        return $self;
    }

    /**
     * Name of the key within the vault.
     */
    public function withKeyName(string $keyName): self
    {
        $self = clone $this;
        $self['keyName'] = $keyName;

        return $self;
    }

    /**
     * Azure AD tenant ID.
     */
    public function withTenantID(string $tenantID): self
    {
        $self = clone $this;
        $self['tenantID'] = $tenantID;

        return $self;
    }

    /**
     * @param 'azure' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Key Vault data-plane URI — `https://{vault-name}.vault.azure.net` or `https://{hsm-name}.managedhsm.azure.net`.
     */
    public function withVaultURI(string $vaultURI): self
    {
        $self = clone $this;
        $self['vaultURI'] = $vaultURI;

        return $self;
    }

    /**
     * Azure AD application (client) ID. Omit to use Anthropic's multitenant app. Provide only if using a single-tenant app registration in the customer's directory.
     */
    public function withClientID(?string $clientID): self
    {
        $self = clone $this;
        $self['clientID'] = $clientID;

        return $self;
    }
}
