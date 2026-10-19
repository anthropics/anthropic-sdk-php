<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Workspaces;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitListParams;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitUpdateParams;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RateLimitsRawContract
{
    /**
     * @api
     *
     * @param string $rateLimitID path param: The `id` of the organization's rate-limit entry to set overrides for
     * @param array<string,mixed>|RateLimitUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceRateLimit>
     *
     * @throws APIException
     */
    public function update(
        string $rateLimitID,
        array|RateLimitUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workspaceID the ID of the workspace
     * @param array<string,mixed>|RateLimitListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<WorkspaceRateLimit>>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        array|RateLimitListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
