<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequest;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequestStatus;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface IncreaseRequestsContract
{
    /**
     * @api
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitIncreaseRequestID,
        RequestOptions|array|null $requestOptions = null,
    ): BetaSpendLimitIncreaseRequest;

    /**
     * @api
     *
     * @param list<string>|null $actorIDs Filter by requester, as `user_...` tagged IDs.
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param list<BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus>>|null $status Filter by status. Omit to return all.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaSpendLimitIncreaseRequest>
     *
     * @throws APIException
     */
    public function list(
        ?array $actorIDs = null,
        ?int $limit = null,
        ?string $page = null,
        ?array $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request
     * @param string $amount new per-user spend limit as a non-negative integer decimal string (minor units)
     * @param SpendLimitPeriod|value-of<SpendLimitPeriod>|null $period
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function approve(
        string $spendLimitIncreaseRequestID,
        string $amount,
        SpendLimitPeriod|string|null $period = null,
        ?bool $suppressNotification = null,
        RequestOptions|array|null $requestOptions = null,
    ): IncreaseRequestApproveResponse;

    /**
     * @api
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deny(
        string $spendLimitIncreaseRequestID,
        ?bool $suppressNotification = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaSpendLimitIncreaseRequest;
}
