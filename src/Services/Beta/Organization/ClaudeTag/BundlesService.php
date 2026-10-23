<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\BundlesContract;
use Anthropic\Services\Beta\Organization\ClaudeTag\Bundles\TargetsService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class BundlesService implements BundlesContract
{
    /**
     * @api
     */
    public BundlesRawService $raw;

    /**
     * @api
     */
    public TargetsService $targets;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BundlesRawService($client);
        $this->targets = new TargetsService($client);
    }

    /**
     * @api
     *
     * Get one Bundle. What the Bundle grants (connectors, repositories and credentials) is never returned.
     *
     * @param string $bundleID the Bundle's identifier, starting with `capp_`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $bundleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagBundle {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($bundleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the organization's Bundles, newest first by `created_at`. A Bundle that Claude Tag manages for itself is not listed.
     *
     * @param int $limit Query param: Number of items to return per page, between 1 and 100. Defaults to 20.
     * @param string $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeTagBundle>
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
