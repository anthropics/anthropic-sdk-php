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
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Compliance\Review\CasesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaComplianceReviewVerdictParamShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewVerdictParam
 */
final class CasesService implements CasesContract
{
    /**
     * @api
     */
    public CasesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CasesRawService($client);
    }

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Optional header to specify the beta version(s) you want to use.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $caseID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaComplianceReviewCase {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($caseID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param \DateTimeInterface $createdAtGt Query param: Return only cases whose `created_at` is after this time.
     * @param \DateTimeInterface $createdAtGte Query param: Return only cases whose `created_at` is at or after this time.
     * @param \DateTimeInterface $createdAtLt Query param: Return only cases whose `created_at` is before this time.
     * @param \DateTimeInterface $createdAtLte Query param: Return only cases whose `created_at` is at or before this time.
     * @param int $limit Query param: Number of cases to return per page, between 1 and 100. Defaults to 20.
     * @param ComplianceReviewOrder|value-of<ComplianceReviewOrder> $order Query param: Sort direction, by `order_by` and then by `id`. Defaults to `desc`.
     * @param BetaComplianceReviewCaseOrderBy|value-of<BetaComplianceReviewCaseOrderBy> $orderBy Query param: The field to sort by. Defaults to `created_at`.
     * @param string $page Query param: Opaque cursor from a previous response's `next_page`. Leave it out to get the first page. A cursor works only with the filters and sort order of the request that returned it.
     * @param BetaComplianceReviewCaseStatusFilter|value-of<BetaComplianceReviewCaseStatusFilter> $status Query param: Return only cases with this status. Leave it out to get both open and closed cases.
     * @param \DateTimeInterface $updatedAtGt Query param: Return only cases whose `updated_at` is after this time.
     * @param \DateTimeInterface $updatedAtGte Query param: Return cases whose `updated_at` is at or after this time. Cases slightly older than this time are also returned, so that a sync misses no change.
     * @param \DateTimeInterface $updatedAtLt Query param: Return only cases whose `updated_at` is before this time.
     * @param \DateTimeInterface $updatedAtLte Query param: Return only cases whose `updated_at` is at or before this time.
     * @param string $userProfileID Query param: Return only cases where a message's `user_profile_id` is this ID, including cases that also have messages of other user profiles. A case stops matching once its messages' `user_profile_id` is null. An ID that matches no reachable case returns no cases. A request that sends the `anthropic-user-profile-id` header without this parameter returns a 400 error.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaComplianceReviewCase>
     *
     * @throws APIException
     */
    public function list(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ComplianceReviewOrder|string|null $order = null,
        BetaComplianceReviewCaseOrderBy|string|null $orderBy = null,
        ?string $page = null,
        BetaComplianceReviewCaseStatusFilter|string|null $status = null,
        ?\DateTimeInterface $updatedAtGt = null,
        ?\DateTimeInterface $updatedAtGte = null,
        ?\DateTimeInterface $updatedAtLt = null,
        ?\DateTimeInterface $updatedAtLte = null,
        ?string $userProfileID = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'createdAtGt' => $createdAtGt,
                'createdAtGte' => $createdAtGte,
                'createdAtLt' => $createdAtLt,
                'createdAtLte' => $createdAtLte,
                'limit' => $limit,
                'order' => $order,
                'orderBy' => $orderBy,
                'page' => $page,
                'status' => $status,
                'updatedAtGt' => $updatedAtGt,
                'updatedAtGte' => $updatedAtGte,
                'updatedAtLt' => $updatedAtLt,
                'updatedAtLte' => $updatedAtLte,
                'userProfileID' => $userProfileID,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination> $determination Body param: Your conclusion on the case as a whole. Anthropic doesn't check it against `verdicts`.
     * @param list<BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>> $policyCategories Body param: The policy categories that you found were violated. Send one to four with `violation`, and none with `no_violation`. They need not match the case's own. Each value is one of `cyber`, `bio`, `chem`, `radnuc` (radiological or nuclear weapons), `cgw` (conventional weapons), `mgw` (military-grade weapons systems), `io` (influence operations), `fraud`, `violent_extremism`, `surveillance`, `human_exploitation`, `self_harm`, `adult_content`, `reasoning_extraction`, `frontier_llm` (use of the model to accelerate frontier AI research and development in restricted ways), `compromised_key` or `other`, and can appear once.
     * @param list<BetaComplianceReviewVerdictParam|BetaComplianceReviewVerdictParamShape> $verdicts Body param: Your conclusions on individual messages of the case. They need not cover every message, and each `item_id` can appear once.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas Header param: Optional header to specify the beta version(s) you want to use.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function respond(
        string $caseID,
        BetaComplianceReviewDetermination|string $determination,
        ?array $policyCategories = null,
        ?array $verdicts = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaComplianceReviewCase {
        $params = Util::removeNulls(
            [
                'determination' => $determination,
                'policyCategories' => $policyCategories,
                'verdicts' => $verdicts,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->respond($caseID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
