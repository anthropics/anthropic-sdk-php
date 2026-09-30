<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\PluginListParams\OwnerType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the Plugins created under the organization, newest first: those in the
 * organization's own plugin marketplaces and those in members' personal plugin
 * marketplaces.
 *
 * Plugins in members' personal marketplaces are listed with the same detail as the
 * organization's own, and their files can be downloaded through the version archive
 * endpoint, which records each such download on the Compliance API activity feed.
 *
 * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginsService::list()
 *
 * @phpstan-type PluginListParamsShape = array{
 *   createdAtGt?: \DateTimeInterface|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLt?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   limit?: int|null,
 *   marketplaceID?: string|null,
 *   organizationID?: string|null,
 *   ownerType?: null|OwnerType|value-of<OwnerType>,
 *   ownerUserID?: string|null,
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginListParams implements BaseModel
{
    /** @use SdkModel<PluginListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $createdAtGt;

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $createdAtLt;

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Only Plugins in this plugin marketplace (prefixed `marketplace_`).
     */
    #[Optional(nullable: true)]
    public ?string $marketplaceID;

    /**
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    #[Optional(nullable: true)]
    public ?string $organizationID;

    /**
     * `organization` for Plugins in the organization's plugin marketplaces, `user` for Plugins in members' personal plugin marketplaces.
     *
     * @var value-of<OwnerType>|null $ownerType
     */
    #[Optional(enum: OwnerType::class, nullable: true)]
    public ?string $ownerType;

    /**
     * Only Plugins in this member's personal plugin marketplaces (prefixed `user_`); a removed member's ID is accepted.
     */
    #[Optional(nullable: true)]
    public ?string $ownerUserID;

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param OwnerType|value-of<OwnerType>|null $ownerType
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ?string $marketplaceID = null,
        ?string $organizationID = null,
        OwnerType|string|null $ownerType = null,
        ?string $ownerUserID = null,
        ?string $page = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $createdAtGt && $self['createdAtGt'] = $createdAtGt;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLt && $self['createdAtLt'] = $createdAtLt;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $limit && $self['limit'] = $limit;
        null !== $marketplaceID && $self['marketplaceID'] = $marketplaceID;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $ownerType && $self['ownerType'] = $ownerType;
        null !== $ownerUserID && $self['ownerUserID'] = $ownerUserID;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    public function withCreatedAtGt(?\DateTimeInterface $createdAtGt): self
    {
        $self = clone $this;
        $self['createdAtGt'] = $createdAtGt;

        return $self;
    }

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    public function withCreatedAtGte(?\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    public function withCreatedAtLt(?\DateTimeInterface $createdAtLt): self
    {
        $self = clone $this;
        $self['createdAtLt'] = $createdAtLt;

        return $self;
    }

    /**
     * RFC 3339 timestamp bound; combine [gte], [gt], [lte], [lt].
     */
    public function withCreatedAtLte(?\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Only Plugins in this plugin marketplace (prefixed `marketplace_`).
     */
    public function withMarketplaceID(?string $marketplaceID): self
    {
        $self = clone $this;
        $self['marketplaceID'] = $marketplaceID;

        return $self;
    }

    /**
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * `organization` for Plugins in the organization's plugin marketplaces, `user` for Plugins in members' personal plugin marketplaces.
     *
     * @param OwnerType|value-of<OwnerType>|null $ownerType
     */
    public function withOwnerType(OwnerType|string|null $ownerType): self
    {
        $self = clone $this;
        $self['ownerType'] = $ownerType;

        return $self;
    }

    /**
     * Only Plugins in this member's personal plugin marketplaces (prefixed `user_`); a removed member's ID is accepted.
     */
    public function withOwnerUserID(?string $ownerUserID): self
    {
        $self = clone $this;
        $self['ownerUserID'] = $ownerUserID;

        return $self;
    }

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `ce-plugins-2026-09-01` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
