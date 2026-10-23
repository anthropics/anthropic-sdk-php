<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostItem;
use Anthropic\Beta\Organization\Analytics\Cost\CostListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\ReportPageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface CostRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CostListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ReportPageCursor<BetaAnalyticsCostItem>>
     *
     * @throws APIException
     */
    public function list(
        array|CostListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
