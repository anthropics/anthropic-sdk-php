<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Beta\Compliance\Review\Notices\BetaComplianceReviewNotice;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Compliance\Review\NoticesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class NoticesService implements NoticesContract
{
    /**
     * @api
     */
    public NoticesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new NoticesRawService($client);
    }

    /**
     * @api
     *
     * List Anthropic's notices to the organizations that the API key can reach, newest first by default. A notice is returned only if the API key can read every case in its `case_ids`.
     *
     * To poll, store the largest `created_at` you have read, and send it as the at-or-after filter on `created_at`. Read every page, match results by `id`, and store the new largest value after the last page.
     *
     * An Admin API key with the `read:compliance_review_cases` scope can call this endpoint.
     *
     * @param string $caseID Query param: Return only notices whose `case_ids` include this case (`rvc_...`). A case that the API key can't read returns an empty list.
     * @param \DateTimeInterface $createdAtGt Query param: Return only notices whose `created_at` is after this time.
     * @param \DateTimeInterface $createdAtGte Query param: Return notices whose `created_at` is at or after this time. Notices slightly older than this time are also returned, so that a poll misses no notice.
     * @param \DateTimeInterface $createdAtLt Query param: Return only notices whose `created_at` is before this time.
     * @param \DateTimeInterface $createdAtLte Query param: Return only notices whose `created_at` is at or before this time.
     * @param int $limit Query param: Number of notices to return per page, between 1 and 100. Defaults to 20.
     * @param ComplianceReviewOrder|value-of<ComplianceReviewOrder> $order Query param: Sort direction, by `created_at` and then by `id`. Defaults to `desc`.
     * @param string $page Query param: Opaque cursor from a previous response's `next_page`. Leave it out to get the first page. A cursor works only with the filters and sort order of the request that returned it.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaComplianceReviewNotice>
     *
     * @throws APIException
     */
    public function list(
        ?string $caseID = null,
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ComplianceReviewOrder|string|null $order = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'caseID' => $caseID,
                'createdAtGt' => $createdAtGt,
                'createdAtGte' => $createdAtGte,
                'createdAtLt' => $createdAtLt,
                'createdAtLte' => $createdAtLte,
                'limit' => $limit,
                'order' => $order,
                'page' => $page,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
