<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagDeletedBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTargetCreate;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTargetCreate;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\Bundles\TargetsContract;

/**
 * @phpstan-import-type BetaClaudeTagBundleTargetCreateShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTargetCreate
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class TargetsService implements TargetsContract
{
    /**
     * @api
     */
    public TargetsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TargetsRawService($client);
    }

    /**
     * @api
     *
     * Attach a Bundle to a Slack channel or a Slack workspace. A Bundle attached to a workspace can be used in the workspace and in every channel in it. Attaching a Bundle to a channel or workspace it is already attached to returns the existing Bundle Target. The channel or workspace must be set up: attaching never sets a channel up. A group direct message takes no Bundle and returns 400.
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
    ): BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget {
        $params = Util::removeNulls(['target' => $target, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($bundleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get one Bundle Target. Returns 404 when `target_id` is the identifier of another Bundle's Bundle Target, or the Bundle Target was detached.
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
    ): BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget {
        $params = Util::removeNulls(['bundleID' => $bundleID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($targetID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the Slack channels and Slack workspaces a Bundle is attached to, newest first by `created_at`. Only channels and workspaces the organization owns are listed; a Bundle that is attached to anything else has no Bundle Target for it.
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
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($bundleID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Detach a Bundle from a Slack channel or a Slack workspace. A repeated detach returns 404.
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
    ): BetaClaudeTagDeletedBundleTarget {
        $params = Util::removeNulls(['bundleID' => $bundleID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($targetID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
