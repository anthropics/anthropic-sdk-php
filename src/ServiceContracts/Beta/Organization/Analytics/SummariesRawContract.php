<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsSingleDayActivitySummary;
use Anthropic\Beta\Organization\Analytics\Summaries\SummaryListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SummariesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SummaryListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsSingleDayActivitySummary>>
     *
     * @throws APIException
     */
    public function list(
        array|SummaryListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
