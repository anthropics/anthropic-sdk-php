<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\Environments\BetaCloudConfigParams\Networking;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Request params for `cloud` environment configuration.
 *
 * Fields default to null; on update, omitted fields preserve the
 * existing value.
 *
 * @phpstan-import-type NetworkingShape from \Anthropic\Beta\Environments\BetaCloudConfigParams\Networking
 * @phpstan-import-type BetaPackagesParamsShape from \Anthropic\Beta\Environments\BetaPackagesParams
 * @phpstan-import-type NetworkingVariants from \Anthropic\Beta\Environments\BetaCloudConfigParams\Networking
 *
 * @phpstan-type BetaCloudConfigParamsShape = array{
 *   type: 'cloud',
 *   networking?: NetworkingShape|null,
 *   packages?: null|BetaPackagesParams|BetaPackagesParamsShape,
 * }
 */
final class BetaCloudConfigParams implements BaseModel
{
    /** @use SdkModel<BetaCloudConfigParamsShape> */
    use SdkModel;

    /**
     * Environment type.
     *
     * @var 'cloud' $type
     */
    #[Required(type: new ConstantOf('cloud'))]
    public string $type = 'cloud';

    /**
     * Network configuration policy. Omit on update to preserve the existing value.
     *
     * @var NetworkingVariants|null $networking
     */
    #[Optional(union: Networking::class, nullable: true)]
    public BetaUnrestrictedNetwork|BetaLimitedNetworkParams|null $networking;

    /**
     * Package manager configuration. Under `limited` networking, requires `networking.allow_package_managers` to be `true`. Omit on update to preserve the existing value.
     */
    #[Optional(nullable: true)]
    public ?BetaPackagesParams $packages;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param NetworkingShape|null $networking
     * @param BetaPackagesParams|BetaPackagesParamsShape|null $packages
     */
    public static function with(
        BetaUnrestrictedNetwork|array|BetaLimitedNetworkParams|null $networking = null,
        BetaPackagesParams|array|null $packages = null,
    ): self {
        $self = new self;

        null !== $networking && $self['networking'] = $networking;
        null !== $packages && $self['packages'] = $packages;

        return $self;
    }

    /**
     * Environment type.
     *
     * @param 'cloud' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Network configuration policy. Omit on update to preserve the existing value.
     *
     * @param NetworkingShape|null $networking
     */
    public function withNetworking(
        BetaUnrestrictedNetwork|array|BetaLimitedNetworkParams|null $networking
    ): self {
        $self = clone $this;
        $self['networking'] = $networking;

        return $self;
    }

    /**
     * Package manager configuration. Under `limited` networking, requires `networking.allow_package_managers` to be `true`. Omit on update to preserve the existing value.
     *
     * @param BetaPackagesParams|BetaPackagesParamsShape|null $packages
     */
    public function withPackages(BetaPackagesParams|array|null $packages): self
    {
        $self = clone $this;
        $self['packages'] = $packages;

        return $self;
    }
}
