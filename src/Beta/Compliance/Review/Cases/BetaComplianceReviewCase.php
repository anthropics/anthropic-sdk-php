<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A record of an organization's messages that Anthropic flagged and sent to the organization to review. It lists the messages by ID and doesn't include their content.
 *
 * @phpstan-import-type BetaComplianceReviewEnforcementActionShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewEnforcementAction
 * @phpstan-import-type BetaComplianceReviewCaseStatusShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseStatus
 * @phpstan-import-type BetaComplianceReviewTranscriptShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewTranscript
 * @phpstan-import-type BetaComplianceReviewCaseStatusVariants from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseStatus
 *
 * @phpstan-type BetaComplianceReviewCaseShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   enforcementAction: null|BetaComplianceReviewEnforcementAction|BetaComplianceReviewEnforcementActionShape,
 *   organizationID: string,
 *   policyCategories: list<BetaComplianceReviewPolicyCategory|value-of<BetaComplianceReviewPolicyCategory>>,
 *   status: BetaComplianceReviewCaseStatusShape,
 *   transcripts: list<BetaComplianceReviewTranscript|BetaComplianceReviewTranscriptShape>,
 *   type: 'compliance_review_case',
 *   updatedAt: \DateTimeInterface,
 *   workspaceID: string|null,
 * }
 */
final class BetaComplianceReviewCase implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewCaseShape> */
    use SdkModel;

    /**
     * The object type, always `compliance_review_case`.
     *
     * @var 'compliance_review_case' $type
     */
    #[Required(type: new ConstantOf('compliance_review_case'))]
    public string $type = 'compliance_review_case';

    /**
     * The unique ID of the case (`rvc_...`).
     */
    #[Required]
    public string $id;

    /**
     * When Anthropic sent the case. The time you have to respond starts here.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The action that Anthropic took before it sent the case. Null when it took none.
     */
    #[Required('enforcement_action')]
    public ?BetaComplianceReviewEnforcementAction $enforcementAction;

    /**
     * The UUID of the organization that sent the flagged messages, which the case belongs to.
     */
    #[Required('organization_id')]
    public string $organizationID;

    /**
     * Anthropic's labels for why the messages were flagged, such as `cyber` or `fraud`. There is at least one. New values can appear, so accept a value that you don't know.
     *
     * @var list<value-of<BetaComplianceReviewPolicyCategory>> $policyCategories
     */
    #[Required(
        'policy_categories',
        list: BetaComplianceReviewPolicyCategory::class
    )]
    public array $policyCategories;

    /**
     * Whether Anthropic is still waiting for a response.
     *
     * @var BetaComplianceReviewCaseStatusVariants $status
     */
    #[Required(union: BetaComplianceReviewCaseStatus::class)]
    public BetaComplianceReviewCaseOpen|BetaComplianceReviewCaseClosed $status;

    /**
     * The flagged messages. There is at least one, and the list isn't paginated.
     *
     * @var list<BetaComplianceReviewTranscript> $transcripts
     */
    #[Required(list: BetaComplianceReviewTranscript::class)]
    public array $transcripts;

    /**
     * When the case last changed. It changes when Anthropic sends the case, when the case closes, and when Anthropic sends a notice about the case.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * The ID of the workspace that sent the flagged messages (`wrkspc_...`). Null when the messages have no workspace, and it can be null for the default workspace.
     */
    #[Required('workspace_id')]
    public ?string $workspaceID;

    /**
     * `new BetaComplianceReviewCase()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewCase::with(
     *   id: ...,
     *   createdAt: ...,
     *   enforcementAction: ...,
     *   organizationID: ...,
     *   policyCategories: ...,
     *   status: ...,
     *   transcripts: ...,
     *   updatedAt: ...,
     *   workspaceID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewCase())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEnforcementAction(...)
     *   ->withOrganizationID(...)
     *   ->withPolicyCategories(...)
     *   ->withStatus(...)
     *   ->withTranscripts(...)
     *   ->withUpdatedAt(...)
     *   ->withWorkspaceID(...)
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
     * @param BetaComplianceReviewEnforcementAction|BetaComplianceReviewEnforcementActionShape|null $enforcementAction
     * @param list<BetaComplianceReviewPolicyCategory|value-of<BetaComplianceReviewPolicyCategory>> $policyCategories
     * @param BetaComplianceReviewCaseStatusShape $status
     * @param list<BetaComplianceReviewTranscript|BetaComplianceReviewTranscriptShape> $transcripts
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        BetaComplianceReviewEnforcementAction|array|null $enforcementAction,
        string $organizationID,
        array $policyCategories,
        BetaComplianceReviewCaseOpen|array|BetaComplianceReviewCaseClosed $status,
        array $transcripts,
        \DateTimeInterface $updatedAt,
        ?string $workspaceID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['enforcementAction'] = $enforcementAction;
        $self['organizationID'] = $organizationID;
        $self['policyCategories'] = $policyCategories;
        $self['status'] = $status;
        $self['transcripts'] = $transcripts;
        $self['updatedAt'] = $updatedAt;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The unique ID of the case (`rvc_...`).
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * When Anthropic sent the case. The time you have to respond starts here.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The action that Anthropic took before it sent the case. Null when it took none.
     *
     * @param BetaComplianceReviewEnforcementAction|BetaComplianceReviewEnforcementActionShape|null $enforcementAction
     */
    public function withEnforcementAction(
        BetaComplianceReviewEnforcementAction|array|null $enforcementAction
    ): self {
        $self = clone $this;
        $self['enforcementAction'] = $enforcementAction;

        return $self;
    }

    /**
     * The UUID of the organization that sent the flagged messages, which the case belongs to.
     */
    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * Anthropic's labels for why the messages were flagged, such as `cyber` or `fraud`. There is at least one. New values can appear, so accept a value that you don't know.
     *
     * @param list<BetaComplianceReviewPolicyCategory|value-of<BetaComplianceReviewPolicyCategory>> $policyCategories
     */
    public function withPolicyCategories(array $policyCategories): self
    {
        $self = clone $this;
        $self['policyCategories'] = $policyCategories;

        return $self;
    }

    /**
     * Whether Anthropic is still waiting for a response.
     *
     * @param BetaComplianceReviewCaseStatusShape $status
     */
    public function withStatus(
        BetaComplianceReviewCaseOpen|array|BetaComplianceReviewCaseClosed $status
    ): self {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The flagged messages. There is at least one, and the list isn't paginated.
     *
     * @param list<BetaComplianceReviewTranscript|BetaComplianceReviewTranscriptShape> $transcripts
     */
    public function withTranscripts(array $transcripts): self
    {
        $self = clone $this;
        $self['transcripts'] = $transcripts;

        return $self;
    }

    /**
     * The object type, always `compliance_review_case`.
     *
     * @param 'compliance_review_case' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When the case last changed. It changes when Anthropic sends the case, when the case closes, and when Anthropic sends a notice about the case.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * The ID of the workspace that sent the flagged messages (`wrkspc_...`). Null when the messages have no workspace, and it can be null for the default workspace.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
