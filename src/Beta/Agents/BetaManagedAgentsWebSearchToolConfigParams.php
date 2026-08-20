<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams\PermissionPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration override for the web_search tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams\PermissionPolicy
 * @phpstan-import-type BetaManagedAgentsUserLocationShape from \Anthropic\Beta\Agents\BetaManagedAgentsUserLocation
 *
 * @phpstan-type BetaManagedAgentsWebSearchToolConfigParamsShape = array{
 *   name: 'web_search',
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   enabled?: bool|null,
 *   permissionPolicy?: PermissionPolicyShape|null,
 *   type?: null|Type|value-of<Type>,
 *   userLocation?: null|BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape,
 * }
 */
final class BetaManagedAgentsWebSearchToolConfigParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebSearchToolConfigParamsShape> */
    use SdkModel;

    /**
     * Must be "web_search".
     *
     * @var 'web_search' $name
     */
    #[Required]
    public string $name = 'web_search';

    /**
     * Only return search results whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "docs.example.com" (no scheme or port; an optional path suffix is accepted). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with blocked_domains.
     *
     * @var list<string>|null $allowedDomains
     */
    #[Optional('allowed_domains', list: 'string')]
    public ?array $allowedDomains;

    /**
     * Never return search results whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "ads.example.com" (no scheme or port; an optional path suffix is accepted). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with allowed_domains.
     *
     * @var list<string>|null $blockedDomains
     */
    #[Optional('blocked_domains', list: 'string')]
    public ?array $blockedDomains;

    /**
     * Whether this tool is enabled and available to Claude. Overrides the default_config setting.
     */
    #[Optional(nullable: true)]
    public ?bool $enabled;

    /**
     * Permission policy for tool execution.
     *
     * @var PermissionPolicyVariants|null $permissionPolicy
     */
    #[Optional(
        'permission_policy',
        union: PermissionPolicy::class,
        nullable: true
    )]
    public BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy;

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class)]
    public ?string $type;

    /**
     * Approximate user location for search result localization.
     */
    #[Optional('user_location', nullable: true)]
    public ?BetaManagedAgentsUserLocation $userLocation;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param PermissionPolicyShape|null $permissionPolicy
     * @param Type|value-of<Type>|null $type
     * @param BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape|null $userLocation
     */
    public static function with(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?bool $enabled = null,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy = null,
        Type|string|null $type = null,
        BetaManagedAgentsUserLocation|array|null $userLocation = null,
    ): self {
        $self = new self;

        null !== $allowedDomains && $self['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $self['blockedDomains'] = $blockedDomains;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $permissionPolicy && $self['permissionPolicy'] = $permissionPolicy;
        null !== $type && $self['type'] = $type;
        null !== $userLocation && $self['userLocation'] = $userLocation;

        return $self;
    }

    /**
     * Must be "web_search".
     *
     * @param 'web_search' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Only return search results whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "docs.example.com" (no scheme or port; an optional path suffix is accepted). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with blocked_domains.
     *
     * @param list<string> $allowedDomains
     */
    public function withAllowedDomains(array $allowedDomains): self
    {
        $self = clone $this;
        $self['allowedDomains'] = $allowedDomains;

        return $self;
    }

    /**
     * Never return search results whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "ads.example.com" (no scheme or port; an optional path suffix is accepted). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with allowed_domains.
     *
     * @param list<string> $blockedDomains
     */
    public function withBlockedDomains(array $blockedDomains): self
    {
        $self = clone $this;
        $self['blockedDomains'] = $blockedDomains;

        return $self;
    }

    /**
     * Whether this tool is enabled and available to Claude. Overrides the default_config setting.
     */
    public function withEnabled(?bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Permission policy for tool execution.
     *
     * @param PermissionPolicyShape|null $permissionPolicy
     */
    public function withPermissionPolicy(
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy,
    ): self {
        $self = clone $this;
        $self['permissionPolicy'] = $permissionPolicy;

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
