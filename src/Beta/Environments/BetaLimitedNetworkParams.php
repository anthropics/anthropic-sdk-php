<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Limited network request params.
 *
 * Fields default to null; on update, omitted fields preserve the
 * existing value.
 *
 * @phpstan-type BetaLimitedNetworkParamsShape = array{
 *   type: 'limited',
 *   allowMCPServers?: bool|null,
 *   allowPackageManagers?: bool|null,
 *   allowedHosts?: list<string>|null,
 * }
 */
final class BetaLimitedNetworkParams implements BaseModel
{
    /** @use SdkModel<BetaLimitedNetworkParamsShape> */
    use SdkModel;

    /**
     * Network policy type.
     *
     * @var 'limited' $type
     */
    #[Required]
    public string $type = 'limited';

    /**
     * Permits outbound access to MCP server endpoints configured on the agent, beyond those listed in the `allowed_hosts` array. Defaults to `false`.
     */
    #[Optional('allow_mcp_servers', nullable: true)]
    public ?bool $allowMCPServers;

    /**
     * Permits outbound access to public package registries (PyPI, npm, etc.) beyond those listed in the `allowed_hosts` array. Defaults to `false`.
     */
    #[Optional('allow_package_managers', nullable: true)]
    public ?bool $allowPackageManagers;

    /**
     * Specifies domains the container can reach.
     *
     * @var list<string>|null $allowedHosts
     */
    #[Optional('allowed_hosts', list: 'string', nullable: true)]
    public ?array $allowedHosts;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedHosts
     */
    public static function with(
        ?bool $allowMCPServers = null,
        ?bool $allowPackageManagers = null,
        ?array $allowedHosts = null,
    ): self {
        $self = new self;

        null !== $allowMCPServers && $self['allowMCPServers'] = $allowMCPServers;
        null !== $allowPackageManagers && $self['allowPackageManagers'] = $allowPackageManagers;
        null !== $allowedHosts && $self['allowedHosts'] = $allowedHosts;

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

    /**
     * Permits outbound access to MCP server endpoints configured on the agent, beyond those listed in the `allowed_hosts` array. Defaults to `false`.
     */
    public function withAllowMCPServers(?bool $allowMCPServers): self
    {
        $self = clone $this;
        $self['allowMCPServers'] = $allowMCPServers;

        return $self;
    }

    /**
     * Permits outbound access to public package registries (PyPI, npm, etc.) beyond those listed in the `allowed_hosts` array. Defaults to `false`.
     */
    public function withAllowPackageManagers(?bool $allowPackageManagers): self
    {
        $self = clone $this;
        $self['allowPackageManagers'] = $allowPackageManagers;

        return $self;
    }

    /**
     * Specifies domains the container can reach.
     *
     * @param list<string>|null $allowedHosts
     */
    public function withAllowedHosts(?array $allowedHosts): self
    {
        $self = clone $this;
        $self['allowedHosts'] = $allowedHosts;

        return $self;
    }
}
