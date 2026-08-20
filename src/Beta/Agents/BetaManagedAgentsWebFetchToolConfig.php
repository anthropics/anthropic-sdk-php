<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfig\PermissionPolicy;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for the web_fetch tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfig\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfig\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsWebFetchToolConfigShape = array{
 *   enabled: bool,
 *   name: 'web_fetch',
 *   permissionPolicy: PermissionPolicyShape,
 *   type: 'web_fetch',
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   maxContentTokens?: int|null,
 * }
 */
final class BetaManagedAgentsWebFetchToolConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchToolConfigShape> */
    use SdkModel;

    /** @var 'web_fetch' $name */
    #[Required]
    public string $name = 'web_fetch';

    /** @var 'web_fetch' $type */
    #[Required]
    public string $type = 'web_fetch';

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

    #[Optional('max_content_tokens', nullable: true)]
    public ?int $maxContentTokens;

    /**
     * `new BetaManagedAgentsWebFetchToolConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsWebFetchToolConfig::with(enabled: ..., permissionPolicy: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsWebFetchToolConfig)
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
     */
    public static function with(
        bool $enabled,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?int $maxContentTokens = null,
    ): self {
        $self = new self;

        $self['enabled'] = $enabled;
        $self['permissionPolicy'] = $permissionPolicy;

        null !== $allowedDomains && $self['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $self['blockedDomains'] = $blockedDomains;
        null !== $maxContentTokens && $self['maxContentTokens'] = $maxContentTokens;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * @param 'web_fetch' $name
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
     * @param 'web_fetch' $type
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

    public function withMaxContentTokens(?int $maxContentTokens): self
    {
        $self = clone $this;
        $self['maxContentTokens'] = $maxContentTokens;

        return $self;
    }
}
