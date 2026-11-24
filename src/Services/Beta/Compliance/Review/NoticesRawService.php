<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Beta\Compliance\Review\Notices\BetaComplianceReviewNotice;
use Anthropic\Beta\Compliance\Review\Notices\NoticeListParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Compliance\Review\NoticesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class NoticesRawService implements NoticesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List Anthropic's notices to the organizations that the API key can reach, newest first by default. A notice is returned only if the API key can read every case in its `case_ids`.
     *
     * To poll, store the largest `created_at` you have read, and send it as the at-or-after filter on `created_at`. Read every page, match results by `id`, and store the new largest value after the last page.
     *
     * An Admin API key with the `read:compliance_review_cases` scope can call this endpoint.
     *
     * @param array{
     *   caseID?: string,
     *   createdAtGt?: \DateTimeInterface,
     *   createdAtGte?: \DateTimeInterface,
     *   createdAtLt?: \DateTimeInterface,
     *   createdAtLte?: \DateTimeInterface,
     *   limit?: int,
     *   order?: ComplianceReviewOrder|value-of<ComplianceReviewOrder>,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|NoticeListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaComplianceReviewNotice>>
     *
     * @throws APIException
     */
    public function list(
        array|NoticeListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = NoticeListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'caseID',
                'createdAtGt',
                'createdAtGte',
                'createdAtLt',
                'createdAtLte',
                'limit',
                'order',
                'page',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/compliance/review/notices',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'caseID' => 'case_id',
                    'createdAtGt' => 'created_at[gt]',
                    'createdAtGte' => 'created_at[gte]',
                    'createdAtLt' => 'created_at[lt]',
                    'createdAtLte' => 'created_at[lte]',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.compliance.review.notices.list',
                route: '/v1/compliance/review/notices',
                query: [
                    'case_id',
                    'created_at[gt]',
                    'created_at[gte]',
                    'created_at[lt]',
                    'created_at[lte]',
                    'limit',
                    'order',
                    'page',
                ],
            )),
            convert: BetaComplianceReviewNotice::class,
            page: PageCursor::class,
        );
    }
}
