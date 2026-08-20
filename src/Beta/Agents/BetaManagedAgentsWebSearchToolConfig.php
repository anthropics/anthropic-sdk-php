<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfig\PermissionPolicy;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for the web_search tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfig\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfig\PermissionPolicy
 * @phpstan-import-type BetaManagedAgentsUserLocationShape from \Anthropic\Beta\Agents\BetaManagedAgentsUserLocation
 *
 * @phpstan-type BetaManagedAgentsWebSearchToolConfigShape = array{
 *   enabled: bool,
 *   name: 'web_search',
 *   permissionPolicy: PermissionPolicyShape,
 *   type: 'web_search',
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   userLocation?: null|BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape,
 * }
 */
final class BetaManagedAgentsWebSearchToolConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebSearchToolConfigShape> */
    use SdkModel;

    /** @var 'web_search' $name */
    #[Required]
    public string $name = 'web_search';

    /** @var 'web_search' $type */
    #[Required]
    public string $type = 'web_search';

    #[Required]
    public bool $enabled;

    /**
     * Permission policy for tool execution.
     *
     * @var PermissionPolicyVariants $permissionPolicy
     */
    #[Required('permission_policy', union: PermissionPolicy::class)]
    public BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy;

    /** @var list<string>|null $allowedDomains */
    #[Optional('allowed_domains', list: 'string')]
    public ?array $allowedDomains;

    /** @var list<string>|null $blockedDomains */
    #[Optional('blocked_domains', list: 'string')]
    public ?array $blockedDomains;

    /**
     * Approximate user location for search result localization.
     */
    #[Optional('user_location', nullable: true)]
    public ?BetaManagedAgentsUserLocation $userLocation;

    /**
     * `new BetaManagedAgentsWebSearchToolConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWebSearchToolConfig::with(enabled: ..., permissionPolicy: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWebSearchToolConfig)
     *   ->withEnabled(...)
     *   ->withPermissionPolicy(...)
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
     * @param PermissionPolicyShape $permissionPolicy
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape|null $userLocation
     */
    public static function with(
        bool $enabled,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        BetaManagedAgentsUserLocation|array|null $userLocation = null,
    ): self {
        $self = new self;

        $self['enabled'] = $enabled;
        $self['permissionPolicy'] = $permissionPolicy;

        null !== $allowedDomains && $self['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $self['blockedDomains'] = $blockedDomains;
        null !== $userLocation && $self['userLocation'] = $userLocation;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * @param 'web_search' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Permission policy for tool execution.
     *
     * @param PermissionPolicyShape $permissionPolicy
     */
    public function withPermissionPolicy(
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy,
    ): self {
        $self = clone $this;
        $self['permissionPolicy'] = $permissionPolicy;

        return $self;
    }

    /**
     * @param 'web_search' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param list<string> $allowedDomains
     */
    public function withAllowedDomains(array $allowedDomains): self
    {
        $self = clone $this;
        $self['allowedDomains'] = $allowedDomains;

        return $self;
    }

    /**
     * @param list<string> $blockedDomains
     */
    public function withBlockedDomains(array $blockedDomains): self
    {
        $self = clone $this;
        $self['blockedDomains'] = $blockedDomains;

        return $self;
    }

    /**
     * Approximate user location for search result localization.
     *
     * @param BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape|null $userLocation
     */
    public function withUserLocation(
        BetaManagedAgentsUserLocation|array|null $userLocation
    ): self {
        $self = clone $this;
        $self['userLocation'] = $userLocation;

        return $self;
    }
}
