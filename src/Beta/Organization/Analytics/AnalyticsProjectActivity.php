<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-project activity data for a given day.
 *
 * @phpstan-import-type AnalyticsUserShape from \Anthropic\Beta\Organization\Analytics\AnalyticsUser
 *
 * @phpstan-type AnalyticsProjectActivityShape = array{
 *   distinctUserCount: int,
 *   messageCount: int,
 *   projectID: string,
 *   projectName: string,
 *   createdAt?: \DateTimeInterface|null,
 *   createdBy?: null|AnalyticsUser|AnalyticsUserShape,
 *   distinctConversationCount?: int|null,
 *   product?: string|null,
 *   rbacGroupID?: string|null,
 *   rbacGroupName?: string|null,
 *   userID?: string|null,
 * }
 */
final class AnalyticsProjectActivity implements BaseModel
{
    /** @use SdkModel<AnalyticsProjectActivityShape> */
    use SdkModel;

    /**
     * Number of distinct users who used the project on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    #[Required('distinct_user_count')]
    public int $distinctUserCount;

    /**
     * Number of messages sent in the project on the requested day.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Tagged project identifier (e.g. `claude_proj_...`).
     */
    #[Required('project_id')]
    public string $projectID;

    /**
     * Name of the project.
     */
    #[Required('project_name')]
    public string $projectName;

    /**
     * Project creation timestamp in RFC 3339 format. Null if the project was deleted before attribution was recorded.
     */
    #[Optional('created_at', nullable: true)]
    public ?\DateTimeInterface $createdAt;

    /**
     * User who created the project. Null if the project was deleted before attribution was recorded, or if the creator's account no longer exists.
     */
    #[Optional('created_by', nullable: true)]
    public ?AnalyticsUser $createdBy;

    /**
     * Number of distinct conversations in the project. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Optional('distinct_conversation_count', nullable: true)]
    public ?int $distinctConversationCount;

    /**
     * Product that produced this row's activity: one of `chat`, `claude_code`, `cowork`, or `office_agent` (the canonical Cost & Usage product naming; an `office_agent` row's per-surface breakdown is in its `office_metrics`). On `/plugins` only `cowork` and `claude_code` occur (the only surfaces with plugin attribution); on `/artifacts` only `chat`, `claude_code`, and `cowork` occur (the surfaces that create artifacts); `/apps/chat/projects` does not support the product dimension (a `product` entry in `group_by[]` or `filter[]` there is rejected). Present only when the request grouped by `product`.
     */
    #[Optional(nullable: true)]
    public ?string $product;

    /**
     * Tagged RBAC group identifier (`rbac_group_...`), matching the spend-limits API spelling. Present only when the request grouped by `rbac_group_id`.
     */
    #[Optional('rbac_group_id', nullable: true)]
    public ?string $rbacGroupID;

    /**
     * Resolved RBAC group display name, alongside `rbac_group_id` when name resolution is available. Null if the group has been deleted or its name could not be resolved; `rbac_group_id` remains the stable key.
     */
    #[Optional('rbac_group_name', nullable: true)]
    public ?string $rbacGroupName;

    /**
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    #[Optional('user_id', nullable: true)]
    public ?string $userID;

    /**
     * `new AnalyticsProjectActivity()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsProjectActivity::with(
     *   distinctUserCount: ..., messageCount: ..., projectID: ..., projectName: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsProjectActivity())
     *   ->withDistinctUserCount(...)
     *   ->withMessageCount(...)
     *   ->withProjectID(...)
     *   ->withProjectName(...)
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
     * @param AnalyticsUser|AnalyticsUserShape|null $createdBy
     */
    public static function with(
        int $distinctUserCount,
        int $messageCount,
        string $projectID,
        string $projectName,
        ?\DateTimeInterface $createdAt = null,
        AnalyticsUser|array|null $createdBy = null,
        ?int $distinctConversationCount = null,
        ?string $product = null,
        ?string $rbacGroupID = null,
        ?string $rbacGroupName = null,
        ?string $userID = null,
    ): self {
        $self = new self;

        $self['distinctUserCount'] = $distinctUserCount;
        $self['messageCount'] = $messageCount;
        $self['projectID'] = $projectID;
        $self['projectName'] = $projectName;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $createdBy && $self['createdBy'] = $createdBy;
        null !== $distinctConversationCount && $self['distinctConversationCount'] = $distinctConversationCount;
        null !== $product && $self['product'] = $product;
        null !== $rbacGroupID && $self['rbacGroupID'] = $rbacGroupID;
        null !== $rbacGroupName && $self['rbacGroupName'] = $rbacGroupName;
        null !== $userID && $self['userID'] = $userID;

        return $self;
    }

    /**
     * Number of distinct users who used the project on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    public function withDistinctUserCount(int $distinctUserCount): self
    {
        $self = clone $this;
        $self['distinctUserCount'] = $distinctUserCount;

        return $self;
    }

    /**
     * Number of messages sent in the project on the requested day.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Tagged project identifier (e.g. `claude_proj_...`).
     */
    public function withProjectID(string $projectID): self
    {
        $self = clone $this;
        $self['projectID'] = $projectID;

        return $self;
    }

    /**
     * Name of the project.
     */
    public function withProjectName(string $projectName): self
    {
        $self = clone $this;
        $self['projectName'] = $projectName;

        return $self;
    }

    /**
     * Project creation timestamp in RFC 3339 format. Null if the project was deleted before attribution was recorded.
     */
    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * User who created the project. Null if the project was deleted before attribution was recorded, or if the creator's account no longer exists.
     *
     * @param AnalyticsUser|AnalyticsUserShape|null $createdBy
     */
    public function withCreatedBy(AnalyticsUser|array|null $createdBy): self
    {
        $self = clone $this;
        $self['createdBy'] = $createdBy;

        return $self;
    }

    /**
     * Number of distinct conversations in the project. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationCount(
        ?int $distinctConversationCount
    ): self {
        $self = clone $this;
        $self['distinctConversationCount'] = $distinctConversationCount;

        return $self;
    }

    /**
     * Product that produced this row's activity: one of `chat`, `claude_code`, `cowork`, or `office_agent` (the canonical Cost & Usage product naming; an `office_agent` row's per-surface breakdown is in its `office_metrics`). On `/plugins` only `cowork` and `claude_code` occur (the only surfaces with plugin attribution); on `/artifacts` only `chat`, `claude_code`, and `cowork` occur (the surfaces that create artifacts); `/apps/chat/projects` does not support the product dimension (a `product` entry in `group_by[]` or `filter[]` there is rejected). Present only when the request grouped by `product`.
     */
    public function withProduct(?string $product): self
    {
        $self = clone $this;
        $self['product'] = $product;

        return $self;
    }

    /**
     * Tagged RBAC group identifier (`rbac_group_...`), matching the spend-limits API spelling. Present only when the request grouped by `rbac_group_id`.
     */
    public function withRBACGroupID(?string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * Resolved RBAC group display name, alongside `rbac_group_id` when name resolution is available. Null if the group has been deleted or its name could not be resolved; `rbac_group_id` remains the stable key.
     */
    public function withRBACGroupName(?string $rbacGroupName): self
    {
        $self = clone $this;
        $self['rbacGroupName'] = $rbacGroupName;

        return $self;
    }

    /**
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    public function withUserID(?string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
