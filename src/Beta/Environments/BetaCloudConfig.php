<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Beta\Environments\BetaCloudConfig\Networking;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * `cloud` environment configuration.
 *
 * @phpstan-import-type NetworkingVariants from \Anthropic\Beta\Environments\BetaCloudConfig\Networking
 * @phpstan-import-type NetworkingShape from \Anthropic\Beta\Environments\BetaCloudConfig\Networking
 * @phpstan-import-type BetaPackagesShape from \Anthropic\Beta\Environments\BetaPackages
 *
 * @phpstan-type BetaCloudConfigShape = array{
 *   networking: NetworkingShape,
 *   packages: BetaPackages|BetaPackagesShape,
 *   type: 'cloud',
 * }
 */
final class BetaCloudConfig implements BaseModel
{
    /** @use SdkModel<BetaCloudConfigShape> */
    use SdkModel;

    /**
     * Environment type.
     *
     * @var 'cloud' $type
     */
    #[Required]
    public string $type = 'cloud';

    /**
     * Network configuration policy.
     *
     * @var NetworkingVariants $networking
     */
    #[Required(union: Networking::class)]
    public BetaUnrestrictedNetwork|BetaLimitedNetwork $networking;

    /**
     * Package manager configuration.
     */
    #[Required]
    public BetaPackages $packages;

    /**
     * `new BetaCloudConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCloudConfig::with(networking: ..., packages: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCloudConfig)->withNetworking(...)->withPackages(...)
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
     * @param NetworkingShape $networking
     * @param BetaPackages|BetaPackagesShape $packages
     */
    public static function with(
        BetaUnrestrictedNetwork|array|BetaLimitedNetwork $networking,
        BetaPackages|array $packages,
    ): self {
        $self = new self;

        $self['networking'] = $networking;
        $self['packages'] = $packages;

        return $self;
    }

    /**
     * Network configuration policy.
     *
     * @param NetworkingShape $networking
     */
    public function withNetworking(
        BetaUnrestrictedNetwork|array|BetaLimitedNetwork $networking
    ): self {
        $self = clone $this;
        $self['networking'] = $networking;

        return $self;
    }

    /**
     * Package manager configuration.
     *
     * @param BetaPackages|BetaPackagesShape $packages
     */
    public function withPackages(BetaPackages|array $packages): self
    {
        $self = clone $this;
        $self['packages'] = $packages;

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
}
