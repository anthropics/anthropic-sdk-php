<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\BetaEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingException;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledException;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedException;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictException;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\BetaClaudeTagSlackWorkspace;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\SlackWorkspacesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ClaudeTagSettingsUpdateShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSettingsUpdate
 */
final class SlackWorkspacesService implements SlackWorkspacesContract
{
    /**
     * @api
     */
    public SlackWorkspacesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SlackWorkspacesRawService($client);
    }

    /**
     * @api
     *
     * Get one Slack workspace and its settings. By default `settings` holds what the workspace itself stores: a setting that is null there is not set on the workspace and is inherited. With `include_inherited=true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and the request fails with 503 rather than resolve against a settings level that could not be read. Either way `sources` names the settings level each value comes from.
     *
     * @param string $id Path param: The workspace's identifier, starting with `slws_`.
     * @param bool $includeInherited Query param: When `true`, `settings` holds what applies in the workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what the workspace itself stores.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?bool $includeInherited = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackWorkspace {
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
     * Change the settings a Slack workspace stores. The update is partial: a setting left out is unchanged, and a setting sent as null is cleared, so the workspace inherits it. If any value is refused, no setting in the request is stored.
     *
     * @param string $id Path param: The workspace's identifier, starting with `slws_`.
     * @param ClaudeTagSettingsUpdate|ClaudeTagSettingsUpdateShape $settings Body param: The settings to change.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws BetaEnvironmentNotFoundException `settings.environment_id` names no Environment within the organization's reach.
     * @throws SlackChannelSetUpEnvironmentNotFoundException `settings.environment_id` names no Environment within the organization's reach, and the request had set the channel up by then. The channel stays set up with every setting unset.
     * @throws SlackChannelSetUpSettingsConflictException The request set the channel up, and something else then changed the channel or removed it. Nothing of `settings` was stored.
     * @throws APIException
     */
    public function update(
        string $id,
        ClaudeTagSettingsUpdate|array $settings,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaClaudeTagSlackWorkspace {
        $params = Util::removeNulls(['settings' => $settings, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the set-up Slack workspaces the organization owns, newest first by `created_at`. Pass `slack_workspace_id` to look one workspace up by its Slack identifier: `data` then holds that workspace, or is empty when it is not set up. A workspace of a Slack Enterprise Grid the organization has connected returns 404 until it is set up. With `include_inherited=true` each workspace's `settings` holds what applies in it, and the request fails with 503 rather than resolve against a settings level that could not be read. A `page` cursor resumes only a request with the same `include_inherited`.
     *
     * @param bool $includeInherited Query param: When `true`, `settings` holds what applies in each workspace once the organization's Slack defaults are taken into account, and every member of `sources` names the level a value comes from. When `false` or left out, `settings` holds what each workspace itself stores.
     * @param int $limit Query param: Number of items to return per page, between 1 and 100. Defaults to 20.
     * @param string $page Query param: Opaque cursor from a previous response's `next_page`.
     * @param string $slackWorkspaceID Query param: Slack's identifier for one workspace, as in the workspace object's `slack.workspace_id`, not its `id`. With it `data` holds that workspace alone, or nothing when it is not set up.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: This endpoint is in beta: requests must send `experimental-claude-tag-2026-10-21` in this header.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaClaudeTagSlackWorkspace>
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws APIException
     */
    public function list(
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $slackWorkspaceID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'includeInherited' => $includeInherited,
                'limit' => $limit,
                'page' => $page,
                'slackWorkspaceID' => $slackWorkspaceID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
