<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Limited network access.
 *
 * @phpstan-type BetaLimitedNetworkShape = array{
 *   allowMCPServers: bool,
 *   allowPackageManagers: bool,
 *   allowedHosts: list<string>,
 *   type: 'limited',
 * }
 */
final class BetaLimitedNetwork implements BaseModel
{
    /** @use SdkModel<BetaLimitedNetworkShape> */
    use SdkModel;

    /**
     * Network policy type.
     *
     * @var 'limited' $type
     */
    #[Required]
    public string $type = 'limited';

    /**
     * Permits outbound access to MCP server endpoints configured on the agent, beyond those listed in the `allowed_hosts` array.
     */
    #[Required('allow_mcp_servers')]
    public bool $allowMCPServers;

    /**
     * Permits outbound access to public package registries (PyPI, npm, etc.) beyond those listed in the `allowed_hosts` array.
     */
    #[Required('allow_package_managers')]
    public bool $allowPackageManagers;

    /**
     * Specifies domains the container can reach.
     *
     * @var list<string> $allowedHosts
     */
    #[Required('allowed_hosts', list: 'string')]
    public array $allowedHosts;

    /**
     * `new BetaLimitedNetwork()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaLimitedNetwork::with(
     *   allowMCPServers: ..., allowPackageManagers: ..., allowedHosts: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaLimitedNetwork)
     *   ->withAllowMCPServers(...)
     *   ->withAllowPackageManagers(...)
     *   ->withAllowedHosts(...)
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
    public static function with(
        bool $allowMCPServers,
        bool $allowPackageManagers,
        array $allowedHosts
    ): self {
        $self = new self;

        $self['allowMCPServers'] = $allowMCPServers;
        $self['allowPackageManagers'] = $allowPackageManagers;
        $self['allowedHosts'] = $allowedHosts;

        return $self;
    }

    /**
     * Permits outbound access to MCP server endpoints configured on the agent, beyond those listed in the `allowed_hosts` array.
     */
    public function withAllowMCPServers(bool $allowMCPServers): self
    {
        $self = clone $this;
        $self['allowMCPServers'] = $allowMCPServers;

        return $self;
    }

    /**
     * Permits outbound access to public package registries (PyPI, npm, etc.) beyond those listed in the `allowed_hosts` array.
     */
    public function withAllowPackageManagers(bool $allowPackageManagers): self
    {
        $self = clone $this;
        $self['allowPackageManagers'] = $allowPackageManagers;

        return $self;
    }

    /**
     * Specifies domains the container can reach.
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
     * Network policy type.
     *
     * @param 'limited' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
