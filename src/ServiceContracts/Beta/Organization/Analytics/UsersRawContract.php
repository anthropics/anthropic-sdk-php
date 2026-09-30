<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsUserActivity;
use Anthropic\Beta\Organization\Analytics\Users\UserListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UserListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsUserActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|UserListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
