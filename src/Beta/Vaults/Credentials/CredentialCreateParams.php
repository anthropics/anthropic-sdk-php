<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Vaults\Credentials\CredentialCreateParams\Auth;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Credential.
 *
 * @see Anthropic\Services\Beta\Vaults\CredentialsService::create()
 *
 * @phpstan-import-type AuthVariants from \Anthropic\Beta\Vaults\Credentials\CredentialCreateParams\Auth
 * @phpstan-import-type AuthShape from \Anthropic\Beta\Vaults\Credentials\CredentialCreateParams\Auth
 *
 * @phpstan-type CredentialCreateParamsShape = array{
 *   auth: AuthShape,
 *   displayName?: string|null,
 *   metadata?: array<string,string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CredentialCreateParams implements BaseModel
{
    /** @use SdkModel<CredentialCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Authentication details for creating a credential.
     *
     * @var AuthVariants $auth
     */
    #[Required(union: Auth::class)]
    public ManagedAgentsMCPOAuthCreateParams|ManagedAgentsStaticBearerCreateParams $auth;

    /**
     * Human-readable name for the credential. Up to 255 characters.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * Arbitrary key-value metadata to attach to the credential. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new CredentialCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CredentialCreateParams::with(auth: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CredentialCreateParams)->withAuth(...)
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
     * @param array<string,string>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ManagedAgentsMCPOAuthCreateParams|array|ManagedAgentsStaticBearerCreateParams $auth,
        ?string $displayName = null,
        ?array $metadata = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['auth'] = $auth;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Authentication details for creating a credential.
     *
     * @param AuthShape $auth
     */
    public function withAuth(
        ManagedAgentsMCPOAuthCreateParams|array|ManagedAgentsStaticBearerCreateParams $auth,
    ): self {
        $self = clone $this;
        $self['auth'] = $auth;

        return $self;
    }

    /**
     * Human-readable name for the credential. Up to 255 characters.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Arbitrary key-value metadata to attach to the credential. Maximum 16 pairs, keys up to 64 chars, values up to 512 chars.
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
