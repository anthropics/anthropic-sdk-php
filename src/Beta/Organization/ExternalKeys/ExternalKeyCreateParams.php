<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys;

use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\Geo;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create an external key config owned by the caller's organization.
 *
 * @see Anthropic\Services\Beta\Organization\ExternalKeysService::create()
 *
 * @phpstan-import-type ProviderConfigVariants from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 *
 * @phpstan-type ExternalKeyCreateParamsShape = array{
 *   providerConfig: ProviderConfigShape,
 *   displayName?: string|null,
 *   geo?: null|Geo|value-of<Geo>,
 * }
 */
final class ExternalKeyCreateParams implements BaseModel
{
    /** @use SdkModel<ExternalKeyCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * KMS provider identity and auth coordinates.
     *
     * @var ProviderConfigVariants $providerConfig
     */
    #[Required('provider_config', union: ProviderConfig::class)]
    public AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfigParam $providerConfig;

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
    #[Optional(enum: Geo::class)]
    public ?string $geo;

    /**
     * `new ExternalKeyCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExternalKeyCreateParams::with(providerConfig: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExternalKeyCreateParams)->withProviderConfig(...)
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
     * @param ProviderConfigShape $providerConfig
     * @param Geo|value-of<Geo>|null $geo
     */
    public static function with(
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam $providerConfig,
        ?string $displayName = null,
        Geo|string|null $geo = null,
    ): self {
        $self = new self;

        $self['providerConfig'] = $providerConfig;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $geo && $self['geo'] = $geo;

        return $self;
    }

    /**
     * KMS provider identity and auth coordinates.
     *
     * @param ProviderConfigShape $providerConfig
     */
    public function withProviderConfig(
        AWSExternalKeyConfig|array|GCPExternalKeyConfig|AzureExternalKeyConfigParam $providerConfig,
    ): self {
        $self = clone $this;
        $self['providerConfig'] = $providerConfig;

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
     * @param Geo|value-of<Geo> $geo
     */
    public function withGeo(Geo|string $geo): self
    {
        $self = clone $this;
        $self['geo'] = $geo;

        return $self;
    }
}
