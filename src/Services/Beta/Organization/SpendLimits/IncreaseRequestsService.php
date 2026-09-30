<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequest;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequestStatus;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimits\IncreaseRequestsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class IncreaseRequestsService implements IncreaseRequestsContract
{
    /**
     * @api
     */
    public IncreaseRequestsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new IncreaseRequestsRawService($client);
    }

    /**
     * @api
     *
     * Retrieve a spend limit increase request.
     *
     * While `pending`, the response includes a live `spend_summary` for the
     * requester at the request's period.
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitIncreaseRequestID,
        RequestOptions|array|null $requestOptions = null,
    ): BetaSpendLimitIncreaseRequest {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($spendLimitIncreaseRequestID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List spend limit increase requests, most recent first.
     *
     * Pending requests include a live `spend_summary` for the requester.
     * Requests whose requester is no longer a member are excluded.
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
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'actorIDs' => $actorIDs,
                'limit' => $limit,
                'page' => $page,
                'status' => $status,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Approve a pending spend limit increase request.
     *
     * Writes a per-user spend limit at `amount` for the requester and
     * transitions the request to `approved`. `period` defaults to the period
     * the member was blocked on. Anthropic emails the requester unless
     * `suppress_notification` is set.
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
    ): IncreaseRequestApproveResponse {
        $params = Util::removeNulls(
            [
                'amount' => $amount,
                'period' => $period,
                'suppressNotification' => $suppressNotification,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->approve($spendLimitIncreaseRequestID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deny a pending spend limit increase request.
     *
     * Idempotent on `denied`; denying an already-`approved` request returns
     * 400. Anthropic emails the requester unless `suppress_notification` is set.
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
    ): BetaSpendLimitIncreaseRequest {
        $params = Util::removeNulls(
            ['suppressNotification' => $suppressNotification]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deny($spendLimitIncreaseRequestID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
