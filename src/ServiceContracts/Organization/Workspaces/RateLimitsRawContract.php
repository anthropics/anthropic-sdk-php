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
use Anthropic\SandboxEgressRestrictedException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RateLimitsRawContract
{
    /**
     * @api
     *
     * @param string $rateLimitID Path param: The `id` of the organization's rate-limit entry to set overrides for.
     * @param array<string,mixed>|RateLimitUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceRateLimit>
     *
     * @throws SandboxEgressRestrictedException
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
     * @param string $workspaceID The ID of the workspace.
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
