<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeTag;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BetaClaudeTagBundle;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BundleListParams;
use Anthropic\Beta\Organization\ClaudeTag\Bundles\BundleRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTag\BundlesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class BundlesRawService implements BundlesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get one Bundle. What the Bundle grants (connectors, repositories and credentials) is never returned.
     *
     * @param string $bundleID the Bundle's identifier, starting with `capp_`
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|BundleRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = BundleRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/claude_tag/bundles/%1$s', $bundleID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.bundles.retrieve',
                route: '/v1/organizations/claude_tag/bundles/{bundle_id}',
                attributes: [
                    'anthropic.organization.claude_tag.bundle.id' => $bundleID,
                ],
            )),
            convert: BetaClaudeTagBundle::class,
        );
    }

    /**
     * @api
     *
     * List the organization's Bundles, newest first by `created_at`. A Bundle that Claude Tag manages for itself is not listed.
     *
     * @param array{
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|BundleListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaClaudeTagBundle>>
     *
     * @throws APIException
     */
    public function list(
        array|BundleListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BundleListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/claude_tag/bundles',
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'experimental-claude-tag-2026-10-21',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.claude_tag.bundles.list',
                route: '/v1/organizations/claude_tag/bundles',
                query: ['limit', 'page'],
            )),
            convert: BetaClaudeTagBundle::class,
            page: PageCursor::class,
        );
    }
}
