<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Environments\BetaEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingException;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledException;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedException;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictException;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\BetaClaudeTagSlackWorkspace;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\SlackWorkspaceListParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\SlackWorkspaceRetrieveParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackWorkspaces\SlackWorkspaceUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SlackWorkspacesRawContract
{
    /**
     * @api
     *
     * @param string $id Path param: The workspace's identifier, starting with `slws_`.
     * @param array<string,mixed>|SlackWorkspaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackWorkspace>
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SlackWorkspaceRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The workspace's identifier, starting with `slws_`.
     * @param array<string,mixed>|SlackWorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackWorkspace>
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
        array|SlackWorkspaceUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SlackWorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackWorkspace>>
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws APIException
     */
    public function list(
        array|SlackWorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
