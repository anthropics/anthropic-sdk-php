<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\Geo;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Partially update an external key config. Omitted fields are left unchanged.
 *
 * `display_name` is always editable. `geo` and `provider_config` cannot
 * be changed once any workspace references this config, because previously
 * encrypted data requires the original key identity to decrypt.
 *
 * @see Anthropic\Services\Beta\Organization\ExternalKeysService::update()
 *
 * @phpstan-import-type ProviderConfigVariants from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyUpdateParams\ProviderConfig
 *
 * @phpstan-type ExternalKeyUpdateParamsShape = array{
 *   displayName?: string|null,
 *   geo?: null|Geo|value-of<Geo>,
 *   providerConfig?: ProviderConfigShape|null,
 * }
 */
final class ExternalKeyUpdateParams implements BaseModel
{
    /** @use SdkModel<ExternalKeyUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Human-friendly display name.
     */
    #[Optional('display_name', nullable: true)]
    public ?string $displayName;

    /**
     * Data residency geo. Only `us` is supported.
     *
     * @var value-of<Geo>|null $geo
     */
    #[Optional(enum: Geo::class, nullable: true)]
    public ?string $geo;

    /**
     * KMS provider identity and auth coordinates.
     *
     * @var ProviderConfigVariants|null $providerConfig
     */
    #[Optional('provider_config', union: ProviderConfig::class, nullable: true)]
    public AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfigParam|null $providerConfig;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Geo|value-of<Geo>|null $geo
     * @param ProviderConfigShape|null $providerConfig
     */
    public static function with(
        ?string $displayName = null,
        Geo|string|null $geo = null,
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam|null $providerConfig = null,
    ): self {
        $self = new self;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $geo && $self['geo'] = $geo;
        null !== $providerConfig && $self['providerConfig'] = $providerConfig;

        return $self;
    }

    /**
     * Human-friendly display name.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * Data residency geo. Only `us` is supported.
     *
     * @param Geo|value-of<Geo>|null $geo
     */
    public function withGeo(Geo|string|null $geo): self
    {
        $self = clone $this;
        $self['geo'] = $geo;

        return $self;
    }

    /**
     * KMS provider identity and auth coordinates.
     *
     * @param ProviderConfigShape|null $providerConfig
     */
    public function withProviderConfig(
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam|null $providerConfig,
    ): self {
        $self = clone $this;
        $self['providerConfig'] = $providerConfig;

        return $self;
    }
}
