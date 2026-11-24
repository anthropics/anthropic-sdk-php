<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the review cases of every organization that the API key can reach, newest first by default. Both open and closed cases are returned unless `status` is set.
 *
 * To sync, store the largest `updated_at` you have read, and send it as the at-or-after filter on `updated_at`, sorted by `updated_at` ascending. That finds new cases, newly closed cases, and cases with a new notice. Read every page, match results by `id`, and store the new largest value after the last page.
 *
 * A request with the `anthropic-user-profile-id` header and no `user_profile_id` parameter returns a 400 error.
 *
 * An Admin API key with the `read:compliance_review_cases` scope can call this endpoint.
 *
 * @see Anthropic\Services\Beta\Compliance\Review\CasesService::list()
 *
 * @phpstan-type CaseListParamsShape = array{
 *   createdAtGt?: \DateTimeInterface|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLt?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   limit?: int|null,
 *   order?: null|ComplianceReviewOrder|value-of<ComplianceReviewOrder>,
 *   orderBy?: null|BetaComplianceReviewCaseOrderBy|value-of<BetaComplianceReviewCaseOrderBy>,
 *   page?: string|null,
 *   status?: null|BetaComplianceReviewCaseStatusFilter|value-of<BetaComplianceReviewCaseStatusFilter>,
 *   updatedAtGt?: \DateTimeInterface|null,
 *   updatedAtGte?: \DateTimeInterface|null,
 *   updatedAtLt?: \DateTimeInterface|null,
 *   updatedAtLte?: \DateTimeInterface|null,
 *   userProfileID?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CaseListParams implements BaseModel
{
    /** @use SdkModel<CaseListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return only cases whose `created_at` is after this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGt;

    /**
     * Return only cases whose `created_at` is at or after this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return only cases whose `created_at` is before this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLt;

    /**
     * Return only cases whose `created_at` is at or before this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * Number of cases to return per page, between 1 and 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Sort direction, by `order_by` and then by `id`. Defaults to `desc`.
     *
     * @var value-of<ComplianceReviewOrder>|null $order
     */
    #[Optional(enum: ComplianceReviewOrder::class)]
    public ?string $order;

    /**
     * The field to sort by. Defaults to `created_at`.
     *
     * @var value-of<BetaComplianceReviewCaseOrderBy>|null $orderBy
     */
    #[Optional(enum: BetaComplianceReviewCaseOrderBy::class)]
    public ?string $orderBy;

    /**
     * Opaque cursor from a previous response's `next_page`. Leave it out to get the first page. A cursor works only with the filters and sort order of the request that returned it.
     */
    #[Optional]
    public ?string $page;

    /**
     * Return only cases with this status. Leave it out to get both open and closed cases.
     *
     * @var value-of<BetaComplianceReviewCaseStatusFilter>|null $status
     */
    #[Optional(enum: BetaComplianceReviewCaseStatusFilter::class)]
    public ?string $status;

    /**
     * Return only cases whose `updated_at` is after this time.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAtGt;

    /**
     * Return cases whose `updated_at` is at or after this time. Cases slightly older than this time are also returned, so that a sync misses no change.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAtGte;

    /**
     * Return only cases whose `updated_at` is before this time.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAtLt;

    /**
     * Return only cases whose `updated_at` is at or before this time.
     */
    #[Optional]
    public ?\DateTimeInterface $updatedAtLte;

    /**
     * Return only cases where a message's `user_profile_id` is this ID, including cases that also have messages of other user profiles. A case stops matching once its messages' `user_profile_id` is null. An ID that matches no reachable case returns no cases. A request that sends the `anthropic-user-profile-id` header without this parameter returns a 400 error.
     */
    #[Optional]
    public ?string $userProfileID;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ComplianceReviewOrder|value-of<ComplianceReviewOrder>|null $order
     * @param BetaComplianceReviewCaseOrderBy|value-of<BetaComplianceReviewCaseOrderBy>|null $orderBy
     * @param BetaComplianceReviewCaseStatusFilter|value-of<BetaComplianceReviewCaseStatusFilter>|null $status
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
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
    ): self {
        $self = new self;

        null !== $createdAtGt && $self['createdAtGt'] = $createdAtGt;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLt && $self['createdAtLt'] = $createdAtLt;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $orderBy && $self['orderBy'] = $orderBy;
        null !== $page && $self['page'] = $page;
        null !== $status && $self['status'] = $status;
        null !== $updatedAtGt && $self['updatedAtGt'] = $updatedAtGt;
        null !== $updatedAtGte && $self['updatedAtGte'] = $updatedAtGte;
        null !== $updatedAtLt && $self['updatedAtLt'] = $updatedAtLt;
        null !== $updatedAtLte && $self['updatedAtLte'] = $updatedAtLte;
        null !== $userProfileID && $self['userProfileID'] = $userProfileID;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Return only cases whose `created_at` is after this time.
     */
    public function withCreatedAtGt(\DateTimeInterface $createdAtGt): self
    {
        $self = clone $this;
        $self['createdAtGt'] = $createdAtGt;

        return $self;
    }

    /**
     * Return only cases whose `created_at` is at or after this time.
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return only cases whose `created_at` is before this time.
     */
    public function withCreatedAtLt(\DateTimeInterface $createdAtLt): self
    {
        $self = clone $this;
        $self['createdAtLt'] = $createdAtLt;

        return $self;
    }

    /**
     * Return only cases whose `created_at` is at or before this time.
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * Number of cases to return per page, between 1 and 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Sort direction, by `order_by` and then by `id`. Defaults to `desc`.
     *
     * @param ComplianceReviewOrder|value-of<ComplianceReviewOrder> $order
     */
    public function withOrder(ComplianceReviewOrder|string $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

        return $self;
    }

    /**
     * The field to sort by. Defaults to `created_at`.
     *
     * @param BetaComplianceReviewCaseOrderBy|value-of<BetaComplianceReviewCaseOrderBy> $orderBy
     */
    public function withOrderBy(
        BetaComplianceReviewCaseOrderBy|string $orderBy
    ): self {
        $self = clone $this;
        $self['orderBy'] = $orderBy;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`. Leave it out to get the first page. A cursor works only with the filters and sort order of the request that returned it.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only cases with this status. Leave it out to get both open and closed cases.
     *
     * @param BetaComplianceReviewCaseStatusFilter|value-of<BetaComplianceReviewCaseStatusFilter> $status
     */
    public function withStatus(
        BetaComplianceReviewCaseStatusFilter|string $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Return only cases whose `updated_at` is after this time.
     */
    public function withUpdatedAtGt(\DateTimeInterface $updatedAtGt): self
    {
        $self = clone $this;
        $self['updatedAtGt'] = $updatedAtGt;

        return $self;
    }

    /**
     * Return cases whose `updated_at` is at or after this time. Cases slightly older than this time are also returned, so that a sync misses no change.
     */
    public function withUpdatedAtGte(\DateTimeInterface $updatedAtGte): self
    {
        $self = clone $this;
        $self['updatedAtGte'] = $updatedAtGte;

        return $self;
    }

    /**
     * Return only cases whose `updated_at` is before this time.
     */
    public function withUpdatedAtLt(\DateTimeInterface $updatedAtLt): self
    {
        $self = clone $this;
        $self['updatedAtLt'] = $updatedAtLt;

        return $self;
    }

    /**
     * Return only cases whose `updated_at` is at or before this time.
     */
    public function withUpdatedAtLte(\DateTimeInterface $updatedAtLte): self
    {
        $self = clone $this;
        $self['updatedAtLte'] = $updatedAtLte;

        return $self;
    }

    /**
     * Return only cases where a message's `user_profile_id` is this ID, including cases that also have messages of other user profiles. A case stops matching once its messages' `user_profile_id` is null. An ID that matches no reachable case returns no cases. A request that sends the `anthropic-user-profile-id` header without this parameter returns a 400 error.
     */
    public function withUserProfileID(string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
