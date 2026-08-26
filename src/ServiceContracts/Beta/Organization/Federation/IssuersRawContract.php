<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Federation;

use Anthropic\Beta\Organization\Federation\Issuers\BetaFederationIssuer;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerArchiveParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerCreateParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerListParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerRetrieveParams;
use Anthropic\Beta\Organization\Federation\Issuers\IssuerUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface IssuersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|IssuerCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function create(
        array|IssuerCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer
     * @param array<string,mixed>|IssuerRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationIssuerID,
        array|IssuerRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationIssuerID path param: ID of the federation issuer to update
     * @param array<string,mixed>|IssuerUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function update(
        string $federationIssuerID,
        array|IssuerUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|IssuerListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaFederationIssuer>>
     *
     * @throws APIException
     */
    public function list(
        array|IssuerListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer to archive
     * @param array<string,mixed>|IssuerArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaFederationIssuer>
     *
     * @throws APIException
     */
    public function archive(
        string $federationIssuerID,
        array|IssuerArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
