<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Tunnels\BetaTunnel;
use Anthropic\Beta\Tunnels\BetaTunnelToken;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\TunnelsContract;
use Anthropic\Services\Beta\Tunnels\CertificatesService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class TunnelsService implements TunnelsContract
{
    /**
     * @api
     */
    public TunnelsRawService $raw;

    /**
     * @api
     */
    public CertificatesService $certificates;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TunnelsRawService($client);
        $this->certificates = new CertificatesService($client);
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Creates a tunnel. Creation allocates a fresh hostname and provisions the tunnel; it is not idempotent. The new tunnel rejects MCP traffic until at least one CA certificate is added.
     *
     * @param string|null $displayName body param: Optional human-readable name for the tunnel (1-255 characters)
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?string $displayName = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaTunnel {
        $params = Util::removeNulls(
            ['displayName' => $displayName, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Fetches a tunnel by ID.
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $tunnelID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaTunnel {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($tunnelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Lists tunnels. Results are ordered by creation time, newest first; archived tunnels are excluded unless include_archived is set.
     *
     * @param bool $includeArchived Query param: Whether to include archived tunnels in the results. Defaults to false.
     * @param int $limit Query param: Maximum number of tunnels to return per page. Defaults to 20, maximum 1000.
     * @param string $page query param: Opaque pagination cursor from a previous `list_tunnels` response
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaTunnel>
     *
     * @throws APIException
     */
    public function list(
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
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Archives a tunnel. Archival is irreversible: every non-archived certificate on the tunnel is archived in the same operation, the hostname is retired and never re-allocated, and the tunnel token is invalidated. Retrying against an already-archived tunnel returns the existing record unchanged.
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $tunnelID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaTunnel {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($tunnelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Reveals a tunnel's connector token. The value is fetched live on each call; Anthropic does not store it. Repeated calls return the same value until the token is rotated. Exposed as POST so the token does not appear in intermediary access logs.
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function revealToken(
        string $tunnelID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaTunnelToken {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->revealToken($tunnelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Rotates a tunnel's connector token. Rotation invalidates the current token for new connections and returns a fresh value; established connections are not severed. A connector restarted after rotation must use the new value.
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param string|null $reason body param: Optional free-text reason for the rotation, recorded for audit
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateToken(
        string $tunnelID,
        ?string $reason = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaTunnelToken {
        $params = Util::removeNulls(['reason' => $reason, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->rotateToken($tunnelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
