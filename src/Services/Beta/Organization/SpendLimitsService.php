<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitUserScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitWorkspaceScope;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimitsContract;
use Anthropic\Services\Beta\Organization\SpendLimits\EffectiveService;
use Anthropic\Services\Beta\Organization\SpendLimits\IncreaseRequestsService;

/**
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SpendLimitsService implements SpendLimitsContract
{
    /**
     * @api
     */
    public SpendLimitsRawService $raw;

    /**
     * @api
     */
    public EffectiveService $effective;

    /**
     * @api
     */
    public IncreaseRequestsService $increaseRequests;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SpendLimitsRawService($client);
        $this->effective = new EffectiveService($client);
        $this->increaseRequests = new IncreaseRequestsService($client);
    }

    /**
     * @api
     *
     * Retrieve a spend limit by ID.
     *
     * @param string $spendLimitID ID of the Spend Limit
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): SpendLimit {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($spendLimitID, requestOptions: $requestOptions);

        return $response->parse();
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
     * @throws APIException
     */
    public function delete(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): SpendLimitDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($spendLimitID, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string|null $amount Limit amount as a non-negative integer decimal string in the minor unit of the organization's billing currency (cents for USD): "50000" is $500.00. `null` sets an explicit no-limit override for this scope and `period` only — each period resolves independently, so caps for other periods still apply.
     * @param ScopeShape $scope What the limit applies to. Claude Enterprise organizations set `user` limits. Claude Console organizations set `organization` and `workspace` limits. Any other combination returns 400. Setting `organization` and `workspace` limits through the API is in an early access preview. To request access, contact your Anthropic account team.
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod> $period
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function set(
        ?string $amount,
        SpendLimitUserScope|array|SpendLimitOrganizationScope|SpendLimitWorkspaceScope $scope,
        SpendLimitPeriod|string|null $period = null,
        RequestOptions|array|null $requestOptions = null,
    ): SpendLimit {
        $params = Util::removeNulls(
            ['amount' => $amount, 'scope' => $scope, 'period' => $period]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->set(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
