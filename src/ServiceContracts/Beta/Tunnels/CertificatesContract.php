<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Tunnels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Tunnels\Certificates\TunnelCertificate;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface CertificatesContract
{
    /**
     * @api
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param string $caCertificatePem Body param: PEM-encoded X.509 CA certificate. Must contain exactly one certificate and no private-key material. Maximum 8KB.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $tunnelID,
        string $caCertificatePem,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TunnelCertificate;

    /**
     * @api
     *
     * @param string $certificateID Path param: Path parameter certificate_id
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $certificateID,
        string $tunnelID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TunnelCertificate;

    /**
     * @api
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param bool $includeArchived Query param: Whether to include archived certificates in the results. Defaults to false.
     * @param int $limit Query param: Maximum number of certificates to return per page. Defaults to 20, maximum 1000.
     * @param string $page query param: Opaque pagination cursor from a previous `list_tunnel_certificates` response
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<TunnelCertificate>
     *
     * @throws APIException
     */
    public function list(
        string $tunnelID,
        ?bool $includeArchived = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $certificateID Path param: Path parameter certificate_id
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $certificateID,
        string $tunnelID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): TunnelCertificate;
}
