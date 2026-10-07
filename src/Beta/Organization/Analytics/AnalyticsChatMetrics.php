<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude.ai activity metrics for a single user on a given day.
 *
 * @phpstan-type AnalyticsChatMetricsShape = array{
 *   connectorsUsedCount: int,
 *   distinctArtifactsCreatedCount: int,
 *   distinctConnectorsUsedCount: int|null,
 *   distinctConversationCount: int|null,
 *   distinctFilesUploadedCount: int|null,
 *   distinctProjectsCreatedCount: int,
 *   distinctProjectsUsedCount: int|null,
 *   distinctSharedArtifactsViewedCount: int|null,
 *   distinctSkillsUsedCount: int|null,
 *   messageCount: int,
 *   sharedConversationsViewedCount: int,
 *   thinkingMessageCount: int,
 * }
 */
final class AnalyticsChatMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsChatMetricsShape> */
    use SdkModel;

    /**
     * Number of MCP connector invocations.
     */
    #[Required('connectors_used_count')]
    public int $connectorsUsedCount;

    /**
     * Number of distinct artifacts created. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('distinct_artifacts_created_count')]
    public int $distinctArtifactsCreatedCount;

    /**
     * Distinct claude.ai connectors this user used. Excludes calls whose connector could not be identified and all calls from organizations with zero data retention. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_connectors_used_count')]
    public ?int $distinctConnectorsUsedCount;

    /**
     * Number of distinct conversations the user participated in. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_conversation_count')]
    public ?int $distinctConversationCount;

    /**
     * Number of distinct files uploaded. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_files_uploaded_count')]
    public ?int $distinctFilesUploadedCount;

    /**
     * Number of distinct projects created. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('distinct_projects_created_count')]
    public int $distinctProjectsCreatedCount;

    /**
     * Number of distinct projects used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_projects_used_count')]
    public ?int $distinctProjectsUsedCount;

    /**
     * Number of distinct shared artifacts the user viewed. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_shared_artifacts_viewed_count')]
    public ?int $distinctSharedArtifactsViewedCount;

    /**
     * Number of distinct skills used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_skills_used_count')]
    public ?int $distinctSkillsUsedCount;

    /**
     * Number of messages sent.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Number of times the user opened a shared conversation in a project.
     */
    #[Required('shared_conversations_viewed_count')]
    public int $sharedConversationsViewedCount;

    /**
     * Number of messages that used extended thinking.
     */
    #[Required('thinking_message_count')]
    public int $thinkingMessageCount;

    /**
     * `new AnalyticsChatMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsChatMetrics::with(
     *   connectorsUsedCount: ...,
     *   distinctArtifactsCreatedCount: ...,
     *   distinctConnectorsUsedCount: ...,
     *   distinctConversationCount: ...,
     *   distinctFilesUploadedCount: ...,
     *   distinctProjectsCreatedCount: ...,
     *   distinctProjectsUsedCount: ...,
     *   distinctSharedArtifactsViewedCount: ...,
     *   distinctSkillsUsedCount: ...,
     *   messageCount: ...,
     *   sharedConversationsViewedCount: ...,
     *   thinkingMessageCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsChatMetrics())
     *   ->withConnectorsUsedCount(...)
     *   ->withDistinctArtifactsCreatedCount(...)
     *   ->withDistinctConnectorsUsedCount(...)
     *   ->withDistinctConversationCount(...)
     *   ->withDistinctFilesUploadedCount(...)
     *   ->withDistinctProjectsCreatedCount(...)
     *   ->withDistinctProjectsUsedCount(...)
     *   ->withDistinctSharedArtifactsViewedCount(...)
     *   ->withDistinctSkillsUsedCount(...)
     *   ->withMessageCount(...)
     *   ->withSharedConversationsViewedCount(...)
     *   ->withThinkingMessageCount(...)
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
        int $connectorsUsedCount,
        int $distinctArtifactsCreatedCount,
        ?int $distinctConnectorsUsedCount,
        ?int $distinctConversationCount,
        ?int $distinctFilesUploadedCount,
        int $distinctProjectsCreatedCount,
        ?int $distinctProjectsUsedCount,
        ?int $distinctSharedArtifactsViewedCount,
        ?int $distinctSkillsUsedCount,
        int $messageCount,
        int $sharedConversationsViewedCount,
        int $thinkingMessageCount,
    ): self {
        $self = new self;

        $self['connectorsUsedCount'] = $connectorsUsedCount;
        $self['distinctArtifactsCreatedCount'] = $distinctArtifactsCreatedCount;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;
        $self['distinctConversationCount'] = $distinctConversationCount;
        $self['distinctFilesUploadedCount'] = $distinctFilesUploadedCount;
        $self['distinctProjectsCreatedCount'] = $distinctProjectsCreatedCount;
        $self['distinctProjectsUsedCount'] = $distinctProjectsUsedCount;
        $self['distinctSharedArtifactsViewedCount'] = $distinctSharedArtifactsViewedCount;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;
        $self['messageCount'] = $messageCount;
        $self['sharedConversationsViewedCount'] = $sharedConversationsViewedCount;
        $self['thinkingMessageCount'] = $thinkingMessageCount;

        return $self;
    }

    /**
     * Number of MCP connector invocations.
     */
    public function withConnectorsUsedCount(int $connectorsUsedCount): self
    {
        $self = clone $this;
        $self['connectorsUsedCount'] = $connectorsUsedCount;

        return $self;
    }

    /**
     * Number of distinct artifacts created. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withDistinctArtifactsCreatedCount(
        int $distinctArtifactsCreatedCount
    ): self {
        $self = clone $this;
        $self['distinctArtifactsCreatedCount'] = $distinctArtifactsCreatedCount;

        return $self;
    }

    /**
     * Distinct claude.ai connectors this user used. Excludes calls whose connector could not be identified and all calls from organizations with zero data retention. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConnectorsUsedCount(
        ?int $distinctConnectorsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConnectorsUsedCount'] = $distinctConnectorsUsedCount;

        return $self;
    }

    /**
     * Number of distinct conversations the user participated in. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationCount(
        ?int $distinctConversationCount
    ): self {
        $self = clone $this;
        $self['distinctConversationCount'] = $distinctConversationCount;

        return $self;
    }

    /**
     * Number of distinct files uploaded. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctFilesUploadedCount(
        ?int $distinctFilesUploadedCount
    ): self {
        $self = clone $this;
        $self['distinctFilesUploadedCount'] = $distinctFilesUploadedCount;

        return $self;
    }

    /**
     * Number of distinct projects created. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withDistinctProjectsCreatedCount(
        int $distinctProjectsCreatedCount
    ): self {
        $self = clone $this;
        $self['distinctProjectsCreatedCount'] = $distinctProjectsCreatedCount;

        return $self;
    }

    /**
     * Number of distinct projects used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctProjectsUsedCount(
        ?int $distinctProjectsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctProjectsUsedCount'] = $distinctProjectsUsedCount;

        return $self;
    }

    /**
     * Number of distinct shared artifacts the user viewed. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSharedArtifactsViewedCount(
        ?int $distinctSharedArtifactsViewedCount
    ): self {
        $self = clone $this;
        $self['distinctSharedArtifactsViewedCount'] = $distinctSharedArtifactsViewedCount;

        return $self;
    }

    /**
     * Number of distinct skills used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSkillsUsedCount(
        ?int $distinctSkillsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSkillsUsedCount'] = $distinctSkillsUsedCount;

        return $self;
    }

    /**
     * Number of messages sent.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Number of times the user opened a shared conversation in a project.
     */
    public function withSharedConversationsViewedCount(
        int $sharedConversationsViewedCount
    ): self {
        $self = clone $this;
        $self['sharedConversationsViewedCount'] = $sharedConversationsViewedCount;

        return $self;
    }

    /**
     * Number of messages that used extended thinking.
     */
    public function withThinkingMessageCount(int $thinkingMessageCount): self
    {
        $self = clone $this;
        $self['thinkingMessageCount'] = $thinkingMessageCount;

        return $self;
    }
}
