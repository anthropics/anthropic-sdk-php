<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\MapOf;

/**
 * Update Vault.
 *
 * @see Anthropic\Services\Beta\VaultsService::update()
 *
 * @phpstan-type VaultUpdateParamsShape = array{
 *   displayName?: string|null,
 *   metadata?: array<string,string|null>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class VaultUpdateParams implements BaseModel
{
    /** @use SdkModel<VaultUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Updated human-readable name for the vault. 1-255 characters.
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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string|null>|null $metadata
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $displayName = null,
        ?array $metadata = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Updated human-readable name for the vault. 1-255 characters.
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
