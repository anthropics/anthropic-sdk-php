<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Plugins;

use Anthropic\Beta\Organization\Plugins\Shares\BetaPluginShare;
use Anthropic\Beta\Organization\Plugins\Shares\ShareListParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SharesRawContract
{
    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array<string,mixed>|ShareListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaPluginShare>>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        array|ShareListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
