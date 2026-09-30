<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsCostUsersItem;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UserCostReportRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|UserCostReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsCostUsersItem>>
     *
     * @throws APIException
     */
    public function list(
        array|UserCostReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
