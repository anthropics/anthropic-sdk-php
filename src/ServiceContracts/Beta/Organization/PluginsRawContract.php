<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\BetaUnsupportedCharsetException;
use Anthropic\Beta\Organization\Plugins\DeletedPlugin;
use Anthropic\Beta\Organization\Plugins\Plugin;
use Anthropic\Beta\Organization\Plugins\PluginCreateParams;
use Anthropic\Beta\Organization\Plugins\PluginDeleteParams;
use Anthropic\Beta\Organization\Plugins\PluginListParams;
use Anthropic\Beta\Organization\Plugins\PluginNameTakenException;
use Anthropic\Beta\Organization\Plugins\PluginRetrieveParams;
use Anthropic\Beta\Organization\Plugins\PluginUpdateParams;
use Anthropic\Beta\Organization\Plugins\RegistrationPendingException;
use Anthropic\Beta\Organization\Plugins\ScanFailedException;
use Anthropic\Beta\Organization\Plugins\ScanPendingException;
use Anthropic\Beta\Organization\Plugins\SkillNameTakenException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
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
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws BetaUnsupportedCharsetException
     * @throws PluginNameTakenException
     * @throws SkillNameTakenException
     * @throws RegistrationPendingException
     * @throws APIException
     */
    public function create(
        array|PluginCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $pluginID Path param: ID of the Plugin (prefixed `plugin_`).
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
     * @param string $pluginID Path param: ID of the Plugin (prefixed `plugin_`).
     * @param array<string,mixed>|PluginUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Plugin>
     *
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws ScanFailedException
     * @throws ScanPendingException
     * @throws SkillNameTakenException
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
     * @param string $pluginID ID of the Plugin (prefixed `plugin_`).
     * @param array<string,mixed>|PluginDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedPlugin>
     *
     * @throws CMEKKeyDisabledException
     * @throws APIException
     */
    public function delete(
        string $pluginID,
        array|PluginDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
