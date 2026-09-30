<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Shares;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Plugins\Shares\ShareListParams\TargetType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the shares the owner of a member-owned Plugin has given — to every member of
 * the organization, to an RBAC Group, or to one member — most recently granted first.
 *
 * Shares are read-only in this API: members give and withdraw them in claude.ai, and
 * who gave a share is recorded on the Compliance API activity feed rather than on the
 * share. An organization-owned Plugin has installation settings instead, so this path
 * returns 404 for one.
 *
 * **Accepted credentials:** an Admin API key with the `read:plugins` or `read:org_audit` scope, or a Compliance Access Key with the `read:compliance_org_data` scope.
 *
 * Every request must include the beta header `anthropic-beta: ce-plugins-2026-09-01`. A request without it returns `404`, exactly as if the endpoint did not exist. The Plugins API is in beta and is available to Claude Enterprise organizations only. It is not available to Claude Platform (Claude Console) organizations, or to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\Plugins\SharesService::list()
 *
 * @phpstan-type ShareListParamsShape = array{
 *   limit?: int|null,
 *   organizationID?: string|null,
 *   page?: string|null,
 *   targetType?: null|TargetType|value-of<TargetType>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ShareListParams implements BaseModel
{
    /** @use SdkModel<ShareListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of items to return per page.
     *
     * Defaults to `20`. Ranges from `1` to `100`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    #[Optional(nullable: true)]
    public ?string $organizationID;

    /**
     * Optionally set to the `next_page` token from the previous response.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Only shares with this kind of target: `organization` (every member), `rbac_group` (one RBAC Group), or `organization_member` (one member).
     *
     * @var value-of<TargetType>|null $targetType
     */
    #[Optional(enum: TargetType::class, nullable: true)]
    public ?string $targetType;

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
     * @param TargetType|value-of<TargetType>|null $targetType
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $organizationID = null,
        ?string $page = null,
        TargetType|string|null $targetType = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $organizationID && $self['organizationID'] = $organizationID;
        null !== $page && $self['page'] = $page;
        null !== $targetType && $self['targetType'] = $targetType;
        null !== $betas && $self['betas'] = $betas;

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
     * For a `read:org_audit` or `read:compliance_org_data` key created for all of a parent organization's linked organizations: a child organization of that parent to read instead of the organization the key was created in, given as the organization's UUID or its `org_`-prefixed ID. A value that is neither returns a 400; an organization that is not a child of the key's parent, or where the Plugins API is not available, returns a 404. Any other key may pass only its own organization's ID here; another organization returns a 404.
     */
    public function withOrganizationID(?string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

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
     * Only shares with this kind of target: `organization` (every member), `rbac_group` (one RBAC Group), or `organization_member` (one member).
     *
     * @param TargetType|value-of<TargetType>|null $targetType
     */
    public function withTargetType(TargetType|string|null $targetType): self
    {
        $self = clone $this;
        $self['targetType'] = $targetType;

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
