<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Substitute the secret only on requests to the listed hosts.
 *
 * @phpstan-type ManagedAgentsLimitedCredentialNetworkingParamsShape = array{
 *   allowedHosts: list<string>, type: 'limited'
 * }
 */
final class ManagedAgentsLimitedCredentialNetworkingParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsLimitedCredentialNetworkingParamsShape> */
    use SdkModel;

    /** @var 'limited' $type */
    #[Required(type: new ConstantOf('limited'))]
    public string $type = 'limited';

    /**
     * The destination hosts of the outbound requests that the credential's secret is substituted into.
     *
     * Each entry is a bare hostname (`api.example.com`), an IPv4 address (`192.0.2.1`), or a `*.` wildcard (`*.example.com`). URLs, ports, paths, and IPv6 addresses aren't accepted. The list can have up to 16 entries.
     *
     * @var list<string> $allowedHosts
     */
    #[Required('allowed_hosts', list: 'string')]
    public array $allowedHosts;

    /**
     * `new ManagedAgentsLimitedCredentialNetworkingParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsLimitedCredentialNetworkingParams::with(allowedHosts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsLimitedCredentialNetworkingParams())->withAllowedHosts(...)
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
     * @param list<string> $allowedHosts
     */
    public static function with(array $allowedHosts): self
    {
        $self = new self;

        $self['allowedHosts'] = $allowedHosts;

        return $self;
    }

    /**
     * The destination hosts of the outbound requests that the credential's secret is substituted into.
     *
     * Each entry is a bare hostname (`api.example.com`), an IPv4 address (`192.0.2.1`), or a `*.` wildcard (`*.example.com`). URLs, ports, paths, and IPv6 addresses aren't accepted. The list can have up to 16 entries.
     *
     * @param list<string> $allowedHosts
     */
    public function withAllowedHosts(array $allowedHosts): self
    {
        $self = clone $this;
        $self['allowedHosts'] = $allowedHosts;

        return $self;
    }

    /**
     * @param 'limited' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
