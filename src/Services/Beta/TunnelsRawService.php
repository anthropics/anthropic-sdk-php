<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Tunnels\BetaTunnel;
use Anthropic\Beta\Tunnels\BetaTunnelToken;
use Anthropic\Beta\Tunnels\TunnelArchiveParams;
use Anthropic\Beta\Tunnels\TunnelCreateParams;
use Anthropic\Beta\Tunnels\TunnelListParams;
use Anthropic\Beta\Tunnels\TunnelRetrieveParams;
use Anthropic\Beta\Tunnels\TunnelRevealTokenParams;
use Anthropic\Beta\Tunnels\TunnelRotateTokenParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\TunnelsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class TunnelsRawService implements TunnelsRawContract
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
     * Creates a tunnel. Creation allocates a fresh hostname and provisions the tunnel; it is not idempotent. The new tunnel rejects MCP traffic until at least one CA certificate is added.
     *
     * @param array{
     *   displayName?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TunnelCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTunnel>
     *
     * @throws APIException
     */
    public function create(
        array|TunnelCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TunnelCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/tunnels?beta=true',
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
            convert: BetaTunnel::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Fetches a tunnel by ID.
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TunnelRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTunnel>
     *
     * @throws APIException
     */
    public function retrieve(
        string $tunnelID,
        array|TunnelRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TunnelRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/tunnels/%1$s?beta=true', $tunnelID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: BetaTunnel::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Lists tunnels. Results are ordered by creation time, newest first; archived tunnels are excluded unless include_archived is set.
     *
     * @param array{
     *   includeArchived?: bool,
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TunnelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaTunnel>>
     *
     * @throws APIException
     */
    public function list(
        array|TunnelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TunnelListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeArchived', 'limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/tunnels?beta=true',
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
            convert: BetaTunnel::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Archives a tunnel. Archival is irreversible: every non-archived certificate on the tunnel is archived in the same operation, the hostname is retired and never re-allocated, and the tunnel token is invalidated. Retrying against an already-archived tunnel returns the existing record unchanged.
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TunnelArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTunnel>
     *
     * @throws APIException
     */
    public function archive(
        string $tunnelID,
        array|TunnelArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TunnelArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/tunnels/%1$s/archive?beta=true', $tunnelID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: BetaTunnel::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Reveals a tunnel's connector token. The value is fetched live on each call; Anthropic does not store it. Repeated calls return the same value until the token is rotated. Exposed as POST so the token does not appear in intermediary access logs.
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TunnelRevealTokenParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTunnelToken>
     *
     * @throws APIException
     */
    public function revealToken(
        string $tunnelID,
        array|TunnelRevealTokenParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TunnelRevealTokenParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/tunnels/%1$s/reveal_token?beta=true', $tunnelID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'mcp-tunnels-2026-06-22']],
                $options,
            ),
            convert: BetaTunnelToken::class,
        );
    }

    /**
     * @api
     *
     * The Tunnels API is in research preview. It requires the `anthropic-beta: mcp-tunnels-2026-06-22` header and may change without a deprecation period. It supersedes the Admin API endpoints at `/v1/organizations/tunnels`, which remain available during a migration window.
     *
     * Rotates a tunnel's connector token. Rotation invalidates the current token for new connections and returns a fresh value; established connections are not severed. A connector restarted after rotation must use the new value.
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param array{
     *   reason?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TunnelRotateTokenParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTunnelToken>
     *
     * @throws APIException
     */
    public function rotateToken(
        string $tunnelID,
        array|TunnelRotateTokenParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TunnelRotateTokenParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/tunnels/%1$s/rotate_token?beta=true', $tunnelID],
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
            convert: BetaTunnelToken::class,
        );
    }
}
