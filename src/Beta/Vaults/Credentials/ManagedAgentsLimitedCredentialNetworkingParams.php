<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Substitute the secret only on requests to the listed hosts.
 *
 * @phpstan-type ManagedAgentsLimitedCredentialNetworkingParamsShape = array{
 *   allowedHosts: list<string>, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsLimitedCredentialNetworkingParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsLimitedCredentialNetworkingParamsShape> */
    use SdkModel;

    /**
     * Hostnames on which the secret will be substituted. Each entry is a bare hostname (`api.example.com`), an IPv4 address (`192.0.2.1`), or a `*.`-prefixed wildcard (`*.example.com`). URLs, ports, paths, and IPv6 addresses are not accepted. At most 16 entries.
     *
     * @var list<string> $allowedHosts
     */
    #[Required('allowed_hosts', list: 'string')]
    public array $allowedHosts;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsLimitedCredentialNetworkingParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsLimitedCredentialNetworkingParams::with(
     *   allowedHosts: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsLimitedCredentialNetworkingParams)
     *   ->withAllowedHosts(...)
     *   ->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(array $allowedHosts, Type|string $type): self
    {
        $self = new self;

        $self['allowedHosts'] = $allowedHosts;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Hostnames on which the secret will be substituted. Each entry is a bare hostname (`api.example.com`), an IPv4 address (`192.0.2.1`), or a `*.`-prefixed wildcard (`*.example.com`). URLs, ports, paths, and IPv6 addresses are not accepted. At most 16 entries.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
