<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentArchivedException;
use Anthropic\Beta\Environments\BetaEnvironmentCreateDisabledException;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
use Anthropic\Beta\Environments\BetaEnvironmentUpdateDisabledException;
use Anthropic\Beta\Environments\BetaInvalidConfigTypeChangeException;
use Anthropic\Beta\Environments\EnvironmentArchiveParams;
use Anthropic\Beta\Environments\EnvironmentCreateParams;
use Anthropic\Beta\Environments\EnvironmentDeleteParams;
use Anthropic\Beta\Environments\EnvironmentListParams;
use Anthropic\Beta\Environments\EnvironmentRetrieveParams;
use Anthropic\Beta\Environments\EnvironmentUpdateParams;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EnvironmentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws BetaEnvironmentCreateDisabledException Anthropic has turned off creating environments for this organization. Existing environments still work.
     * @throws APIException
     */
    public function create(
        array|EnvironmentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function retrieve(
        string $environmentID,
        array|EnvironmentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $environmentID Path param
     * @param array<string,mixed>|EnvironmentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws BetaEnvironmentArchivedException The environment is archived, so it cannot be updated.
     * @throws BetaInvalidConfigTypeChangeException `config.type` differs from the environment's stored type, which cannot change after creation.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws BetaEnvironmentUpdateDisabledException Anthropic has turned off updating environments for this organization. Existing environments still work as they are.
     * @throws APIException
     */
    public function update(
        string $environmentID,
        array|EnvironmentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaEnvironment>>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function list(
        array|EnvironmentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironmentDeleteResponse>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function delete(
        string $environmentID,
        array|EnvironmentDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function archive(
        string $environmentID,
        array|EnvironmentArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
