<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Organization\ExternalKeys\ExternalKeyCreateParams\Geo;
use Anthropic\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig;

/**
 * Create an external key config owned by the caller's organization.
 *
 * @see Anthropic\Services\Organization\ExternalKeysService::create()
 *
 * @phpstan-import-type ProviderConfigShape from \Anthropic\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 * @phpstan-import-type ProviderConfigVariants from \Anthropic\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig
 *
 * @phpstan-type ExternalKeyCreateParamsShape = array{
 *   providerConfig: ProviderConfigShape,
 *   displayName?: string|null,
 *   geo?: null|Geo|value-of<Geo>,
 *   userProfileID?: string|null,
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
     * ID of a user profile to bind the key to. Omit this field for a key that isn't bound to a user profile. Such a key can be attached to a Workspace whatever its user profile. The binding cannot be changed later. A key bound to a user profile can only be attached to a Workspace that has the same user profile.
     */
    #[Optional('user_profile_id', nullable: true)]
    public ?string $userProfileID;

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
     * (new ExternalKeyCreateParams())->withProviderConfig(...)
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
        ?string $userProfileID = null,
    ): self {
        $self = new self;

        $self['providerConfig'] = $providerConfig;

        null !== $displayName && $self['displayName'] = $displayName;
        null !== $geo && $self['geo'] = $geo;
        null !== $userProfileID && $self['userProfileID'] = $userProfileID;

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

    /**
     * ID of a user profile to bind the key to. Omit this field for a key that isn't bound to a user profile. Such a key can be attached to a Workspace whatever its user profile. The binding cannot be changed later. A key bound to a user profile can only be attached to a Workspace that has the same user profile.
     */
    public function withUserProfileID(?string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }
}
