<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit;
use Anthropic\Beta\Organization\RateLimits\RateLimitListParams;
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
     * @param array<string,mixed>|RateLimitListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<OrganizationRateLimit>>
     *
     * @throws APIException
     */
    public function list(
        array|RateLimitListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
