<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Workspaces;

use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitUpdateValue;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type WorkspaceRateLimitUpdateValueShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitUpdateValue
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RateLimitsContract
{
    /**
     * @api
     *
     * @param string $rateLimitID path param: The `id` of the organization's rate-limit entry to set overrides for
     * @param string $workspaceID path param: The ID of the workspace
     * @param list<WorkspaceRateLimitUpdateValue|WorkspaceRateLimitUpdateValueShape> $limits Body param: Limits to set or clear. Unspecified limit types are unchanged.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $rateLimitID,
        string $workspaceID,
        array $limits,
        RequestOptions|array|null $requestOptions = null,
    ): WorkspaceRateLimit;

    /**
     * @api
     *
     * @param string $workspaceID the ID of the workspace
     * @param GroupType|value-of<GroupType>|null $groupType filter by group type
     * @param bool $includeInherited also list the limiter values the workspace inherits from the organization, including groups with no workspace-level override
     * @param int|null $limit Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<WorkspaceRateLimit>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        GroupType|string|null $groupType = null,
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
