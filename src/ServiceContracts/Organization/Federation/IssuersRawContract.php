<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\Federation;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\Federation\Issuers\FederationIssuer;
use Anthropic\Organization\Federation\Issuers\IssuerCreateParams;
use Anthropic\Organization\Federation\Issuers\IssuerListParams;
use Anthropic\Organization\Federation\Issuers\IssuerUpdateParams;
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
     * @return BaseResponse<FederationIssuer>
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
     *
     * @throws APIException
     */
    public function retrieve(
        string $federationIssuerID,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $federationIssuerID ID of the federation issuer to update
     * @param array<string,mixed>|IssuerUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
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
     * @return BaseResponse<PageCursor<FederationIssuer>>
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FederationIssuer>
     *
     * @throws APIException
     */
    public function archive(
        string $federationIssuerID,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
