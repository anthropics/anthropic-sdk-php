<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagDeletedBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetCreateParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetDeleteParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetListParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\Bundles\TargetsRawContract;

/**
 * @phpstan-import-type BetaClaudeTagBundleTargetCreateShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTargetCreate
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class TargetsRawService implements TargetsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Attach a Bundle to a Slack channel or a Slack workspace. A Bundle attached to a workspace can be used in the workspace and in every channel in it. Attaching a Bundle to a channel or workspace it is already attached to returns the existing Bundle Target. The channel or workspace must be set up: attaching never sets a channel up. A group direct message takes no Bundle and returns 400.
     *
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param array{
     *   target: BetaClaudeTagBundleTargetCreateShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TargetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>
     *
     * @throws APIException
     */
    public function create(
        string $bundleID,
        array|TargetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TargetCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/claude_tag/bundles/%1$s/targets', $bundleID],
            headers: Util::array_transform_keys(
                array_diff_key($parsed, array_flip(['target'])),
                ['betas' => 'anthropic-beta'],
            ),
            body: (object) $parsed['target'],
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.bundles.targets.create',
                route: '/v1/organizations/claude_tag/bundles/{bundle_id}/targets',
                attributes: [
                    'anthropic.organization.claude_tag.bundle.id' => $bundleID,
                ],
            )),
            convert: BetaClaudeTagBundleTarget::class,
        );
    }

    /**
     * @api
     *
     * Get one Bundle Target. Returns 404 when `target_id` is the identifier of another Bundle's Bundle Target, or the Bundle Target was detached.
     *
     * @param string $targetID Path param: The Bundle Target's identifier, starting with `btgt_`. Attach Bundle and List Bundle Targets return it. It is never the identifier of the channel or workspace.
     * @param array{
     *   bundleID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TargetRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>
     *
     * @throws APIException
     */
    public function retrieve(
        string $targetID,
        array|TargetRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TargetRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $bundleID = $parsed['bundleID'];
        unset($parsed['bundleID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/claude_tag/bundles/%1$s/targets/%2$s',
                $bundleID,
                $targetID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.bundles.targets.retrieve',
                route: '/v1/organizations/claude_tag/bundles/{bundle_id}/targets/{target_id}',
                attributes: [
                    'anthropic.organization.claude_tag.bundle.id' => $bundleID,
                    'anthropic.organization.claude_tag.bundle.target.id' => $targetID,
                ],
            )),
            convert: BetaClaudeTagBundleTarget::class,
        );
    }

    /**
     * @api
     *
     * List the Slack channels and Slack workspaces a Bundle is attached to, newest first by `created_at`. Only channels and workspaces the organization owns are listed; a Bundle that is attached to anything else has no Bundle Target for it.
     *
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param array{
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TargetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>,>
     *
     * @throws APIException
     */
    public function list(
        string $bundleID,
        array|TargetListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TargetListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/claude_tag/bundles/%1$s/targets', $bundleID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.bundles.targets.list',
                route: '/v1/organizations/claude_tag/bundles/{bundle_id}/targets',
                query: ['limit', 'page'],
                attributes: [
                    'anthropic.organization.claude_tag.bundle.id' => $bundleID,
                ],
            )),
            convert: BetaClaudeTagBundleTarget::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Detach a Bundle from a Slack channel or a Slack workspace. A repeated detach returns 404.
     *
     * @param string $targetID Path param: The Bundle Target's identifier, starting with `btgt_`. Attach Bundle and List Bundle Targets return it. It is never the identifier of the channel or workspace.
     * @param array{
     *   bundleID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TargetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagDeletedBundleTarget>
     *
     * @throws APIException
     */
    public function delete(
        string $targetID,
        array|TargetDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TargetDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $bundleID = $parsed['bundleID'];
        unset($parsed['bundleID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/claude_tag/bundles/%1$s/targets/%2$s',
                $bundleID,
                $targetID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.bundles.targets.delete',
                route: '/v1/organizations/claude_tag/bundles/{bundle_id}/targets/{target_id}',
                attributes: [
                    'anthropic.organization.claude_tag.bundle.id' => $bundleID,
                    'anthropic.organization.claude_tag.bundle.target.id' => $targetID,
                ],
            )),
            convert: BetaClaudeTagDeletedBundleTarget::class,
        );
    }
}
