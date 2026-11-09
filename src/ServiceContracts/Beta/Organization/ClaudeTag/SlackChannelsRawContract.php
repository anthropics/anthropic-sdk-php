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
     * @throws SlackChannelSetUpSettingsRefusedException
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
     * @throws BetaEnvironmentNotFoundException
     * @throws SlackChannelSetUpEnvironmentNotFoundException
     * @throws SlackChannelSetUpSettingsConflictException
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
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
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
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
     * @throws BetaEnvironmentNotFoundException
     * @throws SlackChannelSetUpEnvironmentNotFoundException
     * @throws SlackChannelSetUpSettingsConflictException
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
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
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
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
     * @throws SlackChannelSetUpSettingsConflictException
     * @throws APIException
     */
    public function delete(
        string $id,
        array|SlackChannelDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
