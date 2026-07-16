<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Tunnels\BetaTunnel;
use Anthropic\Beta\Tunnels\BetaTunnelToken;
use Anthropic\Beta\Tunnels\TunnelArchiveParams;
use Anthropic\Beta\Tunnels\TunnelCreateParams;
use Anthropic\Beta\Tunnels\TunnelListParams;
use Anthropic\Beta\Tunnels\TunnelRetrieveParams;
use Anthropic\Beta\Tunnels\TunnelRevealTokenParams;
use Anthropic\Beta\Tunnels\TunnelRotateTokenParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface TunnelsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TunnelCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTunnel>
     *
     * @throws APIException
     */
    public function create(
        array|TunnelCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param array<string,mixed>|TunnelRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TunnelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaTunnel>>
     *
     * @throws APIException
     */
    public function list(
        array|TunnelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param array<string,mixed>|TunnelArchiveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $tunnelID Path parameter tunnel_id
     * @param array<string,mixed>|TunnelRevealTokenParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $tunnelID Path param: Path parameter tunnel_id
     * @param array<string,mixed>|TunnelRotateTokenParams $params
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
    ): BaseResponse;
}
