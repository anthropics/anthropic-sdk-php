<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Workspaces;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitListParams;
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
