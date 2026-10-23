<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagDeletedBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTargetCreate;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTargetCreate;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type BetaClaudeTagBundleTargetCreateShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTargetCreate
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface TargetsContract
{
    /**
     * @api
     *
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param BetaClaudeTagBundleTargetCreateShape $target Body param
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $bundleID,
        BetaClaudeTagSlackChannelBundleTargetCreate|array|BetaClaudeTagSlackWorkspaceBundleTargetCreate $target,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget;

    /**
     * @api
     *
     * @param string $targetID Path param: The Bundle Target's identifier, starting with `btgt_`. Attach Bundle and List Bundle Targets return it. It is never the identifier of the channel or workspace.
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $targetID,
        string $bundleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget;

    /**
     * @api
     *
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param int $limit Query param: Number of items to return per page, between 1 and 100. Defaults to 20.
     * @param string $page query param: Opaque cursor from a previous response's `next_page`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>
     *
     * @throws APIException
     */
    public function list(
        string $bundleID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $targetID Path param: The Bundle Target's identifier, starting with `btgt_`. Attach Bundle and List Bundle Targets return it. It is never the identifier of the channel or workspace.
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $targetID,
        string $bundleID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagDeletedBundleTarget;
}
