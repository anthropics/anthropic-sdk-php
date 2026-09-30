<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsPluginActivity;
use Anthropic\Beta\Organization\Analytics\Plugins\PluginListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
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
