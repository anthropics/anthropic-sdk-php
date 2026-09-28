<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceRetrieveParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceUpdateParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidateArchiveParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidateRepositoryParams;
use Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceValidationReport;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface PluginMarketplacesRawContract
{
    /**
     * @api
     *
     * @param string $marketplaceID path param: ID of the plugin marketplace (prefixed `marketplace_`)
     * @param array<string,mixed>|PluginMarketplaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $marketplaceID,
        array|PluginMarketplaceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $marketplaceID path param: ID of the plugin marketplace (prefixed `marketplace_`)
     * @param array<string,mixed>|PluginMarketplaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplace>
     *
     * @throws APIException
     */
    public function update(
        string $marketplaceID,
        array|PluginMarketplaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PluginMarketplaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<PluginMarketplace>>
     *
     * @throws APIException
     */
    public function list(
        array|PluginMarketplaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PluginMarketplaceValidateArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplaceValidationReport>
     *
     * @throws APIException
     */
    public function validateArchive(
        array|PluginMarketplaceValidateArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PluginMarketplaceValidateRepositoryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PluginMarketplaceValidationReport>
     *
     * @throws APIException
     */
    public function validateRepository(
        array|PluginMarketplaceValidateRepositoryParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
