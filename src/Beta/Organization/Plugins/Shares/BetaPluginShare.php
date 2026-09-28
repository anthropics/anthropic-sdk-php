<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Shares;

use Anthropic\Beta\Organization\Plugins\PluginTargetOrganization;
use Anthropic\Beta\Organization\Plugins\PluginTargetOrganizationMember;
use Anthropic\Beta\Organization\Plugins\PluginTargetRBACGroup;
use Anthropic\Beta\Organization\Plugins\Shares\BetaPluginShare\Target;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One share the owner of a member-owned Plugin has given. Shares are
 * read-only in this API and have no ID of their own; who gave a share is
 * recorded on the Compliance API activity feed, not here.
 *
 * @phpstan-import-type TargetVariants from \Anthropic\Beta\Organization\Plugins\Shares\BetaPluginShare\Target
 * @phpstan-import-type TargetShape from \Anthropic\Beta\Organization\Plugins\Shares\BetaPluginShare\Target
 *
 * @phpstan-type BetaPluginShareShape = array{
 *   grantedAt: \DateTimeInterface,
 *   pluginID: string,
 *   target: TargetShape,
 *   type: 'plugin_share',
 * }
 */
final class BetaPluginShare implements BaseModel
{
    /** @use SdkModel<BetaPluginShareShape> */
    use SdkModel;

    /**
     * Always `plugin_share`.
     *
     * @var 'plugin_share' $type
     */
    #[Required(type: new ConstantOf('plugin_share'))]
    public string $type = 'plugin_share';

    /**
     * When the share was given; a share whose role is later changed in claude.ai is re-granted and carries the time of that change.
     */
    #[Required('granted_at')]
    public \DateTimeInterface $grantedAt;

    /**
     * The Plugin's ID.
     */
    #[Required('plugin_id')]
    public string $pluginID;

    /**
     * Who the Plugin is shared with: `organization` (every member), `rbac_group` (one RBAC Group), or `organization_member` (one member).
     *
     * @var TargetVariants $target
     */
    #[Required(union: Target::class)]
    public PluginTargetOrganization|PluginTargetRBACGroup|PluginTargetOrganizationMember $target;

    /**
     * `new BetaPluginShare()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaPluginShare::with(grantedAt: ..., pluginID: ..., target: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaPluginShare)->withGrantedAt(...)->withPluginID(...)->withTarget(...)
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
     * @param TargetShape $target
     */
    public static function with(
        \DateTimeInterface $grantedAt,
        string $pluginID,
        PluginTargetOrganization|array|PluginTargetRBACGroup|PluginTargetOrganizationMember $target,
    ): self {
        $self = new self;

        $self['grantedAt'] = $grantedAt;
        $self['pluginID'] = $pluginID;
        $self['target'] = $target;

        return $self;
    }

    /**
     * When the share was given; a share whose role is later changed in claude.ai is re-granted and carries the time of that change.
     */
    public function withGrantedAt(\DateTimeInterface $grantedAt): self
    {
        $self = clone $this;
        $self['grantedAt'] = $grantedAt;

        return $self;
    }

    /**
     * The Plugin's ID.
     */
    public function withPluginID(string $pluginID): self
    {
        $self = clone $this;
        $self['pluginID'] = $pluginID;

        return $self;
    }

    /**
     * Who the Plugin is shared with: `organization` (every member), `rbac_group` (one RBAC Group), or `organization_member` (one member).
     *
     * @param TargetShape $target
     */
    public function withTarget(
        PluginTargetOrganization|array|PluginTargetRBACGroup|PluginTargetOrganizationMember $target,
    ): self {
        $self = clone $this;
        $self['target'] = $target;

        return $self;
    }

    /**
     * Always `plugin_share`.
     *
     * @param 'plugin_share' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
