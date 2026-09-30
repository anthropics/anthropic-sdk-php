<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\OwnerType;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams\Source;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the plugin marketplaces Plugins live in, newest first: the organization's own
 * and its members' personal ones.
 *
 * Plugin marketplaces are created, connected to a repository and deleted in
 * claude.ai, not through this API. The organization's library marketplace, the
 * organization-owned `manual` marketplace that uploads go to when no marketplace is
 * named, is created the first time something is put in it and is listed from then on.
 *
 * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\PluginMarketplacesService::list()
 *
 * @phpstan-type PluginMarketplaceListParamsShape = array{
 *   limit?: int|null,
 *   organizationID?: string|null,
 *   ownerType?: null|OwnerType|value-of<OwnerType>,
 *   page?: string|null,
 *   source?: null|Source|value-of<Source>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class PluginMarketplaceListParams implements BaseModel
{
    /** @use SdkModel<PluginMarketplaceListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    #[Optional(nullable: true)]
    public ?string $organizationID;

    /**
     * `organization` for the organization's plugin marketplaces, `user` for members' personal plugin marketplaces.
     *
     * @var value-of<OwnerType>|null $ownerType
     */
    #[Optional(enum: OwnerType::class, nullable: true)]
    public ?string $ownerType;

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Only plugin marketplaces with this `source`: `manual` for those whose Plugins are uploaded; `github`, `gitlab` or `public_git` for those synchronized from a Git repository. `directory` (Anthropic's catalog) is never listed here.
     *
     * @var value-of<Source>|null $source
     */
    #[Optional(enum: Source::class, nullable: true)]
    public ?string $source;

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
     * @param Source|value-of<Source>|null $source
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $organizationID = null,
        OwnerType|string|null $ownerType = null,
        ?string $page = null,
        Source|string|null $source = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $ownerType && $self['ownerType'] = $ownerType;
        null !== $page && $self['page'] = $page;
        null !== $source && $self['source'] = $source;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `1000`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
     * `organization` for the organization's plugin marketplaces, `user` for members' personal plugin marketplaces.
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
     * Optionally set to the `next_page` token from the previous response.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Only plugin marketplaces with this `source`: `manual` for those whose Plugins are uploaded; `github`, `gitlab` or `public_git` for those synchronized from a Git repository. `directory` (Anthropic's catalog) is never listed here.
     *
     * @param Source|value-of<Source>|null $source
     */
    public function withSource(Source|string|null $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

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
