<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Tunnels;

use Anthropic\Beta\Tunnels\Certificates\CertificateArchiveParams;
use Anthropic\Beta\Tunnels\Certificates\CertificateCreateParams;
use Anthropic\Beta\Tunnels\Certificates\CertificateListParams;
use Anthropic\Beta\Tunnels\Certificates\CertificateRetrieveParams;
use Anthropic\Beta\Tunnels\Certificates\TunnelCertificate;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface CertificatesRawContract
{
    /**
     * @api
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param array<string,mixed>|CertificateCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TunnelCertificate>
     *
     * @throws APIException
     */
    public function create(
        string $tunnelID,
        array|CertificateCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $certificateID Path param: Path parameter certificate_id
     * @param array<string,mixed>|CertificateRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TunnelCertificate>
     *
     * @throws APIException
     */
    public function retrieve(
        string $certificateID,
        array|CertificateRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param array<string,mixed>|CertificateListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<TunnelCertificate>>
     *
     * @throws APIException
     */
    public function list(
        string $tunnelID,
        array|CertificateListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $certificateID Path param: Path parameter certificate_id
     * @param array<string,mixed>|CertificateArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TunnelCertificate>
     *
     * @throws APIException
     */
    public function archive(
        string $certificateID,
        array|CertificateArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
