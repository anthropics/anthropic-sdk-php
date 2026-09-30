<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsCostReportTimeBucket;
use Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface CostReportRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CostReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsCostReportTimeBucket>>
     *
     * @throws APIException
     */
    public function list(
        array|CostReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
