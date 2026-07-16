<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Tunnels\BetaTunnel;
use Anthropic\Beta\Tunnels\BetaTunnelToken;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface TunnelsContract
{
    /**
     * @api
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
    ): BetaTunnel;

    /**
     * @api
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
    ): BetaTunnel;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): BetaTunnel;

    /**
     * @api
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
    ): BetaTunnelToken;

    /**
     * @api
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
    ): BetaTunnelToken;
}
