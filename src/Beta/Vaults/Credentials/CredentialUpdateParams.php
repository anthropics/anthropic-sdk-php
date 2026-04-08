<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update Credential.
 *
 * @see Anthropic\Services\Beta\Vaults\CredentialsService::update()
 *
 * @phpstan-import-type AuthVariants from \Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth
 *
 * @phpstan-type CredentialUpdateParamsShape = array{
 *   vaultID: string,
 *   auth?: AuthShape|null,
 *   displayName?: string|null,
 *   metadata?: array<string,string|null>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CredentialUpdateParams implements BaseModel
{
    /** @use SdkModel<CredentialUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $vaultID;

    /**
     * Updated authentication details for a credential.
     *
     * @var AuthVariants|null $auth
     */
    #[Optional(union: Auth::class)]
    public ManagedAgentsMCPOAuthUpdateParams|ManagedAgentsStaticBearerUpdateParams|null $auth;

    /**
     * Updated human-readable name for the credential. 1-255 characters.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omitted keys are preserved.
     *
     * @var array<string,string|null>|null $metadata
     */
    #[Optional(type: new MapOf('string', nullable: true), nullable: true)]
    public ?array $metadata;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new CredentialUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CredentialUpdateParams::with(vaultID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CredentialUpdateParams)->withVaultID(...)
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
     * @param AuthShape|null $auth
     * @param array<string,string|null>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $vaultID,
        ManagedAgentsMCPOAuthUpdateParams|array|ManagedAgentsStaticBearerUpdateParams|null $auth = null,
        ?string $displayName = null,
        ?array $metadata = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['vaultID'] = $vaultID;

        null !== $auth && $self['auth'] = $auth;
        null !== $displayName && $self['displayName'] = $displayName;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    public function withVaultID(string $vaultID): self
    {
        $self = clone $this;
        $self['vaultID'] = $vaultID;

        return $self;
    }

    /**
     * Updated authentication details for a credential.
     *
     * @param AuthShape $auth
     */
    public function withAuth(
        ManagedAgentsMCPOAuthUpdateParams|array|ManagedAgentsStaticBearerUpdateParams $auth,
    ): self {
        $self = clone $this;
        $self['auth'] = $auth;

        return $self;
    }

    /**
     * Updated human-readable name for the credential. 1-255 characters.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omitted keys are preserved.
     *
     * @param array<string,string|null>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
