<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Artifact-creation activity for one (`artifact_type`, `is_shared`) bucket
 * on a given day.
 *
 * Artifacts form a small finite cube — the canonical MIME type (8 values incl.
 * `other`) crossed with shared-vs-private — so the response is the full set of
 * non-empty buckets, not a ranked/paginated list. Claude Code and Cowork
 * artifacts report under `text/html` and are counted from 2026-08-17
 * onward; earlier days contain claude.ai chat artifacts only. With
 * `group_by[]=product` / `user_id` / `rbac_group_id` each row is further
 * split by the flat group keys and counts are scoped to that cut.
 *
 * @phpstan-type AnalyticsArtifactActivityShape = array{
 *   artifactType: string,
 *   artifactsCreatedCount: int,
 *   distinctUserCount: int,
 *   isShared: bool,
 *   publishedArtifactsCreatedCount: int,
 *   product?: string|null,
 *   rbacGroupID?: string|null,
 *   rbacGroupName?: string|null,
 *   userID?: string|null,
 * }
 */
final class AnalyticsArtifactActivity implements BaseModel
{
    /** @use SdkModel<AnalyticsArtifactActivityShape> */
    use SdkModel;

    /**
     * Canonical artifact MIME type (e.g. `text/markdown`, `application/vnd.ant.react`, `image/svg+xml`), or `other`. Claude Code and Cowork artifacts report as `text/html`.
     */
    #[Required('artifact_type')]
    public string $artifactType;

    /**
     * Number of artifacts created in this bucket on the requested day.
     */
    #[Required('artifacts_created_count')]
    public int $artifactsCreatedCount;

    /**
     * Number of distinct users who created artifacts in this bucket on the requested day.
     */
    #[Required('distinct_user_count')]
    public int $distinctUserCount;

    /**
     * Whether the artifacts in this bucket have ever been shared (a Claude Code / Cowork artifact is shared once anyone beyond its creator may open it: named members, the whole organization, or anyone with the link).
     */
    #[Required('is_shared')]
    public bool $isShared;

    /**
     * Number of those artifacts that have been published (for Claude Code / Cowork artifacts: open to anyone with the link); never exceeds `artifacts_created_count`.
     */
    #[Required('published_artifacts_created_count')]
    public int $publishedArtifactsCreatedCount;

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
     * `new AnalyticsArtifactActivity()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsArtifactActivity::with(
     *   artifactType: ...,
     *   artifactsCreatedCount: ...,
     *   distinctUserCount: ...,
     *   isShared: ...,
     *   publishedArtifactsCreatedCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsArtifactActivity())
     *   ->withArtifactType(...)
     *   ->withArtifactsCreatedCount(...)
     *   ->withDistinctUserCount(...)
     *   ->withIsShared(...)
     *   ->withPublishedArtifactsCreatedCount(...)
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
     */
    public static function with(
        string $artifactType,
        int $artifactsCreatedCount,
        int $distinctUserCount,
        bool $isShared,
        int $publishedArtifactsCreatedCount,
        ?string $product = null,
        ?string $rbacGroupID = null,
        ?string $rbacGroupName = null,
        ?string $userID = null,
    ): self {
        $self = new self;

        $self['artifactType'] = $artifactType;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;
        $self['distinctUserCount'] = $distinctUserCount;
        $self['isShared'] = $isShared;
        $self['publishedArtifactsCreatedCount'] = $publishedArtifactsCreatedCount;

        null !== $product && $self['product'] = $product;
        null !== $rbacGroupID && $self['rbacGroupID'] = $rbacGroupID;
        null !== $rbacGroupName && $self['rbacGroupName'] = $rbacGroupName;
        null !== $userID && $self['userID'] = $userID;

        return $self;
    }

    /**
     * Canonical artifact MIME type (e.g. `text/markdown`, `application/vnd.ant.react`, `image/svg+xml`), or `other`. Claude Code and Cowork artifacts report as `text/html`.
     */
    public function withArtifactType(string $artifactType): self
    {
        $self = clone $this;
        $self['artifactType'] = $artifactType;

        return $self;
    }

    /**
     * Number of artifacts created in this bucket on the requested day.
     */
    public function withArtifactsCreatedCount(int $artifactsCreatedCount): self
    {
        $self = clone $this;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;

        return $self;
    }

    /**
     * Number of distinct users who created artifacts in this bucket on the requested day.
     */
    public function withDistinctUserCount(int $distinctUserCount): self
    {
        $self = clone $this;
        $self['distinctUserCount'] = $distinctUserCount;

        return $self;
    }

    /**
     * Whether the artifacts in this bucket have ever been shared (a Claude Code / Cowork artifact is shared once anyone beyond its creator may open it: named members, the whole organization, or anyone with the link).
     */
    public function withIsShared(bool $isShared): self
    {
        $self = clone $this;
        $self['isShared'] = $isShared;

        return $self;
    }

    /**
     * Number of those artifacts that have been published (for Claude Code / Cowork artifacts: open to anyone with the link); never exceeds `artifacts_created_count`.
     */
    public function withPublishedArtifactsCreatedCount(
        int $publishedArtifactsCreatedCount
    ): self {
        $self = clone $this;
        $self['publishedArtifactsCreatedCount'] = $publishedArtifactsCreatedCount;

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
