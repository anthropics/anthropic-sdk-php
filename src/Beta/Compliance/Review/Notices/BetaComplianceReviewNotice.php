<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Notices;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A message from Anthropic to an organization about its review cases or about the organization as a whole, such as a request to respond by a date, a warning, or a question. A notice doesn't change after Anthropic sends it.
 *
 * @phpstan-import-type BetaComplianceReviewNoticeKindShape from \Anthropic\Beta\Compliance\Review\Notices\BetaComplianceReviewNoticeKind
 *
 * @phpstan-type BetaComplianceReviewNoticeShape = array{
 *   id: string,
 *   caseIDs: list<string>,
 *   createdAt: \DateTimeInterface,
 *   kind: BetaComplianceReviewNoticeKind|BetaComplianceReviewNoticeKindShape,
 *   message: string,
 *   organizationID: string,
 *   respondBy: \DateTimeInterface|null,
 *   type: 'compliance_review_notice',
 * }
 */
final class BetaComplianceReviewNotice implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewNoticeShape> */
    use SdkModel;

    /**
     * The object type, always `compliance_review_notice`.
     *
     * @var 'compliance_review_notice' $type
     */
    #[Required(type: new ConstantOf('compliance_review_notice'))]
    public string $type = 'compliance_review_notice';

    /**
     * The unique ID of the notice (`rvn_...`).
     */
    #[Required]
    public string $id;

    /**
     * The IDs of the cases that the notice is about (`rvc_...`). Empty when the notice is about the whole organization.
     *
     * @var list<string> $caseIDs
     */
    #[Required('case_ids', list: 'string')]
    public array $caseIDs;

    /**
     * When Anthropic sent the notice.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * What kind of notice this is.
     */
    #[Required]
    public BetaComplianceReviewNoticeKind $kind;

    /**
     * The text of the notice.
     */
    #[Required]
    public string $message;

    /**
     * The UUID of the organization that the notice is for.
     */
    #[Required('organization_id')]
    public string $organizationID;

    /**
     * The time by which Anthropic asks for an answer. Null when there is no deadline. Missing it changes nothing on a case, and the time to respond to a case can end before it.
     */
    #[Required('respond_by')]
    public ?\DateTimeInterface $respondBy;

    /**
     * `new BetaComplianceReviewNotice()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewNotice::with(
     *   id: ...,
     *   caseIDs: ...,
     *   createdAt: ...,
     *   kind: ...,
     *   message: ...,
     *   organizationID: ...,
     *   respondBy: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewNotice())
     *   ->withID(...)
     *   ->withCaseIDs(...)
     *   ->withCreatedAt(...)
     *   ->withKind(...)
     *   ->withMessage(...)
     *   ->withOrganizationID(...)
     *   ->withRespondBy(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string> $caseIDs
     * @param BetaComplianceReviewNoticeKind|BetaComplianceReviewNoticeKindShape $kind
     */
    public static function with(
        string $id,
        array $caseIDs,
        \DateTimeInterface $createdAt,
        BetaComplianceReviewNoticeKind|array $kind,
        string $message,
        string $organizationID,
        ?\DateTimeInterface $respondBy,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['caseIDs'] = $caseIDs;
        $self['createdAt'] = $createdAt;
        $self['kind'] = $kind;
        $self['message'] = $message;
        $self['organizationID'] = $organizationID;
        $self['respondBy'] = $respondBy;

        return $self;
    }

    /**
     * The unique ID of the notice (`rvn_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The IDs of the cases that the notice is about (`rvc_...`). Empty when the notice is about the whole organization.
     *
     * @param list<string> $caseIDs
     */
    public function withCaseIDs(array $caseIDs): self
    {
        $self = clone $this;
        $self['caseIDs'] = $caseIDs;

        return $self;
    }

    /**
     * When Anthropic sent the notice.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * What kind of notice this is.
     *
     * @param BetaComplianceReviewNoticeKind|BetaComplianceReviewNoticeKindShape $kind
     */
    public function withKind(BetaComplianceReviewNoticeKind|array $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    /**
     * The text of the notice.
     */
    public function withMessage(string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }

    /**
     * The UUID of the organization that the notice is for.
     */
    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * The time by which Anthropic asks for an answer. Null when there is no deadline. Missing it changes nothing on a case, and the time to respond to a case can end before it.
     */
    public function withRespondBy(?\DateTimeInterface $respondBy): self
    {
        $self = clone $this;
        $self['respondBy'] = $respondBy;

        return $self;
    }

    /**
     * The object type, always `compliance_review_notice`.
     *
     * @param 'compliance_review_notice' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
