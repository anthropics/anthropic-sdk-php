<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Artifacts;

use Anthropic\Beta\Organization\Analytics\Artifacts\ArtifactListParams\GroupBy;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get artifact-creation activity for a given day, broken out by MIME type.
 *
 * Returns the full (`artifact_type`, `is_shared`) cube for the organization;
 * `next_page` is null except for grouped queries, which paginate. The cube
 * can be broken out per product, per member, or per RBAC group via
 * `group_by[]`, and scoped via `filter[]`. Requires an API key with the
 * `read:analytics` scope.
 *
 * @see Anthropic\Services\Beta\Organization\Analytics\ArtifactsService::list()
 *
 * @phpstan-type ArtifactListParamsShape = array{
 *   date: string,
 *   filter?: list<string>|null,
 *   groupBy?: list<GroupBy|value-of<GroupBy>>|null,
 *   limit?: int|null,
 *   page?: string|null,
 * }
 */
final class ArtifactListParams implements BaseModel
{
    /** @use SdkModel<ArtifactListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * UTC date in YYYY-MM-DD format. The day to get artifact activity for. Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     */
    #[Required]
    public string $date;

    /**
     * Filters as `dimension:value`, e.g. `filter[]=rbac_group_id:{id}`. Repeat the param for OR within a dimension and across dimensions for AND. Supported dimensions on this endpoint: `artifact_type`, `is_shared`, `product`, `rbac_group_id`, `user_id`. Value forms: `artifact_type` is a canonical artifact MIME type (e.g. `text/markdown`) or `other`; `is_shared` is `true` or `false`; `product` is `chat`, `claude_code`, or `cowork` (the surfaces that create artifacts); `rbac_group_id` takes the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each covered UTC day (time-of-usage attribution); `user_id` takes a tagged user id (`user_...`), as emitted in responses. An unsupported dimension returns 400. At most 100 entries.
     *
     * @var list<string>|null $filter
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $filter;

    /**
     * Dimensions to break results out by: `product`, `user_id` and/or `rbac_group_id`. The ungrouped artifact-type cube is finite and returned in full; grouped queries multiply the cube and paginate via `next_page`. `product` takes the values `chat`, `claude_code`, or `cowork` (the surfaces that create artifacts). `rbac_group_id` attributes a user to every group they held at any point during the requested UTC day, so grouped rows are not an exclusive partition. At most 100 entries.
     *
     * @var list<value-of<GroupBy>>|null $groupBy
     */
    #[Optional(list: GroupBy::class, nullable: true)]
    public ?array $groupBy;

    /**
     * Maximum rows to return (1-1000, default 100). The ungrouped artifact-type cube is finite and returned in full; `limit` is the page size only when `group_by[]` multiplies the cube.
     */
    #[Optional(nullable: true)]
    public ?int $limit;

    /**
     * Opaque cursor from a previous response's `next_page` field. Only valid with `group_by[]` — the ungrouped cube is never paginated.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * `new ArtifactListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ArtifactListParams::with(date: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ArtifactListParams())->withDate(...)
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
     * @param list<string>|null $filter
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy
     */
    public static function with(
        string $date,
        ?array $filter = null,
        ?array $groupBy = null,
        ?int $limit = null,
        ?string $page = null,
    ): self {
        $self = new self;

        $self['date'] = $date;

        null !== $filter && $self['filter'] = $filter;
        null !== $groupBy && $self['groupBy'] = $groupBy;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;

        return $self;
    }

    /**
     * UTC date in YYYY-MM-DD format. The day to get artifact activity for. Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     */
    public function withDate(string $date): self
    {
        $self = clone $this;
        $self['date'] = $date;

        return $self;
    }

    /**
     * Filters as `dimension:value`, e.g. `filter[]=rbac_group_id:{id}`. Repeat the param for OR within a dimension and across dimensions for AND. Supported dimensions on this endpoint: `artifact_type`, `is_shared`, `product`, `rbac_group_id`, `user_id`. Value forms: `artifact_type` is a canonical artifact MIME type (e.g. `text/markdown`) or `other`; `is_shared` is `true` or `false`; `product` is `chat`, `claude_code`, or `cowork` (the surfaces that create artifacts); `rbac_group_id` takes the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each covered UTC day (time-of-usage attribution); `user_id` takes a tagged user id (`user_...`), as emitted in responses. An unsupported dimension returns 400. At most 100 entries.
     *
     * @param list<string>|null $filter
     */
    public function withFilter(?array $filter): self
    {
        $self = clone $this;
        $self['filter'] = $filter;

        return $self;
    }

    /**
     * Dimensions to break results out by: `product`, `user_id` and/or `rbac_group_id`. The ungrouped artifact-type cube is finite and returned in full; grouped queries multiply the cube and paginate via `next_page`. `product` takes the values `chat`, `claude_code`, or `cowork` (the surfaces that create artifacts). `rbac_group_id` attributes a user to every group they held at any point during the requested UTC day, so grouped rows are not an exclusive partition. At most 100 entries.
     *
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy
     */
    public function withGroupBy(?array $groupBy): self
    {
        $self = clone $this;
        $self['groupBy'] = $groupBy;

        return $self;
    }

    /**
     * Maximum rows to return (1-1000, default 100). The ungrouped artifact-type cube is finite and returned in full; `limit` is the page size only when `group_by[]` multiplies the cube.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page` field. Only valid with `group_by[]` — the ungrouped cube is never paginated.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
