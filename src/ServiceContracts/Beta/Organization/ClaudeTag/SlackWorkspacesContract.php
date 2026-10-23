<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\BetaClaudeTagSlackWorkspace;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 */
interface SlackWorkspacesContract
{
    /**
     * @api
     *
     * @param string $id path param: The workspace's identifier, starting with `slws_`
     * @param bool $includeInherited Query param: When `true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the workspace itself stores.
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
    ): BetaClaudeTagSlackWorkspace;

    /**
     * @api
     *
     * @param string $id path param: The workspace's identifier, starting with `slws_`
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
    ): BetaClaudeTagSlackWorkspace;

    /**
     * @api
     *
     * @param bool $includeInherited Query param: When `true`, `settings` holds what applies in each workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each workspace itself stores.
     * @param int $limit Query param: Number of items to return per page, between 1 and 100. Defaults to 20.
     * @param string $page query param: Opaque cursor from a previous response's `next_page`
     * @param string $slackWorkspaceID Query param: Slack's identifier for one workspace, as in the workspace object's `slack.workspace_id`, not its `id`. With it `data` holds that workspace alone, or nothing when it is not set up.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeTagSlackWorkspace>
     *
     * @throws APIException
     */
    public function list(
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $slackWorkspaceID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
