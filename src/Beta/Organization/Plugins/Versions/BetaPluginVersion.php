<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Versions;

use Anthropic\Beta\Organization\Plugins\PluginAPIActor;
use Anthropic\Beta\Organization\Plugins\PluginComponent;
use Anthropic\Beta\Organization\Plugins\PluginContentScan;
use Anthropic\Beta\Organization\Plugins\PluginUserActor;
use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion\CreatedBy;
use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion\Reach;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type PluginComponentShape from \Anthropic\Beta\Organization\Plugins\PluginComponent
 * @phpstan-import-type PluginContentScanShape from \Anthropic\Beta\Organization\Plugins\PluginContentScan
 * @phpstan-import-type CreatedByShape from \Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion\CreatedBy
 * @phpstan-import-type CreatedByVariants from \Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion\CreatedBy
 *
 * @phpstan-type BetaPluginVersionShape = array{
 *   id: string,
 *   components: list<PluginComponent|PluginComponentShape>|null,
 *   contentScan: null|PluginContentScan|PluginContentScanShape,
 *   createdAt: \DateTimeInterface,
 *   createdBy: CreatedByShape|null,
 *   description: string|null,
 *   displayName: string|null,
 *   manifestVersion: string|null,
 *   pluginID: string,
 *   reach: null|Reach|value-of<Reach>,
 *   releaseNotes: string|null,
 *   type: 'plugin_version',
 * }
 */
final class BetaPluginVersion implements BaseModel
{
    /** @use SdkModel<BetaPluginVersionShape> */
    use SdkModel;

    /**
     * Always `plugin_version`.
     *
     * @var 'plugin_version' $type
     */
    #[Required(type: new ConstantOf('plugin_version'))]
    public string $type = 'plugin_version';

    /**
     * The version's ID.
     */
    #[Required]
    public string $id;

    /**
     * What the version contains; null when not enumerated.
     *
     * @var list<PluginComponent>|null $components
     */
    #[Required(list: PluginComponent::class)]
    public ?array $components;

    /**
     * This version's content scan; null when it has not been scanned.
     */
    #[Required('content_scan')]
    public ?PluginContentScan $contentScan;

    /**
     * RFC 3339.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Who uploaded this version; null when not recorded.
     *
     * @var CreatedByVariants|null $createdBy
     */
    #[Required('created_by', union: CreatedBy::class)]
    public PluginUserActor|PluginAPIActor|null $createdBy;

    /**
     * The manifest's description; null when it declares none.
     */
    #[Required]
    public ?string $description;

    /**
     * The manifest's display name; null when it declares none.
     */
    #[Required('display_name')]
    public ?string $displayName;

    /**
     * The version string the manifest declares; null when it declares none.
     */
    #[Required('manifest_version')]
    public ?string $manifestVersion;

    /**
     * The Plugin's ID.
     */
    #[Required('plugin_id')]
    public string $pluginID;

    /**
     * How far the version reaches: `remote`, `privileged` or `contained`, as on the Plugin; null when not classifiable.
     *
     * @var value-of<Reach>|null $reach
     */
    #[Required(enum: Reach::class)]
    public ?string $reach;

    /**
     * As supplied with the upload; null when none were supplied.
     */
    #[Required('release_notes')]
    public ?string $releaseNotes;

    /**
     * `new BetaPluginVersion()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaPluginVersion::with(
     *   id: ...,
     *   components: ...,
     *   contentScan: ...,
     *   createdAt: ...,
     *   createdBy: ...,
     *   description: ...,
     *   displayName: ...,
     *   manifestVersion: ...,
     *   pluginID: ...,
     *   reach: ...,
     *   releaseNotes: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaPluginVersion())
     *   ->withID(...)
     *   ->withComponents(...)
     *   ->withContentScan(...)
     *   ->withCreatedAt(...)
     *   ->withCreatedBy(...)
     *   ->withDescription(...)
     *   ->withDisplayName(...)
     *   ->withManifestVersion(...)
     *   ->withPluginID(...)
     *   ->withReach(...)
     *   ->withReleaseNotes(...)
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
        ?string $manifestVersion,
        string $pluginID,
        Reach|string|null $reach,
        ?string $releaseNotes,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['components'] = $components;
        $self['contentScan'] = $contentScan;
        $self['createdAt'] = $createdAt;
        $self['createdBy'] = $createdBy;
        $self['description'] = $description;
        $self['displayName'] = $displayName;
        $self['manifestVersion'] = $manifestVersion;
        $self['pluginID'] = $pluginID;
        $self['reach'] = $reach;
        $self['releaseNotes'] = $releaseNotes;

        return $self;
    }

    /**
     * The version's ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * What the version contains; null when not enumerated.
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
     * This version's content scan; null when it has not been scanned.
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
     * Who uploaded this version; null when not recorded.
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
     * The manifest's description; null when it declares none.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * The manifest's display name; null when it declares none.
     */
    public function withDisplayName(?string $displayName): self
    {
        $self = clone $this;
        $self['displayName'] = $displayName;

        return $self;
    }

    /**
     * The version string the manifest declares; null when it declares none.
     */
    public function withManifestVersion(?string $manifestVersion): self
    {
        $self = clone $this;
        $self['manifestVersion'] = $manifestVersion;

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
     * How far the version reaches: `remote`, `privileged` or `contained`, as on the Plugin; null when not classifiable.
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
     * As supplied with the upload; null when none were supplied.
     */
    public function withReleaseNotes(?string $releaseNotes): self
    {
        $self = clone $this;
        $self['releaseNotes'] = $releaseNotes;

        return $self;
    }

    /**
     * Always `plugin_version`.
     *
     * @param 'plugin_version' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
