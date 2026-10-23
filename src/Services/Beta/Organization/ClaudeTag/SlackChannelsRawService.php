<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagDeletedSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelCreateParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelDeleteParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelListParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelRetrieveParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\SlackChannelsRawContract;

/**
 * @phpstan-import-type ClaudeTagSlackChannelIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers
 * @phpstan-import-type ClaudeTagSettingsCreateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 */
final class SlackChannelsRawService implements SlackChannelsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Set a Slack channel up for Claude Tag and return it with its identifier. If the channel is already set up, whether in claude.ai, by Claude's first use in it or by an earlier request, the existing channel is returned, so the request can be repeated. `settings`, when sent, is applied as an update applies it. Before a channel is set up, Claude's Slack app confirms with Slack that the channel is in the workspace, is not archived and is visible to the app; a channel that fails the confirmation returns 404. Setting the channel up and applying `settings` are two steps: when the second is refused, the response is the refusal, the channel stays set up with every setting unset, and the error's `details.slack_channel_id` holds the channel's identifier.
     *
     * @param array{
     *   slack: ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape,
     *   settings?: ClaudeTagSettingsCreate|ClaudeTagSettingsCreateShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackChannelCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function create(
        array|SlackChannelCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackChannelCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/claude_tag/slack_channels',
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
                name: 'anthropic.organization.claude_tag.slack_channels.create',
                route: '/v1/organizations/claude_tag/slack_channels',
                createdId: 'anthropic.organization.claude_tag.slack_channel.id',
            )),
            convert: BetaClaudeTagSlackChannel::class,
        );
    }

    /**
     * @api
     *
     * Get one Slack channel and its settings. By default `settings` holds what the channel itself stores: a setting that is null there is not set on the channel and is inherited. With `include_inherited=true`, `settings` holds what applies in the channel once the settings levels above it are taken into account, and the request fails with 503 rather than resolve against a settings level that could not be read. Either way `sources` names the settings level each value comes from, so a caller tells the channel's own value from an inherited one by its source, not by whether it is null.
     *
     * @param string $id path param: The channel's identifier, starting with `slch_`
     * @param array{
     *   includeInherited?: bool,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackChannelRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SlackChannelRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackChannelRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['includeInherited']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/claude_tag/slack_channels/%1$s', $id],
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
                name: 'anthropic.organization.claude_tag.slack_channels.retrieve',
                route: '/v1/organizations/claude_tag/slack_channels/{id}',
                query: ['include_inherited'],
                attributes: [
                    'anthropic.organization.claude_tag.slack_channel.id' => $id,
                ],
            )),
            convert: BetaClaudeTagSlackChannel::class,
        );
    }

    /**
     * @api
     *
     * Change the settings a Slack channel stores. The update is partial: a setting left out is unchanged, and a setting sent as null is cleared, so the channel inherits it. If any value is refused, no setting in the request is stored. A group direct message takes no settings and returns 400.
     *
     * @param string $id path param: The channel's identifier, starting with `slch_`
     * @param array{
     *   settings: ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackChannelUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|SlackChannelUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackChannelUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/claude_tag/slack_channels/%1$s', $id],
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
                name: 'anthropic.organization.claude_tag.slack_channels.update',
                route: '/v1/organizations/claude_tag/slack_channels/{id}',
                attributes: [
                    'anthropic.organization.claude_tag.slack_channel.id' => $id,
                ],
            )),
            convert: BetaClaudeTagSlackChannel::class,
        );
    }

    /**
     * @api
     *
     * List the set-up Slack channels of one Slack workspace, newest first by `created_at`. A channel that is not set up is not listed: Slack holds the full list of a workspace's channels. Pass `slack_channel_id` as well to look one channel up by its Slack identifiers: `data` then holds that channel, or is empty when it is not set up, and `limit` and `page` are ignored. A workspace that the organization owns only through a Slack Enterprise Grid returns 404 until it is set up. With `include_inherited=true` each channel's `settings` holds what applies in it, and the request fails with 503 rather than resolve against a settings level that could not be read. A `page` cursor resumes only a request with the same `include_inherited`.
     *
     * @param array{
     *   slackWorkspaceID: string,
     *   includeInherited?: bool,
     *   limit?: int,
     *   page?: string,
     *   slackChannelID?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SlackChannelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackChannel>>
     *
     * @throws APIException
     */
    public function list(
        array|SlackChannelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackChannelListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'slackWorkspaceID',
                'includeInherited',
                'limit',
                'page',
                'slackChannelID',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/claude_tag/slack_channels',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'slackWorkspaceID' => 'slack_workspace_id',
                    'includeInherited' => 'include_inherited',
                    'slackChannelID' => 'slack_channel_id',
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
                name: 'anthropic.organization.claude_tag.slack_channels.list',
                route: '/v1/organizations/claude_tag/slack_channels',
                query: [
                    'include_inherited',
                    'limit',
                    'page',
                    'slack_channel_id',
                    'slack_workspace_id',
                ],
            )),
            convert: BetaClaudeTagSlackChannel::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Remove a Slack channel from Claude Tag. This deletes the channel's stored settings and its Bundle Targets at once, and then, in the background, the channel's sessions and their transcripts, its memory, its routines and the artifacts published from it. None of it can be restored. The channel in Slack and its messages are unchanged. The request is refused with 400 and `error.details.error_code` `slack_channel_enabled` while `enabled` resolves to `true` for the channel, as a read with `include_inherited=true` returns it: set `enabled` to `false` on the channel first. This guards against removing a channel in use by mistake; it is not a way to keep Claude out, because the removal deletes the channel's own `enabled: false` with its other settings, after which the channel inherits again and Claude's next use of it can set it up anew with a new identifier. The identifier returns 404 as soon as the request returns, so a repeated removal returns 404. A group direct message returns 400, and so does a channel that holds configuration this API does not manage.
     *
     * @param string $id the channel's identifier, starting with `slch_`
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|SlackChannelDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagDeletedSlackChannel>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|SlackChannelDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SlackChannelDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/claude_tag/slack_channels/%1$s', $id],
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
                name: 'anthropic.organization.claude_tag.slack_channels.delete',
                route: '/v1/organizations/claude_tag/slack_channels/{id}',
                attributes: [
                    'anthropic.organization.claude_tag.slack_channel.id' => $id,
                ],
            )),
            convert: BetaClaudeTagDeletedSlackChannel::class,
        );
    }
}
