<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCase;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseOrderBy;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseStatusFilter;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewDetermination;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewVerdictParam;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewViolatedPolicyCategory;
use Anthropic\Beta\Compliance\Review\Cases\CaseListParams;
use Anthropic\Beta\Compliance\Review\Cases\CaseRespondParams;
use Anthropic\Beta\Compliance\Review\Cases\CaseRetrieveParams;
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Compliance\Review\CasesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaComplianceReviewVerdictParamShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewVerdictParam
 */
final class CasesRawService implements CasesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Read one review case.
     *
     * A case that the API key can't reach, or that Anthropic hasn't sent, returns the same 404 as a case that doesn't exist.
     *
     * An Admin API key with the `read:compliance_review_cases` scope can call this endpoint.
     *
     * @param string $caseID The ID of the case (`rvc_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|CaseRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CaseRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/compliance/review/cases/%1$s', $caseID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.compliance.review.cases.retrieve',
                route: '/v1/compliance/review/cases/{case_id}',
                attributes: ['anthropic.compliance.review.case.id' => $caseID],
            )),
            convert: BetaComplianceReviewCase::class,
        );
    }

    /**
     * @api
     *
     * List the review cases of every organization that the API key can reach, newest first by default. Both open and closed cases are returned unless `status` is set.
     *
     * To sync, store the largest `updated_at` you have read, and send it as the at-or-after filter on `updated_at`, sorted by `updated_at` ascending. That finds new cases, newly closed cases, and cases with a new notice. Read every page, match results by `id`, and store the new largest value after the last page.
     *
     * A request with the `anthropic-user-profile-id` header and no `user_profile_id` parameter returns a 400 error.
     *
     * An Admin API key with the `read:compliance_review_cases` scope can call this endpoint.
     *
     * @param array{
     *   createdAtGt?: \DateTimeInterface,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLt?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   limit?: int,
     *   order?: ComplianceReviewOrder|value-of<ComplianceReviewOrder>,
     *   orderBy?: BetaComplianceReviewCaseOrderBy|value-of<BetaComplianceReviewCaseOrderBy>,
     *   page?: string,
     *   status?: BetaComplianceReviewCaseStatusFilter|value-of<BetaComplianceReviewCaseStatusFilter>,
     *   updatedAtGt?: \DateTimeInterface,
     *   updatedAtGte?: \DateTimeInterface,
     *   updatedAtLt?: \DateTimeInterface,
     *   updatedAtLte?: \DateTimeInterface,
     *   userProfileID?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CaseListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaComplianceReviewCase>>
     *
     * @throws APIException
     */
    public function list(
        array|CaseListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CaseListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'createdAtGt',
                'createdAtGte',
                'createdAtLt',
                'createdAtLte',
                'limit',
                'order',
                'orderBy',
                'page',
                'status',
                'updatedAtGt',
                'updatedAtGte',
                'updatedAtLt',
                'updatedAtLte',
                'userProfileID',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/compliance/review/cases',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'createdAtGt' => 'created_at[gt]',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLt' => 'created_at[lt]',
                    'createdAtLte' => 'created_at[lte]',
                    'orderBy' => 'order_by',
                    'updatedAtGt' => 'updated_at[gt]',
                    'updatedAtGte' => 'updated_at[gte]',
                    'updatedAtLt' => 'updated_at[lt]',
                    'updatedAtLte' => 'updated_at[lte]',
                    'userProfileID' => 'user_profile_id',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.compliance.review.cases.list',
                route: '/v1/compliance/review/cases',
                query: [
                    'created_at[gt]',
                    'created_at[gte]',
                    'created_at[lt]',
                    'created_at[lte]',
                    'limit',
                    'order',
                    'order_by',
                    'page',
                    'status',
                    'updated_at[gt]',
                    'updated_at[gte]',
                    'updated_at[lt]',
                    'updated_at[lte]',
                    'user_profile_id',
                ],
            )),
            convert: BetaComplianceReviewCase::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Send your conclusion on a review case. A response closes the case, and a closed case can't be reopened.
     *
     * Only the first response counts. A request is safe to send again: if the closed case has a response with the same field values, in any list order, the API returns 200 and changes nothing. If the closed case has a different response, or none, the API returns a 400 with `case_closed` in `error.details.error_code`.
     *
     * If your end customer reviews this case instead of you, the API returns a 403 with `case_reviewed_by_end_customer` in `error.details.error_code`.
     *
     * An Admin API key with the `write:compliance_review_cases` scope can call this endpoint.
     *
     * @param string $caseID Path param: The ID of the case (`rvc_...`).
     * @param array{
     *   determination: BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination>,
     *   policyCategories?: list<BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>>,
     *   verdicts?: list<BetaComplianceReviewVerdictParam|BetaComplianceReviewVerdictParamShape>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CaseRespondParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CaseRespondParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/compliance/review/cases/%1$s/respond', $caseID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.compliance.review.cases.respond',
                route: '/v1/compliance/review/cases/{case_id}/respond',
                attributes: ['anthropic.compliance.review.case.id' => $caseID],
            )),
            convert: BetaComplianceReviewCase::class,
        );
    }
}
