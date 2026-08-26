<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;
use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
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
     * @return BaseResponse<PageCursor<BetaWorkspaceRateLimit>>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        array|RateLimitListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
