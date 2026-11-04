<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\BetaBillingFrozenException;
use Anthropic\Beta\Organization\SpendLimits\SpendLimit;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitDeleteResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitListParams;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitsAdminAPIWritesNotEnabledException;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\OrganizationTypeNotSupportedException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SpendLimitsRawContract
{
    /**
     * @api
     *
     * @param string $spendLimitID ID of the Spend Limit.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimit>
     *
     * @throws SpendLimitsAdminAPIWritesNotEnabledException The organization cannot retrieve, set or delete spend limits with an Admin API credential.
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SpendLimitListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SpendLimit>>
     *
     * @throws OrganizationTypeNotSupportedException The endpoint does not support the organization's type. Each endpoint's description says which organization types it supports.
     * @throws APIException
     */
    public function list(
        array|SpendLimitListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $spendLimitID ID of the Spend Limit.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimitDeleteResponse>
     *
     * @throws BetaBillingFrozenException Anthropic has temporarily disabled billing changes for the user account the credential belongs to. Contact support.
     * @throws SpendLimitsAdminAPIWritesNotEnabledException The organization cannot retrieve, set or delete spend limits with an Admin API credential.
     * @throws APIException
     */
    public function delete(
        string $spendLimitID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SpendLimitSetParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimit>
     *
     * @throws BetaBillingFrozenException Anthropic has temporarily disabled billing changes for the user account the credential belongs to. Contact support.
     * @throws SpendLimitsAdminAPIWritesNotEnabledException The organization cannot retrieve, set or delete spend limits with an Admin API credential.
     * @throws APIException
     */
    public function set(
        array|SpendLimitSetParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
