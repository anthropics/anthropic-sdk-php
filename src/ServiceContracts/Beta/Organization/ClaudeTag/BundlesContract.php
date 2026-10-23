<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface BundlesContract
{
    /**
     * @api
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
    ): BetaClaudeTagBundle;

    /**
     * @api
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
    ): PageCursor;
}
