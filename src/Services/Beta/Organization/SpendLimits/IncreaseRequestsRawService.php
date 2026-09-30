<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\SpendLimits;

use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequest;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\BetaSpendLimitIncreaseRequestStatus;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveParams;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestDenyParams;
use Anthropic\Beta\Organization\SpendLimits\IncreaseRequests\IncreaseRequestListParams;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitPeriod;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\SpendLimits\IncreaseRequestsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class IncreaseRequestsRawService implements IncreaseRequestsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @return BaseResponse<BetaSpendLimitIncreaseRequest>
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitIncreaseRequestID,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/spend_limit_increase_requests/%1$s?beta=true',
                $spendLimitIncreaseRequestID,
            ],
            options: $requestOptions,
            convert: BetaSpendLimitIncreaseRequest::class,
        );
    }

    /**
     * @api
     *
     * List spend limit increase requests, most recent first.
     *
     * Pending requests include a live `spend_summary` for the requester.
     * Requests whose requester is no longer a member are excluded.
     *
     * @param array{
     *   actorIDs?: list<string>|null,
     *   limit?: int,
     *   page?: string|null,
     *   status?: list<BetaSpendLimitIncreaseRequestStatus|value-of<BetaSpendLimitIncreaseRequestStatus>>|null,
     * }|IncreaseRequestListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaSpendLimitIncreaseRequest>>
     *
     * @throws APIException
     */
    public function list(
        array|IncreaseRequestListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IncreaseRequestListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/spend_limit_increase_requests?beta=true',
            query: Util::array_transform_keys($parsed, ['actorIDs' => 'actor_ids']),
            options: $options,
            convert: BetaSpendLimitIncreaseRequest::class,
            page: PageCursor::class,
        );
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
     * @param array{
     *   amount: string,
     *   period?: SpendLimitPeriod|value-of<SpendLimitPeriod>|null,
     *   suppressNotification?: bool,
     * }|IncreaseRequestApproveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IncreaseRequestApproveResponse>
     *
     * @throws APIException
     */
    public function approve(
        string $spendLimitIncreaseRequestID,
        array|IncreaseRequestApproveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IncreaseRequestApproveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/spend_limit_increase_requests/%1$s/approve?beta=true',
                $spendLimitIncreaseRequestID,
            ],
            body: (object) $parsed,
            options: $options,
            convert: IncreaseRequestApproveResponse::class,
        );
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
     * @param array{suppressNotification?: bool}|IncreaseRequestDenyParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaSpendLimitIncreaseRequest>
     *
     * @throws APIException
     */
    public function deny(
        string $spendLimitIncreaseRequestID,
        array|IncreaseRequestDenyParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IncreaseRequestDenyParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/spend_limit_increase_requests/%1$s/deny?beta=true',
                $spendLimitIncreaseRequestID,
            ],
            body: (object) $parsed,
            options: $options,
            convert: BetaSpendLimitIncreaseRequest::class,
        );
    }
}
