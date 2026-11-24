<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Compliance\Review;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCase;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseOrderBy;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseStatusFilter;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewDetermination;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewVerdictParam;
use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewViolatedPolicyCategory;
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type BetaComplianceReviewVerdictParamShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewVerdictParam
 */
interface CasesContract
{
    /**
     * @api
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
    ): BetaComplianceReviewCase;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): BetaComplianceReviewCase;
}
