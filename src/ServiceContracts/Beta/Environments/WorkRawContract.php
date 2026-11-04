<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Environments;

use Anthropic\Beta\Environments\BetaInvalidMetadataException;
use Anthropic\Beta\Environments\Work\HeartbeatPreconditionFailedException;
use Anthropic\Beta\Environments\Work\SelfHostedWork;
use Anthropic\Beta\Environments\Work\SelfHostedWorkHeartbeatResponse;
use Anthropic\Beta\Environments\Work\SelfHostedWorkQueueStats;
use Anthropic\Beta\Environments\Work\WorkAckParams;
use Anthropic\Beta\Environments\Work\WorkHeartbeatParams;
use Anthropic\Beta\Environments\Work\WorkListParams;
use Anthropic\Beta\Environments\Work\WorkPollParams;
use Anthropic\Beta\Environments\Work\WorkRetrieveParams;
use Anthropic\Beta\Environments\Work\WorkStatsParams;
use Anthropic\Beta\Environments\Work\WorkStopParams;
use Anthropic\Beta\Environments\Work\WorkUpdateParams;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkRawContract
{
    /**
     * @api
     *
     * @param string $workID Path param
     * @param array<string,mixed>|WorkRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function retrieve(
        string $workID,
        array|WorkRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workID Path param
     * @param array<string,mixed>|WorkUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws BetaInvalidMetadataException `metadata` has too many keys, a key or value that is too long, or a reserved key. The message names each problem.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function update(
        string $workID,
        array|WorkUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $environmentID Path param
     * @param array<string,mixed>|WorkListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SelfHostedWork>>
     *
     * @throws APIException
     */
    public function list(
        string $environmentID,
        array|WorkListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workID Path param
     * @param array<string,mixed>|WorkAckParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function ack(
        string $workID,
        array|WorkAckParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workID Path param
     * @param array<string,mixed>|WorkHeartbeatParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWorkHeartbeatResponse>
     *
     * @throws HeartbeatPreconditionFailedException `expected_last_heartbeat` does not match the stored heartbeat, so another worker may hold the lease.
     * @throws APIException
     */
    public function heartbeat(
        string $workID,
        array|WorkHeartbeatParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $environmentID Path param
     * @param array<string,mixed>|WorkPollParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function poll(
        string $environmentID,
        array|WorkPollParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WorkStatsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWorkQueueStats>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function stats(
        string $environmentID,
        array|WorkStatsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $workID Path param
     * @param array<string,mixed>|WorkStopParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws APIException
     */
    public function stop(
        string $workID,
        array|WorkStopParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
