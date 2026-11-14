<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingException;
use Anthropic\Beta\Organization\ClaudeTag\BundleAttachmentNotSupportedException;
use Anthropic\Beta\Organization\ClaudeTag\BundleOnCallException;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledException;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedException;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictException;
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
    ): BetaClaudeTagBundle {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($bundleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Change a Bundle's instructions. The update is partial: a field left out is unchanged, and `instructions` sent as null or as an empty string clears them. The later of two updates wins. Sessions that start after the change use the new instructions; sessions already running keep the ones they started with. Some Bundles are managed in claude.ai, and an update of one returns 400.
     *
     * @param string $bundleID Path param: The Bundle's identifier, starting with `capp_`.
     * @param string|null $instructions Body param: Instructions for Claude, up to 10,000 bytes (UTF-8), added to the instructions of every session that can use the Bundle. Null or an empty string clears them.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws BundleAttachmentNotSupportedException
     * @throws BundleOnCallException
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
     * @throws SlackChannelSetUpSettingsConflictException
     * @throws APIException
     */
    public function update(
        string $bundleID,
        ?string $instructions = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagBundle {
        $params = Util::removeNulls(
            ['instructions' => $instructions, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($bundleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the organization's Bundles, newest first by `created_at`. A Bundle that Claude Tag manages for itself is not listed.
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
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
