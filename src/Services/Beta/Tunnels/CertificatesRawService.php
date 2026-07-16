<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Tunnels;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Tunnels\Certificates\CertificateArchiveParams;
use Anthropic\Beta\Tunnels\Certificates\CertificateCreateParams;
use Anthropic\Beta\Tunnels\Certificates\CertificateListParams;
use Anthropic\Beta\Tunnels\Certificates\CertificateRetrieveParams;
use Anthropic\Beta\Tunnels\Certificates\TunnelCertificate;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Tunnels\CertificatesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class CertificatesRawService implements CertificatesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Registers a public CA certificate on a tunnel. Anthropic verifies the gateway's server certificate against this CA when it terminates the inner TLS session. A tunnel holds at most two non-archived certificates.
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param array{
     *   caCertificatePem: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CertificateCreateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CertificateCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/tunnels/%1$s/certificates?beta=true', $tunnelID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: TunnelCertificate::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Fetches a tunnel certificate by ID.
     *
     * @param string $certificateID Path param: Path parameter certificate_id
     * @param array{
     *   tunnelID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|CertificateRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CertificateRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $tunnelID = $parsed['tunnelID'];
        unset($parsed['tunnelID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/tunnels/%1$s/certificates/%2$s?beta=true', $tunnelID, $certificateID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: TunnelCertificate::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Lists the certificates registered on a tunnel. Archived certificates are excluded unless include_archived is set.
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param array{
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CertificateListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CertificateListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeArchived', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/tunnels/%1$s/certificates?beta=true', $tunnelID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeArchived' => 'include_archived'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: TunnelCertificate::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Archives a tunnel certificate, removing it from the set Anthropic trusts for the tunnel. The certificate record is retained. Archiving the last non-archived certificate is permitted; the tunnel rejects MCP traffic until a new certificate is added.
     *
     * @param string $certificateID Path param: Path parameter certificate_id
     * @param array{
     *   tunnelID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|CertificateArchiveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CertificateArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $tunnelID = $parsed['tunnelID'];
        unset($parsed['tunnelID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/tunnels/%1$s/certificates/%2$s/archive?beta=true',
                $tunnelID,
                $certificateID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: TunnelCertificate::class,
        );
    }
}
