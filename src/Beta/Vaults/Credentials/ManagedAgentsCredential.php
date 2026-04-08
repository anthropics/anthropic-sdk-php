<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential\Auth;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A credential stored in a vault. Sensitive fields are never returned in responses.
 *
 * @phpstan-import-type AuthVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential\Auth
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential\Auth
 *
 * @phpstan-type ManagedAgentsCredentialShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   auth: AuthShape,
 *   createdAt: \DateTimeInterface,
 *   metadata: array<string,string>,
 *   type: Type|value-of<Type>,
 *   updatedAt: \DateTimeInterface,
 *   vaultID: string,
 *   displayName?: string|null,
 * }
 */
final class ManagedAgentsCredential implements BaseModel
{
    /** @use SdkModel<ManagedAgentsCredentialShape> */
    use SdkModel;

    /**
     * Unique identifier for the credential.
     */
    #[Required]
    public string $id;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * Authentication details for a credential.
     *
     * @var AuthVariants $auth
     */
    #[Required(union: Auth::class)]
    public ManagedAgentsMCPOAuthAuthResponse|ManagedAgentsStaticBearerAuthResponse $auth;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Arbitrary key-value metadata attached to the credential.
     *
     * @var array<string,string> $metadata
     */
    #[Required(map: 'string')]
    public array $metadata;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A timestamp in RFC 3339 format.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Identifier of the vault this credential belongs to.
     */
    #[Required('vault_id')]
    public string $vaultID;

    /**
     * Human-readable name for the credential.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * `new ManagedAgentsCredential()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsCredential::with(
     *   id: ...,
     *   archivedAt: ...,
     *   auth: ...,
     *   createdAt: ...,
     *   metadata: ...,
     *   type: ...,
     *   updatedAt: ...,
     *   vaultID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsCredential)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withAuth(...)
     *   ->withCreatedAt(...)
     *   ->withMetadata(...)
     *   ->withType(...)
     *   ->withUpdatedAt(...)
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
     * @param AuthShape $auth
     * @param array<string,string> $metadata
     * @param Type|value-of<Type> $type
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ManagedAgentsMCPOAuthAuthResponse|array|ManagedAgentsStaticBearerAuthResponse $auth,
        \DateTimeInterface $createdAt,
        array $metadata,
        Type|string $type,
        \DateTimeInterface $updatedAt,
        string $vaultID,
        ?string $displayName = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['auth'] = $auth;
        $self['createdAt'] = $createdAt;
        $self['metadata'] = $metadata;
        $self['type'] = $type;
        $self['updatedAt'] = $updatedAt;
        $self['vaultID'] = $vaultID;

        null !== $displayName && $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Unique identifier for the credential.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * Authentication details for a credential.
     *
     * @param AuthShape $auth
     */
    public function withAuth(
        ManagedAgentsMCPOAuthAuthResponse|array|ManagedAgentsStaticBearerAuthResponse $auth,
    ): self {
        $self = clone $this;
        $self['auth'] = $auth;

        return $self;
    }

    /**
     * A timestamp in RFC 3339 format.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Arbitrary key-value metadata attached to the credential.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

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
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Identifier of the vault this credential belongs to.
     */
    public function withVaultID(string $vaultID): self
    {
        $self = clone $this;
        $self['vaultID'] = $vaultID;

        return $self;
    }

    /**
     * Human-readable name for the credential.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }
}
