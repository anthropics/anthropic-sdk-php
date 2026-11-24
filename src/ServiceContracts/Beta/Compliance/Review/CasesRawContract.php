<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Compliance\Review;

use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCase;
use Anthropic\Beta\Compliance\Review\Cases\CaseListParams;
use Anthropic\Beta\Compliance\Review\Cases\CaseRespondParams;
use Anthropic\Beta\Compliance\Review\Cases\CaseRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface CasesRawContract
{
    /**
     * @api
     *
     * @param string $caseID The ID of the case (`rvc_...`).
     * @param array<string,mixed>|CaseRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaComplianceReviewCase>
     *
     * @throws APIException
     */
    public function retrieve(
        string $caseID,
        array|CaseRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CaseListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaComplianceReviewCase>>
     *
     * @throws APIException
     */
    public function list(
        array|CaseListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $caseID Path param: The ID of the case (`rvc_...`).
     * @param array<string,mixed>|CaseRespondParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaComplianceReviewCase>
     *
     * @throws APIException
     */
    public function respond(
        string $caseID,
        array|CaseRespondParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
