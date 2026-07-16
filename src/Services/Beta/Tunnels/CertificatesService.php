<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Tunnels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Tunnels\Certificates\TunnelCertificate;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Tunnels\CertificatesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class CertificatesService implements CertificatesContract
{
    /**
     * @api
     */
    public CertificatesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CertificatesRawService($client);
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Registers a public CA certificate on a tunnel. Anthropic verifies the gateway's server certificate against this CA when it terminates the inner TLS session. A tunnel holds at most two non-archived certificates.
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
    ): TunnelCertificate {
        $params = Util::removeNulls(
            ['caCertificatePem' => $caCertificatePem, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($tunnelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Fetches a tunnel certificate by ID.
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
    ): TunnelCertificate {
        $params = Util::removeNulls(['tunnelID' => $tunnelID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($certificateID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Lists the certificates registered on a tunnel. Archived certificates are excluded unless include_archived is set.
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
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeArchived' => $includeArchived,
                'limit' => $limit,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($tunnelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Archives a tunnel certificate, removing it from the set Anthropic trusts for the tunnel. The certificate record is retained. Archiving the last non-archived certificate is permitted; the tunnel rejects MCP traffic until a new certificate is added.
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
    ): TunnelCertificate {
        $params = Util::removeNulls(['tunnelID' => $tunnelID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($certificateID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
