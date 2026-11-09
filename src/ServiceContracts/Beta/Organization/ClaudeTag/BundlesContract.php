<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingException;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledException;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedException;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredException;
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
     * @param string $bundleID The Bundle's identifier, starting with `capp_`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
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
     * @param string $page Query param: Opaque cursor from a previous response's `next_page`.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeTagBundle>
     *
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
