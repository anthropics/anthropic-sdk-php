<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity;
use Anthropic\Beta\Organization\Analytics\Connectors\ConnectorListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ConnectorsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ConnectorListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsConnectorActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|ConnectorListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
