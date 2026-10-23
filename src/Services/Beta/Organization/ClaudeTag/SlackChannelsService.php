<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagDeletedSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagSlackChannel;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\SlackChannelsContract;

/**
 * @phpstan-import-type ClaudeTagSlackChannelIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers
 * @phpstan-import-type ClaudeTagSettingsCreateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 */
final class SlackChannelsService implements SlackChannelsContract
{
    /**
     * @api
     */
    public SlackChannelsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SlackChannelsRawService($client);
    }

    /**
     * @api
     *
     * Set a Slack channel up for Claude Tag and return it with its identifier. If the channel is already set up, whether in claude.ai, by Claude's first use in it or by an earlier request, the existing channel is returned, so the request can be repeated. `settings`, when sent, is applied as an update applies it. Before a channel is set up, Claude's Slack app confirms with Slack that the channel is in the workspace, is not archived and is visible to the app; a channel that fails the confirmation returns 404. Setting the channel up and applying `settings` are two steps: when the second is refused, the response is the refusal, the channel stays set up with every setting unset, and the error's `details.slack_channel_id` holds the channel's identifier.
     *
     * @param ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape $slack Body param: Slack's own identifiers for the channel to set up. The organization must own the workspace.
     * @param ClaudeTagSettingsCreate|ClaudeTagSettingsCreateShape $settings body param: Settings to store on the channel, applied as Update Slack Channel applies them
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ClaudeTagSlackChannelIdentifiers|array $slack,
        ClaudeTagSettingsCreate|array|null $settings = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackChannel {
        $params = Util::removeNulls(
            ['slack' => $slack, 'settings' => $settings, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get one Slack channel and its settings. By default `settings` holds what the channel itself stores: a setting that is null there is not set on the channel and is inherited. With `include_inherited=true`, `settings` holds what applies in the channel once the settings levels above it are taken into account, and the request fails with 503 rather than resolve against a settings level that could not be read. Either way `sources` names the settings level each value comes from, so a caller tells the channel's own value from an inherited one by its source, not by whether it is null.
     *
     * @param string $id path param: The channel's identifier, starting with `slch_`
     * @param bool $includeInherited Query param: When `true`, `settings` holds what applies in the channel once the settings levels above it are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the channel itself stores.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?bool $includeInherited = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackChannel {
        $params = Util::removeNulls(
            ['includeInherited' => $includeInherited, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Change the settings a Slack channel stores. The update is partial: a setting left out is unchanged, and a setting sent as null is cleared, so the channel inherits it. If any value is refused, no setting in the request is stored. A group direct message takes no settings and returns 400.
     *
     * @param string $id path param: The channel's identifier, starting with `slch_`
     * @param ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape $settings body param: The settings to change
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ClaudeTagSettingsUpdate|array $settings,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackChannel {
        $params = Util::removeNulls(['settings' => $settings, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the set-up Slack channels of one Slack workspace, newest first by `created_at`. A channel that is not set up is not listed: Slack holds the full list of a workspace's channels. Pass `slack_channel_id` as well to look one channel up by its Slack identifiers: `data` then holds that channel, or is empty when it is not set up, and `limit` and `page` are ignored. A workspace that the organization owns only through a Slack Enterprise Grid returns 404 until it is set up. With `include_inherited=true` each channel's `settings` holds what applies in it, and the request fails with 503 rather than resolve against a settings level that could not be read. A `page` cursor resumes only a request with the same `include_inherited`.
     *
     * @param string $slackWorkspaceID Query param: The Slack workspace whose channels to list: Slack's identifier for it, as in the channel object's `slack.workspace_id`, not the workspace object's `id`.
     * @param bool $includeInherited Query param: When `true`, `settings` holds what applies in each channel once the settings levels above it are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each channel itself stores.
     * @param int $limit Query param: Number of items to return per page, between 1 and 100. Defaults to 20.
     * @param string $page query param: Opaque cursor from a previous response's `next_page`
     * @param string $slackChannelID Query param: Slack's identifier for one channel of that workspace, as in the channel object's `slack.channel_id`. It is not the channel object's `id`. With it `data` holds that channel alone, or nothing when the channel is not set up.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeTagSlackChannel>
     *
     * @throws APIException
     */
    public function list(
        string $slackWorkspaceID,
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $slackChannelID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'slackWorkspaceID' => $slackWorkspaceID,
                'includeInherited' => $includeInherited,
                'limit' => $limit,
                'page' => $page,
                'slackChannelID' => $slackChannelID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a Slack channel from Claude Tag. This deletes the channel's stored settings and its Bundle Targets at once, and then, in the background, the channel's sessions and their transcripts, its memory, its routines and the artifacts published from it. None of it can be restored. The channel in Slack and its messages are unchanged. The request is refused with 400 and `error.details.error_code` `slack_channel_enabled` while `enabled` resolves to `true` for the channel, as a read with `include_inherited=true` returns it: set `enabled` to `false` on the channel first. This guards against removing a channel in use by mistake; it is not a way to keep Claude out, because the removal deletes the channel's own `enabled: false` with its other settings, after which the channel inherits again and Claude's next use of it can set it up anew with a new identifier. The identifier returns 404 as soon as the request returns, so a repeated removal returns 404. A group direct message returns 400, and so does a channel that holds configuration this API does not manage.
     *
     * @param string $id the channel's identifier, starting with `slch_`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas this endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagDeletedSlackChannel {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
