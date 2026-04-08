<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Delete Credential.
 *
 * @see Anthropic\Services\Beta\Vaults\CredentialsService::delete()
 *
 * @phpstan-type CredentialDeleteParamsShape = array{
 *   vaultID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CredentialDeleteParams implements BaseModel
{
    /** @use SdkModel<CredentialDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $vaultID;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new CredentialDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CredentialDeleteParams::with(vaultID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CredentialDeleteParams)->withVaultID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(string $vaultID, ?array $betas = null): self
    {
        $self = new self;

        $self['vaultID'] = $vaultID;

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
