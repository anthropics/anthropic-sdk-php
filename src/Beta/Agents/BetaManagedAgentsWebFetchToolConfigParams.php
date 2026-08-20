<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams\PermissionPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration override for the web_fetch tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsWebFetchToolConfigParamsShape = array{
 *   name: 'web_fetch',
 *   allowedDomains?: list<string>|null,
 *   blockedDomains?: list<string>|null,
 *   enabled?: bool|null,
 *   maxContentTokens?: int|null,
 *   permissionPolicy?: PermissionPolicyShape|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsWebFetchToolConfigParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsWebFetchToolConfigParamsShape> */
    use SdkModel;

    /**
     * Must be "web_fetch".
     *
     * @var 'web_fetch' $name
     */
    #[Required]
    public string $name = 'web_fetch';

    /**
     * Only fetch URLs whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "docs.example.com" (no scheme, port, or path). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with blocked_domains.
     *
     * @var list<string>|null $allowedDomains
     */
    #[Optional('allowed_domains', list: 'string')]
    public ?array $allowedDomains;

    /**
     * Never fetch URLs whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "ads.example.com" (no scheme, port, or path). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with allowed_domains.
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
     * Maximum number of tokens of fetched text content to include in context per call. Does not apply to binary content such as PDFs.
     */
    #[Optional('max_content_tokens', nullable: true)]
    public ?int $maxContentTokens;

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
     */
    public static function with(
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?bool $enabled = null,
        ?int $maxContentTokens = null,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $allowedDomains && $self['allowedDomains'] = $allowedDomains;
        null !== $blockedDomains && $self['blockedDomains'] = $blockedDomains;
        null !== $enabled && $self['enabled'] = $enabled;
        null !== $maxContentTokens && $self['maxContentTokens'] = $maxContentTokens;
        null !== $permissionPolicy && $self['permissionPolicy'] = $permissionPolicy;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Must be "web_fetch".
     *
     * @param 'web_fetch' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Only fetch URLs whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "docs.example.com" (no scheme, port, or path). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with blocked_domains.
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
     * Never fetch URLs whose host is one of these domains or a subdomain of one. Each entry is a plain hostname like "ads.example.com" (no scheme, port, or path). At most 64 entries; an empty list is rejected (omit the field instead). Cannot be combined with allowed_domains.
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
     * Maximum number of tokens of fetched text content to include in context per call. Does not apply to binary content such as PDFs.
     */
    public function withMaxContentTokens(?int $maxContentTokens): self
    {
        $self = clone $this;
        $self['maxContentTokens'] = $maxContentTokens;

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
}
