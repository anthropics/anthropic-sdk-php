<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One stored item that the organization it belongs to can read for review.
 *
 * @phpstan-import-type BetaComplianceReviewActorShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewActor
 * @phpstan-import-type BetaComplianceReviewMessageDetailsShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewMessageDetails
 * @phpstan-import-type BetaComplianceReviewSafeguardsReasonShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewSafeguardsReason
 * @phpstan-import-type BetaComplianceReviewActorVariants from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewActor
 *
 * @phpstan-type BetaComplianceReviewItemShape = array{
 *   id: string,
 *   actor: BetaComplianceReviewActorShape|null,
 *   contentExpiresAt: \DateTimeInterface,
 *   createdAt: \DateTimeInterface,
 *   details: BetaComplianceReviewMessageDetails|BetaComplianceReviewMessageDetailsShape,
 *   organizationID: string,
 *   readReason: BetaComplianceReviewSafeguardsReason|BetaComplianceReviewSafeguardsReasonShape,
 *   type: 'compliance_review_item',
 *   userProfileID: string|null,
 *   workspaceID: string|null,
 * }
 */
final class BetaComplianceReviewItem implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewItemShape> */
    use SdkModel;

    /**
     * The object type, always `compliance_review_item`.
     *
     * @var 'compliance_review_item' $type
     */
    #[Required(type: new ConstantOf('compliance_review_item'))]
    public string $type = 'compliance_review_item';

    /**
     * The ID of the item. For a message, its own ID, such as `msg_...`.
     */
    #[Required]
    public string $id;

    /**
     * For a message, who sent it. Null when no sender was recorded. New types can appear, so accept a type that you don't know.
     *
     * @var BetaComplianceReviewActorVariants|null $actor
     */
    #[Required(union: BetaComplianceReviewActor::class)]
    public BetaComplianceReviewUserActor|BetaComplianceReviewAPIActor|BetaComplianceReviewServiceAccountActor|null $actor;

    /**
     * Read the item, and save any copy you need, by this time. The item can stop being readable sooner.
     */
    #[Required('content_expires_at')]
    public \DateTimeInterface $contentExpiresAt;

    /**
     * For a message, when Anthropic received the call.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * What is particular to this kind of item. New types can appear, so accept a type that you don't know.
     */
    #[Required]
    public BetaComplianceReviewMessageDetails $details;

    /**
     * The UUID of the organization that the item belongs to. For a message, the organization that sent it.
     */
    #[Required('organization_id')]
    public string $organizationID;

    /**
     * Why the item is readable. New types can appear, so accept a type that you don't know.
     */
    #[Required('read_reason')]
    public BetaComplianceReviewSafeguardsReason $readReason;

    /**
     * The ID of the user profile that the item was attributed to (`uprof_...`). Null when none was recorded.
     */
    #[Required('user_profile_id')]
    public ?string $userProfileID;

    /**
     * The ID of the workspace (`wrkspc_...`). Null when the item isn't attributed to a workspace.
     */
    #[Required('workspace_id')]
    public ?string $workspaceID;

    /**
     * `new BetaComplianceReviewItem()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewItem::with(
     *   id: ...,
     *   actor: ...,
     *   contentExpiresAt: ...,
     *   createdAt: ...,
     *   details: ...,
     *   organizationID: ...,
     *   readReason: ...,
     *   userProfileID: ...,
     *   workspaceID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewItem())
     *   ->withID(...)
     *   ->withActor(...)
     *   ->withContentExpiresAt(...)
     *   ->withCreatedAt(...)
     *   ->withDetails(...)
     *   ->withOrganizationID(...)
     *   ->withReadReason(...)
     *   ->withUserProfileID(...)
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
     * @param BetaComplianceReviewActorShape|null $actor
     * @param BetaComplianceReviewMessageDetails|BetaComplianceReviewMessageDetailsShape $details
     * @param BetaComplianceReviewSafeguardsReason|BetaComplianceReviewSafeguardsReasonShape $readReason
     */
    public static function with(
        string $id,
        BetaComplianceReviewUserActor|array|BetaComplianceReviewAPIActor|BetaComplianceReviewServiceAccountActor|null $actor,
        \DateTimeInterface $contentExpiresAt,
        \DateTimeInterface $createdAt,
        BetaComplianceReviewMessageDetails|array $details,
        string $organizationID,
        BetaComplianceReviewSafeguardsReason|array $readReason,
        ?string $userProfileID,
        ?string $workspaceID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['actor'] = $actor;
        $self['contentExpiresAt'] = $contentExpiresAt;
        $self['createdAt'] = $createdAt;
        $self['details'] = $details;
        $self['organizationID'] = $organizationID;
        $self['readReason'] = $readReason;
        $self['userProfileID'] = $userProfileID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The ID of the item. For a message, its own ID, such as `msg_...`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * For a message, who sent it. Null when no sender was recorded. New types can appear, so accept a type that you don't know.
     *
     * @param BetaComplianceReviewActorShape|null $actor
     */
    public function withActor(
        BetaComplianceReviewUserActor|array|BetaComplianceReviewAPIActor|BetaComplianceReviewServiceAccountActor|null $actor,
    ): self {
        $self = clone $this;
        $self['actor'] = $actor;

        return $self;
    }

    /**
     * Read the item, and save any copy you need, by this time. The item can stop being readable sooner.
     */
    public function withContentExpiresAt(
        \DateTimeInterface $contentExpiresAt
    ): self {
        $self = clone $this;
        $self['contentExpiresAt'] = $contentExpiresAt;

        return $self;
    }

    /**
     * For a message, when Anthropic received the call.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * What is particular to this kind of item. New types can appear, so accept a type that you don't know.
     *
     * @param BetaComplianceReviewMessageDetails|BetaComplianceReviewMessageDetailsShape $details
     */
    public function withDetails(
        BetaComplianceReviewMessageDetails|array $details
    ): self {
        $self = clone $this;
        $self['details'] = $details;

        return $self;
    }

    /**
     * The UUID of the organization that the item belongs to. For a message, the organization that sent it.
     */
    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * Why the item is readable. New types can appear, so accept a type that you don't know.
     *
     * @param BetaComplianceReviewSafeguardsReason|BetaComplianceReviewSafeguardsReasonShape $readReason
     */
    public function withReadReason(
        BetaComplianceReviewSafeguardsReason|array $readReason
    ): self {
        $self = clone $this;
        $self['readReason'] = $readReason;

        return $self;
    }

    /**
     * The object type, always `compliance_review_item`.
     *
     * @param 'compliance_review_item' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The ID of the user profile that the item was attributed to (`uprof_...`). Null when none was recorded.
     */
    public function withUserProfileID(?string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * The ID of the workspace (`wrkspc_...`). Null when the item isn't attributed to a workspace.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
