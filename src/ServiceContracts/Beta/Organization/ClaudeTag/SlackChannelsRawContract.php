<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Environments\BetaEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\APIKeyScopeMissingException;
use Anthropic\Beta\Organization\ClaudeTag\ClaudeTagWritesNotEnabledException;
use Anthropic\Beta\Organization\ClaudeTag\ComplianceConfigurationRestrictedException;
use Anthropic\Beta\Organization\ClaudeTag\OrganizationLevelScopedAPIKeyRequiredException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagDeletedSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\BetaClaudeTagSlackChannel;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelCreateParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelDeleteParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelListParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelRetrieveParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannels\SlackChannelUpdateParams;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpEnvironmentNotFoundException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsConflictException;
use Anthropic\Beta\Organization\ClaudeTag\SlackChannelSetUpSettingsRefusedException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SlackChannelsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SlackChannelCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws SlackChannelSetUpSettingsRefusedException The request set the channel up, and `settings` was then refused. The channel stays set up with every setting unset.
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws BetaEnvironmentNotFoundException `settings.environment_id` names no Environment within the organization's reach.
     * @throws SlackChannelSetUpEnvironmentNotFoundException `settings.environment_id` names no Environment within the organization's reach, and the request had set the channel up by then. The channel stays set up with every setting unset.
     * @throws SlackChannelSetUpSettingsConflictException The request set the channel up, and something else then changed the channel or removed it. Nothing of `settings` was stored.
     * @throws APIException
     */
    public function create(
        array|SlackChannelCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The channel's identifier, starting with `slch_`.
     * @param array<string,mixed>|SlackChannelRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|SlackChannelRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: The channel's identifier, starting with `slch_`.
     * @param array<string,mixed>|SlackChannelUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannel>
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
        array|SlackChannelUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SlackChannelListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackChannel>>
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws APIException
     */
    public function list(
        array|SlackChannelListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id The channel's identifier, starting with `slch_`.
     * @param array<string,mixed>|SlackChannelDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagDeletedSlackChannel>
     *
     * @throws APIKeyScopeMissingException The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
     * @throws ClaudeTagWritesNotEnabledException Changes through the Claude Tag API are not enabled for the organization.
     * @throws ComplianceConfigurationRestrictedException The organization's compliance configuration does not let Claude Tag store anything new.
     * @throws OrganizationLevelScopedAPIKeyRequiredException The credential is not a scoped API key that is bound at the organization level.
     * @throws SlackChannelSetUpSettingsConflictException The request set the channel up, and something else then changed the channel or removed it. Nothing of `settings` was stored.
     * @throws APIException
     */
    public function delete(
        string $id,
        array|SlackChannelDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
