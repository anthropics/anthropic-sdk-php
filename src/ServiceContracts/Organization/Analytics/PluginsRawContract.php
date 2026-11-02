<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Analytics;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Analytics\AnalyticsPluginActivity;
use Anthropic\Organization\Analytics\Plugins\PluginListParams;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PluginsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PluginListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsPluginActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|PluginListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
