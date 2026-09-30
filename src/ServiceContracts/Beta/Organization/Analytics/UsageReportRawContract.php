<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsUsageReportTimeBucket;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsageReportRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UsageReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsUsageReportTimeBucket>>
     *
     * @throws APIException
     */
    public function list(
        array|UsageReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
