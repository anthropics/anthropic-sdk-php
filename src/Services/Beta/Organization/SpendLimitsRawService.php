<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimitsRawContract;

/**
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
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
            options: $requestOptions,
            convert: SpendLimit::class,
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
     * workspace limits. Deleting them through the API is in an early access preview.
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
            options: $requestOptions,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/spend_limits?beta=true',
            body: (object) $parsed,
            options: $options,
            convert: SpendLimit::class,
        );
    }
}
