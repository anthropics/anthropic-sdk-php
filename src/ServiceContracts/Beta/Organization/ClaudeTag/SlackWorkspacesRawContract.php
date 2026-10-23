<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

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
     * @param string $id path param: The workspace's identifier, starting with `slws_`
     * @param array<string,mixed>|SlackWorkspaceRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackWorkspace>
     *
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
     * @param string $id path param: The workspace's identifier, starting with `slws_`
     * @param array<string,mixed>|SlackWorkspaceUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackWorkspace>
     *
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
     * @throws APIException
     */
    public function list(
        array|SlackWorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
