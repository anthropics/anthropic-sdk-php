<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Notices;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Compliance\Review\ComplianceReviewOrder;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Anthropic's notices to the organizations that the API key can reach, newest first by default. A notice is returned only if the API key can read every case in its `case_ids`.
 *
 * To poll, store the largest `created_at` you have read, and send it as the at-or-after filter on `created_at`. Read every page, match results by `id`, and store the new largest value after the last page.
 *
 * An Admin API key with the `read:compliance_review_cases` scope can call this endpoint.
 *
 * @see Anthropic\Services\Beta\Compliance\Review\NoticesService::list()
 *
 * @phpstan-type NoticeListParamsShape = array{
 *   caseID?: string|null,
 *   createdAtGt?: \DateTimeInterface|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLt?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   limit?: int|null,
 *   order?: null|ComplianceReviewOrder|value-of<ComplianceReviewOrder>,
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class NoticeListParams implements BaseModel
{
    /** @use SdkModel<NoticeListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return only notices whose `case_ids` include this case (`rvc_...`). A case that the API key can't read returns an empty list.
     */
    #[Optional]
    public ?string $caseID;

    /**
     * Return only notices whose `created_at` is after this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGt;

    /**
     * Return notices whose `created_at` is at or after this time. Notices slightly older than this time are also returned, so that a poll misses no notice.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return only notices whose `created_at` is before this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLt;

    /**
     * Return only notices whose `created_at` is at or before this time.
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * Number of notices to return per page, between 1 and 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Sort direction, by `created_at` and then by `id`. Defaults to `desc`.
     *
     * @var value-of<ComplianceReviewOrder>|null $order
     */
    #[Optional(enum: ComplianceReviewOrder::class)]
    public ?string $order;

    /**
     * Opaque cursor from a previous response's `next_page`. Leave it out to get the first page. A cursor works only with the filters and sort order of the request that returned it.
     */
    #[Optional]
    public ?string $page;

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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $caseID = null,
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        ComplianceReviewOrder|string|null $order = null,
        ?string $page = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $caseID && $self['caseID'] = $caseID;
        null !== $createdAtGt && $self['createdAtGt'] = $createdAtGt;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLt && $self['createdAtLt'] = $createdAtLt;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Return only notices whose `case_ids` include this case (`rvc_...`). A case that the API key can't read returns an empty list.
     */
    public function withCaseID(string $caseID): self
    {
        $self = clone $this;
        $self['caseID'] = $caseID;

        return $self;
    }

    /**
     * Return only notices whose `created_at` is after this time.
     */
    public function withCreatedAtGt(\DateTimeInterface $createdAtGt): self
    {
        $self = clone $this;
        $self['createdAtGt'] = $createdAtGt;

        return $self;
    }

    /**
     * Return notices whose `created_at` is at or after this time. Notices slightly older than this time are also returned, so that a poll misses no notice.
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return only notices whose `created_at` is before this time.
     */
    public function withCreatedAtLt(\DateTimeInterface $createdAtLt): self
    {
        $self = clone $this;
        $self['createdAtLt'] = $createdAtLt;

        return $self;
    }

    /**
     * Return only notices whose `created_at` is at or before this time.
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

        return $self;
    }

    /**
     * Number of notices to return per page, between 1 and 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Sort direction, by `created_at` and then by `id`. Defaults to `desc`.
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
     * Opaque cursor from a previous response's `next_page`. Leave it out to get the first page. A cursor works only with the filters and sort order of the request that returned it.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

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
