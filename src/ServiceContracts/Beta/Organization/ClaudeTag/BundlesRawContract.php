<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\ClaudeTag;

use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BundleListParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BundleRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface BundlesRawContract
{
    /**
     * @api
     *
     * @param string $bundleID the Bundle's identifier, starting with `capp_`
     * @param array<string,mixed>|BundleRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaClaudeTagBundle>
     *
     * @throws APIException
     */
    public function retrieve(
        string $bundleID,
        array|BundleRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BundleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagBundle>>
     *
     * @throws APIException
     */
    public function list(
        array|BundleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
