<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsUsageUsersItem;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UserUsageReportRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UserUsageReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsUsageUsersItem>>
     *
     * @throws APIException
     */
    public function list(
        array|UserUsageReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
