<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Plugins;

use Anthropic\Beta\BetaUnsupportedCharsetException;
use Anthropic\Beta\Organization\Plugins\RegistrationPendingException;
use Anthropic\Beta\Organization\Plugins\SkillNameTakenException;
use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;
use Anthropic\Beta\Organization\Plugins\Versions\VersionCreateParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionDownloadParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionListParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionRetrieveParams;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface VersionsRawContract
{
    /**
     * @api
     *
     * @param string $pluginID Path param: ID of the Plugin (prefixed `plugin_`).
     * @param array<string,mixed>|VersionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaPluginVersion>
     *
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws BetaUnsupportedCharsetException The request's `Content-Type` header names a charset other than UTF-8, ISO-8859-1 or US-ASCII. Send the request with no charset, or with one of these.
     * @throws SkillNameTakenException One of the Plugin's skills has the name of an organization skill. `skill_name` is that name.
     * @throws RegistrationPendingException The Plugin version was stored but is not yet usable in claude.ai. `plugin_id` and `plugin_version_id` identify what was stored.
     * @throws APIException
     */
    public function create(
        string $pluginID,
        array|VersionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $version Path param: ID of the Plugin Version (prefixed `pluginver_`), or `latest` for the newest one.
     * @param array<string,mixed>|VersionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaPluginVersion>
     *
     * @throws APIException
     */
    public function retrieve(
        string $version,
        array|VersionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $pluginID Path param: ID of the Plugin (prefixed `plugin_`).
     * @param array<string,mixed>|VersionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaPluginVersion>>
     *
     * @throws APIException
     */
    public function list(
        string $pluginID,
        array|VersionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $version Path param: ID of the Plugin Version (prefixed `pluginver_`). `latest` is not accepted here.
     * @param array<string,mixed>|VersionDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws APIException
     */
    public function download(
        string $version,
        array|VersionDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
