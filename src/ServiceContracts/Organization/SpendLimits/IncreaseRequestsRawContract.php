<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Organization\SpendLimits;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveParams;
use Anthropic\Organization\SpendLimits\IncreaseRequests\IncreaseRequestApproveResponse;
use Anthropic\Organization\SpendLimits\IncreaseRequests\IncreaseRequestDenyParams;
use Anthropic\Organization\SpendLimits\IncreaseRequests\IncreaseRequestListParams;
use Anthropic\Organization\SpendLimits\IncreaseRequests\SpendLimitIncreaseRequest;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface IncreaseRequestsRawContract
{
    /**
     * @api
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimitIncreaseRequest>
     *
     * @throws APIException
     */
    public function retrieve(
        string $spendLimitIncreaseRequestID,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|IncreaseRequestListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SpendLimitIncreaseRequest>>
     *
     * @throws APIException
     */
    public function list(
        array|IncreaseRequestListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request.
     * @param array<string,mixed>|IncreaseRequestApproveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $spendLimitIncreaseRequestID ID of the spend limit increase request.
     * @param array<string,mixed>|IncreaseRequestDenyParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SpendLimitIncreaseRequest>
     *
     * @throws APIException
     */
    public function deny(
        string $spendLimitIncreaseRequestID,
        array|IncreaseRequestDenyParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
