<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\Organization\Plugins\Plugin\CreatedBy;
use Anthropic\Beta\Organization\Plugins\Plugin\OrganizationInstallationPreference;
use Anthropic\Beta\Organization\Plugins\Plugin\Owner;
use Anthropic\Beta\Organization\Plugins\Plugin\Reach;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type CreatedByVariants from \Anthropic\Beta\Organization\Plugins\Plugin\CreatedBy
 * @phpstan-import-type OwnerVariants from \Anthropic\Beta\Organization\Plugins\Plugin\Owner
 * @phpstan-import-type PluginComponentShape from \Anthropic\Beta\Organization\Plugins\PluginComponent
 * @phpstan-import-type PluginContentScanShape from \Anthropic\Beta\Organization\Plugins\PluginContentScan
 * @phpstan-import-type CreatedByShape from \Anthropic\Beta\Organization\Plugins\Plugin\CreatedBy
 * @phpstan-import-type OwnerShape from \Anthropic\Beta\Organization\Plugins\Plugin\Owner
 *
 * @phpstan-type PluginShape = array{
 *   id: string,
 *   components: list<PluginComponent|PluginComponentShape>|null,
 *   contentScan: null|PluginContentScan|PluginContentScanShape,
 *   createdAt: \DateTimeInterface,
 *   createdBy: CreatedByShape|null,
 *   description: string|null,
 *   displayName: string|null,
 *   latestVersionID: string,
 *   manifestVersion: string|null,
 *   marketplaceID: string,
 *   name: string,
 *   organizationInstallationPreference: null|OrganizationInstallationPreference|value-of<OrganizationInstallationPreference>,
 *   organizationInstallationPreferenceInherited: bool|null,
 *   owner: OwnerShape,
 *   reach: null|Reach|value-of<Reach>,
 *   servedVersionID: string,
 *   servedVersionPinned: bool,
 *   type: 'plugin',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class Plugin implements BaseModel
{
    /** @use SdkModel<PluginShape> */
    use SdkModel;

    /**
     * Always `plugin`.
     *
     * @var 'plugin' $type
     */
    #[Required(type: new ConstantOf('plugin'))]
    public string $type = 'plugin';

    /**
     * The Plugin's ID.
     */
    #[Required]
    public string $id;

    /**
     * What the served version contains; null when not enumerated.
     *
     * @var list<PluginComponent>|null $components
     */
    #[Required(list: PluginComponent::class)]
    public ?array $components;

    /**
     * The served version's content scan; null when it has not been scanned.
     */
    #[Required('content_scan')]
    public ?PluginContentScan $contentScan;

    /**
     * RFC 3339.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Who created the Plugin; null when no creator is recorded.
     *
     * @var CreatedByVariants|null $createdBy
     */
    #[Required('created_by', union: CreatedBy::class)]
    public PluginUserActor|PluginAPIActor|null $createdBy;

    /**
     * The served version's description.
     */
    #[Required]
    public ?string $description;

    /**
     * The served version's display name.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /**
     * The newest version.
     */
    #[Required('latest_version_id')]
    public string $latestVersionID;

    /**
     * The version string the served version's manifest declares.
     */
    #[Required('manifest_version')]
    public ?string $manifestVersion;

    /**
     * The ID of the plugin marketplace the Plugin lives in.
     */
    #[Required('marketplace_id')]
    public string $marketplaceID;

    /**
     * Lowercase identifier, unique within its plugin marketplace. Fixed for an organization-owned Plugin's lifetime; a member-owned Plugin's changes when its owner renames it in claude.ai, while its `id` stays the same.
     */
    #[Required]
    public string $name;

    /**
     * Organization-owned Plugin: the organization-wide installation setting every member gets unless an RBAC Group they belong to holds its own — the Plugin's own setting, or its plugin marketplace's default. Null for a member-owned Plugin, which has shares instead. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
     *
     * @var value-of<OrganizationInstallationPreference>|null $organizationInstallationPreference
     */
    #[Required(
        'organization_installation_preference',
        enum: OrganizationInstallationPreference::class,
    )]
    public ?string $organizationInstallationPreference;

    /**
     * Organization-owned Plugin: true while it has no organization-wide setting of its own and `organization_installation_preference` is its plugin marketplace's default. Null for a member-owned Plugin.
     */
    #[Required('organization_installation_preference_inherited')]
    public ?bool $organizationInstallationPreferenceInherited;

    /**
     * Who owns the Plugin: the organization, or the member whose personal plugin marketplace it lives in.
     *
     * @var OwnerVariants $owner
     */
    #[Required(union: Owner::class)]
    public PluginOwnerOrganization|PluginOwnerUser $owner;

    /**
     * How far the served version reaches: `remote` when it declares an MCP server or a CLI, `privileged` when it declares a hook, monitor, language server or settings but nothing remote, `contained` otherwise; null when not classifiable.
     *
     * @var value-of<Reach>|null $reach
     */
    #[Required(enum: Reach::class)]
    public ?string $reach;

    /**
     * The version claude.ai serves to members.
     */
    #[Required('served_version_id')]
    public string $servedVersionID;

    /**
     * False while the served version follows each new version; true once it has been pinned to one.
     */
    #[Required('served_version_pinned')]
    public bool $servedVersionPinned;

    /**
     * RFC 3339. Moves on a new version and on a served-version change; a change to the Plugin's installation settings or shares does not move it.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new Plugin()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Plugin::with(
     *   id: ...,
     *   components: ...,
     *   contentScan: ...,
     *   createdAt: ...,
     *   createdBy: ...,
     *   description: ...,
     *   displayName: ...,
     *   latestVersionID: ...,
     *   manifestVersion: ...,
     *   marketplaceID: ...,
     *   name: ...,
     *   organizationInstallationPreference: ...,
     *   organizationInstallationPreferenceInherited: ...,
     *   owner: ...,
     *   reach: ...,
     *   servedVersionID: ...,
     *   servedVersionPinned: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Plugin)
     *   ->withID(...)
     *   ->withComponents(...)
     *   ->withContentScan(...)
     *   ->withCreatedAt(...)
     *   ->withCreatedBy(...)
     *   ->withDescription(...)
     *   ->withDisplayName(...)
     *   ->withLatestVersionID(...)
     *   ->withManifestVersion(...)
     *   ->withMarketplaceID(...)
     *   ->withName(...)
     *   ->withOrganizationInstallationPreference(...)
     *   ->withOrganizationInstallationPreferenceInherited(...)
     *   ->withOwner(...)
     *   ->withReach(...)
     *   ->withServedVersionID(...)
     *   ->withServedVersionPinned(...)
     *   ->withUpdatedAt(...)
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
     * @param list<PluginComponent|PluginComponentShape>|null $components
     * @param PluginContentScan|PluginContentScanShape|null $contentScan
     * @param CreatedByShape|null $createdBy
     * @param OrganizationInstallationPreference|value-of<OrganizationInstallationPreference>|null $organizationInstallationPreference
     * @param OwnerShape $owner
     * @param Reach|value-of<Reach>|null $reach
     */
    public static function with(
        string $id,
        ?array $components,
        PluginContentScan|array|null $contentScan,
        \DateTimeInterface $createdAt,
        PluginUserActor|array|PluginAPIActor|null $createdBy,
        ?string $description,
        ?string $displayName,
        string $latestVersionID,
        ?string $manifestVersion,
        string $marketplaceID,
        string $name,
        OrganizationInstallationPreference|string|null $organizationInstallationPreference,
        ?bool $organizationInstallationPreferenceInherited,
        PluginOwnerOrganization|array|PluginOwnerUser $owner,
        Reach|string|null $reach,
        string $servedVersionID,
        bool $servedVersionPinned,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['components'] = $components;
        $self['contentScan'] = $contentScan;
        $self['createdAt'] = $createdAt;
        $self['createdBy'] = $createdBy;
        $self['description'] = $description;
        $self['displayName'] = $displayName;
        $self['latestVersionID'] = $latestVersionID;
        $self['manifestVersion'] = $manifestVersion;
        $self['marketplaceID'] = $marketplaceID;
        $self['name'] = $name;
        $self['organizationInstallationPreference'] = $organizationInstallationPreference;
        $self['organizationInstallationPreferenceInherited'] = $organizationInstallationPreferenceInherited;
        $self['owner'] = $owner;
        $self['reach'] = $reach;
        $self['servedVersionID'] = $servedVersionID;
        $self['servedVersionPinned'] = $servedVersionPinned;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The Plugin's ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * What the served version contains; null when not enumerated.
     *
     * @param list<PluginComponent|PluginComponentShape>|null $components
     */
    public function withComponents(?array $components): self
    {
        $self = clone $this;
        $self['components'] = $components;

        return $self;
    }

    /**
     * The served version's content scan; null when it has not been scanned.
     *
     * @param PluginContentScan|PluginContentScanShape|null $contentScan
     */
    public function withContentScan(
        PluginContentScan|array|null $contentScan
    ): self {
        $self = clone $this;
        $self['contentScan'] = $contentScan;

        return $self;
    }

    /**
     * RFC 3339.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Who created the Plugin; null when no creator is recorded.
     *
     * @param CreatedByShape|null $createdBy
     */
    public function withCreatedBy(
        PluginUserActor|array|PluginAPIActor|null $createdBy
    ): self {
        $self = clone $this;
        $self['createdBy'] = $createdBy;

        return $self;
    }

    /**
     * The served version's description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The served version's display name.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * The newest version.
     */
    public function withLatestVersionID(string $latestVersionID): self
    {
        $self = clone $this;
        $self['latestVersionID'] = $latestVersionID;

        return $self;
    }

    /**
     * The version string the served version's manifest declares.
     */
    public function withManifestVersion(?string $manifestVersion): self
    {
        $self = clone $this;
        $self['manifestVersion'] = $manifestVersion;

        return $self;
    }

    /**
     * The ID of the plugin marketplace the Plugin lives in.
     */
    public function withMarketplaceID(string $marketplaceID): self
    {
        $self = clone $this;
        $self['marketplaceID'] = $marketplaceID;

        return $self;
    }

    /**
     * Lowercase identifier, unique within its plugin marketplace. Fixed for an organization-owned Plugin's lifetime; a member-owned Plugin's changes when its owner renames it in claude.ai, while its `id` stays the same.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Organization-owned Plugin: the organization-wide installation setting every member gets unless an RBAC Group they belong to holds its own — the Plugin's own setting, or its plugin marketplace's default. Null for a member-owned Plugin, which has shares instead. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
     *
     * @param OrganizationInstallationPreference|value-of<OrganizationInstallationPreference>|null $organizationInstallationPreference
     */
    public function withOrganizationInstallationPreference(
        OrganizationInstallationPreference|string|null $organizationInstallationPreference,
    ): self {
        $self = clone $this;
        $self['organizationInstallationPreference'] = $organizationInstallationPreference;

        return $self;
    }

    /**
     * Organization-owned Plugin: true while it has no organization-wide setting of its own and `organization_installation_preference` is its plugin marketplace's default. Null for a member-owned Plugin.
     */
    public function withOrganizationInstallationPreferenceInherited(
        ?bool $organizationInstallationPreferenceInherited
    ): self {
        $self = clone $this;
        $self['organizationInstallationPreferenceInherited'] = $organizationInstallationPreferenceInherited;

        return $self;
    }

    /**
     * Who owns the Plugin: the organization, or the member whose personal plugin marketplace it lives in.
     *
     * @param OwnerShape $owner
     */
    public function withOwner(
        PluginOwnerOrganization|array|PluginOwnerUser $owner
    ): self {
        $self = clone $this;
        $self['owner'] = $owner;

        return $self;
    }

    /**
     * How far the served version reaches: `remote` when it declares an MCP server or a CLI, `privileged` when it declares a hook, monitor, language server or settings but nothing remote, `contained` otherwise; null when not classifiable.
     *
     * @param Reach|value-of<Reach>|null $reach
     */
    public function withReach(Reach|string|null $reach): self
    {
        $self = clone $this;
        $self['reach'] = $reach;

        return $self;
    }

    /**
     * The version claude.ai serves to members.
     */
    public function withServedVersionID(string $servedVersionID): self
    {
        $self = clone $this;
        $self['servedVersionID'] = $servedVersionID;

        return $self;
    }

    /**
     * False while the served version follows each new version; true once it has been pinned to one.
     */
    public function withServedVersionPinned(bool $servedVersionPinned): self
    {
        $self = clone $this;
        $self['servedVersionPinned'] = $servedVersionPinned;

        return $self;
    }

    /**
     * Always `plugin`.
     *
     * @param 'plugin' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * RFC 3339. Moves on a new version and on a served-version change; a change to the Plugin's installation settings or shares does not move it.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
