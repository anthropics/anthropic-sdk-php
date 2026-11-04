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
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws BetaUnsupportedCharsetException The request's `Content-Type` header names a charset other than UTF-8, ISO-8859-1 or US-ASCII. Send the request with no charset, or with one of these.
     * @throws PluginNameTakenException The marketplace already holds this name. `plugin_id` is the Plugin that holds it, and can be absent.
     * @throws SkillNameTakenException One of the Plugin's skills has the name of an organization skill. `skill_name` is that name.
     * @throws RegistrationPendingException The Plugin version was stored but is not yet usable in claude.ai. `plugin_id` and `plugin_version_id` identify what was stored.
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
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws ScanFailedException The version in `plugin_version_id` did not pass its content scan, so it cannot be served.
     * @throws ScanPendingException The content scan of the version in `plugin_version_id` is still running. Retry once the scan finishes.
     * @throws SkillNameTakenException One of the Plugin's skills has the name of an organization skill. `skill_name` is that name.
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
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws APIException
     */
    public function delete(
        string $pluginID,
        array|PluginDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
