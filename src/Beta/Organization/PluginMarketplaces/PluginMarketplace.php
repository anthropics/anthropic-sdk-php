<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\DefaultInstallationPreference;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\Owner;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\Source;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\SyncStatus;
use Anthropic\Beta\Organization\Plugins\PluginOwnerOrganization;
use Anthropic\Beta\Organization\Plugins\PluginOwnerUser;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type OwnerVariants from \Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\Owner
 * @phpstan-import-type OwnerShape from \Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\Owner
 *
 * @phpstan-type PluginMarketplaceShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   defaultInstallationPreference: null|DefaultInstallationPreference|value-of<DefaultInstallationPreference>,
 *   lastSyncEndedAt: \DateTimeInterface|null,
 *   lastSyncReadSha: string|null,
 *   name: string,
 *   owner: OwnerShape,
 *   source: Source|value-of<Source>,
 *   syncStatus: null|SyncStatus|value-of<SyncStatus>,
 *   type: 'plugin_marketplace',
 * }
 */
final class PluginMarketplace implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceShape> */
    use SdkModel;

    /**
     * Always `plugin_marketplace`.
     *
     * @var 'plugin_marketplace' $type
     */
    #[Required(type: new ConstantOf('plugin_marketplace'))]
    public string $type = 'plugin_marketplace';

    /**
     * The plugin marketplace's ID, prefixed `marketplace_`.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Organization plugin marketplace: the organization-wide setting every Plugin in it with no setting of its own gets. Null for a member's personal plugin marketplace. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
     *
     * @var value-of<DefaultInstallationPreference>|null $defaultInstallationPreference
     */
    #[Required(
        'default_installation_preference',
        enum: DefaultInstallationPreference::class,
    )]
    public ?string $defaultInstallationPreference;

    /**
     * RFC 3339. When the most recent synchronization attempt to finish did so, whatever its outcome; for a repository plugin marketplace no synchronization has run on yet, when it was created. Null for a plugin marketplace that is not synchronized from a repository.
     */
    #[Required('last_sync_ended_at')]
    public ?\DateTimeInterface $lastSyncEndedAt;

    /**
     * The commit the last synchronization attempt that reached the repository read, whether or not its content was then accepted (see `sync_status`); an attempt that ends `failed_auth` or `failed_transient` leaves it unchanged. Null until an attempt has first read the repository, and for a plugin marketplace that is not synchronized from a repository.
     */
    #[Required('last_sync_read_sha')]
    public ?string $lastSyncReadSha;

    /**
     * Fixed for the plugin marketplace's lifetime.
     */
    #[Required]
    public string $name;

    /**
     * The organization, or the member whose personal plugin marketplace it is.
     *
     * @var OwnerVariants $owner
     */
    #[Required(union: Owner::class)]
    public PluginOwnerOrganization|PluginOwnerUser $owner;

    /**
     * Where the plugin marketplace's Plugins come from: `manual` when they are uploaded; `github`, `gitlab` or `public_git` when they are synchronized from the Git repository the owner connected, into which nothing can be uploaded; `directory` is Anthropic's own catalog, which this API does not list. A value this API does not yet name is returned as stored.
     *
     * @var value-of<Source> $source
     */
    #[Required(enum: Source::class)]
    public string $source;

    /**
     * Outcome of the plugin marketplace's most recent synchronization: one of `success`, `in_progress`, `failed_content`, `failed_transient`, `failed_auth`, `failed_limits`; a value this API does not yet name is returned as stored. Null until a synchronization is first attempted — so always for a `manual` plugin marketplace.
     *
     * @var value-of<SyncStatus>|null $syncStatus
     */
    #[Required('sync_status', enum: SyncStatus::class)]
    public ?string $syncStatus;

    /**
     * `new PluginMarketplace()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginMarketplace::with(
     *   id: ...,
     *   createdAt: ...,
     *   defaultInstallationPreference: ...,
     *   lastSyncEndedAt: ...,
     *   lastSyncReadSha: ...,
     *   name: ...,
     *   owner: ...,
     *   source: ...,
     *   syncStatus: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginMarketplace)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDefaultInstallationPreference(...)
     *   ->withLastSyncEndedAt(...)
     *   ->withLastSyncReadSha(...)
     *   ->withName(...)
     *   ->withOwner(...)
     *   ->withSource(...)
     *   ->withSyncStatus(...)
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
     * @param DefaultInstallationPreference|value-of<DefaultInstallationPreference>|null $defaultInstallationPreference
     * @param OwnerShape $owner
     * @param Source|value-of<Source> $source
     * @param SyncStatus|value-of<SyncStatus>|null $syncStatus
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        DefaultInstallationPreference|string|null $defaultInstallationPreference,
        ?\DateTimeInterface $lastSyncEndedAt,
        ?string $lastSyncReadSha,
        string $name,
        PluginOwnerOrganization|array|PluginOwnerUser $owner,
        Source|string $source,
        SyncStatus|string|null $syncStatus,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['defaultInstallationPreference'] = $defaultInstallationPreference;
        $self['lastSyncEndedAt'] = $lastSyncEndedAt;
        $self['lastSyncReadSha'] = $lastSyncReadSha;
        $self['name'] = $name;
        $self['owner'] = $owner;
        $self['source'] = $source;
        $self['syncStatus'] = $syncStatus;

        return $self;
    }

    /**
     * The plugin marketplace's ID, prefixed `marketplace_`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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
     * Organization plugin marketplace: the organization-wide setting every Plugin in it with no setting of its own gets. Null for a member's personal plugin marketplace. One of `required`, `auto_install`, `available`, `not_available`; a value this API does not yet name is returned as stored.
     *
     * @param DefaultInstallationPreference|value-of<DefaultInstallationPreference>|null $defaultInstallationPreference
     */
    public function withDefaultInstallationPreference(
        DefaultInstallationPreference|string|null $defaultInstallationPreference
    ): self {
        $self = clone $this;
        $self['defaultInstallationPreference'] = $defaultInstallationPreference;

        return $self;
    }

    /**
     * RFC 3339. When the most recent synchronization attempt to finish did so, whatever its outcome; for a repository plugin marketplace no synchronization has run on yet, when it was created. Null for a plugin marketplace that is not synchronized from a repository.
     */
    public function withLastSyncEndedAt(
        ?\DateTimeInterface $lastSyncEndedAt
    ): self {
        $self = clone $this;
        $self['lastSyncEndedAt'] = $lastSyncEndedAt;

        return $self;
    }

    /**
     * The commit the last synchronization attempt that reached the repository read, whether or not its content was then accepted (see `sync_status`); an attempt that ends `failed_auth` or `failed_transient` leaves it unchanged. Null until an attempt has first read the repository, and for a plugin marketplace that is not synchronized from a repository.
     */
    public function withLastSyncReadSha(?string $lastSyncReadSha): self
    {
        $self = clone $this;
        $self['lastSyncReadSha'] = $lastSyncReadSha;

        return $self;
    }

    /**
     * Fixed for the plugin marketplace's lifetime.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * The organization, or the member whose personal plugin marketplace it is.
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
     * Where the plugin marketplace's Plugins come from: `manual` when they are uploaded; `github`, `gitlab` or `public_git` when they are synchronized from the Git repository the owner connected, into which nothing can be uploaded; `directory` is Anthropic's own catalog, which this API does not list. A value this API does not yet name is returned as stored.
     *
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Outcome of the plugin marketplace's most recent synchronization: one of `success`, `in_progress`, `failed_content`, `failed_transient`, `failed_auth`, `failed_limits`; a value this API does not yet name is returned as stored. Null until a synchronization is first attempted — so always for a `manual` plugin marketplace.
     *
     * @param SyncStatus|value-of<SyncStatus>|null $syncStatus
     */
    public function withSyncStatus(SyncStatus|string|null $syncStatus): self
    {
        $self = clone $this;
        $self['syncStatus'] = $syncStatus;

        return $self;
    }

    /**
     * Always `plugin_marketplace`.
     *
     * @param 'plugin_marketplace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
