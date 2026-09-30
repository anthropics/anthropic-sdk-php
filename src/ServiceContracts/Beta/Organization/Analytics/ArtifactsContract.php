<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsArtifactActivity;
use Anthropic\Beta\Organization\Analytics\Artifacts\ArtifactListParams\GroupBy;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ArtifactsContract
{
    /**
     * @api
     *
     * @param string $date UTC date in YYYY-MM-DD format. The day to get artifact activity for. Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     * @param list<string>|null $filter Filters as `dimension:value`, e.g. `filter[]=rbac_group_id:{id}`. Repeat the param for OR within a dimension and across dimensions for AND. Supported dimensions on this endpoint: `artifact_type`, `is_shared`, `product`, `rbac_group_id`, `user_id`. Value forms: `artifact_type` is a canonical artifact MIME type (e.g. `text/markdown`) or `other`; `is_shared` is `true` or `false`; `product` is `chat`, `claude_code`, or `cowork` (the surfaces that create artifacts); `rbac_group_id` takes the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each covered UTC day (time-of-usage attribution); `user_id` takes a tagged user id (`user_...`), as emitted in responses. An unsupported dimension returns 400. At most 100 entries.
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy Dimensions to break results out by: `product`, `user_id` and/or `rbac_group_id`. The ungrouped artifact-type cube is finite and returned in full; grouped queries multiply the cube and paginate via `next_page`. `product` takes the values `chat`, `claude_code`, or `cowork` (the surfaces that create artifacts). `rbac_group_id` attributes a user to every group they held at any point during the requested UTC day, so grouped rows are not an exclusive partition. At most 100 entries.
     * @param int|null $limit Maximum rows to return (1-1000, default 100). The ungrouped artifact-type cube is finite and returned in full; `limit` is the page size only when `group_by[]` multiplies the cube.
     * @param string|null $page Opaque cursor from a previous response's `next_page` field. Only valid with `group_by[]` — the ungrouped cube is never paginated.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<AnalyticsArtifactActivity>
     *
     * @throws APIException
     */
    public function list(
        string $date,
        ?array $filter = null,
        ?array $groupBy = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
