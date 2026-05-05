<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialValidation\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Result of live-probing a credential against its configured MCP server.
 *
 * @phpstan-import-type ManagedAgentsMCPProbeShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPProbe
 * @phpstan-import-type ManagedAgentsRefreshObjectShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsRefreshObject
 *
 * @phpstan-type ManagedAgentsCredentialValidationShape = array{
 *   credentialID: string,
 *   hasRefreshToken: bool,
 *   mcpProbe: null|ManagedAgentsMCPProbe|ManagedAgentsMCPProbeShape,
 *   refresh: null|ManagedAgentsRefreshObject|ManagedAgentsRefreshObjectShape,
 *   status: ManagedAgentsCredentialValidationStatus|value-of<ManagedAgentsCredentialValidationStatus>,
 *   type: Type|value-of<Type>,
 *   validatedAt: \DateTimeInterface,
 *   vaultID: string,
 * }
 */
final class ManagedAgentsCredentialValidation implements BaseModel
{
    /** @use SdkModel<ManagedAgentsCredentialValidationShape> */
    use SdkModel;

    /**
     * Unique identifier of the credential that was validated.
     */
    #[Required('credential_id')]
    public string $credentialID;

    /**
     * Whether the credential has a refresh token configured.
     */
    #[Required('has_refresh_token')]
    public bool $hasRefreshToken;

    /**
     * The failing step of an MCP validation probe.
     */
    #[Required('mcp_probe')]
    public ?ManagedAgentsMCPProbe $mcpProbe;

    /**
     * Outcome of a refresh-token exchange attempted during credential validation.
     */
    #[Required]
    public ?ManagedAgentsRefreshObject $refresh;

    /**
     * Overall verdict of a credential validation probe.
     *
     * @var value-of<ManagedAgentsCredentialValidationStatus> $status
     */
    #[Required(enum: ManagedAgentsCredentialValidationStatus::class)]
    public string $status;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('validated_at')]
    public \DateTimeInterface $validatedAt;

    /**
     * Identifier of the vault containing the credential.
     */
    #[Required('vault_id')]
    public string $vaultID;

    /**
     * `new ManagedAgentsCredentialValidation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsCredentialValidation::with(
     *   credentialID: ...,
     *   hasRefreshToken: ...,
     *   mcpProbe: ...,
     *   refresh: ...,
     *   status: ...,
     *   type: ...,
     *   validatedAt: ...,
     *   vaultID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsCredentialValidation)
     *   ->withCredentialID(...)
     *   ->withHasRefreshToken(...)
     *   ->withMCPProbe(...)
     *   ->withRefresh(...)
     *   ->withStatus(...)
     *   ->withType(...)
     *   ->withValidatedAt(...)
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
     * @param ManagedAgentsMCPProbe|ManagedAgentsMCPProbeShape|null $mcpProbe
     * @param ManagedAgentsRefreshObject|ManagedAgentsRefreshObjectShape|null $refresh
     * @param ManagedAgentsCredentialValidationStatus|value-of<ManagedAgentsCredentialValidationStatus> $status
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $credentialID,
        bool $hasRefreshToken,
        ManagedAgentsMCPProbe|array|null $mcpProbe,
        ManagedAgentsRefreshObject|array|null $refresh,
        ManagedAgentsCredentialValidationStatus|string $status,
        Type|string $type,
        \DateTimeInterface $validatedAt,
        string $vaultID,
    ): self {
        $self = new self;

        $self['credentialID'] = $credentialID;
        $self['hasRefreshToken'] = $hasRefreshToken;
        $self['mcpProbe'] = $mcpProbe;
        $self['refresh'] = $refresh;
        $self['status'] = $status;
        $self['type'] = $type;
        $self['validatedAt'] = $validatedAt;
        $self['vaultID'] = $vaultID;

        return $self;
    }

    /**
     * Unique identifier of the credential that was validated.
     */
    public function withCredentialID(string $credentialID): self
    {
        $self = clone $this;
        $self['credentialID'] = $credentialID;

        return $self;
    }

    /**
     * Whether the credential has a refresh token configured.
     */
    public function withHasRefreshToken(bool $hasRefreshToken): self
    {
        $self = clone $this;
        $self['hasRefreshToken'] = $hasRefreshToken;

        return $self;
    }

    /**
     * The failing step of an MCP validation probe.
     *
     * @param ManagedAgentsMCPProbe|ManagedAgentsMCPProbeShape|null $mcpProbe
     */
    public function withMCPProbe(
        ManagedAgentsMCPProbe|array|null $mcpProbe
    ): self {
        $self = clone $this;
        $self['mcpProbe'] = $mcpProbe;

        return $self;
    }

    /**
     * Outcome of a refresh-token exchange attempted during credential validation.
     *
     * @param ManagedAgentsRefreshObject|ManagedAgentsRefreshObjectShape|null $refresh
     */
    public function withRefresh(
        ManagedAgentsRefreshObject|array|null $refresh
    ): self {
        $self = clone $this;
        $self['refresh'] = $refresh;

        return $self;
    }

    /**
     * Overall verdict of a credential validation probe.
     *
     * @param ManagedAgentsCredentialValidationStatus|value-of<ManagedAgentsCredentialValidationStatus> $status
     */
    public function withStatus(
        ManagedAgentsCredentialValidationStatus|string $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

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
     * A timestamp in RFC 3339 format.
     */
    public function withValidatedAt(\DateTimeInterface $validatedAt): self
    {
        $self = clone $this;
        $self['validatedAt'] = $validatedAt;

        return $self;
    }

    /**
     * Identifier of the vault containing the credential.
     */
    public function withVaultID(string $vaultID): self
    {
        $self = clone $this;
        $self['vaultID'] = $vaultID;

        return $self;
    }
}
