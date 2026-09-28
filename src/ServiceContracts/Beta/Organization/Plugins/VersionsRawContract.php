<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Plugins;

use Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;
use Anthropic\Beta\Organization\Plugins\Versions\VersionCreateParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionDownloadParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionListParams;
use Anthropic\Beta\Organization\Plugins\Versions\VersionRetrieveParams;
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
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
     * @param array<string,mixed>|VersionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaPluginVersion>
     *
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
     * @param string $version path param: ID of the Plugin Version (prefixed `pluginver_`), or `latest` for the newest one
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
     * @param string $pluginID path param: ID of the Plugin (prefixed `plugin_`)
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
     * @throws APIException
     */
    public function download(
        string $version,
        array|VersionDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
