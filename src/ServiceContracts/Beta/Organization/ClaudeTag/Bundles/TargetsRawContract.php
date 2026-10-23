<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\Bundles;

use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagDeletedBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTarget;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetCreateParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetDeleteParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetListParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\TargetRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface TargetsRawContract
{
    /**
     * @api
     *
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param array<string,mixed>|TargetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>
     *
     * @throws APIException
     */
    public function create(
        string $bundleID,
        array|TargetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $targetID Path param: The Bundle Target's identifier, starting with `btgt_`. Attach Bundle and List Bundle Targets return it. It is never the identifier of the channel or workspace.
     * @param array<string,mixed>|TargetRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>
     *
     * @throws APIException
     */
    public function retrieve(
        string $targetID,
        array|TargetRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $bundleID path param: The Bundle's identifier, starting with `capp_`
     * @param array<string,mixed>|TargetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget,>,>
     *
     * @throws APIException
     */
    public function list(
        string $bundleID,
        array|TargetListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $targetID Path param: The Bundle Target's identifier, starting with `btgt_`. Attach Bundle and List Bundle Targets return it. It is never the identifier of the channel or workspace.
     * @param array<string,mixed>|TargetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagDeletedBundleTarget>
     *
     * @throws APIException
     */
    public function delete(
        string $targetID,
        array|TargetDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
