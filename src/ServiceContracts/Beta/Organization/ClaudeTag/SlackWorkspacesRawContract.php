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
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
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
     * @throws APIKeyScopeMissingException
     * @throws ClaudeTagWritesNotEnabledException
     * @throws ComplianceConfigurationRestrictedException
     * @throws OrganizationLevelScopedAPIKeyRequiredException
     * @throws APIException
     */
    public function list(
        array|SlackWorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
