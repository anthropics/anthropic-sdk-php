<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\BetaClaudeTagSlackWorkspace;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\SlackWorkspaceListParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\SlackWorkspaceRetrieveParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\SlackWorkspaceUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\SlackWorkspacesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 */
final class SlackWorkspacesRawService implements SlackWorkspacesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get one Slack workspace and its settings. By default `settings` holds what the workspace itself stores: a setting that is null there is not set on the workspace and is inherited. With `include_inherited=true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and the request fails with 503 rather than resolve against a settings level that could not be read. Either way `sources` names the settings level each value comes from.
     *
     * @param string $id path param: The workspace's identifier, starting with `slws_`
     * @param array{
     *   includeInherited?: bool,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackWorkspaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackWorkspace>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SlackWorkspaceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackWorkspaceRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeInherited']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/claude_tag/slack_workspaces/%1$s', $id],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['includeInherited' => 'include_inherited'],
            ),
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
                name: 'anthropic.organization.claude_tag.slack_workspaces.retrieve',
                route: '/v1/organizations/claude_tag/slack_workspaces/{id}',
                query: ['include_inherited'],
                attributes: [
                    'anthropic.organization.claude_tag.slack_workspace.id' => $id,
                ],
            )),
            convert: BetaClaudeTagSlackWorkspace::class,
        );
    }

    /**
     * @api
     *
     * Change the settings a Slack workspace stores. The update is partial: a setting left out is unchanged, and a setting sent as null is cleared, so the workspace inherits it. If any value is refused, no setting in the request is stored.
     *
     * @param string $id path param: The workspace's identifier, starting with `slws_`
     * @param array{
     *   settings: ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackWorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackWorkspace>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|SlackWorkspaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackWorkspaceUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/claude_tag/slack_workspaces/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.slack_workspaces.update',
                route: '/v1/organizations/claude_tag/slack_workspaces/{id}',
                attributes: [
                    'anthropic.organization.claude_tag.slack_workspace.id' => $id,
                ],
            )),
            convert: BetaClaudeTagSlackWorkspace::class,
        );
    }

    /**
     * @api
     *
     * List the set-up Slack workspaces the organization owns, newest first by `created_at`. Pass `slack_workspace_id` to look one workspace up by its Slack identifier: `data` then holds that workspace, or is empty when it is not set up. A workspace of a Slack Enterprise Grid the organization has connected returns 404 until it is set up. With `include_inherited=true` each workspace's `settings` holds what applies in it, and the request fails with 503 rather than resolve against a settings level that could not be read. A `page` cursor resumes only a request with the same `include_inherited`.
     *
     * @param array{
     *   includeInherited?: bool,
     *   limit?: int,
     *   page?: string,
     *   slackWorkspaceID?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackWorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackWorkspace>>
     *
     * @throws APIException
     */
    public function list(
        array|SlackWorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackWorkspaceListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            ['includeInherited', 'limit', 'page', 'slackWorkspaceID']
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/claude_tag/slack_workspaces',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'includeInherited' => 'include_inherited',
                    'slackWorkspaceID' => 'slack_workspace_id',
                ],
            ),
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
                name: 'anthropic.organization.claude_tag.slack_workspaces.list',
                route: '/v1/organizations/claude_tag/slack_workspaces',
                query: ['include_inherited', 'limit', 'page', 'slack_workspace_id'],
            )),
            convert: BetaClaudeTagSlackWorkspace::class,
            page: PageCursor::class,
        );
    }
}
