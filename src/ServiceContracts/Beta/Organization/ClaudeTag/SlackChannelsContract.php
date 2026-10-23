<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagDeletedSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagSlackChannel;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type ClaudeTagSlackChannelIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers
 * @phpstan-import-type ClaudeTagSettingsCreateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsCreate
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 */
interface SlackChannelsContract
{
    /**
     * @api
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
    ): BetaClaudeTagSlackChannel;

    /**
     * @api
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
    ): BetaClaudeTagSlackChannel;

    /**
     * @api
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
    ): BetaClaudeTagSlackChannel;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): BetaClaudeTagDeletedSlackChannel;
}
