<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitListParams;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitListParams\ScopeType;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimitsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope
 */
final class SpendLimitsRawService implements SpendLimitsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve a spend limit by ID.
     *
     * @param string $spendLimitID ID of the Spend Limit
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimit>
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/spend_limits/%1$s?beta=true', $spendLimitID],
            options: RequestOptions::parse($requestOptions)->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.spend_limits.retrieve',
                route: '/v1/organizations/spend_limits/{spend_limit_id}',
                attributes: ['anthropic.organization.spend_limit.id' => $spendLimitID],
            )),
            convert: SpendLimit::class,
        );
    }

    /**
     * @api
     *
     * List the organization's spend limits.
     *
     * A Claude Console organization's limits, including any read-only `usage_tier`
     * limit, come newest first. Listing them is in an early access preview. To
     * request access, contact your Anthropic account team. A Claude Enterprise
     * organization's limits are grouped by scope type, in the order `organization`,
     * `seat_tier`, `rbac_group`, `organization_service`, `user`; within a type they
     * come in a fixed order that is not creation order.
     *
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   scopeType?: list<ScopeType|value-of<ScopeType>>|null,
     *   workspaceID?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SpendLimitListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SpendLimit>>
     *
     * @throws APIException
     */
    public function list(
        array|SpendLimitListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SpendLimitListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page', 'scopeType', 'workspaceID']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/spend_limits?beta=true',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['scopeType' => 'scope_type', 'workspaceID' => 'workspace_id'],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => ['anthropic-beta' => 'spend-limit-reads-2026-09-26'],
                ],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.spend_limits.list',
                route: '/v1/organizations/spend_limits',
                query: ['limit', 'page', 'scope_type', 'workspace_id'],
            )),
            convert: SpendLimit::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a spend limit.
     *
     * For a Claude Enterprise organization, this deletes a per-user override, and
     * the member falls back to any inherited spend limit at that period. Its
     * seat-tier, group, and organization-level rows cannot be deleted via this
     * endpoint. A Claude Console organization deletes its organization and
     * workspace limits, but not its `usage_tier` limit. Deleting organization and
     * workspace limits through the API is in an early access preview.
     *
     * @param string $spendLimitID ID of the Spend Limit
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimitDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/spend_limits/%1$s?beta=true', $spendLimitID],
            options: RequestOptions::parse($requestOptions)->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.spend_limits.delete',
                route: '/v1/organizations/spend_limits/{spend_limit_id}',
                attributes: ['anthropic.organization.spend_limit.id' => $spendLimitID],
            )),
            convert: SpendLimitDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Set a spend limit.
     *
     * Upsert keyed on (scope, period): setting a limit that already exists
     * overwrites it in place. A Claude Enterprise organization sets `user`
     * limits. Its seat-tier, group, and organization-level defaults are configured
     * in claude.ai. A Claude Console organization sets `organization` and
     * `workspace` limits, which are monthly and always carry an amount. Setting those
     * limits is in an early access preview. To request access, contact your
     * Anthropic account team.
     *
     * @param array{
     *   amount: string|null,
     *   scope: ScopeShape,
     *   period?: SpendLimitPeriod|value-of<SpendLimitPeriod>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|SpendLimitSetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimit>
     *
     * @throws APIException
     */
    public function set(
        array|SpendLimitSetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SpendLimitSetParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/spend_limits?beta=true',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.spend_limits.set',
                route: '/v1/organizations/spend_limits',
                createdId: 'anthropic.organization.spend_limit.id',
            )),
            convert: SpendLimit::class,
        );
    }
}
