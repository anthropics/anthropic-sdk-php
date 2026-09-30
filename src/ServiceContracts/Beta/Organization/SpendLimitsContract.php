<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitUserScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitWorkspaceScope;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type ScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SpendLimitsContract
{
    /**
     * @api
     *
     * @param string $spendLimitID ID of the Spend Limit
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): SpendLimit;

    /**
     * @api
     *
     * @param string $spendLimitID ID of the Spend Limit
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): SpendLimitDeleteResponse;

    /**
     * @api
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
    ): SpendLimit;
}
