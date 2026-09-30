<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\Plugins\DeletedPlugin;
use Anthropic\Beta\Organization\Plugins\Plugin;
use Anthropic\Beta\Organization\Plugins\PluginCreateParams;
use Anthropic\Beta\Organization\Plugins\PluginDeleteParams;
use Anthropic\Beta\Organization\Plugins\PluginListParams;
use Anthropic\Beta\Organization\Plugins\PluginRetrieveParams;
use Anthropic\Beta\Organization\Plugins\PluginUpdateParams;
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
     * @param array<string,mixed>|PluginCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws APIException
     */
    public function create(
        array|PluginCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array<string,mixed>|PluginRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws APIException
     */
    public function retrieve(
        string $pluginID,
        array|PluginRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array<string,mixed>|PluginUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws APIException
     */
    public function update(
        string $pluginID,
        array|PluginUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PluginListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<Plugin>>
     *
     * @throws APIException
     */
    public function list(
        array|PluginListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $pluginID ID of the Plugin (prefixed `plugin_`)
     * @param array<string,mixed>|PluginDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedPlugin>
     *
     * @throws APIException
     */
    public function delete(
        string $pluginID,
        array|PluginDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
