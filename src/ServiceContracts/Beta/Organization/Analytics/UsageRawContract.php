<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\Usage\BetaAnalyticsUsageItem;
use Anthropic\Beta\Organization\Analytics\Usage\UsageListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\ReportPageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsageRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UsageListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ReportPageCursor<BetaAnalyticsUsageItem>>
     *
     * @throws APIException
     */
    public function list(
        array|UsageListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
